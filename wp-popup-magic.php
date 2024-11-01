<?php
/*
  Plugin Name: WP Popup Magic
  Plugin URI: https://www.themelocation.com/
  Description: Create amazing popups and page effects with WP Popup Magic.
  Version: 1.0.0
  Author: ThemeLocation
  Author URI: https://www.themelocation.com/
  License: GPL2 or later
 */

// plugin definitions
define('WPPUM_I18N_DOMAIN', 'wppum');
define('WPPUM_PLUGIN_VERSION', '3.0.5');
define('WPPUM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WPPUM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WPPUM_CLOSE_BUTTONS_REL_PATH', 'images/close-buttons/');
define('WPPUM_OPEN_BUTTONS_REL_PATH', 'images/open-buttons/');
define('WPPUM_BACKGROUND_IMAGES_REL_PATH', 'images/backgrounds/');

require_once( WPPUM_PLUGIN_PATH . 'config.php' );
require_once( WPPUM_PLUGIN_PATH . 'libraries/mailchimp/class-mailchimp-oauth.php' );
require_once( WPPUM_PLUGIN_PATH . 'libraries/mailchimp/class-mailchimp.php' );
require_once( WPPUM_PLUGIN_PATH . 'class-wppum-admin.php' );
require_once( WPPUM_PLUGIN_PATH . 'class-wppum-frontend.php' );

$wppum = new WPPUM();

class WPPUM {

    /**
     * Plugin's main entry point.
     * */
    function __construct() {
        $this->init_fonts();

        // upgrade from previous version
        add_action('admin_init', array(&$this, 'upgrade'));

        // create popup custom post type
        add_action('init', array(&$this, 'register_wppum_popup_custom_post_type'));

        $wppum_admin = new WPPUM_Admin();
        $wppum_frontend = new WPPUM_Frontend();


        wp_oembed_add_provider('#http://(www\.)?youtube\.com/watch.*#i', 'http://www.youtube.com/oembed', true);
        wp_oembed_add_provider('#https://(www\.)?youtube\.com/watch.*#i', 'https://www.youtube.com/oembed', true);
    }

    /**
     * Set fonts data from cache or server.
     * */
    function init_fonts() {
        global $wppum_fonts, $wppum_combined_fonts_css;
        $wppum_fonts = get_site_transient('wppum_fonts');

        if (empty($wppum_fonts)) {      // cache has expired, or data has not yet been retrieved
            $response = wp_remote_get(WPPUM_FONTS_URL);

            // couldn't get fonts?
            if (is_wp_error($response)) {
                return;
            }

            $fonts = isset($response['body']) ? $response['body'] : '';
            if (empty($fonts)) {
                return;   // could not retrieve fonts
            }

            // parse the fonts before caching
            $fonts = json_decode($fonts);
            $wppum_fonts = array();

        
            if( isset($fonts) ) {
                foreach ($fonts->items as $font) {
                    // Don't use this font if it's not available in regular which is our default
                    if (!isset($font->variants[0]) || 'regular' != $font->variants[0]) {
                        continue;
                    }

                    $fontUrl = sprintf('%s://fonts.googleapis.com/css?family=%s', is_ssl() ? 'https' : 'http', str_replace(' ', '+', $font->family));

                    $wppum_fonts[$font->family] = array($font->family, $fontUrl);
                }
            }

            // cache the fonts data
            set_site_transient('wppum_fonts', $wppum_fonts, WPPUM_FONTS_CACHE_EXPIRY);
        }

        // prepare for loading the font CSS files in batches at a time
        $wppum_combined_fonts_css = array();
        $wppum_fonts_css = '';
        foreach ($wppum_fonts as $font_name => $font) {
            $wppum_fonts_css .= str_replace(' ', '+', $font_name) . '|';
            if (strlen($wppum_fonts_css) > 1500) {
                $wppum_combined_fonts_css[] = 'https://fonts.googleapis.com/css?family=' . substr($wppum_fonts_css, 0, -1);
                $wppum_fonts_css = '';
            }
        }
        if (!empty($wppum_fonts_css)) {
            $wppum_combined_fonts_css[] = 'https://fonts.googleapis.com/css?family=' . substr($wppum_fonts_css, 0, -1);
        }
    }

    /**
     * Perform upgrade from old settings to new custom post types.
     * */
    function upgrade() {
        global $wppum_default_popup, $wppum;

        // initialize settings to default values if not yet set
        $settings = get_option('wppum_settings');
        if (false === $settings) {
            $settings = array('wppum_ads' => 1);
            update_option('wppum_settings', $settings);
        }

        $installed_ver = get_option('wppum_version');

        if ($installed_ver === WPPUM_PLUGIN_VERSION) {
            return;
        }
        // remove existing deprecated animations
        $this->remove_deprecated_animations();
        // perform upgrade
        $panels = get_option('snpanel_settings');
        if (empty($panels)) {
            // update version
            update_option('wppum_version', WPPUM_PLUGIN_VERSION);

            return; // nothing to upgrade!
        }
        $master_panel = get_option('snpanel_master_panel_name');
        $home_page_panel = get_option('snpanel_home_page_panel_name');

        // get default close button
        $default_close_buttons = $this->get_close_button_defaults();
        $default_close_button = $default_close_buttons[0];
        $old_default_close_button_html = '<span class="snpanel-close" style="cursor:pointer;z-index:99999999;position:absolute;right:5px;top:5px;"><img src="' . admin_url('/images/no.png') . '" title="Close" /></span>';

        foreach ($panels as $panel_name => $panel) {
            // init custom post
            $new_popup_post = array(
                'post_title' => $panel_name,
                'post_content' => $panel['contents'],
                'post_status' => 'publish',
                'post_type' => 'wppum_popup'
            );
            $post_id = wp_insert_post($new_popup_post);

            // set custom field values
            $popup = $wppum_default_popup;
            unset($popup['contents']);
            unset($popup['order']);
            $new_to_old_fields_mapping = array(
                'classes' => 'class_name',
                'trigger_delay' => 'delay',
            );
            $new_target_types = array('none', 'element', 'top', 'bottom', 'shortcode');
            foreach ($popup as $field => $value) {
                // for most fields, simply copy old value to the same or renamed field
                $old_field = $field;
                if (isset($new_to_old_fields_mapping[$field])) {
                    $old_field = $new_to_old_fields_mapping[$field];
                }

                if (!empty($old_field) && isset($panel[$old_field])) {
                    $value = $panel[$old_field];
                }

                // handle special modified/new fields
                if ('vertical_offset_type' === $field) {
                    // vertical offset type: top, center, bottom
                    if (intval($panel['position_center']) === 1) {
                        $value = 'center';
                    } else {
                        if (!empty($panel['position_top'])) {
                            $value = 'top';
                        } else {
                            $value = 'bottom';
                        }
                    }
                } else if ('vertical_offset' === $field) {
                    // vertical offset value (derived from position_top or position_bottom)
                    if (intval($panel['position_center']) !== 1) {
                        if (!empty($panel['position_top'])) {
                            $value = $panel['position_top'];
                        } else {
                            $value = $panel['position_bottom'];
                        }
                    }
                } else if ('horizontal_offset_type' === $field) {
                    // horizontal offset type: left, center, right
                    if (intval($panel['position_center']) === 1) {
                        $value = 'center';
                    } else {
                        if (!empty($panel['position_left'])) {
                            $value = 'left';
                        } else {
                            $value = 'right';
                        }
                    }
                } else if ('horizontal_offset' === $field) {
                    // horizontal offset value (derived from position_left or position_right)
                    if (intval($panel['position_center']) !== 1) {
                        if (!empty($panel['position_left'])) {
                            $value = $panel['position_left'];
                        } else {
                            $value = $panel['position_right'];
                        }
                    }
                } else if ('close_button_img' === $field) {
                    if (empty($panel['close_button'])) {
                        // no close button set
                        $value = '';
                    } else {
                        // use default close button image
                        $value = $default_close_button;
                    }
                } else if ('close_button_html' === $field) {
                    if (!empty($panel['close_button']) && trim($panel['close_button']) !== $old_default_close_button_html) {
                        // copy the old close button HTML only if it had been modified from the default value
                        $value = $panel['close_button'];
                    }
                } else if ('target_type' === $field || 'end_target_type' === $field) {
                    $value = $new_target_types[intval($panel[$field]) + 1];
                } else if ('trigger_pages' === $field) {
                    // determine trigger pages
                    if ($panel_name === $master_panel && $panel_name === $home_page_panel) {
                        $value = 'show_all_include_homepage';
                    } else if ($panel_name === $master_panel) {
                        $value = 'show_all_exclude_homepage';
                    } else if ($panel_name === $home_page_panel) {
                        $value = 'show_homepage_and_shortcode';
                    } else {
                        $value = 'hide_all';
                    }
                } else if ('trigger_on_timing' === $field) {
                    // set "trigger on timing" to true if panel delay > 0
                    if (intval($panel['delay']) > 0) {
                        $value = '1';
                    }
                }

                $popup[$field] = $value;
            }

            update_post_meta($post_id, '_wppum', $popup);
        }

        // backup old data, in case
        update_option('wppum_old_panels', $panels);
        update_option('wppum_old_master_panel_name', $master_panel);
        update_option('wppum_old_home_page_panel_name', $home_page_panel);

        // delete the snpanel options
        delete_option('snpanel_settings');
        delete_option('snpanel_master_panel_name');
        delete_option('snpanel_home_page_panel_name');

        // update version
        update_option('wppum_version', WPPUM_PLUGIN_VERSION);
    }

    /**
     * Register WP Popup Magic Popup custom post type.
     * */
    function register_wppum_popup_custom_post_type() {
        $labels = array(
            'name' => esc_html__('Popups', WPPUM_I18N_DOMAIN),
            'singular_name' => esc_html__('Popup', WPPUM_I18N_DOMAIN),
            'add_new' => esc_html__('Add New', WPPUM_I18N_DOMAIN),
            'add_new_item' => esc_html__('Add New Popup', WPPUM_I18N_DOMAIN),
            'edit_item' => esc_html__('Edit Popup', WPPUM_I18N_DOMAIN),
            'new_item' => esc_html__('New Popup', WPPUM_I18N_DOMAIN),
            'all_items' => esc_html__('All Popups', WPPUM_I18N_DOMAIN),
            'view_item' => esc_html__('View Popup', WPPUM_I18N_DOMAIN),
            'search_items' => esc_html__('Search Popups', WPPUM_I18N_DOMAIN),
            'not_found' => esc_html__('No popups found', WPPUM_I18N_DOMAIN),
            'not_found_in_trash' => esc_html__('No popups found in the Trash', WPPUM_I18N_DOMAIN),
            'parent_item_colon' => '',
            'menu_name' => 'WP Popup Magic'
        );
        $args = array(
            'labels' => $labels,
            'description' => 'WP Popup Magic Popups',
            'public' => false,
            'show_ui' => true,
            'menu_position' => 105,
            'menu_icon' => WPPUM_PLUGIN_URL . 'images/icon-16.png?ver=' . WPPUM_PLUGIN_VERSION,
            'supports' => array('title', 'editor', 'page-attributes'),
            'has_archive' => false
        );
        register_post_type('wppum_popup', $args);

        // remove URL rewrite for wppum_popup CPTs, and flush rewrite rules only once per plugin version
        if (get_option('wppum_popup_rewrite_rules_updated') !== WPPUM_PLUGIN_VERSION) {
            global $wp_rewrite;
            unset($wp_rewrite->extra_permastructs['wppum_popup']);
            $wp_rewrite->flush_rules();
            update_option('wppum_popup_rewrite_rules_updated', WPPUM_PLUGIN_VERSION);
        }
    }

    /**
     * Retrieve details of all popups in site.
     * */
    function get_all_popups() {
        $popups = get_posts(array('post_type' => 'wppum_popup', 'post_status' => array('publish', 'draft'), 'posts_per_page' => -1));
        foreach ($popups as $index => $popup) {
            $popups[$index] = $this->get_popup($popup->ID);
            $popups[$index]['name'] = $popup->post_title;
            $popups[$index]['ID'] = $popup->ID;
            $popups[$index]['contents'] = wpautop($popup->post_content);
            $popups[$index]['raw_contents'] = $popup->post_content;
            $popups[$index]['order'] = $popup->menu_order;
            $popups[$index]['status'] = $popup->post_status;
        }
        return $popups;
    }

    /**
     * Returns an array of the custom fields of the specified popup.
     * Default values are used for any missing custom fields.
     * */
    function get_popup($id) {
        global $wppum_default_popup;

        $popup = get_post_meta($id, '_wppum', true);
        if (empty($popup)) {
            $popup = array();
        }


        // set correct value for close_button_type for backwards-compatibility
        if (!isset($popup['close_button_type'])) {
            if (empty($popup['close_button_img'])) {
                $popup['close_button_type'] = 'hide';
            } else {
                $popup['close_button_type'] = 'close';
            }
        }

        // set correct value for frequency_type for backwards-compatibility
        if (!isset($popup['frequency_type'])) {
            if (!empty($popup['frequency_limit_times']) && !empty($popup['frequency_limit_days'])) {
                $popup['frequency_type'] = 'custom';
            } else {
                $popup['frequency_type'] = 'none';
            }
        }

        $popup = shortcode_atts($wppum_default_popup, $popup);
        unset($popup['contents']);

        // set default close button image (first image in defaults)
        if (empty($popup['close_button_img'])) {
            $close_button_defaults = $this->get_close_button_defaults();
            $popup['close_button_img'] = $close_button_defaults[0];
        }

        // set default open button image (first image in defaults)
        if (empty($popup['open_button_img'])) {
            $open_button_defaults = $this->get_open_button_defaults();
            $popup['open_button_img'] = $open_button_defaults[0];
        }
        //print_r($popup);
        return $popup;
    }

    /**
     * Returns array of paths to close button default images.
     * */
    function get_close_button_defaults() {
        static $close_button_defaults = array();

        if (empty($close_button_defaults)) {
            // get default close buttons
            $close_button_defaults = array();
            $close_buttons_dir = WPPUM_PLUGIN_PATH . WPPUM_CLOSE_BUTTONS_REL_PATH;
            if ($handle = opendir($close_buttons_dir)) {
                while (false !== ( $entry = readdir($handle) )) {
                    if ($entry != "." && $entry != "..") {
                        $close_button_defaults[] = WPPUM_PLUGIN_URL . WPPUM_CLOSE_BUTTONS_REL_PATH . $entry;
                    }
                }
            }
            closedir($handle);
        }
        sort($close_button_defaults);
        return $close_button_defaults;
    }

    /**
     * Returns array of paths to open button default images.
     * */
    function get_open_button_defaults() {
        static $open_button_defaults = array();

        if (empty($open_button_defaults)) {
            // get default open buttons
            $open_button_defaults = array();
            $open_buttons_dir = WPPUM_PLUGIN_PATH . WPPUM_OPEN_BUTTONS_REL_PATH;
            if ($handle = opendir($open_buttons_dir)) {
                while (false !== ( $entry = readdir($handle) )) {
                    if ($entry != "." && $entry != "..") {
                        $open_button_defaults[] = WPPUM_PLUGIN_URL . WPPUM_OPEN_BUTTONS_REL_PATH . $entry;
                    }
                }
            }
            closedir($handle);
        }
        sort($open_button_defaults);
        return $open_button_defaults;
    }

    /**
     * Returns array of paths to background default images.
     * */
    function get_background_images_defaults() {
        static $background_images_defaults = array();

        if (empty($background_images_defaults)) {
            // get default background images
            $background_images_defaults = array();
            $background_images_dir = WPPUM_PLUGIN_PATH . WPPUM_BACKGROUND_IMAGES_REL_PATH;
            if ($handle = opendir($background_images_dir)) {
                while (false !== ( $entry = readdir($handle) )) {
                    if ($entry != "." && $entry != "..") {
                        $background_images_defaults[] = WPPUM_PLUGIN_URL . WPPUM_BACKGROUND_IMAGES_REL_PATH . $entry;
                    }
                }
            }
            closedir($handle);
        }
        sort($background_images_defaults);
        return $background_images_defaults;
    }

    /**
     * Sanitizes the POST values before saving/previewing popup.
     * */
    function sanitize_popup() {
        global $wppum_default_popup, $wppum_fonts;

        // init with default values
        $popup = $wppum_default_popup;

        // sanitize input POST values
        $not_blank_fields = array('trigger_delay', 'overlay_opacity');
        $fields_with_units = array('width', 'height', 'vertical_offset', 'horizontal_offset', 'ok_button_width', 'cancel_button_width');
        $checkbox_fields = array('trigger_on_timing', 'trigger_on_leaving_viewport', 'trigger_on_link_click', 'trigger_browser_scroll');

        $post_rules_fields = array('show_all_include_homepage_options',
            'show_all_exclude_homepage_options',
            'show_homepage_and_shortcode_options',
            'show_pages_options',
            'hide_pages_options',
            'hide_all_options',
            'specific_cat_options',
            'url_pattern_options',
            'web_referring_url_options');

        $checkbox_fields[] = "trigger_on_newsletter_email";
        foreach ($popup as $field => $default_value) {
            if (isset($_POST['wppum_' . $field])) {
                // trim the POST value
                $value = trim(stripslashes($_POST['wppum_' . $field]));
            } else if (in_array($field, $checkbox_fields)) {
                // set to 0 if POST is not set, and field is a checkbox
                $value = '0';
            } else if (in_array($field, $post_rules_fields)) {
                // set to 0 if POST is not set, and field is a checkbox
                $value = isset($_POST[$field]) ? sanitize_text_field($_POST[$field]) : '';
            } else {
                // use default value if POST is not set, and field is not a checkbox
                $value = $default_value;
            }

            // ensure values are not blank for certain fields
            if (in_array($field, $not_blank_fields)) {
                if (empty($value)) {
                    $value = $default_value;
                }
            }

            // for fields with px/% units, use units from the text element if specified
            // otherwise, convert to int and grab the unit from the select element as well
            if (in_array($field, $fields_with_units)) {
                if (strlen($value) >= 1 && substr($value, -1) === '%') {
                    $unit = '%';
                } else if (strlen($value) >= 2 && substr(strtolower($value), -2) === 'px') {
                    $unit = 'px';
                } else {
                    // grab unit from the select element
                    $unit = 'px';
                    if (isset($_POST['wppum_' . $field . '_unit'])) {
                        $unit = $_POST['wppum_' . $field . '_unit'];
                    }
                }

                $value = intval($value) . $unit;
            }

            // if "no frequency limit" radio button field is selected, ensure the values for frequency_limit_times
            // and frequency_limit_days is set to 0
            if ('frequency_limit_times' === $field || 'frequency_limit_days' === $field) {
                if ($_POST['wppum_frequency_type'] === 'none') {
                    $value = '0';
                }
            }

            // ensure "no frequency limit" radio button field is selected if value for frequency_limit_times
            // and/or frequency_limit_days is 0
            if ('frequency_type' === $field) {
                if ($_POST['wppum_frequency_type'] === 'custom' && ( empty($_POST['wppum_frequency_limit_times']) || empty($_POST['wppum_frequency_limit_days']) )) {
                    $value = 'none';
                }
            }

            // for trigger_pages_ids field, ensure list is comma-delimited (removing whitespace) and
            // contains only numbers, and there are no duplicates
            if ('trigger_pages_ids' === $field) {
                $page_ids = explode(',', $value);
                $sanitized_page_ids = array();
                foreach ($page_ids as $id) {
                    if (intval($id) > 0) {
                        $duplicate = false;
                        foreach ($sanitized_page_ids as $past_id) {
                            if (intval($id) === intval($past_id)) {
                                $duplicate = true;
                                break;
                            }
                        }
                        if (!$duplicate) {
                            $sanitized_page_ids[] = intval($id);
                        }
                    }
                }
                $value = implode(',', $sanitized_page_ids);
            }

            // if Show close/toggle button is not checked, ensure close_button_img is set to blank
            if ('close_button_img' === $field) {
                if ($_POST['wppum_close_button_type'] !== 'close' && $_POST['wppum_close_button_type'] !== 'toggle') {
                    $value = '';
                }
            }

            // if Background Color image radio button is checked, ensure background_img is set to blank
            if ('background_img' === $field) {
                if ($_POST['wppum_background_type'] === 'color') {
                    $value = '';
                }
            }

            // ensure newlines in "Styles"/"Advanced HTML for close button" can get imported properly in future
            if ('styles' === $field || 'close_button_html' === $field) {
                $value = str_replace("\r\n", "\n", $value);
            }

            // ensure no empty whitelisted domains in the input, and domains don't contain http:// or https:// prefixes or trailing slashes
            if ('whitelisted_domains' === $field) {
                $value = implode("\n", array_filter(array_map(array(&$this, 'sanitize_domain'), explode("\n", $value))));
                $value = implode("\n", array_filter(array_map(array(&$this, 'sanitize_domain'), explode(",", $value))));
            }
            if ('popup_type' === $field) {
                $value = $_POST['popup_type'];
            }
            $popup[$field] = $value;
        }

        // Add all rules
        foreach ($post_rules_fields as $pr_fields => $pr_values) {
            $field_name = $pr_values;
            $val_field_name = str_replace('options', 'val', $pr_values);
            $popup[$field_name] = isset($_POST[$field_name]) ? $_POST[$field_name] : '';
            if ($pr_values === 'hide_pages_options') {
                $option_page_ids = explode(',', isset($_POST[$val_field_name]) ? $_POST[$val_field_name] : '' );
                $option_sanitized_page_ids = array();
                foreach ($option_page_ids as $ids) {
                    if (intval($ids) > 0) {
                        $duplicate = false;
                        foreach ($option_sanitized_page_ids as $past_id) {
                            if (intval($ids) === intval($past_id)) {
                                $duplicate = true;
                                break;
                            }
                        }
                        if (!$duplicate) {
                            $option_sanitized_page_ids[] = intval($ids);
                        }
                    }
                }
                $value = implode(',', $option_sanitized_page_ids);
                $popup[$val_field_name] = $value;
            }
            if ($pr_values === 'show_pages_options') {
                $option_page_ids = isset($_POST[$val_field_name]) ? $_POST[$val_field_name] : [];
                $option_sanitized_page_ids = array();
                foreach ($option_page_ids as $ids) {
                    if (intval($ids) > 0) {
                        $duplicate = false;
                        foreach ($option_sanitized_page_ids as $past_id) {
                            if (intval($ids) === intval($past_id)) {
                                $duplicate = true;
                                break;
                            }
                        }
                        if (!$duplicate) {
                            $option_sanitized_page_ids[] = intval($ids);
                        }
                    }
                }
                $value = implode(',', $option_sanitized_page_ids);
                $popup[$val_field_name] = $value;
            }
            if ($pr_values === 'url_pattern_options') {
                $popup[$val_field_name] = $_POST[$val_field_name];
            }
        }

        if (isset($_POST['web_referring_url_options']) && $_POST['web_referring_url_options'] === 'web_referring_url') {
            $popup['web_referring_url_val'] = $_POST['web_referring_url_val'];
        }

        if (isset($_POST['specific_cat_options']) && $_POST['specific_cat_options'] === 'specific_cat') {
            $specific_category_val_is = implode(',', $_POST['specific_category']);
            $popup['specific_category_val'] = $specific_category_val_is;
        }

        return $popup;
    }

    /**
     * Sanitizes a domain by removing http:// and https:// prefixes and trailing slashes.
     * */
    function sanitize_domain($domain) {
        $domain = trim(str_ireplace(array('http://', 'https://'), '', $domain));
        if (substr($domain, -1) === '/') {
            $domain = substr($domain, 0, -1);
        }
        return $domain;
    }

    function remove_deprecated_animations() {
        $deprecated = array('puff', 'scale', 'size');
        $query = new WP_Query(array('post_type' => 'wppum_popup'));
        while ($query->have_posts()) {
            $query->the_post();
            $meta = get_post_meta($query->post->ID, '_wppum', true);
            if (in_array($meta['animation_effect'], $deprecated)) {
                $meta['animation_effect'] = 'slide';
                $meta['slide_direction'] = 'up';
                $meta['clip_direction'] = 'vertical';
                $meta['slide_speed'] = '1000';
                update_post_meta($query->post->ID, '_wppum', $meta);
            }
        }
    }
}