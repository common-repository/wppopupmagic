<?php

/**
 * WP Popup Magic - Admin functions.
 * */
class WPPUM_Admin {

    private $popup_type = "";
    private $popup = array();
    private $dummy_post_id = 0;
    private $popup_steps = [];
    private $default_popup = [
        "text" => [
                "wppum_background_color" => "C7C7C7",
                "wppum_overlay_color" => "303030",
                "wppum_overlay_opacity" => "50",
                "wppum_border_width" => "5",
                "wppum_border_radius" => "2",
                "wppum_border_color" => "ffffff",
                "wppum_padding_top" => "25",
                "wppum_padding_left" => "25",
                "wppum_padding_right" => "25",
                "wppum_padding_bottom" => "25",
                "wppum_background_img"=> WPPUM_PLUGIN_URL."images/backgrounds/pattern-1.png"
            ],
        'radios' => [
            "wppum_popup_theme" => "1",
            'wppum_close_button_type' => "close",
            'wppum_size_type' => "custom",
            "wppum_overlay" => "1",
            'wppum_background_type' => "image"
        ],
        'checkboxes' => [
            'wppum_position_centered' => "1",
        ],
        'selectBoxes' => [
            'wppum_border_style' => 'solid',
            "wppum_animation_effect" => "fade",
        ],
    ];
    private $news_letter_template_defaults = [
        '1' => [
            "text" => [
                "wppum_newsletter_submit_btn_color" => "fdb913",
                "wppum_newsletter_submit_btn_hover" => "fdb913",
                "wppum_newsletter_submit_btn_text_color" => "ffffff",
            ],
            'radios' => [
                'wppum_size_type' => "contents",
            ],
        ],
        '2' => [
            "text" => [
                'wppum_newsletter_submit_btn_color' => "0091d5",
                "wppum_newsletter_submit_btn_hover" => "0091d5",
                "wppum_newsletter_submit_btn_text_color" => "ffffff",
            ],
            'radios' => [
                'wppum_size_type' => "contents",
            ],
        ],
        '3' => [
            "text" => [
                "wppum_newsletter_submit_btn_color" => "fdb913",
                "wppum_newsletter_submit_btn_hover" => "fdb913",
                "wppum_newsletter_submit_btn_text_color" => "ffffff",
            ],
            'radios' => [
                'wppum_size_type' => "contents",
            ],
        ],
        '4' => [
            "text" => [
                "wppum_newsletter_submit_btn_color" => "626262",
                "wppum_newsletter_submit_btn_hover" => "626262",
                "wppum_newsletter_submit_btn_text_color" => "ffffff",
                "wppum_width" => "100",
                "wppum_height" => "700",
            ],
            'selectBoxes' => [
                "wppum_height_unit" => "px",
                "wppum_width_unit" => "%",
            ],
            'radios' => [
                'wppum_size_type' => "custom",
            ],
        ],
        '5' => [
            "text" => [
                "wppum_newsletter_submit_btn_color" => "0072bc",
                "wppum_newsletter_submit_btn_hover" => "0072bc",
                "wppum_newsletter_submit_btn_text_color" => "ffffff",
            ],
            'radios' => [
                'wppum_size_type' => "contents",
            ],
        ],
    ];

    private $wppum_popup_theme_defaults = [
        '1' => [
            "text" => [
                "wppum_background_color" => "C7C7C7",
                "wppum_overlay_color" => "303030",
                "wppum_overlay_opacity" => "50",
                "wppum_border_width" => "5",
                "wppum_border_radius" => "2",
                "wppum_border_color" => "ffffff",
                "wppum_padding_top" => "25",
                "wppum_padding_left" => "25",
                "wppum_padding_right" => "25",
                "wppum_padding_bottom" => "25",
                "wppum_background_img"=> WPPUM_PLUGIN_URL."images/backgrounds/pattern-1.png"
            ],
            'radios' => [
                'wppum_size_type' => "custom",
                'wppum_background_type' => "image"
            ],
            'selectBoxes' => [
                'wppum_border_style' => 'solid'
                
            ],
        ],
        '2' => [
            "text" => [
                'wppum_background_color' => "303030",
                "wppum_overlay_color" => "FFFFFF",
                "wppum_overlay_opacity" => "50",
                "wppum_border_width" => "2",
                "wppum_border_radius" => "0",
                "wppum_border_color" => "000000",
                "wppum_padding_top" => "20",
                "wppum_padding_left" => "20",
                "wppum_padding_right" => "20",
                "wppum_padding_bottom" => "20",
                "wppum_background_img"=> WPPUM_PLUGIN_URL."images/backgrounds/pattern-2.png"
            ],
            'selectBoxes' => [
                'wppum_border_style' => 'solid',
                
                
            ],
            'radios' => [
                'wppum_background_type' => "image"
                //'wppum_size_type' => "contents",
            ],
        ],
        '3' => [
            "text" => [
                'wppum_background_color' => "303030",
                "wppum_overlay_color" => "303030",
                "wppum_overlay_opacity" => "50",
                "wppum_border_width" => "2",
                "wppum_border_radius" => "0",
                "wppum_border_color" => "000000",
                "wppum_padding_top" => "20",
                "wppum_padding_left" => "20",
                "wppum_padding_right" => "20",
                "wppum_padding_bottom" => "20",
                "wppum_background_img"=> WPPUM_PLUGIN_URL."images/backgrounds/pattern-2.png"
            ],
            'selectBoxes' => [
                'wppum_border_style' => 'solid',
                
                
            ],
            'radios' => [
                'wppum_background_type' => "image"
                //'wppum_size_type' => "contents",
            ],
        ],

        '4' => [
            "text" => [
                "wppum_background_color" => "ffffff",
                "wppum_overlay_color" => "626262",
                "wppum_overlay_opacity" => "50",
                "wppum_border_width" => "3",
                "wppum_border_radius" => "4",
                "wppum_border_color" => "fbaf5d",
                "wppum_padding_top" => "32",
                "wppum_padding_left" => "32",
                "wppum_padding_right" => "32",
                "wppum_padding_bottom" => "32",
            ],
            'selectBoxes' => [
                'wppum_border_style' => 'solid',
                
            ],
            'radios' => [
                'wppum_background_type' => "color"
                //'wppum_size_type' => "custom",
            ],
        ],
        '5' => [
            "text" => [
                "wppum_background_color" => "003471",
                "wppum_overlay_color" => "303030",
                "wppum_overlay_opacity" => "50",
                "wppum_border_width" => "3",
                "wppum_border_radius" => "4",
                "wppum_border_color" => "ffffff",
                "wppum_padding_top" => "2",
                "wppum_padding_left" => "2",
                "wppum_padding_right" => "2",
                "wppum_padding_bottom" => "2",
            ],
            'selectBoxes' => [
                'wppum_border_style' => 'solid',
                
            ],
            'radios' => [
                'wppum_background_type' => "color"
                //'wppum_size_type' => "contents",
            ],
        ]
    ];
    private $defaults_by_popup = [
        "toggle" => [
            'radios' => [
                'wppum_close_button_type' => "toggle",
                'wppum_size_type' => "contents",
            ],
            'checkboxes' => [
                'wppum_position_centered' => "1",
            ],
            'selectBoxes' => [
                "wppum_animation_effect" => "fade",
            ]
        ],
        "mexit" => [
            'radios' => [
                'wppum_size_type' => "contents",
            ],
            'checkboxes' => [
                "wppum_trigger_on_timing" => "0",
                'wppum_trigger_on_leaving_viewport' => "1",
                'wppum_position_centered' => "1",
            ],
            'selectBoxes' => [
                "wppum_animation_effect" => "fade",
            ]
        ],
        "elink" => [
            'checkboxes' => [
                'wppum_trigger_on_link_click' => "1",
                "wppum_trigger_on_timing" => "0",
            ],
            'radios' => [
                'wppum_link_click_popup_type' => "confirm",
            ],
            'selectBoxes' => [
                "wppum_animation_effect" => "fade",
            ]
        ],
        "fscreen" => [
            'text' => [
                'wppum_width' => "100",
                'wppum_height' => "100",
            ],
            'selectBoxes' => [
                'wppum_height_unit' => "%",
                'wppum_width_unit' => "%",
                "wppum_vertical_offset_type" => "center",
                "wppum_horizontal_offset_type" => "center",
                "wppum_animation_effect" => "fade",
            ],
            'radios' => [
                'wppum_size_type' => "custom",
            ],
            'checkboxes' => [
                'wppum_position_centered' => "1",
            ],
        ],
        "slider" => [
            'text' => [
                "wppum_trigger_delay" => "1000",
            ],
            'selectBoxes' => [
                'wppum_height_unit' => "px",
                'wppum_width_unit' => "px",
                "wppum_vertical_offset_type" => "bottom",
                "wppum_horizontal_offset_type" => "left",
                "wppum_slide_direction" => "left",
                "wppum_animation_effect" => "slide",
            ],
            'radios' => [
                'wppum_size_type' => "contents",
                "wppum_scroll_with_page" => "1",
                "wppum_show_mobile" => "disable_mobile",
            ],
            'checkboxes' => [
                'wppum_position_centered' => "0",
            ],
        ],
    ];
    private $popupSetting = [];

    function __construct() {
        // AJAX validation of popup when saving
        add_action('wp_ajax_wppum_pre_submit_validation', array(&$this, 'pre_submit_validation'));

        global $wppum_default_popup_instructions;
        if (is_admin()) {
            $post_id = isset($_REQUEST['post']) ? sanitize_text_field($_REQUEST['post']) : 0;

            if (isset($_REQUEST['popup_type'])) {
                $this->popup_type = $_REQUEST['popup_type'];
            } else {
                $this->popup_type = $popup_type = get_post_meta($post_id, "popup_type", true);
            }
            if( isset( $wppum_default_popup_instructions[$this->popup_type] ) ) {
                $this->popup_steps = $wppum_default_popup_instructions[$this->popup_type];
            }
            if (isset($_REQUEST['popup_type']) && $_REQUEST['popup_type'] != "") {
                $popuptype = $_REQUEST['popup_type'];
                $popupDefaults = isset($this->defaults_by_popup[$popuptype]) ? $this->defaults_by_popup[$popuptype] : [];
                foreach ($this->default_popup as $key => $value) {
                    $popupDefaultsElement = isset( $popupDefaults[$key] );
                    foreach ($value as $subkey => $subVal) {
                        if (!isset($popupDefaultsElement[$subkey])) {
                            $popupDefaults[$key][$subkey] = $subVal;
                        }
                    }
                }
                $this->popupSetting = $popupDefaults;
            }

            // add PDF link to "Installed plugins" page
            add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);

            // load admin scripts
            add_action('admin_enqueue_scripts', array(&$this, 'load_scripts'));

            add_filter('add_meta_boxes', array(&$this, 'add_remove_meta_boxes'));

            // force meta boxes in Edit Popup pages to be 1-column
            add_filter('screen_layout_columns', array(&$this, 'screen_layout_columns'));
            add_filter('get_user_option_screen_layout_wppum_popup', array(&$this, 'screen_layout_wppum_popup'));

            // set popup updated messages
            add_filter('post_updated_messages', array(&$this, 'popup_updated_messages'));

            // set default post content for new Popup custom type posts
            add_filter('default_content', array(&$this, 'popup_default_content'));

            // change Publish and Draft status text to Live and Disabled respectively
            add_filter('gettext', array(&$this, 'change_popup_status_text'), 10, 3);

            // handle saving of a popup
            add_action('save_post', array(&$this, 'save_popup'));
            add_action('admin_head-post.php', array(&$this, 'publish_admin_hook'));
            add_action('admin_head-post-new.php', array(&$this, 'publish_admin_hook'));
            add_action('admin_head', array(&$this, 'plupload_admin_head'));

            // show header logo/ad/change title text in admin pages
            add_filter('enter_title_here', array(&$this, 'edit_popup_enter_title_text'));
            add_action('admin_footer', array(&$this, 'custom_header_ad_js'));

            // add custom row action links
            add_action('post_row_actions', array(&$this, 'popup_row_actions'), 10, 2);

            // add shortcode columns and sortable Order column to Popups listing screen
            add_filter('manage_wppum_popup_posts_columns', array(&$this, 'popups_list_column_headers'));
            add_action('manage_wppum_popup_posts_custom_column', array(&$this, 'popups_list_column_content'), 10, 2);
            add_action('manage_wppum_popup_posts_custom_column', array(&$this, 'popups_list_pageBuildColumnContent'), 10, 2);
            add_filter('manage_edit-wppum_popup_sortable_columns', array(&$this, 'popups_list_sortable_columns'));

            // handle Duplicate Popup option
            add_action('admin_action_wppum_duplicate', array(&$this, 'duplicate_popup'));
            add_action('admin_notices', array(&$this, 'show_duplicate_success_msg'));

            // register shortcode button
            add_action('admin_init', array(&$this, 'register_mce_button'));

            // register shortcode close link
            add_action('admin_init', array(&$this, 'register_mce_close'));

            // add font selection to tinyMCE editor
            add_filter('mce_buttons', array(&$this, 'add_font_selection_to_tinymce'));
            add_filter('mce_buttons_close', array(&$this, 'add_font_selection_to_tinymce'));
            add_action('tiny_mce_before_init', array(&$this, 'add_custom_fonts_to_tinymce'));

            // add custom  page
            add_action('admin_menu', array(&$this, 'add_settings_page'));
            add_action('admin_init', array(&$this, 'settings_init'));

            // modify imported popup data
            add_filter('wp_import_post_data_processed', array(&$this, 'import_popup'), 10, 2);
            add_filter('wp_import_post_meta', array(&$this, 'import_popup_data'), 10, 3);

            // allow wppum shortcode in nav menu items URLs
            add_action('wp_update_nav_menu_item', array(&$this, 'update_menu_item'), 10, 3);
        }

        add_action('admin_enqueue_scripts', function () {
            if (is_admin())
                wp_enqueue_media();
        });

        // handle AJAX requests for close button image uploads/retrieval of popup names for shortcode dialog
        add_action('wp_ajax_plupload_action', array(&$this, 'g_plupload_action'));
        add_action('wp_ajax_wppum_get_request', array(&$this, 'ajax_get_popups'));
        add_action('wp_ajax_nopriv_newsletter_submit_callback', array(&$this, 'newsletter_submit_callback'));

        add_action('wp_ajax_newsletter_submit_callback', array(&$this, 'newsletter_submit_callback'));

        add_action('admin_init', array($this, 'wppm_page_init'));

        add_action('admin_notices', array($this, 'wppm_admin_notice__success'));

        add_action('admin_head', array($this,'wppm_custom_admin_css'));

        
    }
    function wppm_custom_admin_css() {
          echo '<style>
            #menu-posts-wppum_popup .wp-submenu-wrap li:nth-child(3){
                display: none; 
            }
          </style>';
        }
    function wppm_admin_notice__success() {

        $settings = get_option('wppm_option_name');

        $mailchimp_key = '';
        $mailchimp_list = '';
        $json = array();

        $mailchimp_list = $settings['default_mailing_list_4'];
        $mailchimp_key = $settings['mailchimp_api_key_3'];

        if (empty($mailchimp_list) || empty($mailchimp_key) && (!empty($_GET['popup_type']) && $_GET['post_type'] == 'newsletter' )) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('MailChimp key and list is not configured. Please generate an API key and select a MailChimp list. <a href="edit.php?post_type=wppum_popup&page=wppum_settings">Settings </a>', 'sample-text-domain'); ?></p>
            </div>
            <?php
        }
    }

    function newsletter_submit_callback() {
        global $wpdb; // this is how you get access to the database
        global $counter;

        $settings = get_option('wppm_option_name');

        $mailchimp_key = '';
        $mailchimp_list = '';
        $json = array();

        $mailchimp_list = $settings['default_mailing_list_4'];
        $mailchimp_key = $settings['mailchimp_api_key_3'];

        if (empty($_POST['toEmail'])) {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Email address is required.', 'listingo_core');
            wp_send_json($json);
            die();
        }

        if (isset($_POST['toEmail']) && !empty($_POST['toEmail']) && $mailchimp_key != '') {
            if ($mailchimp_key <> '') {
                $MailChimp = new Listingo_OATH_MailChimp($mailchimp_key);
            }

            $email = sanitize_email($_POST['toEmail']);

            if (isset($_POST['fname']) && !empty($_POST['fname'])) {
                $fname = sanitize_text_field($_POST['fname']);
            } else {
                $fname = '';
            }

            if (isset($_POST['lname']) && !empty($_POST['lname'])) {
                $lname = sanitize_text_field($_POST['lname']);
            } else {
                $lname = '';
            }

            if (trim($mailchimp_list) == '') {
                $json['type'] = 'error';
                $json['message'] = esc_html__('No list selected yet! please contact administrator', 'listingo_core');
                wp_send_json($json);
                die;
            }

            //https://apidocs.mailchimp.com/api/1.3/listsubscribe.func.php
            $result = $MailChimp->listingo_call('lists/subscribe', array(
                'id' => $mailchimp_list,
                'email' => array('email' => $email),
                'merge_vars' => array('FNAME' => $fname, 'LNAME' => $lname),
                'double_optin' => false,
                'update_existing' => false,
                'replace_interests' => false,
                'send_welcome' => true,
            ));
            if ($result <> '') {
                if (isset($result['status']) and $result['status'] == 'error') {
                    $json['type'] = 'error';
                    $json['message'] = $result['error'];
                } else {
                    $json['type'] = 'success';
                    $json['message'] = esc_html__('Subscribe Successfully', 'listingo_core');
                }
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = esc_html__('Some error occur,please try again later.', 'listingo_core');
        }
        wp_send_json($json);
        die();
    }

    /**
     * Change Publish and Draft status text to Live and Disabled respectively.
     * */
    function change_popup_status_text($translated, $original, $domain) {
        global $post_type;

        // ensure the translation only affects WPPUM Popup pages
        if (!empty($post_type) && 'wppum_popup' !== $post_type) {
            return $translated;
        }

        return strtr($original, array('Published' => 'Live', 'Draft' => 'Disabled', 'Save Draft' => 'Save'));
    }

    /**
     * Allow wppum shortcode when saving nav menu item URLs.
     * */
    function update_menu_item($menu_id, $menu_item_db_id, $args) {
        if (strpos($args['menu-item-url'], '[wppum') !== false) {
            update_post_meta($menu_item_db_id, '_menu_item_url', $args['menu-item-url']);
        }
    }

    /**
     * Ensures all popups are imported as Drafts.
     * */
    function import_popup($postdata, $post) {
        // ignore non-popup imports
        if ('wppum_popup' !== $post['post_type']) {
            return $postdata;
        }

        // ensure tags are not stripped from popup content
        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('excerpt_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');

        // force all imported popups to have Draft status
        $postdata['post_status'] = 'draft';
        return $postdata;
    }

    /**
     * Modify URLs in imported popup data to reflect new site.
     * */
    function import_popup_data($postmeta, $post_id, $post) {
        // ignore non-popup imports
        if ('wppum_popup' !== $post['post_type']) {
            return $postmeta;
        }

        static $old_to_new_image_urls = array(
            'close_button_img' => array(),
            'background_img' => array(),
        );
        static $current_image_urls = array(
            'close_button_img' => array(),
            'background_img' => array(),
        );

        // modify the URLs in _wppum postmeta
        foreach ($postmeta as $index => $postmeta_field) {
            if ('_wppum' !== $postmeta_field['key']) {
                continue;   // ignore non-wppum postmeta
            }

            $popup = unserialize($postmeta_field['value']);

            // prepare to parse close/open buttons and background image URLs
            $params = array(
                array(
                    'field_name' => 'close_button_img',
                    'option' => 'wppum_close_button_images',
                    'default_path' => WPPUM_CLOSE_BUTTONS_REL_PATH,
                    'text' => 'close button',
                ),
                array(
                    'field_name' => 'open_button_img',
                    'option' => 'wppum_open_button_images',
                    'default_path' => WPPUM_OPEN_BUTTONS_REL_PATH,
                    'text' => 'open button',
                ),
                array(
                    'field_name' => 'background_img',
                    'option' => 'wppum_background_images',
                    'default_path' => WPPUM_BACKGROUND_IMAGES_REL_PATH,
                    'text' => 'background',
                ),
            );

            for ($i = 0; $i < count($params); $i++) {
                $old_img_url = $popup[$params[$i]['field_name']];
                if (empty($old_img_url)) {
                    continue;
                }

                if (empty($current_image_urls[$params[$i]['field_name']])) {
                    $raw_data = get_option($params[$i]['option']);
                    if (false !== $raw_data) {
                        $current_image_urls[$params[$i]['field_name']] = explode(',', $raw_data);
                    }
                }

                // has image already been processed in a previous imported popup?
                $old_to_new_image_url = $old_to_new_image_urls[$params[$i]['field_name']];
                if (!empty($old_to_new_image_url) && array_key_exists($old_img_url, $old_to_new_image_url)) {
                    $new_img_url = $old_to_new_image_url[$old_img_url];
                } else {
                    // determine whether URL points to default image directory
                    if (false !== strpos($old_img_url, $params[$i]['default_path'])) {
                        // yes; update URL to point to the new default image directory location
                        $new_img_url = WPPUM_PLUGIN_URL . $params[$i]['default_path'] . basename($old_img_url);
                    } else {
                        // no; download image and update URL to point to uploads directory location
                        $tmp_img = download_url($old_img_url);
                        if (is_wp_error($tmp_img)) {
                            echo 'ERROR: Could not download ' . $params[$i]['text'] . ' image file ' . $tmp_img;
                            continue;
                        } else {
                            if (!( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] )) {
                                echo 'ERROR: Could not access WP Uploads directory for ' . $params[$i]['text'] . ' image file ' . $old_img_url;
                                continue;
                            } else {
                                $filename = wp_unique_filename($uploads['path'], basename($old_img_url), null);

                                // Move the file to the uploads dir
                                $new_file = $uploads['path'] . "/$filename";
                                if (false === @ rename($tmp_img, $new_file)) {
                                    echo 'The ' . $params[$i]['text'] . ' image file ' . $old_img_url . ' could not be copied to ' . $uploads['path'] . '.';
                                    continue;
                                } else {
                                    // Set correct file permissions
                                    $stat = stat(dirname($new_file));
                                    $perms = $stat['mode'] & 0000666;
                                    @ chmod($new_file, $perms);

                                    // Compute the new URL
                                    $new_img_url = $uploads['url'] . "/$filename";
                                }
                            }
                        }

                        // ensure this non-default image is added to the main options field
                        if (!in_array($new_img_url, $current_image_urls[$params[$i]['field_name']])) {
                            $current_image_urls[$params[$i]['field_name']][] = $new_img_url;
                            update_option($params[$i]['option'], implode(',', $current_image_urls[$params[$i]['field_name']]));
                        }
                    }
                }

                // update the popup postmeta field
                $popup[$params[$i]['field_name']] = $new_img_url;
                if (empty($old_to_new_image_url) || !array_key_exists($old_img_url, $old_to_new_image_url)) {
                    $old_to_new_image_urls[$params[$i]['field_name']][$old_img_url] = $new_img_url;
                }
            }

            // update the postmeta data
            $postmeta[$index]['value'] = serialize($popup);
        }

        return $postmeta;
    }

    /**
     * Adds plugin  page to wppum_popup custom post type menu.
     * */
    function add_settings_page() {
        add_submenu_page(null, 'Create New Popup', 'Preview Popup', 'manage_options', 'wppum_preview_popup', array(&$this, 'preview_popup_callback'));

        add_submenu_page('edit.php?post_type=wppum_popup', 'Create New Popup', 'Create New Popup', 'manage_options', 'wppum_create_popup', array(&$this, 'create_popup_callback'));

        add_submenu_page('edit.php?post_type=wppum_popup', 'WP Popup Magic - ', 'Settings', 'manage_options', 'wppum_settings', array(&$this, 'settings_page'));
    }

    function create_popup_callback() {

        require_once( WPPUM_POPUP_ADMIN_FILES . '/create-popup-page.php');
    }

    function preview_popup_callback() {

        require_once( WPPUM_POPUP_ADMIN_FILES . '/preview-popup-page.php');
    }

    /**
     * Displays the plugin  page.
     * */
    function settings_page() {
        $this->wppm_options = get_option('wppm_option_name');
        ?>

        <div class="wppum bootstrap-wrapper wppum-box">
            <div class="row" >
                <div class="col-md-9">
                    <h2>Magic Popup</h2>

                </div>
                <div class="col-md-3">
                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/logo_new.png" ?>"/>
                </div>
                <div class="col-md-12">
                    <ul class="nav nav-tabs">

                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#make_new_popups">Settings</a>
                        </li>

                    </ul>


                    <div class="tab-content">

                        <div id="make_new_popups" class="active tab-pane ">
                            <div class="row">
                                <div class="col-md-12 " style="margin-top:15px; margin-bottom: 15px;">
                                    <h4 style="margin-bottom: 20px;">General Settings</h4>

                                    <div class="wrap">
                                        <div id="icon-edit" class="icon32 icon32-posts-wppum_popup"><br /></div>
                                        <h2></h2>
                                        <form action="options.php" method="post">
                                            <?php //settings_fields('wppum_settings');           ?>
                                            <?php settings_fields('wppm_option_group'); ?>

                                            <?php
                                            do_settings_sections('wppm-admin');

                                            ///do_settings_sections('wppum'); 
                                            ?>

                                            <p class="submit">
                                                <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
                                            </p>
                                        </form>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <?php
    }

    public function wppm_page_init() {
        register_setting(
                'wppm_option_group', // option_group
                'wppm_option_name', // option_name
                array($this, 'wppm_sanitize') // sanitize_callback
        );

        add_settings_section(
                'wppm_setting_section', // id
                '', // title
                array($this, 'wppm_section_info'), // callback
                'wppm-admin' // page
        );

        add_settings_field(
                'enable_popup_0', // id
                'Enable popup', // title
                array($this, 'enable_popup_0_callback'), // callback
                'wppm-admin', // page
                'wppm_setting_section' // section
        );

        add_settings_field(
                'enable_plugin_on_mobile_devices_1', // id
                'Enable Plugin on Mobile Devices    ', // title
                array($this, 'enable_plugin_on_mobile_devices_1_callback'), // callback
                'wppm-admin', // page
                'wppm_setting_section' // section
        );

        add_settings_field(
                'mailing_list_manager_2', // id
                'Mailing List Manager', // title
                array($this, 'mailing_list_manager_2_callback'), // callback
                'wppm-admin', // page
                'wppm_setting_section' // section
        );

        add_settings_field(
                'mailchimp_api_key_3', // id
                'MailChimp API Key', // title
                array($this, 'mailchimp_api_key_3_callback'), // callback
                'wppm-admin', // page
                'wppm_setting_section' // section
        );

        add_settings_field(
                'default_mailing_list_4', // id
                'Default Mailing List', // title
                array($this, 'default_mailing_list_4_callback'), // callback
                'wppm-admin', // page
                'wppm_setting_section' // section
        );
    }

    public function wppm_sanitize($input) {
        $sanitary_values = array();
        if (isset($input['enable_popup_0'])) {
            $sanitary_values['enable_popup_0'] = $input['enable_popup_0'];
        }

        if (isset($input['enable_plugin_on_mobile_devices_1'])) {
            $sanitary_values['enable_plugin_on_mobile_devices_1'] = $input['enable_plugin_on_mobile_devices_1'];
        }

        if (isset($input['mailing_list_manager_2'])) {
            $sanitary_values['mailing_list_manager_2'] = $input['mailing_list_manager_2'];
        }

        if (isset($input['mailchimp_api_key_3'])) {
            $sanitary_values['mailchimp_api_key_3'] = esc_textarea($input['mailchimp_api_key_3']);
        }

        if (isset($input['default_mailing_list_4'])) {
            $sanitary_values['default_mailing_list_4'] = $input['default_mailing_list_4'];
        }

        return $sanitary_values;
    }

    public function wppm_section_info() {
        
    }

    public function enable_popup_0_callback() {
        ?> <select name="wppm_option_name[enable_popup_0]" id="enable_popup_0">
        <?php $selected = (isset($this->wppm_options['enable_popup_0']) && $this->wppm_options['enable_popup_0'] === 'yes') ? 'selected' : ''; ?>
            <option value="yes" <?php echo $selected; ?>>Yes</option>
            <?php $selected = (isset($this->wppm_options['enable_popup_0']) && $this->wppm_options['enable_popup_0'] === 'no') ? 'selected' : ''; ?>
            <option value="no" <?php echo $selected; ?>>No</option>
        </select> <?php
    }

    public function enable_plugin_on_mobile_devices_1_callback() {
        ?> <select name="wppm_option_name[enable_plugin_on_mobile_devices_1]" id="enable_plugin_on_mobile_devices_1">
        <?php $selected = (isset($this->wppm_options['enable_plugin_on_mobile_devices_1']) && $this->wppm_options['enable_plugin_on_mobile_devices_1'] === 'yes') ? 'selected' : ''; ?>
            <option value="yes" <?php echo $selected; ?>>Yes</option>
            <?php $selected = (isset($this->wppm_options['enable_plugin_on_mobile_devices_1']) && $this->wppm_options['enable_plugin_on_mobile_devices_1'] === 'no') ? 'selected' : ''; ?>
            <option value="no" <?php echo $selected; ?>>No</option>
        </select> <?php
    }

    public function mailing_list_manager_2_callback() {
        ?> <select name="wppm_option_name[mailing_list_manager_2]" id="mailing_list_manager_2">
        <?php $selected = (isset($this->wppm_options['mailing_list_manager_2']) && $this->wppm_options['mailing_list_manager_2'] === 'mailchimp') ? 'selected' : ''; ?>
            <option value="mailchimp" <?php echo $selected; ?>>MaliChimp</option>
        </select> <?php
    }

    public function mailchimp_api_key_3_callback() {
        printf(
                '<input type="text" class="large-text" rows="5" name="wppm_option_name[mailchimp_api_key_3]" id="mailchimp_api_key_3" value="%s">', isset($this->wppm_options['mailchimp_api_key_3']) ? esc_attr($this->wppm_options['mailchimp_api_key_3']) : ''
        );
        echo '<p><span class="help-text">Get and Api key From <a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank">Get API KEY</a></span></p>';
    }

    public function default_mailing_list_4_callback() {
        $list = ($this->listingo_mailchimp_list($this->wppm_options['mailchimp_api_key_3']));
        ?> <select name="wppm_option_name[default_mailing_list_4]" id="default_mailing_list_4">

            <?php
            foreach ($list as $key => $value) {
                $selected = (isset($this->wppm_options['default_mailing_list_4']) && $this->wppm_options['default_mailing_list_4'] == $key ) ? 'selected' : '';
                ?>
                <option <?php echo $selected; ?> value="<?php echo esc_attr($key) ?>" ><?php echo esc_attr($value) ?></option>
            <?php } ?>
        </select> <?php
    }

    /**
     * Register the settings page options.
     * */
    function settings_init() {
        global $post;
        $disabledEditor = [
            'shortcode',
            "iframe",
            'newsletter',
            "video",
        ];


        if (in_array($this->popup_type, $disabledEditor)) {
            remove_post_type_support("wppum_popup", 'editor');
        }
        register_setting('wppum_settings', 'wppum_settings', array(&$this, 'settings_validate'));
        add_settings_section('wppum_settings_main', '', array(&$this, 'main_settings_section_text'), 'wppum');
        add_settings_field('wppum_ads', 'Ads in admin area', array(&$this, 'settings_ads'), 'wppum', 'wppum_settings_main');
    }

    /**
     * @Mailchimp List
     * @return 
     */
    function listingo_mailchimp_list($id) {
        $mailchimp_list[] = '';
        $mailchimp_list[0] = esc_html__('Select List', 'listingo');
        $mailchimp_option = $id;

        if ($mailchimp_option <> '') {
            if (class_exists('listingo_MailChimp')) {
                $mailchim_obj = new Listingo_MailChimp();
                $lists = $mailchim_obj->listingo_mailchimp_list($mailchimp_option);

                if (is_array($lists) && isset($lists['data'])) {
                    foreach ($lists['data'] as $list) {
                        if (!empty($list['name'])) :
                            $mailchimp_list[$list['id']] = $list['name'];
                        endif;
                    }
                }
            }
        }
        return $mailchimp_list;
    }

    /**
     * Display the main settings section text.
     * */
    function main_settings_section_text() {
        echo '';
    }

    /**
     * Display the setting for enabling/disabling ads.
     * */
    function settings_ads() {
        $settings = get_option('wppum_settings');
        ?>
        <label>
            <input type="radio" id="wppum_ads_enabled" name="wppum_settings[wppum_ads]" value="1"<?php echo intval($settings['wppum_ads']) !== 0 ? ' checked="checked"' : ''; ?> />
            Enabled
        </label>
        <br />
        <label>
            <input type="radio" id="wppum_ads_disabled" name="wppum_settings[wppum_ads]" value="0"<?php echo intval($settings['wppum_ads']) === 0 ? ' checked="checked"' : ''; ?> />
            Disabled
        </label>
        <?php
    }

    /**
     * Validate settings before saving.
     * */
    function settings_validate($input) {
        $settings = get_option('wppum_settings');
        $settings['wppum_ads'] = intval(trim($input['wppum_ads']));
        if ($settings['wppum_ads'] !== 0 && $settings['wppum_ads'] !== 1) {
            $settings['wppum_ads'] = 1;
        }
        return $settings;
    }

    /**
     * Add font selection dropdown to the tinyMCE editor when editing popups.
     * */
    function add_font_selection_to_tinymce($buttons) {
        global $post;
        if (isset($post->post_type ) && $post->post_type === 'wppum_popup') {
            array_push($buttons, 'fontselect');
        }
        return $buttons;
    }

    /**
     * Register custom Google fonts in tinyMCE editor when editing popups.
     * */
    function add_custom_fonts_to_tinymce($in) {

        global $post, $wppum_fonts;

        if (isset($post->post_type ) && $post->post_type !== 'wppum_popup') {
            return $in;
        }

        // default fonts
        $default_fonts = array( );

        // combine default and custom fonts and sort them in alphabetical order
        $fonts = array_merge($default_fonts, $wppum_fonts);
        ksort($fonts);

        // generate the fonts strings
        $theme_advanced_fonts = '';
        $content_css = '';
        foreach ($fonts as $font_name => $font) {
            if (is_array($font)) {
                $font_family = $font[0];
                $content_css .= str_replace(',', '%2C', $font[1]) . ',';
            } else {
                $font_family = $font;
            }
            $font_family = str_replace("'", "", $font_family);
            $theme_advanced_fonts .= $font_name . '=' . ( ( substr($font_family, -1) === ';' ) ? substr($font_family, 0, -1) : $font_family ) . ';';
        }
        $theme_advanced_fonts = substr($theme_advanced_fonts, 0, -1);   // remove semi-colon from final font
        $content_css = substr($content_css, 0, -1);   // remove comma from final font CSS
        // set tinymce parameters
        $in['content_css'] = $content_css;
        // $in['theme_advanced_fonts'] = $theme_advanced_fonts; // Pre
        $in['font_formats'] = $theme_advanced_fonts;

        return $in;
    }

    /**
     * Retrieves the current post being edited, based on post or post_ID parameters.
     * Used during admin_init, when global $post variable is not yet set.
     * */
    function get_admin_post() {
        $post_id = absint(isset($_GET['post']) ? $_GET['post'] : ( isset($_POST['post_ID']) ? $_POST['post_ID'] : 0 ));
        $post = $post_id != 0 ? get_post($post_id) : false; // Post Object, like in the Theme loop
        return $post;
    }

    /**
     * Register WP Popup Magic shortcode button and MCE plugin in "Edit Post/Page" screens.
     * */
    function register_mce_button() {
        $post = $this->get_admin_post();
        if ((!current_user_can('edit_posts') && !current_user_can('edit_pages') ) || ( isset($_GET['post_type']) && 'wppum_popup' === $_GET['post_type']) || ($post && 'wppum_popup' === $post->post_type )) {
            return;
        }
    }

    /**
     * Register WP Popup Magic shortcode button and MCE plugin in "Edit Post/Page" screens.
     * */
    function register_mce_close() {
        $post = $this->get_admin_post();

        if ($post && 'wppum_popup' != $post->post_type) {
            return;
        }
    }

    /**
     * Returns the URL to the dummy preview post for the specified popup.
     * */
    function get_preview_popup_link($popup_id) {
        static $dummy_post = null;

        if (empty($dummy_post)) {
            // simply use the first post available in database
            $dummy_posts = get_posts(array('numberposts' => 1, 'post_status' => 'publish'));
            if (empty($dummy_posts)) {
                // no published posts available; try drafts
                $dummy_posts = get_posts(array('numberposts' => 1, 'post_status' => 'draft'));
            }

            if (empty($dummy_posts)) {
                return '';   // no posts found!
            }

            $dummy_post = $dummy_posts[0];
        }

        return add_query_arg(array('wppum_preview' => $popup_id), get_permalink($dummy_post->ID));
    }

    /**
     * Add PDF link to Wordpress 'Installed plugins' page.
     * */
    function plugin_action_links($links, $file) {
        if ($file == plugin_basename(WPPUM_PLUGIN_PATH . 'wp-popup-magic.php')) {
            $links[] = '<a target="_blank" href="' . WPPUM_PLUGIN_PDF_URL . '">' . __('PDF Manual', WPPUM_I18N_DOMAIN) . '</a>';
        }

        return $links;
    }

    /**
     * Change the default "Post updated" messages for Popup custom post types.
     * */
//SDB - removed preview links in update messages
    function popup_updated_messages($messages) {
        global $post, $post_ID;
        $messages['wppum_popup'] = array(
            1 => sprintf(__('Popup updated'), esc_url($this->get_preview_popup_link($post_ID))),
            4 => __('Popup updated.'),
            5 => isset($_GET['revision']) ? sprintf(__('Popup restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf(__('Popup is now live.'), esc_url($this->get_preview_popup_link($post_ID))),
            7 => __('Popup saved.'),
        );
        return $messages;
    }

    /**
     * Validates popup title and other fields before saving (triggered via AJAX).
     * */
    function pre_submit_validation() {
        global $wppum;

        parse_str($_POST['form_data'], $vars);
        $error = '';
        $success = true;

        // ensure user is trying to publish popup
        if ($vars['post_status'] == 'publish' ||
                ( isset($vars['original_publish']) &&
                in_array($vars['original_publish'], array('Publish', 'Schedule', 'Update')) )) {
            // ensure popup title is not blank
            if (empty($vars['post_title'])) {
                $error = __('Please key in a name for the popup.', WPPUM_I18N_DOMAIN);
            }

            // ensure popup title doesn't contain invalid characters
            if (empty($error)) {
                if (strpbrk($vars['post_title'], '[\'"]<>\\') !== false) {
                    $error = __('Sorry, popup name cannot contain the characters [ ] \' " < > \\', WPPUM_I18N_DOMAIN);
                }
            }

            // ensure popup title doesn't already exist
            if (empty($error)) {
                $popups = $wppum->get_all_popups();
                foreach ($popups as $popup) {
                    if (strtolower($popup['name']) === strtolower($vars['post_title']) && $popup['ID'] !== intval($vars['post_ID'])) {
                        $error = __('Popup name already exists! Please choose another name.', WPPUM_I18N_DOMAIN);
                        break;
                    }
                }
            }

            // ensure if background type is "image", an image is actually selected
            if (empty($error)) {
                if ($vars['wppum_background_type'] === 'image' && empty($vars['wppum_background_img'])) {
                    $error = __('Please select or upload a background image.', WPPUM_I18N_DOMAIN);
                }
            }

            // ensure if "Use background image size" is selected, background type must be image
            if (empty($error)) {
                if ($vars['wppum_size_type'] === 'bgimage' && $vars['wppum_background_type'] !== 'image') {
                    $error = __('No background image selected. Please select a different size setting.', WPPUM_I18N_DOMAIN);
                }
            }

            // ensure if close button is enabled, an image is actually selected
            if (empty($error)) {
                if ((isset($vars['wppum_show_hide_close_button']) && $vars['wppum_show_hide_close_button'] === 'show') && empty($vars['wppum_close_button_img'])) {
                    $error = __('Please select or upload a close button image.', WPPUM_I18N_DOMAIN);
                }
            }

            // ensure both "Custom limit" frequency settings have numeric values that are at least 1
            if (empty($error)) {
                if ('custom' == $vars['wppum_frequency_type']) {
                    if (!is_numeric($vars['wppum_frequency_limit_times']) || $vars['wppum_frequency_limit_times'] < 1) {
                        $error = __('A frequency with a custom limit must have at least 1 popup showing.', WPPUM_I18N_DOMAIN);
                    } elseif (!is_numeric($vars['wppum_frequency_limit_days']) || $vars['wppum_frequency_limit_days'] < 1) {
                        $error = __('A frequency with a custom limit must have at least 1 day of showing.', WPPUM_I18N_DOMAIN);
                    }
                }
            }
        }

        $success = empty($error);
        $result = array('success' => $success, 'error' => $error);

        // return success/failure result
        echo json_encode($result);
        die();
    }

    /**
     * Saves additional custom fields for a Popup custom post type.
     * */
    function save_popup($post_id) {
        global $wppum, $wppum_fonts;


        $post = get_post($post_id);
        if (( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || $post->post_status === 'auto-draft') {
            return;
        }

        if ('wppum_popup' !== $post->post_type) {
            return;
        }

        if (!isset($_POST['wppum_save_nonce'])) {
            return;
        }

        check_admin_referer('wppum_save', 'wppum_save_nonce');

        $popup = $wppum->sanitize_popup();

        if (isset($_POST['popup_type'])) {
            $type = sanitize_text_field( $_POST['popup_type'] );
            update_post_meta($post_id, 'popup_type', $type);
            if ($type == "shortcode") {
                $wppum_shortcode_val = sanitize_text_field( $_POST['wppum_shortcode_val'] );
                remove_action('save_post', array(&$this, 'save_popup'));
                wp_update_post(array('ID' => $post_id, 'post_content' => $wppum_shortcode_val));

                add_action('save_post', array(&$this, 'save_popup'));
            }
            if ($type == "video") {
                $video_link = esc_url_raw($_POST['wppum_embed_video']);
                remove_action('save_post', array(&$this, 'save_popup'));
                wp_update_post(array('ID' => $post_id, 'post_content' => $video_link));

                add_action('save_post', array(&$this, 'save_popup'));
            }
            if ($type == "iframe") {
                $video_link = wp_kses_allowed_html($_POST['wppum_iframe']);
                remove_action('save_post', array(&$this, 'save_popup'));
                wp_update_post(array('ID' => $post_id, 'post_content' => $video_link));

                add_action('save_post', array(&$this, 'save_popup'));
            }
        }

        // save all values to single custom field
        update_post_meta($post_id, '_wppum', $popup);

        // update close buttons options
        if (isset($_POST['wppum_close_button_images'])) {
            update_option('wppum_close_button_images', $_POST['wppum_close_button_images']);
        }

        // update open buttons options
        if (isset($_POST['wppum_open_button_images'])) {
            update_option('wppum_open_button_images', $_POST['wppum_open_button_images']);
        }

        // update background images options
        if (isset($_POST['wppum_background_images'])) {
            update_option('wppum_background_images', $_POST['wppum_background_images']);
        }

        // update post status
        if ($_POST['save'] === __('Save Draft') || ( $_POST['original_publish'] === __('Update') && $_POST['post_status'] === 'draft' )) {
            remove_action('save_post', array(&$this, 'save_popup'));
            wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
            add_action('save_post', array(&$this, 'save_popup'));
        } else {
            wp_publish_post($post_id);
        }
    }

    /**
     * Sets default post content for new Popups.
     * */
    function popup_default_content($content) {
        global $pagenow, $wppum_default_popup;
        if ('post-new.php' === $pagenow && isset($_GET['post_type']) && 'wppum_popup' === $_GET['post_type']) {
            return $wppum_default_popup['contents'];
        }

        return $content;
    }

    /**
     * Adds custom column headers to the Popups list page.
     * */
    function popups_list_column_headers($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', WPPUM_I18N_DOMAIN),
            'shortcode' => __('Shortcode', WPPUM_I18N_DOMAIN),
            'order' => __('Order', WPPUM_I18N_DOMAIN),
            'date' => __('Date', WPPUM_I18N_DOMAIN)
        );
        return $columns;
    }

    function popups_list_pageBuildColumnContent( $column, $post_id=0 ) {
        if( 'shortcode' == $column ) {
            $title = get_the_title( $post_id );
            echo ( '<input type="text" value="[wppum name=\''.$title.'\']" onfocus="this.select();" class="large-text" readonly="readonly">' );
        }
    }

    /**
     * Shows the custom column data in Popups list page.
     * */
    function popups_list_column_content($column_name, $post_ID) {
        $post = get_post($post_ID);

        if ($column_name == 'order') {
            echo $post->menu_order;
        } else if ($column_name === 'start_shortcode') {
            echo '<code>[wppum name="' . $post->post_title . '"]</code>';
        } else if ($column_name === 'end_shortcode') {
            echo '<code>[wppum_end name="' . $post->post_title . '"]</code>';
        } else if ($column_name === 'link_shortcode') {
            echo "Data Popup Name: \n <br>";

// echo '<code>data-popup-name="' . $post->post_title . '"</code>';
            echo '<code>data-popup-name="' . $post->post_title . '"</code>';
            echo " \n <br>";
            echo " \n <br>Sample HTML code: \n <br>";
            echo htmlspecialchars('<a href="#" data-popup-name="' . $post->post_title . '">Click Here</a>');
            echo " \n <br> ";
            echo " \n <br>*Important* Make sure to paste code into the <strong>Text</strong> side of the editor, not the Visual side of the WP editor \n <br>";
        }
    }

    /**
     * Indicate sortable custom columns in Popups list page.
     * */
    function popups_list_sortable_columns($columns) {
        $columns['order'] = 'menu_order';
        return $columns;
    }

    /**
     * Displays success message after duplication of a popup.
     * */
    function show_duplicate_success_msg() {
        if (isset($_GET['wppum_duplicated'])) {
            if (isset($_GET['wppum_duplicate_id']) && isset($_GET['wppum_duplicate_new_id'])) {
                // show successful duplication message

                $post_id = intval($_GET['wppum_duplicate_id']);
                $new_post_id = intval($_GET['wppum_duplicate_new_id']);
                $post = get_post($post_id);
                $new_post = get_post($new_post_id);
                ?><div id="wppum-message" class="updated"><p>Popup <code><?php echo esc_html($post->post_title); ?></code> successfully duplicated to <code><?php echo esc_html($new_post->post_title); ?></code>.</p></div><?php
            }
        }
        $_SERVER['REQUEST_URI'] = remove_query_arg(array('wppum_duplicated', 'wppum_duplicate_id', 'wppum_duplicate_new_id'), $_SERVER['REQUEST_URI']);
    }

    /**
     * Duplicates specified popup with a unique title.
     * */
    function duplicate_popup() {
        global $wppum;

        $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
        if (empty($post_id)) {
            // nothing to do if no post ID specified
            return;
        }

        // get the popup post details
        $post = get_post($post_id);
        $post_type = null;
        if ($post) {
            $post_type = $post->post_type;
            $post_type_object = get_post_type_object($post_type);
        }

        if ($post_type !== 'wppum_popup') {
            // ignore if somehow trying to duplicate non-popup post
            return;
        }

        // ensure request came from valid source
        check_admin_referer('wppum_duplicate');

        // prepare unique title for cloned popup (suffixed with an incremental counter)
        $popups = $wppum->get_all_popups();
        $base_title = $post->post_title;
        $suffix = 2;
        $is_duplicate = true;
        while ($is_duplicate) {
            $new_title = $base_title . '_' . $suffix;
            $suffix++;
            $is_duplicate = false;

            // ensure the new popup title doesn't already exist
            foreach ($popups as $popup) {
                if (strtolower($popup['name']) === strtolower($new_title)) {
                    $is_duplicate = true;
                    break;
                }
            }
        }

        // duplicate the popup
        $new_popup = array(
            'post_title' => $new_title,
            'menu_order' => $post->menu_order,
            'post_content' => $post->post_content,
            'post_status' => $post->post_status,
            'post_type' => 'wppum_popup',
        );
        $new_post_id = wp_insert_post($new_popup);
        update_post_meta($new_post_id, '_wppum', get_post_meta($post_id, '_wppum', true));

        // redirect to original edit.php page
        $_GET['_wp_http_referer'] = 'test';
        $sendback = remove_query_arg(array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer());
        wp_redirect(add_query_arg(array('wppum_duplicated' => 1, 'wppum_duplicate_id' => $post_id, 'wppum_duplicate_new_id' => $new_post_id), $sendback));
        exit();
    }

    /**
     * Force meta boxes in Edit Popup pages to appear in single column.
     * */
    function screen_layout_columns($columns) {
        $columns['wppum_popup'] = 2;
        return $columns;
    }

    function screen_layout_wppum_popup() {
        return 2;
    }

    /**
     * Adds/removes meta boxes from Edit Popup pages.
     * */
    function add_remove_meta_boxes() {
        global $post, $wppum;
        //$this->popup_type = $popup_type = get_post_meta($post->ID, "popup_type", true);
        // grabs the custom fields of this popup
        $this->popup = $wppum->get_popup($post->ID);
        $popup_type = $this->popup_type;

        // remove "Slug" metabox, as well as "submit" and "attributes" metaboxes from "side" column
        remove_meta_box('slugdiv', 'wppum_popup', 'normal');
        remove_meta_box('submitdiv', 'wppum_popup', 'side');
        remove_meta_box('pageparentdiv', 'wppum_popup', 'side');
        remove_meta_box('mymetabox_revslider_0', 'wppum_popup', 'normal');

        // add/re-establish custom metaboxes

        add_meta_box('wppumstatusandpreviewdiv', __('Status', WPPUM_I18N_DOMAIN), 'post_submit_meta_box', 'wppum_popup', 'side', 'core');

        add_meta_box('wppumdesignelementsdiv', __('Popup Design Elements', WPPUM_I18N_DOMAIN), array(&$this, 'popup_design_element_metabox'), 'wppum_popup', 'normal', 'core');

        add_meta_box('wppumwhentodisplaydiv', __('When To Display Popup', WPPUM_I18N_DOMAIN), array(&$this, 'when_to_display_metabox'), 'wppum_popup', 'normal', 'core');

        add_meta_box('wppumanimationeffectsdiv', __('Popup Animation Effects', WPPUM_I18N_DOMAIN), array(&$this, 'popup_animation_meta_box'), 'wppum_popup', 'normal', 'core');
        add_meta_box('wppumwheretoplacediv', __('Where To Place Popup', WPPUM_I18N_DOMAIN), array(&$this, 'when_to_place_metabox'), 'wppum_popup', 'normal', 'core');

        add_meta_box('wppumwhentohidediv', __('When to Hide Popup', WPPUM_I18N_DOMAIN), array(&$this, 'when_to_hide_metabox'), 'wppum_popup', 'normal', 'core');




        add_meta_box('wppumdimensionsdiv', __('Popup Dimensions', WPPUM_I18N_DOMAIN), array(&$this, 'popup_dimensions_meta_box'), 'wppum_popup', 'normal', 'core');

        add_meta_box('wppumadvancedoptionsdiv', __('Advanced Options', WPPUM_I18N_DOMAIN), array(&$this, 'popup_advance_option_meta_box'), 'wppum_popup', 'normal', 'core');
        
        add_meta_box('wppumpageparentdiv', __('Instructions', WPPUM_I18N_DOMAIN), array(&$this, 'instructions_meta_box'), 'wppum_popup', 'side', 'core');


        if ($popup_type == "shortcode" || (isset($_REQUEST['popup_type']) && $_REQUEST['popup_type'] == "shortcode")) {
            add_meta_box('wppumshortcodemetaboxdiv', __('Insert Shortcode', WPPUM_I18N_DOMAIN), array(&$this, 'shortcodepopup_meta_box'), 'wppum_popup', 'normal', 'high');
        }
        if ($popup_type == "iframe" || (isset($_REQUEST['popup_type']) && $_REQUEST['popup_type'] == "iframe")) {
            add_meta_box('wppumiframemetaboxdiv', __('Insert Iframe', WPPUM_I18N_DOMAIN), array(&$this, 'iframepopup_meta_box'), 'wppum_popup', 'normal', 'high');
        }
        if ($popup_type == "video" || (isset($_REQUEST['popup_type']) && $_REQUEST['popup_type'] == "video")) {
            add_meta_box('wppumvideometaboxdiv', __('Insert Embed Video Code', WPPUM_I18N_DOMAIN), array(&$this, 'videopopup_meta_box'), 'wppum_popup', 'normal', 'high');
        }
        if ($popup_type == "newsletter" || (isset($_REQUEST['popup_type']) && $_REQUEST['popup_type'] == "newsletter")) {
            add_meta_box('wppumnewslettermetaboxdiv', __('Insert NewsLetter', WPPUM_I18N_DOMAIN), array(&$this, 'newsletterpopup_meta_box'), 'wppum_popup', 'normal', 'high');
        }
    }

    /**
     * Add 'wppum-meta-box' class to all main Popup Meta Boxes for CSS styling.
     * */
    function add_wppum_metabox_class($classes) {
        array_push($classes, 'wppum-meta-box');
        return $classes;
    }

    function add_left_half_metabox_class($classes) {
        array_push($classes, 'left-half-child');
        return $classes;
    }

    function add_right_half_metabox_class($classes) {
        array_push($classes, 'right-half-child');
        return $classes;
    }

    /**
     * Add 'wppum-parent-meta-box' class to all child Popup Meta Boxes for Javascript toggling.
     * */
    function add_wppumwhentodisplay_metabox_class($classes) {
        array_push($classes, 'wppumwhentodisplaydiv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumwheretoplace_metabox_class($classes) {
        array_push($classes, 'wppumwheretoplacediv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumdesignelements_metabox_class($classes) {
        array_push($classes, 'wppumdesignelementsdiv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumwhentohide_metabox_class($classes) {
        array_push($classes, 'wppumwhentohidediv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumdimensions_metabox_class($classes) {
        array_push($classes, 'wppumdimensionsdiv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumanimationeffects_metabox_class($classes) {
        array_push($classes, 'wppumanimationeffectsdiv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumwheretodisplay_metabox_class($classes) {
        array_push($classes, 'wppumwheretodisplaydiv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    function add_wppumadvancedoptions_metabox_class($classes) {
        array_push($classes, 'wppumadvancedoptionsdiv-child-meta-box', 'wppum-child-meta-box');
        return $classes;
    }

    /**
     * Remove screen options from Edit Popup page./
     * */
    function hide_screen_options() {
        return false;
    }

    /**
     * Display selection for 'px' or '%'.
     * */
    function display_unit_selection($field) {
        $value = $this->popup[$field];
        $unit = 'px';
        if (!empty($value) && ( strlen($value) < 2 || substr($value, -1) === '%' )) {
            $unit = '%';
        }
        ?>
        <select class="unit_selection" name="wppum_<?php echo $field; ?>_unit">
            <option <?php echo $unit === 'px' ? 'selected="selected" ' : ''; ?>value="px">px</option>
            <option <?php echo $unit === '%' ? 'selected="selected" ' : ''; ?>value="%">%</option>
        </select>
        <?php
    }

    /**
     * Returns HTML for specified label with its corresponding tooltip.
     * */
    function get_tooltip_html($tooltip_id, $title = '', $popover = true) {
        global $wppum_tooltip_text;

        if (empty($title)) {
            $title = $tooltip_id;
        }

        ob_start();
        ?>

        <span><?php esc_html_e($title); ?></span>

        <?php
        if ($popover) {
            ?>
            <a  data-placement="top" class=" wppum-tooltip popovers" data-trigger="focus" data-toggle="popover"  title="<?= $tooltip_id; ?>" data-content="<?php echo esc_attr($wppum_tooltip_text[$tooltip_id]); ?>" href="javascript:void(0);" >?</a>

            <?php
        }
        return ob_get_clean();
    }

    function get_title_secton($title = '') {
        ob_start();
        ?>
        <h2 class="section_title"><?php
            esc_html_e($title);
            ?>


        </h2>
        <?php
        return ob_get_clean();
    }

    /**
     * Dummy header meta box.
     * */
    function popup_header_meta_box() {
        
    }

    function when_to_display_metabox($post) {
        $this->popup_events_meta_box($post);
        $this->popup_frequency_meta_box($post);
        $this->popup_mobile_meta_box($post);
        $this->popup_pages_posts_meta_box($post);
    }

    function when_to_place_metabox($post) {
        $this->popup_position_meta_box($post);
    }

    function when_to_hide_metabox($post) {
        $this->popup_self_close_meta_box($post);
        $this->popup_close_button_meta_box($post);
    }

    function popup_design_element_metabox($post) {
        $this->popup_theme_setting_meta_box($post);
        $this->popup_bg_meta_box($post);
        $this->popup_overlay_meta_box($post);
        $this->popup_border_meta_box($post);
        $this->popup_border_content_padding_meta_box($post);
        $this->popup_title_meta_box($post);
    }

    function popup_dimensions_meta_box($post) {
        $this->popup_size_meta_box($post);
    }

    function popup_animation_meta_box($post) {
        $this->popup_slide_animation_meta_box($post);
    }

    function popup_advance_option_meta_box($post) {
        $this->popup_css_meta_box($post);
    }

    function page_popup_preview_meta_box($post) {
        ?>
        <div style="height: 100px; text-align: center; vertical-align: middle;">
            <input type="hidden" name="popup_type" value="<?= isset($_REQUEST['popup_type']) ? $_REQUEST['popup_type'] : $this->popup_type; ?>"/>
            <a target="_blank" class="button button-primary button-large" href="<?php echo admin_url("/edit.php?post_type=wppum_popup&page=wppum_preview_popup&wppum_preview=$post->ID"); ?>">Preview</a>
        </div>
        <?php
    }

    function instructions_meta_box($post) {
        ?>
        <input type="hidden" name="popup_type" value="<?= isset($_REQUEST['popup_type']) ? $_REQUEST['popup_type'] : $this->popup_type; ?>"/>
        <?php
        echo "<ul class='popup_inst'>";
        foreach ($this->popup_steps as $step) {
            echo "<li>$step</li>";
        }
        echo "</ul>";
    }

    function preview_new_button($post) {
        ?>
        <!--<div class="wppum-row ">-->
        <!--<div class="wppum-right" style="text-align:right;">-->
        <input type="hidden" name="popup_type" value="<?= isset($_REQUEST['popup_type']) ? $_REQUEST['popup_type'] : $this->popup_type; ?>"/>
        <a target="_blank" class="button button-primary button-large" href="<?php echo admin_url("/edit.php?post_type=wppum_popup&page=wppum_preview_popup&wppum_preview=$post->ID"); ?>">Preview</a>

        <!--            </div>
                </div>-->
        <?php
    }

    function preview_link_metabox($post) {
        ?>

        <div class="wppum-row ">
            <div class="wppum-right" style="text-align:right;">
                <input type="hidden" name="popup_type" value="<?= isset($_REQUEST['popup_type']) ? $_REQUEST['popup_type'] : $this->popup_type; ?>"/>
                <a target="_blank" class="button button-primary button-large" href="<?php echo admin_url("/edit.php?post_type=wppum_popup&page=wppum_preview_popup&wppum_preview=$post->ID"); ?>">Preview</a>

            </div>
        </div>

        <?php
    }

    function newsletterpopup_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupsize">
            <div class="bootstrap-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="wppum-row ">
                            <div class="wppum-left_30">
                                <input name="wppum_trigger_on_newsletter_email" type="checkbox" id="wppum_trigger_on_newsletter_email" value="1" <?php echo ( $this->popup['trigger_on_newsletter_email'] === '1' ) ? 'checked="checked" ' : ''; ?>/> 

                                <label for="wppum_trigger_on_newsletter_email">Enable User name field</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="wppum-row ">
                            <div class="wppum-left_30">
                                <input name="wppum_require_name_newsletter_email" type="checkbox" id="wppum_require_name_newsletter_email" <?= $this->popup['trigger_on_newsletter_email'] == '1' ? "" : "disabled" ?> value="1" <?php echo ( $this->popup['require_name_newsletter_email'] === '1' ) ? 'checked="checked" ' : ''; ?>/>  

                                <label for="wppum_require_name_newsletter_email">Require User name field</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="bootstrap-wrapper" style="margin-bottom:15px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_email">User Name Placeholder</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" <?= $this->popup['trigger_on_newsletter_email'] == '1' ? "" : "disabled" ?> id="wppum_newsletter_name_placeholder" name="wppum_newsletter_name_placeholder"  value="<?php echo $this->popup['newsletter_name_placeholder']; ?>"/>
                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_email_placeholder">E-Mail Placeholder</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" id="wppum_newsletter_email_placeholder" name="wppum_newsletter_email_placeholder"  value="<?php echo $this->popup['newsletter_email_placeholder']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_heading">NewsLetter Heading</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" id="wppum_newsletter_heading" name="wppum_newsletter_heading"  value="<?php echo $this->popup['newsletter_heading']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_sub_heading">NewsLetter Sub Heading</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" id="wppum_newsletter_sub_heading" name="wppum_newsletter_sub_heading"  value="<?php echo $this->popup['newsletter_sub_heading']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn">Submit button</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" id="wppum_newsletter_submit_btn" name="wppum_newsletter_submit_btn"  value="<?php echo $this->popup['newsletter_submit_btn']; ?>"/>

                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn_loading">Submit button loading text</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" id="wppum_newsletter_submit_btn_loading" name="wppum_newsletter_submit_btn_loading"  value="<?php echo $this->popup['newsletter_submit_btn_loading']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn_success">Submit button success text</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="form-control-full" type="text" id="wppum_newsletter_submit_btn_success" name="wppum_newsletter_submit_btn_success"  value="<?php echo $this->popup['newsletter_submit_btn_success']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn_color">Submit button color</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class=" color"  type="text" id="wppum_newsletter_submit_btn_color" name="wppum_newsletter_submit_btn_color"  value="<?php echo $this->popup['newsletter_submit_btn_color']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn_hover">Submit button hover color</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="color"  type="text" id="wppum_newsletter_submit_btn_hover" name="wppum_newsletter_submit_btn_hover"  value="<?php echo $this->popup['newsletter_submit_btn_hover']; ?>"/>

                            </div>

                        </div>
                        <div class="wppum-row ">

                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn_text_color">Submit button text color</label>
                            </div>
                            <div class="wppum-right right_70">
                                <input  class="color" type="text" id="wppum_newsletter_submit_btn_text_color" name="wppum_newsletter_submit_btn_text_color"  value="<?php echo $this->popup['newsletter_submit_btn_text_color']; ?>"/></label>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="bootstrap-wrapper">
                <div class="row">

                    <div class="col">
                        <?php  $class_hidden = "hidden"; ?>
                        <div class="td">
                            <div class="wppum-left left_30">
                                <label for="wppum_newsletter_submit_btn">News Letter Logo</label>
                            </div>

                            <input class="media_id" size="70" type="hidden"  placeholder="" required name="alta_slider__option_name[%d][image]" id="image_3" value="%s">

                            <!-- <a href="javascript:void(0)" data-key="large" class="%s button button-secondary upload_step_asset">Add image</a> -->
                            <input type="hidden" name="wppum_newsletter_logo" id="wppum_newsletter_logo"/>
                            <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Upload images'); ?>" class="button plupload-browse-button upload_newsletter_logo" /> 

                            <div class="_screenshot">
                                <input type="hidden" value="<?= $this->popup['newsletter_logo']; ?>" name="wppum_newsletter_logo" id="wppum_newsletter_logo"/>

                                <img src="<?= $this->popup['newsletter_logo']; ?>" class="<?= $this->popup['newsletter_logo'] == "" ? $class_hidden : "" ?>" width="100" />
                                <div>
                                    <a href="javascript:void(0)" class="remove-slider-image <?php echo $class_hidden ?>" >Remove Image</a>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>

            <div class="bootstrap-wrapper">
                <div class="row">

                    <div class="col">
                        <h6>Choose Template</h6>
                        </label>
                    </div></div>
                <div class="row">

                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popup-templates/1.jpg" ?>"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Template 1', __('Template 1', WPPUM_I18N_DOMAIN), false); ?>
                                    <input type="radio" name="wppum_newsletter_template" <?= $this->popup['newsletter_template'] == 1 ? "checked" : "" ?> value="1"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popup-templates/2.jpg" ?>"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Template 2', __('Template 2', WPPUM_I18N_DOMAIN), false); ?> <input type="radio" name="wppum_newsletter_template" <?= $this->popup['newsletter_template'] == 2 ? "checked" : "" ?> value="2"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popup-templates/3.png" ?>"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Template 3', __('Template 3', WPPUM_I18N_DOMAIN), false); ?>  <input type="radio" name="wppum_newsletter_template" <?= $this->popup['newsletter_template'] == 3 ? "checked" : "" ?> value="3"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popup-templates/4.jpg" ?>"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Template 4', __('Template 4', WPPUM_I18N_DOMAIN), false); ?>    <input type="radio" name="wppum_newsletter_template" <?= $this->popup['newsletter_template'] == 4 ? "checked" : "" ?> value="4"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popup-templates/6.jpg" ?>"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Template 5', __('Template 5', WPPUM_I18N_DOMAIN), false); ?> <input type="radio" name="wppum_newsletter_template" <?= $this->popup['newsletter_template'] == 5 ? "checked" : "" ?> value="5"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    function videopopup_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupsize">
            <div class="wppum-row">
                <div class="wppum-left">
                    <label for="wppum_embed_video">Video Code</label>
                </div>
                <div class="wppum-right right_80">
                    <textarea   class="form-control-full" type="text" id="wppum_embed_video" name="wppum_embed_video"  ><?php echo $post->post_content; ?></textarea></label>

                </div>
            </div>
        </div>
        <?php
    }

    function iframepopup_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupsize">


            <div class="wppum-row ">
                <div class="wppum-left left_20">
                    <label for="wppum_iframe">iFrame Code</label>
                </div>
                <div class="wppum-right right_80">
                    <textarea class="form-control-full" type="text" id="wppum_iframe" name="wppum_iframe"  ><?php echo $post->post_content; ?></textarea></label>

                </div>
            </div>
        </div>
        <?php
    }

    function shortcodepopup_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupsize">
            <div class="wppum-row ">
                <div class="wppum-left left_20">
                    <label for="wppum_shortcode_val">Shortcode</label>
                </div>
                <div class="wppum-right right_80">
                    <input class="form-control-full"  type="text" id="wppum_shortcode_val" size="90" name="wppum_shortcode_val" value="<?php echo $post->post_content; ?>" /></label>
                    <span class="help help-text">Example: [gallery id="123" size="medium"]</span>
                </div>
            </div>

        </div>
        <?php
    }

    /**
     * Display Popup Title metabox.
     * */
    function popup_title_meta_box($post) {
        wp_nonce_field('wppum_save', 'wppum_save_nonce');
        ?>
        <div id="submitdiv"></div>
        <input type="hidden" id="wppum_preview_link" value="<?php echo esc_attr($this->get_preview_popup_link($post->ID)); ?>"  />
        <div class="wppum-box" id="popuptitle">

            <?php
            echo $this->get_title_secton("Popup Title");
            ?>
            <div class="wppum-row">
                <div class="wppum-left">
                    <label for="wppum_title">Title Bar</lapopup_typebel>
                </div>
                <div class="wppum-right">
                    <label><input type="radio" id="wppum_title_enabled" name="wppum_title" value="1"<?php echo $this->popup['title'] === '1' ? ' checked="checked"' : ''; ?> /> Enabled</label> &nbsp;&nbsp;
                    <label><input type="radio" id="wppum_title_disabled" name="wppum_title" value="0"<?php echo $this->popup['title'] !== '1' ? ' checked="checked"' : ''; ?> /> Disabled</label>
                </div>
            </div>
            <div class="wppum-row wppum-hide-if-no-title"<?php echo $this->popup['title'] === '1' ? '' : ' style="display: none;"'; ?>>
                <div class="wppum-left">
                    <label for="wppum_title_text">Text</label>
                </div>
                <div class="wppum-right">
                    <input id="wppum_title_text" name="wppum_title_text" type="text" style="width: 99%;" value="<?php echo $this->popup['title_text']; ?>" class="regular-text" />
                </div>
            </div>
            <div class="wppum-row wppum-hide-if-no-title"<?php echo $this->popup['title'] === '1' ? '' : ' style="display: none;"' ?>>
                <p><a href="#" class="wppum-show-title-advanced wppum-hide-if-title-advanced">Show advanced options</a></p>
                <p><a href="#" class="wppum-hide-title-advanced wppum-hide-if-not-title-advanced" style="display: none;">Hide advanced options</a></p>
                <div class="wppum-row wppum-hide-if-not-title-advanced" style="display: none;">
                    <label for="wppum_title_html"><?php echo $this->get_tooltip_html('Title HTML', 'HTML'); ?></label><br />
                    <textarea class="wppum-textarea-small" id="wppum_title_html" name="wppum_title_html"><?php echo esc_html($this->popup['title_html']); ?></textarea>
                    <a href="#" class="wppum-revert-title-html" data-html="<?php echo esc_attr(isset($wppum_default_popup['title_html']) ? $wppum_default_popup['title_html'] : '' ); ?>">Revert title bar HTML to default</a><br /><br />
                    <p class="description">
                        <?php _e('Use the tag <code>[TITLE]</code> to get the title text set in the previous option.', WPPUM_I18N_DOMAIN); ?>
                    </p>
                </div>
            </div>

            <div class="wppum-indent-row  wppum-hide-if-background-type-image">
                <label for="wppum_title">Content Color</lapopup_typebel>
                    <input id="wppum_bgcolor" class="color {required:false}" name="wppum_content_color" type="text" value="<?php echo $this->popup['content_color']; ?>" class="regular-text" />
                    <p class="description">Leave blank for transparent.</p>
                </div>
        </div>
        <?php
    }

    /**
     * Display Popup Size metabox.
     * */
    function popup_size_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupsize">

            <?php
            echo $this->get_title_secton("Popup Size");
            ?>
            <div class="wppum-row">
                <label><input type="radio" name="wppum_size_type" value="contents"<?php echo $this->popup['size_type'] === 'contents' ? ' checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Size Fit To Contents', __('Fit to contents', WPPUM_I18N_DOMAIN)); ?></label><br />
                <label><input type="radio" name="wppum_size_type" value="bgimage"<?php echo $this->popup['size_type'] === 'bgimage' ? ' checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Size Background Image', __('Use background image size', WPPUM_I18N_DOMAIN)); ?></label><br />
                <label><input type="radio" name="wppum_size_type" value="custom"<?php echo $this->popup['size_type'] === 'custom' ? ' checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Size Custom', __('Custom size', WPPUM_I18N_DOMAIN)); ?></label>
            </div>
            <div class="wppum-row wppum-hide-if-size-type-not-custom"<?php echo $this->popup['size_type'] === 'custom' ? '' : ' style="display: none;"'; ?>>
                <div class="wppum-indent-row">

                    <div class="bootstrap-wrapper">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="wppum_width">Width</label>
                                <div class="wppum-right">
                                    <input type="text" class="unit_selection_input" id="wppum_width" name="wppum_width" value="<?php echo intval($this->popup['width']); ?>" /></label>
                                    <?php $this->display_unit_selection('width'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <label for="wppum_height">Height</label>

                                <div class="wppum-right">
                                    <input type="text" class="unit_selection_input" id="wppum_height" name="wppum_height" value="<?php echo intval($this->popup['height']); ?>" /></label>
                                    <?php $this->display_unit_selection('height'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Overlay metabox.
     * */
    function popup_overlay_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupoverlay">
            <?php
            echo $this->get_title_secton("Popup Overlay");
            ?>

            <div class="wppum-row">
                <div class="wppum-left">
                    <label for="wppum_overlay">Overlay</label>
                </div>
                <div class="wppum-right">
                    <label><input type="radio" id="wppum_overlay_enabled" name="wppum_overlay" value="1"<?php echo $this->popup['overlay'] === '1' ? ' checked="checked"' : ''; ?> /> Enabled</label> &nbsp;&nbsp;
                    <label><input type="radio" id="wppum_overlay_disabled" name="wppum_overlay" value="0"<?php echo $this->popup['overlay'] !== '1' ? ' checked="checked"' : ''; ?> /> Disabled</label>
                </div>
            </div>
            <div class="wppum-indent-row wppum-hide-if-no-overlay"<?php echo $this->popup['overlay'] === '1' ? '' : ' style="display: none;"'; ?>>
                <div class="bootstrap-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="">
                                <label for="wppum_overlay_color">Color</label>
                            </div>
                            <div class="wppum-right">
                                <input id="wppum_overlay_color" class="color" name="wppum_overlay_color" type="text" value="<?php echo $this->popup['overlay_color']; ?>" class="regular-text" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="">
                                <label for="wppum_overlay_opacity">Opacity</label>
                            </div>
                            <div class="wppum-right">
                                <input id="wppum_overlay_opacity" name="wppum_overlay_opacity" type="number" value="<?php echo $this->popup['overlay_opacity']; ?>" class="unit_selection_input_short regular-text" /> <span class="unit_selection">%</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <?php
    }

    /**
     * Display Popup Border metabox.
     * */
    function popup_border_meta_box($post) {
        // list of options for border styles
        $wppum_border_style_options = array(
            'none', 'hidden', 'dotted', 'dashed', 'solid', 'double', 'groove', 'ridge', 'inset', 'inherit');
        ?>
        <div class="wppum-box" id="popupborder">
            <?php
            echo $this->get_title_secton("Popup Border");
            ?>
            <div class="wppum-indent-row">


                <div class="bootstrap-wrapper">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="wppum_border_width">Width</label>
                            <div class="wppum-right">
                                <input id="wppum_border_width" class="unit_selection_input_short" name="wppum_border_width" type="number" step="1" min="0" value="<?php echo $this->popup['border_width']; ?>" /><span class="unit_selection">px</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="wppum_border_width">Border Radius</label>
                            <div class="wppum-right">
                                <input id="wppum_border_radius" class="unit_selection_input_short" name="wppum_border_radius" type="number" step="1" min="0" value="<?php echo $this->popup['border_radius']; ?>" /><span class="unit_selection">px</span>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <label>Style</label>

                            <div class="wppum-right">
                                <select name="wppum_border_style">
                                    <?php foreach ($wppum_border_style_options as $option) { ?>
                                        <option <?php echo $this->popup['border_style'] == $option ? 'selected="selected" ' : ''; ?>value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <label for="wppum_border_color">Color</label>

                            <div class="wppum-right">
                                <input class="color" id="wppum_border_color" name="wppum_border_color" type="text" value="<?php echo $this->popup['border_color']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <?php
    }

    /**
     * Display Popup Border/Content Padding metabox.
     * */
    function popup_border_content_padding_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupbordercontentpadding">
            <?php
            echo $this->get_title_secton("Popup Padding");
            ?>
            <div class="wppum-indent-row">
                <div class="bootstrap-wrapper">
                    <div class="row">
                        <div class="col-md-3">

                            <label for="wppum_padding_top">Top</label>

                            <div class="wppum-right">
                                <input name="wppum_padding_top" class="unit_selection_input_short" type="number" step="1" min="0" id="wppum_padding_top" value="<?php echo $this->popup['padding_top']; ?>" /><span class="unit_selection">px</span>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <label for="wppum_padding_bottom">Bottom</label>

                            <div class="wppum-right">
                                <input name="wppum_padding_bottom" class="unit_selection_input_short" type="number" step="1" min="0" id="wppum_padding_bottom" value="<?php echo $this->popup['padding_bottom']; ?>" /><span class="unit_selection">px</span>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <label for="wppum_padding_left">Left</label>

                            <div class="wppum-right">
                                <input name="wppum_padding_left" class="unit_selection_input_short" type="number" step="1" min="0" id="wppum_padding_left" value="<?php echo $this->popup['padding_left']; ?>" /><span class="unit_selection">px</span>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <label for="wppum_padding_right">Right</label>

                            <div class="wppum-right">
                                <input name="wppum_padding_right" class="unit_selection_input_short" type="number" step="1" min="0" id="wppum_padding_right" value="<?php echo $this->popup['padding_right']; ?>" /><span class="unit_selection">px</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Position metabox.
     * */
    function popup_position_meta_box($post) {
        $vertical_options = array('top', 'center', 'bottom');
        $horizontal_options = array('left', 'center', 'right');
        ?>
        <div class="wppum-box" id="popupposition">

            <?php
            echo $this->get_title_secton("Popup Position");
            ?>
            <div class="wppum-row">
                <label><input type="checkbox" id="wppum_position_centered" name="wppum_position_centered" value="1"<?php echo $this->popup['vertical_offset_type'] === 'center' && $this->popup['horizontal_offset_type'] === 'center' ? ' checked="checked"' : ''; ?> /></label> Center on screen
            </div>
            <div class="wppum-indent-row">


                <div class="wppum-row ">
                    <div class="wppum-left">
                        <label>Vertical</label>
                    </div>
                    <div class="wppum-right">
                        <span id="wppum-vertical-offset-container"<?php echo $this->popup['vertical_offset_type'] === 'center' ? ' style="display: none;"' : ''; ?>>
                            <input class="unit_selection_input" type="text" id="wppum_vertical_offset" name="wppum_vertical_offset" value="<?php echo intval($this->popup['vertical_offset']); ?>" />
                            <?php $this->display_unit_selection('vertical_offset'); ?>
                            from
                        </span>
                        <select id="wppum_vertical_offset_type" name="wppum_vertical_offset_type">
                            <?php foreach ($vertical_options as $option) { ?>
                                <option value="<?php echo $option; ?>"<?php echo $this->popup['vertical_offset_type'] === $option ? ' selected="selected"' : ''; ?>><?php echo $option; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="wppum-row">
                    <div class="wppum-left">
                        <label>Horizontal</label>
                    </div>
                    <div class="wppum-right">
                        <span id="wppum-horizontal-offset-container"<?php echo $this->popup['horizontal_offset_type'] === 'center' ? ' style="display: none;"' : ''; ?>>
                            <input class="unit_selection_input" type="text" id="wppum_horizontal_offset" name="wppum_horizontal_offset" value="<?php echo intval($this->popup['horizontal_offset']); ?>" />
                            <?php $this->display_unit_selection('horizontal_offset'); ?>
                            from
                        </span>
                        <select id="wppum_horizontal_offset_type" name="wppum_horizontal_offset_type">
                            <?php foreach ($horizontal_options as $option) { ?>
                                <option value="<?php echo $option; ?>"<?php echo $this->popup['horizontal_offset_type'] === $option ? ' selected="selected"' : ''; ?>><?php echo $option; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="wppum-row">
                <div>
                    <label><?php echo $this->get_tooltip_html('Scroll With Page', __('Would you like the popup to scroll with page', WPPUM_I18N_DOMAIN)); ?></label>
                </div>
                <div class="wppum-right">
                    <label><input type="radio" id="wppum_scroll_with_page" name="wppum_scroll_with_page" value="1"<?php echo $this->popup['scroll_with_page'] === '1' ? ' checked="checked"' : ''; ?> /> Yes</label>&nbsp;
                    <label><input type="radio" id="wppum_scroll_with_page" name="wppum_scroll_with_page" value="0"<?php echo $this->popup['scroll_with_page'] !== '1' ? ' checked="checked"' : ''; ?> /> No</label>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Slide Animation metabox.
     * */
    function popup_slide_animation_meta_box($post) {
        $effect_options = array('blind', 'bounce', 'clip', 'drop', 'explode', 'fade', 'fold', 'pulsate', 'shake', 'slide');
        $direction_options = array('from bottom' => 'down', 'from left' => 'left', 'from right' => 'right', 'from top' => 'up');
        $blind_direction_options = array('vertical' => 'vertical', 'horizontal' => 'horizontal');
        ?>
        <div class="wppum-box" id="popupslideanimation">

            <?php
            echo $this->get_title_secton("Popup Animation");
            ?>
            <div class="bootstrap-wrapper">
                <div class="row">
                    <div class="col-md-4">

                        <label>Effect</label>

                        <div class="wppum-right">
                            <select id="wppum_animation_effect" name="wppum_animation_effect">
                                <?php foreach ($effect_options as $option) { ?>
                                    <option value="<?php echo $option; ?>"<?php echo $this->popup['animation_effect'] === $option ? ' selected="selected"' : ''; ?>><?php echo $option; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="wppum-hide-if-effect-no-direction"<?php echo $this->popup['animation_effect'] === 'slide' || $this->popup['animation_effect'] === 'blind' || $this->popup['animation_effect'] === 'drop' ? '' : ' style="display: none;"'; ?>>

                            <label>Direction</label>

                            <div class="wppum-right">
                                <select class="wppum-hide-if-effect-direction-not-blind" id="wppum_slide_direction" name="wppum_slide_direction"<?php echo ( $this->popup['animation_effect'] !== 'blind' ) ? '' : ' disabled="disabled" style="display: none;"'; ?>>
                                    <?php foreach ($direction_options as $text => $option) { ?>
                                        <option value="<?php echo $option; ?>"<?php echo $this->popup['slide_direction'] === $option ? ' selected="selected"' : ''; ?>><?php echo $text; ?></option>
                                    <?php } ?>
                                </select>
                                <select class="wppum-hide-if-effect-direction-blind" id="wppum_blind_direction" name="wppum_slide_direction"<?php echo ( $this->popup['animation_effect'] === 'blind' ) ? '' : ' disabled="disabled" style="display: none;"'; ?>>
                                    <?php foreach ($blind_direction_options as $text => $option) { ?>
                                        <option value="<?php echo $option; ?>"<?php echo $this->popup['slide_direction'] === $option ? ' selected="selected"' : ''; ?>><?php echo $text; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <label for="wppum_slide_speed">Speed</label>

                        <div class="wppum-right">
                            <input class="unit_selection_input_short" name="wppum_slide_speed" type="number" step="1" min="0" id="wppum_slide_speed" value="<?php echo $this->popup['slide_speed']; ?>" /><span class="unit_selection">ms</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }

    /**
     * Display Popup CSS metabox.
     * */
    function popup_css_meta_box($post) {
        ?>
        <div class="wppum-box" id="popupcss">

            <?php
            echo $this->get_title_secton("Popup Advanced");
            ?>
            <div class="wppum-row">
                <div class="wppum-left left_30">
                    <label for="wppum_classes"><?php echo $this->get_tooltip_html('Classes', __('Classes', WPPUM_I18N_DOMAIN)); ?></label>
                </div>
                <div class="wppum-right right_70">
                    <input type="text" id="wppum_classes" name="wppum_classes" value="<?php echo esc_attr($this->popup['classes']); ?>" class="regular-text" />
                    <p class="description">
                        <?php _e("You can specify optional additional classes for this popup's HTML DIV element here, and override/add CSS styling to it below.", WPPUM_I18N_DOMAIN); ?><br />
                        <?php _e('Note that all popups will automatically have class name "wppum", even if not specified here.', WPPUM_I18N_DOMAIN); ?>
                    </p>
                </div>
            </div>
            <div class="wppum-row">
                <div class="wppum-left left_30">
                    <label for="wppum_styles"><?php echo $this->get_tooltip_html('Styles', __('Styles', WPPUM_I18N_DOMAIN)); ?></label>
                </div>
                <div class="wppum-right right_70">
                    <textarea class="wppum-textarea" id="wppum_styles" name="wppum_styles"><?php echo esc_html($this->popup['styles']); ?></textarea>
                    <p class="description">
                        <?php echo esc_html(__('Insert any external <link> tag or inline CSS <style> here. They will be inserted before the HTML closing </head> tag.', WPPUM_I18N_DOMAIN)); ?><br />
                        <?php _e('Any CSS code provided by an external vendor (e.g. AWeber) should be placed here.', WPPUM_I18N_DOMAIN); ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Self Close metabox.
     * */
    function popup_self_close_meta_box($post) {
        global $wppum, $wppum_default_popup;
        $sdb_cpp_self_close;
        ?>
        <div class="wppum-box" id="popupselfclose">
            <?php
            echo $this->get_title_secton("Self Close Popup");
            ?>
            <div class="wppum-row">
                <label><input type="checkbox" name="wppum_self_close_type" value="1" <?php echo $this->popup['self_close_type'] === '1' ? ' checked="checked"' : ''; ?> /> Self-close this popup when any link inside of it is clicked</label><br />
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Close Button metabox.
     * */
    function popup_close_button_meta_box($post) {
        global $wppum, $wppum_default_popup;
        ?>
        <div class="wppum-box" id="popupclosebutton">

            <?php
            echo $this->get_title_secton("Popup Close Button");
            ?>
            <div class="wppum-row">
                <label><input type="radio" name="wppum_close_button_type" value="hide"<?php echo $this->popup['close_button_type'] === 'hide' ? ' checked="checked"' : ''; ?> /> Hide close and toggle buttons</label><br />
                <label><input type="radio" name="wppum_close_button_type" value="close"<?php echo $this->popup['close_button_type'] === 'close' ? ' checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Close Button Image', __('Show close button', WPPUM_I18N_DOMAIN)); ?></label><br />
                <label><input type="radio" name="wppum_close_button_type" value="toggle"<?php echo $this->popup['close_button_type'] === 'toggle' ? ' checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Toggle Button', __('Show toggle button', WPPUM_I18N_DOMAIN)); ?></label>

            </div>
            <div class="wppum-row wppum-indent-row wppum-hide-if-close-button-empty"<?php echo $this->popup['close_button_type'] === 'hide' ? ' style="display: none;"' : ''; ?>>
                <p class="description">Select an image to use as the close button:</p>
                <div class="wppum-section">
                    <?php
                    // get all uploaded close buttons
                    $close_buttons = get_option('wppum_close_button_images', '');

                    $id = "wppum_close_button_images";
                    $svalue = $close_buttons;
                    $multiple = true;
                    ?>
                    <input type="hidden" id="<?php echo $id . "filenames"; ?>" name="wppum_close_button_img" value="<?php echo $this->popup['close_button_img']; ?>" />
                    <input type="hidden" name="<?php echo $id . "_defaults"; ?>" id="<?php echo $id . "_defaults"; ?>" value="<?php echo implode(',', $wppum->get_close_button_defaults()); ?>" />
                    <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
                    <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
                        <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
                        <div class="filelist"></div>
                    </div>
                    <div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
                    </div>
                    <div class="clear"></div>
                    <div>

                    </div>
                    <div class="wppum-row wppum-hide-if-close-button-empty"<?php echo ( $this->popup['close_button_type'] !== 'close' && empty($this->popup['close_button_img']) ) ? ' style="display: none;"' : ''; ?>>
                        <p><a href="#" class="wppum-show-close-button-advanced wppum-hide-if-close-button-advanced">Show advanced options</a></p>
                        <p><a href="#" class="wppum-hide-close-button-advanced wppum-hide-if-not-close-button-advanced" style="display: none;">Hide advanced options</a></p>
                        <div class="wppum-row wppum-hide-if-not-close-button-advanced" style="display: none;">
                            <label for="wppum_close_button_html"><?php echo $this->get_tooltip_html('Close Button HTML', __('HTML', WPPUM_I18N_DOMAIN)); ?></label><br />
                            <textarea class="wppum-textarea" id="wppum_close_button_html" name="wppum_close_button_html"><?php echo esc_html($this->popup['close_button_html']); ?></textarea>
                            <a href="#" class="wppum-revert-close-button-html" data-html="<?php echo esc_attr(isset($wppum_default_popup['close_button_html']) ? $wppum_default_popup['close_button_html'] : ''); ?>">Revert close button HTML to default</a><br /><br />
                            <p class="description">
                                <?php _e('Close button HTML should be wrapped inside an element with class name <code>wppum-close</code>.', WPPUM_I18N_DOMAIN); ?><br />
                                <?php _e('Use the tag <code>[CLOSE_BUTTON]</code> to get the URL of the close button image selected in the previous option.', WPPUM_I18N_DOMAIN); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wppum-row wppum-indent-row wppum-hide-if-open-button-empty"<?php echo $this->popup['close_button_type'] !== 'toggle' ? ' style="display: none;"' : ''; ?>>
                <p class="description">Select an image to use as the open button:</p>

                <div class="wppum-section">
                    <?php
                    // get all uploaded open buttons
                    $open_buttons = get_option('wppum_open_button_images', '');

                    $id = "wppum_open_button_images";
                    $svalue = $open_buttons;
                    $multiple = true;
                    ?>
                    <input type="hidden" id="<?php echo $id . "filenames"; ?>" name="wppum_open_button_img" value="<?php echo $this->popup['open_button_img']; ?>" />
                    <input type="hidden" name="<?php echo $id . "_defaults"; ?>" id="<?php echo $id . "_defaults"; ?>" value="<?php echo implode(',', $wppum->get_open_button_defaults()); ?>" />
                    <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
                    <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
                        <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
                        <div class="filelist"></div>
                    </div>
                    <div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
                    </div>
                    <div class="clear"></div>
                    <div>
                    </div>
                </div>

                <label>Set initial toggle state to: <input type="radio" name="wppum_toggle_state" value="open"<?php echo $this->popup['toggle_state'] === 'open' ? ' checked="checked"' : ''; ?> id="s_open" /> Open</label><label>
                    <input type="radio" name="wppum_toggle_state" value="close"<?php echo $this->popup['toggle_state'] === 'close' ? ' checked="checked"' : ''; ?> id="s_close" /> Close
                </label>

            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Background metabox.
     * */
    function popup_theme_setting_meta_box($post) {
        global $wppum;
        ?>
        <div class="wppum-box" id="popupbg">

            <?php
            echo $this->get_title_secton("Popup Theme");
            ?>

            <div class="bootstrap-wrapper">
                <div class="row">
                    <div class="col">
                        <div class="theme_cont">
                            <label      class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popups/1.png"?>"  width="202"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Theme 1', __('Theme 1', WPPUM_I18N_DOMAIN), false); ?>
                                    <input type="radio" name="wppum_popup_theme" <?= $this->popup['popup_theme'] == 1 ? "checked" : "" ?> value="1"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popups/2.png"?>"  width="202"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Theme 2', __('Theme 2', WPPUM_I18N_DOMAIN), false); ?> <input type="radio" name="wppum_popup_theme" <?= $this->popup['popup_theme'] == 2 ? "checked" : "" ?> value="2"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popups/3.png"?>"  width="202"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Theme 3', __('Theme 3', WPPUM_I18N_DOMAIN), false); ?>  <input type="radio" name="wppum_popup_theme" <?= $this->popup['popup_theme'] == 3 ? "checked" : "" ?> value="3"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popups/4.png"?>"  width="202"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Theme 4', __('Theme 4', WPPUM_I18N_DOMAIN), false); ?>    <input type="radio" name="wppum_popup_theme" <?= $this->popup['popup_theme'] == 4 ? "checked" : "" ?> value="4"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="theme_cont">
                            <label class="wppum_label block">
                                <div class="theme_img">
                                    <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/popups/5.png"?>"  width="202"/>
                                </div>
                                <div class="theme_footer">

                                    <?php echo $this->get_tooltip_html('Theme 5', __('Theme 5', WPPUM_I18N_DOMAIN), false); ?> <input type="radio" name="wppum_popup_theme" <?= $this->popup['popup_theme'] == 5 ? "checked" : "" ?> value="5"  /> 

                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }

    function popup_bg_meta_box($post) {
        global $wppum;
        ?>
        <div class="wppum-box" id="popupbg">

            <?php
            echo $this->get_title_secton("Popup Background");
            ?>
            <div class="wppum-row">

                <div class="wppum-left">
                    <label><input type="radio" name="wppum_background_type" value="color"<?php echo empty($this->popup['background_img']) ? ' checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Background Color', __('Background Color', WPPUM_I18N_DOMAIN)); ?></label>
                </div>
                <div class="wppum-indent-row  wppum-hide-if-background-type-image"<?php echo!empty($this->popup['background_img']) ? ' style="display: none;"' : ''; ?>>
                    <input id="wppum_bgcolor" class="color {required:false}" name="wppum_background_color" type="text" value="<?php echo $this->popup['background_color']; ?>" class="regular-text" />
                    <p class="description">Leave blank for transparent.</p>
                </div>
            </div>
            <div class="wppum-row">
                <div class="wppum-left">
                    <label><input type="radio" name="wppum_background_type" value="image"<?php echo!empty($this->popup['background_img']) ? 'checked="checked"' : ''; ?> /> <?php echo $this->get_tooltip_html('Background Image', __('Image', WPPUM_I18N_DOMAIN)); ?></label>
                </div>
            </div>

            <div class="wppum-indent-row td wppum-row wppum-hide-if-background-type-color"<?php echo empty($this->popup['background_img']) ? ' style="display: none;"' : ''; ?>>
                <?php
                // get all uploaded background images
                $background_images = get_option('wppum_background_images', '');

                $id = "wppum_background_images";
                $svalue = $background_images;
                $multiple = true;
                $class_hidden = "hidden";
                ?>
                <input type="hidden" id="<?php echo $id . "filenames"; ?>" name="wppum_background_img" value="<?php echo $this->popup['background_img']; ?>" />
                <input type="hidden" name="<?php echo $id . "_defaults"; ?>" id="<?php echo $id . "_defaults"; ?>" value="<?php echo implode(',', $wppum->get_background_images_defaults()); ?>" />
                <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
                <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
                    <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
                    <div class="filelist"></div>
                </div>
                <div class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
                </div>
                <div class="clear"></div>
                <div>

                    <input class="media_id" size="70" type="hidden"  placeholder="" required name="alta_slider__option_name[%d][image]" id="image_3" value="%s">

                    <input id="<?php echo $id; ?>plupload-browse-button" type="button" value="<?php esc_attr_e('Upload images'); ?>" class="button plupload-browse-button upload_step_asset" /> 

                    <div class="_screenshot">
                        <img src="" class="<?php echo $class_hidden ?>" width="300" />
                        <div>
                            <a href="javascript:void(0)" class="remove-slider-image <?php echo $class_hidden ?>" >Remove Image</a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Events metabox.
     * */
    function popup_events_meta_box($post) {
        $wppum_target_type_options = array(
            'element' => 'HTML element (by CSS selector)',
            'top' => 'y-offset (in pixels) from top of webpage',
            'bottom' => 'y-offset (in pixels) from bottom of webpage',
            'shortcode' => 'wherever shortcode appears in posts/pages'
        );
        ?>
        <div class="wppum-box" id="popupevents">

            <?php
            echo $this->get_title_secton("When to open popup");
            ?>
            <div class="wppum-row">
                <div>

                    <label>
                        <input name="wppum_trigger_on_timing" type="checkbox" id="wppum_trigger_on_timing" value="1" <?php echo ( $this->popup['trigger_on_timing'] === '1' ) ? 'checked="checked" ' : ''; ?>/> <?php echo $this->get_tooltip_html('Trigger Event Timing', __('Timing from webpage load', WPPUM_I18N_DOMAIN)); ?>
                    </label>
                    <span class="wppum-hide-if-no-delay"<?php echo ( $this->popup['trigger_on_timing'] === '1' ) ? '' : ' style="display: none;"'; ?>>: <input id="wppum_trigger_delay" class="wppum-narrow-input" name="wppum_trigger_delay" type="number" step="1" min="0" value="<?php echo $this->popup['trigger_delay']; ?>" />ms</span>
                </div>
                <div>
                    <label>
                        <input name="wppum_trigger_on_leaving_viewport" type="checkbox" id="wppum_trigger_on_leaving_viewport" value="1" <?php echo ( $this->popup['trigger_on_leaving_viewport'] === '1' ) ? 'checked="checked" ' : ''; ?>/>
                        <?php echo $this->get_tooltip_html('Trigger Event Leave Viewport', __('On Page Exit', WPPUM_I18N_DOMAIN)); ?>
                    </label>
                </div>
                <div>
                    <label>
                        <input name="wppum_trigger_on_link_click" type="checkbox" id="wppum_trigger_on_link_click" value="1" <?php echo ( $this->popup['trigger_on_link_click'] === '1' ) ? 'checked="checked" ' : ''; ?>/> <?php echo $this->get_tooltip_html('Trigger On Link Click', __('Click of an external link', WPPUM_I18N_DOMAIN)); ?>
                    </label>
                    <div class="wppum-indent-row wppum-section wppum-hide-if-no-link-click"<?php echo ( $this->popup['trigger_on_link_click'] === '1' ) ? '' : ' style="display: none;"'; ?>>
                        <div class="wppum-row ">
                            <div class="wppum-left">
                                <?php echo $this->get_tooltip_html('Popup Type', __('Popup Type', WPPUM_I18N_DOMAIN)); ?>
                            </div>
                            <div class="wppum-right">
                                <label><input type="radio" name="wppum_link_click_popup_type" id="wppum_link_click_popup_type_alert" value="alert"<?php echo $this->popup['link_click_popup_type'] === 'alert' ? ' checked="checked"' : ''; ?> /> plain Javascript alert (has an "OK" button but no "Cancel" button)</label><br />
                                <label><input type="radio" name="wppum_link_click_popup_type" id="wppum_link_click_popup_type_confirm" value="confirm"<?php echo $this->popup['link_click_popup_type'] === 'confirm' ? ' checked="checked"' : ''; ?> /> plain Javascript confirm (with "OK" and "Cancel" buttons)</label><br />
                                <label><input type="radio" name="wppum_link_click_popup_type" id="wppum_link_click_popup_type_html" value="html"<?php echo $this->popup['link_click_popup_type'] === 'html' ? ' checked="checked"' : ''; ?> /> normal HTML (uses current popup settings)</label><br />
                            </div>
                        </div>
                        <div class="wppum-row wppum-hide-if-no-link-click-popup"<?php echo ( $this->popup['trigger_on_link_click'] === '1' && $this->popup['link_click_popup_type'] === 'html' ) ? '' : ' style="display: none;"'; ?>>
                            <div class="wppum-left">
                                <label for="wppum_ok_button"><?php echo $this->get_tooltip_html('OK Button', __('OK Button', WPPUM_I18N_DOMAIN)); ?></label>
                            </div>
                            <div class="wppum-right">
                                <label><input type="radio" id="wppum_ok_button_enabled" name="wppum_ok_button" value="1"<?php echo $this->popup['ok_button'] === '1' ? ' checked="checked"' : ''; ?> /> Enabled</label><br />
                                <label><input type="radio" id="wppum_ok_button_disabled" name="wppum_ok_button" value="0"<?php echo $this->popup['ok_button'] !== '1' ? ' checked="checked"' : ''; ?> /> Disabled</label>
                                <div class="wppum-row wppum-hide-if-no-ok-button"<?php echo $this->popup['ok_button'] === '1' ? '' : ' style="display: none;"'; ?>>
                                    <div style="width: 45%; float: left;">
                                        <label for="wppum_ok_button_text">Text:</label>
                                        <input id="wppum_ok_button_text" name="wppum_ok_button_text" type="text" value="<?php echo $this->popup['ok_button_text']; ?>" class="regular-text" />
                                    </div>
                                    <div style="width: 45%; float: left;">
                                        <label for="wppum_ok_button_width">Width:</label>
                                        <input type="text" class="unit_selection_input" id="wppum_ok_button_width" name="wppum_ok_button_width" value="<?php echo intval($this->popup['ok_button_width']); ?>" /></label>
                                        <?php $this->display_unit_selection('ok_button_width'); ?>
                                    </div>
                                </div>
                                <div class="wppum-row wppum-hide-if-no-ok-button"<?php echo $this->popup['ok_button'] === '1' ? '' : ' style="display: none;"' ?>>
                                    <p><a href="#" class="wppum-show-ok-button-advanced wppum-hide-if-ok-button-advanced">Show advanced options</a></p>
                                    <p><a href="#" class="wppum-hide-ok-button-advanced wppum-hide-if-not-ok-button-advanced" style="display: none;">Hide advanced options</a></p>
                                    <div class="wppum-row wppum-hide-if-not-ok-button-advanced" style="display: none;">
                                        <label for="wppum_ok_button_html"><?php echo $this->get_tooltip_html('OK Button HTML', 'HTML'); ?></label><br />
                                        <textarea class="wppum-textarea-small" id="wppum_ok_button_html" name="wppum_ok_button_html"><?php echo esc_html($this->popup['ok_button_html']); ?></textarea>
                                        <a href="#" class="wppum-revert-title-html" data-html="<?php echo esc_attr(isset($wppum_default_popup['title_html']) ? $wppum_default_popup['title_html'] : ''); ?>">Revert OK button HTML to default</a><br /><br />
                                        <p class="description">
                                            <?php _e('The OK button should be wrapped inside the following HTML element: <code><a href="#" class="wppum-ok-button"></a></code>.', WPPUM_I18N_DOMAIN); ?><br />
                                            <?php _e('Use the tags <code>[OK]</code> and <code>[OK_WIDTH]</code> to get the OK button text/width set in the previous option.', WPPUM_I18N_DOMAIN); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wppum-row wppum-hide-if-no-link-click-popup"<?php echo ( $this->popup['trigger_on_link_click'] === '1' && $this->popup['link_click_popup_type'] === 'html' ) ? '' : ' style="display: none;"'; ?>>
                            <div class="wppum-left">
                                <label for="wppum_cancel_button"><?php echo $this->get_tooltip_html('Cancel Button', __('Cancel Button', WPPUM_I18N_DOMAIN)); ?></label>
                            </div>
                            <div class="wppum-right">
                                <label><input type="radio" id="wppum_cancel_button_enabled" name="wppum_cancel_button" value="1"<?php echo $this->popup['cancel_button'] === '1' ? ' checked="checked"' : ''; ?> /> Enabled</label><br />
                                <label><input type="radio" id="wppum_cancel_button_disabled" name="wppum_cancel_button" value="0"<?php echo $this->popup['cancel_button'] !== '1' ? ' checked="checked"' : ''; ?> /> Disabled</label>
                                <div class="wppum-row wppum-hide-if-no-cancel-button"<?php echo $this->popup['cancel_button'] === '1' ? '' : ' style="display: none;"'; ?>>
                                    <div style="width: 45%; float: left;">
                                        <label for="wppum_cancel_button_text">Text:</label>
                                        <input id="wppum_cancel_button_text" name="wppum_cancel_button_text" type="text" value="<?php echo $this->popup['cancel_button_text']; ?>" class="regular-text" />
                                    </div>
                                    <div style="width: 45%; float: left;">
                                        <label for="wppum_cancel_button_width">Width:</label>
                                        <input type="text" class="unit_selection_input" id="wppum_cancel_button_width" name="wppum_cancel_button_width" value="<?php echo intval($this->popup['cancel_button_width']); ?>" />
                                        <?php $this->display_unit_selection('cancel_button_width'); ?>
                                    </div>
                                </div>
                                <div class="wppum-row wppum-hide-if-no-cancel-button"<?php echo $this->popup['cancel_button'] === '1' ? '' : ' style="display: none;"' ?>>
                                    <p><a href="#" class="wppum-show-cancel-button-advanced wppum-hide-if-cancel-button-advanced">Show advanced options</a></p>
                                    <p><a href="#" class="wppum-hide-cancel-button-advanced wppum-hide-if-not-cancel-button-advanced" style="display: none;">Hide advanced options</a></p>
                                    <div class="wppum-row wppum-hide-if-not-cancel-button-advanced" style="display: none;">
                                        <label for="wppum_cancel_button_html"><?php echo $this->get_tooltip_html('Cancel Button HTML', 'HTML'); ?></label><br />
                                        <textarea id="wppum_cancel_button_html" style="width: 99%; height: 70px;" name="wppum_cancel_button_html"><?php echo esc_html($this->popup['cancel_button_html']); ?></textarea>
                                        <a href="#" class="wppum-revert-title-html" data-html="<?php echo esc_attr(isset($wppum_default_popup['title_html']) ? $wppum_default_popup['title_html'] : '' ); ?>">Revert Cancel button HTML to default</a><br /><br />
                                        <p class="description">
                                            <?php _e('The Cancel button should be wrapped inside the following HTML element: <code><a href="#" class="wppum-cancel-button"></a></code>.', WPPUM_I18N_DOMAIN); ?><br />
                                            <?php _e('Use the tags <code>[CANCEL]</code> and <code>[CANCEL_WIDTH]</code> to get the Cancel button text/width set in the previous option.', WPPUM_I18N_DOMAIN); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wppum-row">
                            <div class="wppum-left">
                                <label for="wppum_whitelisted_domains"><?php echo $this->get_tooltip_html('Whitelisted Domains', __('Whitelisted Domains', WPPUM_I18N_DOMAIN)); ?></label>
                            </div>
                            <div class="wppum-right">
                                <textarea class="wppum-textarea" id="wppum_whitelisted_domains" name="wppum_whitelisted_domains" ><?php echo esc_textarea($this->popup['whitelisted_domains']); ?></textarea>
                                <p class="description">
                                    <?php _e('Each domain should be entered on a new line, and should not contain http:// or https:// prefixes, or trailing slashes.', WPPUM_I18N_DOMAIN); ?><br />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <label>
                        <input name="wppum_trigger_browser_scroll" type="checkbox" id="wppum_trigger_browser_scroll" value="1" <?php echo ( $this->popup['trigger_browser_scroll'] === '1' ) ? 'checked="checked" ' : ''; ?>/> <?php echo $this->get_tooltip_html('Trigger Event Browser Scroll', __('Browser scroll', WPPUM_I18N_DOMAIN)); ?>
                    </label>
                    <div class="wppum-row wppum-indent-row wppum-section wppum-hide-if-not-browser-scroll"<?php echo ( $this->popup['trigger_browser_scroll'] === '1' ) ? '' : ' style="display: none;"'; ?>>
                        <div class="wppum-row">
                            <div class="wppum-left"><?php echo $this->get_tooltip_html('Start Trigger Target', __('Start Trigger Target', WPPUM_I18N_DOMAIN)); ?></div>
                            <div class="wppum-right">
                                <div class="bootstrap-wrapper">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="wppum_label">Target Type:</label>
                                            <select name="wppum_target_type" id="wppum_target_type" class="wppum_target_type">
                                                <?php foreach ($wppum_target_type_options as $value => $option) { ?>
                                                    <option value="<?php echo $value; ?>"<?php echo $this->popup['target_type'] === $value ? ' selected="selected"' : ''; ?>><?php echo $option; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label <?php echo $this->popup['target_type'] !== 'element' ? 'style="display:none;" ' : ''; ?>class="wppum_label wppum-hide-if-not-target-css">CSS Selector </label>
                                            <input <?php echo $this->popup['target_type'] !== 'element' ? 'style="display:none;" ' : ''; ?> class="wppum-hide-if-not-target-css" name="wppum_target_element" type="text" value="<?php echo $this->popup['target_element']; ?>" />
                                            <label <?php echo ( $this->popup['target_type'] !== 'top' && $this->popup['target_type'] !== 'bottom' ) ? 'style="display:none; "' : ''; ?>class="wppum_label wppum-hide-if-not-target-offset">y-offset (px)</label>
                                            <input  <?php echo ( $this->popup['target_type'] !== 'top' && $this->popup['target_type'] !== 'bottom' ) ? 'style="display:none; "' : ''; ?> class="wppum-hide-if-not-target-offset" name="wppum_target_offset" type="number" step="1" min="0" value="<?php echo intval($this->popup['target_offset']); ?>" />
                                            <p <?php echo $this->popup['target_type'] !== 'element' ? 'style="display:none;" ' : ''; ?>class="wppum-hide-if-not-target-css description">If CSS selector matches multiple elements, only first element is used. Example CSS selectors: <code>#element-id, .class-name</code></p>
                                            <?php if (!empty($post->post_title)) { ?>
                                                <p>Shortcode: <code>[wppum name="<?php echo esc_html($post->post_title); ?>"]</code></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="wppum-row">
                            <div class="wppum-left"><?php echo $this->get_tooltip_html('End Trigger Target', __('End Trigger Target', WPPUM_I18N_DOMAIN)); ?></div>
                            <div class="wppum-right">
                                <div class="bootstrap-wrapper">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label class="wppum_label">Target Type:</label>
                                            <select name="wppum_end_target_type" id="wppum_end_target_type" class="wppum_target_type">
                                                <option value="none"<?php echo $this->popup['end_target_type'] === 'none' ? ' selected="selected"' : ''; ?>>None</option>
                                                <?php foreach ($wppum_target_type_options as $value => $option) { ?>
                                                    <option value="<?php echo $value; ?>"<?php echo $this->popup['end_target_type'] === $value ? ' selected="selected"' : ''; ?>><?php echo $option; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label <?php echo $this->popup['end_target_type'] !== 'element' ? 'style="display:none;" ' : ''; ?>class="wppum_label wppum-hide-if-not-target-css">CSS Selector </label>
                                            <input <?php echo $this->popup['end_target_type'] !== 'element' ? 'style="display:none;" ' : ''; ?> class="wppum-hide-if-not-target-css" name="wppum_end_target_element" type="text" value="<?php echo $this->popup['end_target_element']; ?>" />
                                            <label <?php echo ( $this->popup['end_target_type'] !== 'top' && $this->popup['target_type'] !== 'bottom' ) ? 'style="display:none; "' : ''; ?>class="wppum_label wppum-hide-if-not-target-offset">y-offset (px)</label>
                                            <input  <?php echo ( $this->popup['end_target_type'] !== 'top' && $this->popup['target_type'] !== 'bottom' ) ? 'style="display:none; "' : ''; ?> class="wppum-hide-if-not-target-offset" name="wppum_end_target_offset" type="number" step="1" min="0" value="<?php echo intval($this->popup['end_target_offset']); ?>" />
                                            <p <?php echo $this->popup['end_target_type'] !== 'element' ? 'style="display:none;" ' : ''; ?>class="wppum-hide-if-not-target-css description">If CSS selector matches multiple elements, only first element is used. Example CSS selectors: <code>#element-id, .class-name</code></p>
                                            <?php if (!empty($post->post_title)) { ?>
                                                <p>Shortcode: <code>[wppum name="<?php echo esc_html($post->post_title); ?>"]</code></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <p style="margin-top:0px; "><i>You do not need to select any events if you want to launch a popup from a link. Get your link code for each popup from the "All Popups" page.</i></p>
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Frequency metabox.
     * */
    function popup_frequency_meta_box($post) {
        ?>
        <div class="wppum-box" id="popuptriggers">
            <?php
            echo $this->get_title_secton("Popup Frequency");
            ?>
            <div class="wppum-row">

                <label><input type="radio" name="wppum_frequency_type" id="wppum_frequency_type" value="none" <?php echo $this->popup['frequency_type'] === 'none' ? ' checked="checked"' : ''; ?> /> No limit</label><br />
                <label><input type="radio" name="wppum_frequency_type" id="wppum_frequency_type" value="session" <?php echo $this->popup['frequency_type'] === 'session' ? ' checked="checked"' : ''; ?> /> Limit to once per user session</label><br />
                <label>
                    <input type="radio" name="wppum_frequency_type" id="wppum_frequency_type" value="custom" <?php echo $this->popup['frequency_type'] === 'custom' ? ' checked="checked"' : ''; ?> /> Custom limit 
                    
                    <div class="bootstrap-wrapper wppum-hide-if-no-frequency"<?php echo $this->popup['frequency_type'] === 'custom' ? '' : ' style="display: none;"'; ?>>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="wppum-narrow-input" name="wppum_frequency_limit_times" type="number" step="1" min="0" id="wppum_frequency_limit_times" value="<?php echo $this->popup['frequency_limit_times']; ?>" /> time(s) every
                            </div>
                            <div class="col-md-6">
                                <input class="wppum-narrow-input" name="wppum_frequency_limit_days" type="number" step="1" min="0" id="wppum_frequency_limit_days" value="<?php echo $this->popup['frequency_limit_days']; ?>" /> day(s)
                            </div>
                        </div>
                    </div>
                    
                </label><br />
                <label>
                    <input type="radio" name="wppum_frequency_type" id="wppum_frequency_type" value="userpersession" <?php echo $this->popup['frequency_type'] === 'userpersession' ? ' checked="checked"' : ''; ?> /> Allow the popup to appear until closed by the user per session</label>
                </label>
            </div>
        </div>

        <?php
    }

    /**
     * Display Popup Mobile metabox.
     * */
    function popup_mobile_meta_box($post) {
        ?>

        <div class="wppum-box" id="popupmobile">

            <?php
            echo $this->get_title_secton("Mobile");
            ?>
            <div class="wppum-row">
                <label><input type="radio" name="wppum_show_mobile" id="wppum_show_mobile_show_all" value="show_all"<?php echo $this->popup['show_mobile'] === 'show_all' ? ' checked="checked"' : ''; ?> /> Show on mobile</label><br />
                <label><input type="radio" name="wppum_show_mobile" id="wppum_show_mobile_disable_mobile" value="disable_mobile"<?php echo $this->popup['show_mobile'] === 'disable_mobile' ? ' checked="checked"' : ''; ?> /> Disable on mobile</label><br />
                <label><input type="radio" name="wppum_show_mobile" id="wppum_show_mobile_mobile_only" value="mobile_only"<?php echo $this->popup['show_mobile'] === 'mobile_only' ? ' checked="checked"' : ''; ?> /> Show on mobile only</label><br />
            </div>
        </div>
        <?php
    }

    /**
     * Display Popup Pages/Posts metabox.
     * */
    function popup_pages_posts_meta_box($post) {

        $show_on_specific_pages = $this->popup['trigger_pages'] === 'show_pages' || $this->popup['trigger_pages'] === 'hide_pages' || $this->popup['trigger_pages'] === 'url_pattern' || $this->popup['trigger_pages'] === 'web_referring_url';

        $show_on_specific_cat = $this->popup['trigger_pages'] === 'specific_cat';

        $cat_options = [
            'specific_cat' => 'Specific blog category(ies) only',
        ];
        $woo_com_options = [
            'woo_cat' => 'WooCommerce category(ies) only',
        ];
        $wppum_trigger_page_options = array(
            'show_all_include_homepage' => 'Show on all web pages (including homepage)',
            'show_all_exclude_homepage' => 'Show on all web pages (excluding homepage)',
            'show_homepage_and_shortcode' => 'Show only on homepage and pages/posts with shortcode',
            'hide_all' => 'Hide on all web pages (except pages/posts with shortcode)',
            'show_pages' => 'Show only on specific pages/posts',
            'hide_pages' => 'Hide only on specific pages/posts',
            'url_pattern' => 'URL contains',
            'web_referring_url' => 'Referring URL contains'
        );

        $wppum_page_option_examples = array(
            'url_pattern' => '/products',
            'web_referring_url' => 'http://twitter.com/',
            'hide_pages' => '1, 3, 10',
        );

        echo '<div class="wppum-box" id="popuptriggers">';
        echo $this->get_title_secton("Select Pages/Posts/Categories to show popup");

        echo '<div class="wppum-row">';
        foreach ($wppum_trigger_page_options as $opKey => $opVal) {
            $keyField = $opKey . '_options';
            $valField = $opKey . '_val';

            printf('<div class="field-group-cont"><label><input name="%s_options" id="%s_options" type="checkbox" value="%s"%s/> %s</label></div>', $opKey, $opKey, $opKey, $this->popup[$keyField] === $opKey ? ' checked=checked ' : '', $opVal);


            if ($opKey === 'show_pages') {
                $pagesIdsAssigned = isset($this->popup[$valField]) ? explode(",", $this->popup[$valField]) : [];
                $mypages = get_pages(array(
                    'sort_column' => 'post_date',
                    'sort_order' => 'desc'
                ));
                echo '<div id="tabs-panel-posttype-page-most-recent" style="min-height: 42px;max-height: 200px;overflow: auto;    padding: 0 .9em;border: 1px solid #ddd;background-color: #fdfdfd;" class="tabs-panel tabs-panel-active"><ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">';
                foreach ($mypages as $page) {
                    $title = $page->post_title;
                    $slug = $page->ID;
                    $checked = in_array($slug, $pagesIdsAssigned) ? "checked" : "";
                    printf('<li><label><input name="%s_val[]" id="%s_val" value="%s" %s type="checkbox" />%s</label></li>', $opKey, $slug, $slug, $checked, $title ? $title : '');
                }
                echo '</ul></div>';
            }


            if ($opKey === 'hide_pages' || $opKey === 'url_pattern' || $opKey === 'web_referring_url') {
                echo "<div class='bootstrap-wrapper'>";
                echo "<div class='row' >";
                echo "<div class='col-md-4'>";
                echo "</div>";
                echo "<div class='col-md-8' style='margin-top: -35px;'>";
                printf('<input name="%s_val" id="%s_val" value="%s" type="text" />', $opKey, $opKey, isset($this->popup[$valField]) ? $this->popup[$valField] : '');

                if (isset($wppum_page_option_examples[$opKey])) {
                    printf('<div> Example: <code>%s</code></div>', $wppum_page_option_examples[$opKey]);
                }
                if ('hide_pages' == $opKey) {
                    printf('
               <p class="description" style="margin-left: 0px;">
                  Key in the IDs of the pages/posts, each separated by a comma.<br />
                  <!-- Note that shortcodes on individual pages/posts will ignore this setting and always render.<br /> -->
                  <a class="wppum-show-hide-post-list" href="#" data-target="#posts-for-%s">Click here to <span>view</span> the list of all pages/posts and their IDs.</a>
               </p>', $opKey);

                    printf('
               <div class="wppum-post-list-wrapper" id="posts-for-%s" style="display: none;">
                  <table border="1" class="wppum-post-list">
                     <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Title</th>
                     </tr>', $opKey);

                    $all_posts = get_posts(array('numberposts' => -1, 'post_type' => array('post', 'page')));

                    foreach ($all_posts as $curr_post) {
                        printf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>', $curr_post->ID, $curr_post->post_type, esc_html($curr_post->post_title));
                    }
                    echo '
                  </table>
               </div>';
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
            } else {
                if (isset($wppum_page_option_examples[$opKey])) {
                    printf('<div> Example: <code>%s</code></div>', $wppum_page_option_examples[$opKey]);
                }
            }
            // Do we have an example to put out?
            // For the specific page/post ID ones output a link to view them
            // For the specific category one, output check boxes of our categories
            if ($opKey === 'specific_cat') {
                $categories = get_categories(array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0));
                $specific_category_list = "";
                $specific_category_val = explode(',', $this->popup['specific_category_val']);
                foreach ($categories as $cat_key => $cat_val) {
                    $specific_category_list .= sprintf('&nbsp;&nbsp;<input name="specific_category[]" type="checkbox" value="%s"%s/>%s', $cat_val->term_id, in_array($cat_val->term_id, $specific_category_val) ? " checked=checked " : "", $cat_val->name);
                }
                echo empty($specific_category_list) ? "No categories found." : $specific_category_list;
            }

            // If we're on hide_all, let's show some explanatory text before the rest
            if ('hide_all' == $opKey) {
                echo '<h4 class="wppum-meta-hdr">Combined Rules</h4>
                  <p>Rules selected below are combined and all must be matched before a popup is shown.</p>';
            }
        }
        echo '</div>';
        echo $this->get_title_secton("Categories");

        echo '<div class="wppum-row">';
        foreach ($cat_options as $opKey => $opVal) {
            $keyField = $opKey . '_options';
            $valField = $opKey . '_val';

            printf('<div class="field-group-cont"><label><input name="%s_options" id="%s_options" type="checkbox" value="%s"%s/> %s</label></div>', $opKey, $opKey, $opKey, $this->popup[$keyField] === $opKey ? ' checked=checked ' : '', $opVal);

            // For the specific page/post ID ones output a link to view them
            // For the specific category one, output check boxes of our categories
            if ($opKey === 'specific_cat') {
                $categories = get_categories(array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0));
                $specific_category_list = "";
                $specific_category_val = explode(',', $this->popup['specific_category_val']);
                foreach ($categories as $cat_key => $cat_val) {
                    $specific_category_list .= sprintf('<div class="field-group-cont"><label><input name="specific_category[]" type="checkbox" value="%s"%s/>&nbsp;&nbsp;%s</label></div>', $cat_val->term_id, in_array($cat_val->term_id, $specific_category_val) ? " checked=checked " : "", $cat_val->name);
                }
                echo empty($specific_category_list) ? "No categories found." : $specific_category_list;
            }

            // If we're on hide_all, let's show some explanatory text before the rest
        }
        echo "</div>";
        if (class_exists('WooCommerce')) {
            // some code

            echo $this->get_title_secton("WooCommerce");
            echo '<div class="wppum-row">';
            foreach ($woo_com_options as $opKey => $opVal) {
                $keyField = $opKey . '_options';
                $valField = $opKey . '_val';

                printf('<div class="field-group-cont"><label><input name="%s_options" id="%s_options" type="checkbox" value="%s"%s/> %s</label></div>', $opKey, $opKey, $opKey, (isset($this->popup[$keyField])) == $opKey ? ' checked=checked ' : '', $opVal);

                // For the specific page/post ID ones output a link to view them
                // For the specific category one, output check boxes of our categories
                if ($opKey === 'woo_cat') {
                    $categories = get_categories(array('taxonomy' => "product_cat", 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => 0));
                    $specific_category_list = "";

                    $specific_category_val = (isset( $this->popup['woo_cat_val'] )) ? explode(',', $this->popup['woo_cat_val']) : array();
                    foreach ($categories as $cat_key => $cat_val) {
                        $specific_category_list .= sprintf('<div class="field-group-cont"><label><input name="woo_cat[]" type="checkbox" value="%s"%s/>&nbsp;&nbsp;%s<label></div>', $cat_val->term_id, in_array($cat_val->term_id, $specific_category_val) ? " checked=checked " : "", $cat_val->name);
                    }
                    echo empty($specific_category_list) ? "No categories found." : $specific_category_list;
                }

                // If we're on hide_all, let's show some explanatory text before the rest
            }
            echo "</div>";
        }
        ?>
        <!--<div class="wppum-row">
        <select name="wppum_trigger_pages" id="wppum_trigger_pages">
        <?php //foreach ($wppum_trigger_page_options as $value => $option) { ?>
        <?php //} ?>                                                  
           </select>
           <label class="wppum-hide-if-not-specific-page-trigger"<?php //echo $show_on_specific_pages ? '' : ' style="display: none;"'; ?>> <span id="wppum_trigger_pages_text">Page/post IDs</span>: <input type="text" class="wppum-medium-input" name="wppum_trigger_pages_ids" value="<?php //echo $this->popup['trigger_pages_ids']; ?>" /></label>
               <div class="wppum-hide-if-not-specific-cat-trigger"<?php //echo $show_on_specific_cat ? '' : ' style="display: none;"'; ?>>
        <?php
        $args = array('orderby' => 'name', 'order' => 'ASC');
        $categories = get_categories($args);
        $specific_category_list = "";
        foreach ($categories as $cat_key => $cat_val) {
            $specific_category_list = '<input name="specific_category" type="checkbox" value="' . $cat_val->term_id . '" />' . $cat_val->name;
        }
        if (isset($specific_category_list)) {
            echo $specific_category_list;
        } else {
            echo "Sorry, you have not any category in list.";
        }
        ?>
               </div>
                <div class="wppum-hide-if-not-specific-cat-trigger"<?php echo $show_on_specific_cat ? '' : ' style="display: none;"'; ?>>
        <?php
        $args = array('orderby' => 'name', 'order' => 'ASC');
        $categories = get_categories($args);
        $specific_category_list = "";
        foreach ($categories as $cat_key => $cat_val) {
            $specific_category_list = '<input name="specific_category" type="checkbox" value="' . $cat_val->term_id . '" />' . $cat_val->name;
        }
        if (isset($specific_category_list)) {
            echo $specific_category_list;
        } else {
            echo "Sorry, you have not any category in list.";
        }
        ?>
               </div>
           <div class="wppum-hide-if-not-specific-page-trigger"<?php echo $show_on_specific_pages ? '' : ' style="display: none;"'; ?>>
              <p class="description">
                 Key in the IDs of the pages/posts, each separated by a comma. Example: <code>1,3,10</code><br />
                 Note that shortcodes on individual pages/posts will ignore this setting and always render.<br />
                 <a class="wppum-show-hide-post-list" href="#">Click here to <span class="wppum-show-hide-post-list-text">view</span> the list of all pages/posts and their IDs.</a>
              </p>
              <div class="wppum-post-list-wrapper wppum-hide-if-post-list-disabled" style="display: none;">
                 <table border="1" class="wppum-post-list">
                    <tr>
                       <th>ID</th>
                       <th>Type</th>
                       <th>Title</th>
                    </tr>
        <?php
        $all_posts = get_posts(array('numberposts' => -1, 'post_type' => array('post', 'page')));
        foreach ($all_posts as $curr_post) {  ?>
                <tr>
                    <td><?php echo $curr_post->ID; ?></td>    
                    <td><?php echo $curr_post->post_type; ?></td>                                     <td><?php echo esc_html($curr_post->post_title); ?></td>
                </tr>
            <?php
        }
        ?>
                 </table>
              </div>
           </div>
        </div>-->
        </div>
        <?php
    }

    /**
     * Display 'Enter a unique popup name here' text in "Edit Popup" page.
     * */
    function edit_popup_enter_title_text($title) {
        global $post;
        if ($post->post_type === 'wppum_popup') {
            return __('Enter a unique popup name here', WPPUM_I18N_DOMAIN);
        }
        return $title;
    }

    /**
     * Add custom row action links to Popup views page.
     * */
    function popup_row_actions($actions, $post) {
        // ensure the options are added only to Published/Draft wppum_popup custom post types
        if ('wppum_popup' === $post->post_type && ( $post->post_status === 'publish' || $post->post_status === 'draft' )) {
            $post_type_object = get_post_type_object($post->post_type);
            $actions['wppum_duplicate'] = '<a href="' . wp_nonce_url(admin_url(sprintf($post_type_object->_edit_link . '&amp;action=wppum_duplicate', $post->ID)), 'wppum_duplicate') . '" title="' . __('Duplicate this popup', WPPUM_I18N_DOMAIN) . '">' . __('Duplicate', WPPUM_I18N_DOMAIN) . '</a>';
// DISABLE PREVIEW WITHIN ARCHIVE
//  $actions['wppum_preview'] = '<a target="_blank" href="' . $this->get_preview_popup_link( $post->ID ) . '" title="' . __( 'Preview this popup', WPPUM_I18N_DOMAIN ) . '">' . __( 'Preview', WPPUM_I18N_DOMAIN ) . '</a>';
        }
        return $actions;
    }

    /**
     * Loads Javascripts required for admin popups pages.
     * */
    function my_enqueue() {
        
    }

    function load_scripts() {
        global $pagenow, $post, $wppum_combined_fonts_css;

        if (!is_admin()) {
            return;
        }

        wp_enqueue_style('bootstrap-custom', WPPUM_PLUGIN_URL . 'assets/css/bootstrap-custom.css', false, WPPUM_PLUGIN_VERSION);
        wp_enqueue_style('font-awesome-css', WPPUM_PLUGIN_URL . 'assets/css/font-awesome.min.css', false, WPPUM_PLUGIN_VERSION);
        wp_register_style('wppum_smoothness', WPPUM_PLUGIN_URL . 'assets/css/smoothness/jquery-ui-1.10.4.custom.css', false, WPPUM_PLUGIN_VERSION);
        wp_enqueue_script('popper.min.js', WPPUM_PLUGIN_URL . 'assets/js//popper.min.js');
        wp_enqueue_script('bootstrap.min.js', WPPUM_PLUGIN_URL . 'assets/js/bootstrap.min.js');

        if (( 'edit.php' === $pagenow || 'post.php' === $pagenow || 'post-new.php' === $pagenow ) && ( isset($post->post_type) && 'wppum_popup' === $post->post_type )) {
            
            wp_enqueue_script('jquery-ui-core');


            wp_enqueue_script('jscolor.js', WPPUM_PLUGIN_URL . 'js/jscolor/jscolor.js', false, WPPUM_PLUGIN_VERSION);
            wp_enqueue_script('wppum_admin.js', WPPUM_PLUGIN_URL . 'js/wppum_admin.js', array('jquery'), WPPUM_PLUGIN_VERSION);

            wp_enqueue_style('wppum_admin.css', WPPUM_PLUGIN_URL . 'css/wppum_admin.css', false, WPPUM_PLUGIN_VERSION);

            wp_enqueue_script('plupload-all');

            wp_register_script('wppum_plupload', WPPUM_PLUGIN_URL . 'js/wppum_plupload.js', array('jquery'), WPPUM_PLUGIN_VERSION);

            wp_enqueue_script('wppum_plupload');

            wp_register_style('wppum_plupload', WPPUM_PLUGIN_URL . 'css/wppum_plupload.css', false, WPPUM_PLUGIN_VERSION);
            wp_enqueue_style('wppum_plupload');
            wp_enqueue_style('wppum_smoothness');


            foreach ($wppum_combined_fonts_css as $index => $fonts_css) {
                wp_enqueue_style('wppum_custom_google_fonts_' . $index, $fonts_css);
            }
        } else if ('edit.php' === $pagenow && isset($_GET['post_type']) && 'wppum_popup' === $_GET['post_type']) {
            add_filter('screen_options_show_screen', '__return_false');

            wp_enqueue_style('wppum_smoothness');
            wp_enqueue_script('wppum_admin_edit.js', WPPUM_PLUGIN_URL . 'js/wppum_admin_edit.js', array('jquery'), WPPUM_PLUGIN_VERSION);
            wp_enqueue_style('wppum_admin.css', WPPUM_PLUGIN_URL . 'css/wppum_admin.css', false, WPPUM_PLUGIN_VERSION);

            //SDB REMOVE QUICK EDIT LINK FROM ARCHIVE
            add_filter('post_row_actions', 'remove_row_actions', 10, 1);

            function remove_row_actions($actions) {
                if (get_post_type() === 'your_post_type')
                    unset($actions['edit']);
                unset($actions['inline hide-if-no-js']);
                unset($action['view']);
                return $actions;
            }

        }
    }

    /**
     * Place js config array for plupload (for upload of close button images).
     * */
    function plupload_admin_head() {
        // place js config array for plupload
        $plupload_init = array(
            'runtimes' => 'html5,silverlight,flash,html4',
            'browse_button' => 'plupload-browse-button', // will be adjusted per uploader
            'container' => 'plupload-upload-ui', // will be adjusted per uploader
            'drop_element' => 'drag-drop-area', // will be adjusted per uploader
            'file_data_name' => 'async-upload', // will be adjusted per uploader
            'multiple_queues' => true,
            'max_file_size' => wp_max_upload_size() . 'b',
            'url' => admin_url('admin-ajax.php'),
            'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
            'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
            'filters' => array(array('title' => __('Allowed Files'), 'extensions' => '*')),
            'multipart' => true,
            'urlstream_upload' => true,
            'multi_selection' => false, // will be added per uploader
            // additional post data to send to our ajax hook
            'multipart_params' => array(
                '_ajax_nonce' => "", // will be added per uploader
                'action' => 'plupload_action', // the ajax action name
                'imgid' => 0 // will be added per uploader
            )
        );
        ?>
        <script type="text/javascript">
            var base_plupload_config =<?php echo json_encode($plupload_init); ?>;
            /*$(function() {
             $( "#postbox-container-2" ).accordion();
             });*/
            var popupSettings = <?= json_encode($this->popupSetting) ?>;
            var newsLetterSettings = <?= json_encode($this->news_letter_template_defaults) ?>;
            var popupThemesSettings = <?= json_encode($this->wppum_popup_theme_defaults) ?>;
        </script>
        <?php
    }

    function g_plupload_action() {
        // check ajax nonce
        $imgid = $_POST["imgid"];
        check_ajax_referer($imgid . 'pluploadan');

        // handle file upload
        $status = wp_handle_upload($_FILES[$imgid . 'async-upload'], array('test_form' => true, 'action' => 'plupload_action'));

        // send the uploaded file url in response
        echo $status['url'];
        exit;
    }

    /**
     * Perform AJAX validation when saving/publishing a popup.
     * */
    function publish_admin_hook() {
        global $post;
        if (is_admin() && $post->post_type == 'wppum_popup') {
            ?>
            <script>
                var jqv = jQuery.noConflict();

                jqv(document).ready(function ($) {
                    var form_action = $('#post').attr('action');
                    jqv('#publish, .preview').click(function () {
                        if (jqv(this).attr('id') === 'publish' && jqv(this).data("valid")) {
                            return true;
                        }
                        var form_data = jqv('#post').serializeArray();
                        var data = {
                            action: 'wppum_pre_submit_validation',
                            security: '<?php echo wp_create_nonce('pre_publish_validation'); ?>',
                            form_data: jqv.param(form_data),
                        };
                        var $that = $(this);
                        jqv.post(ajaxurl, data, function (response) {
                            if (typeof response.success === 'undefined' || typeof response.error === 'undefined') {
                                alert("Error: Could not retrieve valid response from server. Please try again.");
                                jqv("#post").data("valid", false);
                                return;
                            }
                            if (response.success) {
                                if ($that.attr('id') === 'publish') {
                                    jqv("#post").data("valid", true).submit();
                                } else {
                                    $('#post')
                                            .attr('action', $that.attr('href'))
                                            .attr('target', '_blank')
                                            .submit()
                                            .removeAttr('target')
                                            .attr('action', form_action);
                                }
                            } else {
                                alert("Error: " + response.error);
                                jqv("#post").data("valid", false);

                            }
                            //hide loading icon, return Publish button to normal
                            jqv('#ajax-loading, #publishing-action .spinner').hide();
                            jqv('#publish').removeClass('button-primary-disabled');
                            jqv('#save-post').removeClass('button-disabled');
                        }, 'json');
                        return false;
                    });
                });
            </script>
            <?php
        }
    }

    /**
     * Handle AJAX request to retrieve all popup names for shortcode dialog window.
     * */
    function ajax_get_popups() {
        global $wppum;
        ob_start();
        $popups = $wppum->get_all_popups();
        foreach ($popups as $popup) {
            ?><option value="<?php echo $popup['name']; ?>"><?php echo $popup['name']; ?></option><?php
        }
        echo json_encode(array('popup_options' => ob_get_clean()));
        die();
    }

    /**
     * Add custom JS to insert ad before the H2 in WPPUM admin pages.
     * */
    function custom_header_ad_js() {
        global $pagenow, $post;

        if (!is_admin()) {
            return;
        }

        // add header ad only on WPPUM Admin pages
        if (( ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) && 'wppum_popup' === $post->post_type ) ||
                ( 'edit.php' === $pagenow && isset($_GET['post_type']) && 'wppum_popup' === $_GET['post_type'] ) ||
                ( 'wppum_settings' === $pagenow )) {
            global $wppum_ad;

            // format ad into Javascript string
            $wppum_ad_array = preg_split("/(\r\n|\n|\r)/", $wppum_ad);
            $wppum_js_ad = '';
            foreach ($wppum_ad_array as $line) {
                $wppum_js_ad .= str_replace(array("'", "/"), array("\\'", "\\/"), $line);
            }

            $settings = get_option('wppum_settings'); ?>
            <script>
                // findme - 
                var jqv = jQuery.noConflict();
                jqv(window).on('load',function () {
                    popoverTemplate = '<div class="popover" role="tooltip"><div class="arrow" ></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
                    jqv('.popovers').popover({
                        container: "body",
                        html: true,
                        offset: 40,
                        template: popoverTemplate,
                    });
                    jqv(".faqs li h6").click(function () {
                        jqv(this).toggleClass('active');
                    });
                    jqv("input[name='wppum_newsletter_template']").on('change', function () {
                        var nlTemplate = jqv(this).val();
                        var newsLetterSetting = newsLetterSettings[nlTemplate];

                        for (var key in newsLetterSetting) {
                            var inputgroupB = newsLetterSetting[key];
                            for (var key_2 in inputgroupB) {
                                var inputa = inputgroupB[key_2];
                                //                            console.log(inputa, key_2);
                                if (key == "radios") {
                                    if (!jqv('input[name="' + key_2 + '"][value="' + inputa + '"]').is(":checked")) {
                                        jqv('input[name="' + key_2 + '"][value="' + inputa + '"]').click()
                                                .attr('checked', true).trigger('change');
                                    }

                                }

                                if (key == "text") {

                                    jqv('input[name="' + key_2 + '"]').val(inputa).trigger('change');
                                    if (jqv('input[name="' + key_2 + '"]').hasClass('color')) {
                                        jqv('input[name="' + key_2 + '"]').css({'background-color': '#' + inputa});
                                    }

                                }
                                if (key == "selectBoxes") {

                                    jqv('select[name="' + key_2 + '"]').val(inputa).trigger('change');

                                }
                            }
                        }
                    });


                    jqv("input[name='wppum_popup_theme']").on('change', function () {
                        var nlTemplate = jqv(this).val();
                        
                        var newsLetterSetting = popupThemesSettings[nlTemplate];

                        for (var key in newsLetterSetting) {
                            var inputgroupB = newsLetterSetting[key];
                            for (var key_2 in inputgroupB) {
                                var inputa = inputgroupB[key_2];
                                //                            console.log(inputa, key_2);
                                if (key == "radios") {
                                    if (!jqv('input[name="' + key_2 + '"][value="' + inputa + '"]').is(":checked")) {
                                        jqv('input[name="' + key_2 + '"][value="' + inputa + '"]').click().attr('checked', true).trigger('change');
                                    }

                                }

                                if (key == "text") {

                                    jqv('input[name="' + key_2 + '"]').val(inputa).trigger('change');
                                    if (jqv('input[name="' + key_2 + '"]').hasClass('color')) {
                                        jqv('input[name="' + key_2 + '"]').css({'background-color': '#' + inputa});
                                    }

                                }
                                if (key == "selectBoxes") {

                                    jqv('select[name="' + key_2 + '"]').val(inputa).trigger('change');

                                }
                            }
                        }
                    });


                    jqv("#wppum_trigger_on_newsletter_email").on("change", function () {

                        if (jqv(this).attr('checked') == "checked") {
                            jqv("#wppum_newsletter_name_placeholder").attr("disabled", false);
                            jqv("#wppum_require_name_newsletter_email").attr("disabled", false);

                        } else {
                            jqv("#wppum_newsletter_name_placeholder").attr("disabled", true);
                            jqv("#wppum_require_name_newsletter_email").attr("disabled", true);

                        }
                    });
                    for (var key in popupSettings) {
                        var inputgroup = popupSettings[key];
                        for (var key_2 in inputgroup) {
                            var inputa = inputgroup[key_2];
                            //                            console.log(inputa, key_2);
                            if (key == "radios") {
                                if (!jqv('input[name="' + key_2 + '"][value="' + inputa + '"]').is(":checked")) {
                                    jqv('input[name="' + key_2 + '"][value="' + inputa + '"]').click()
                                            .attr('checked', true).trigger('change');
                                }

                            }
                            if (key == "checkboxes") {
                                if (jqv('input[name="' + key_2 + '"]').val() == inputa) {
                                    if (!jqv('input[name="' + key_2 + '"]').is(":checked")) {
                                        jqv('input[name="' + key_2 + '"]').click().attr('checked', true).trigger('change');

                                    }


                                } else {
                                    if (jqv('input[name="' + key_2 + '"]').is(":checked")) {
                                        jqv('input[name="' + key_2 + '"]').click().attr('checked', false).trigger('change');
                                    }
                                }
                            }
                            if (key == "text") {

                                jqv('input[name="' + key_2 + '"]').val(inputa).trigger('change');

                            }
                            if (key == "selectBoxes") {

                                jqv('select[name="' + key_2 + '"]').val(inputa).trigger('change');

                            }
                        }
                    }
                })

                jqv(".left-half-child").wrapAll("<div class='left-half'></div>");
                jqv(".right-half-child").wrapAll("<div class='right-half'></div>");
            </script>
            <?php
        }
    }

}

add_action('edit_form_after_title', 'add_content_after_editor');

function add_content_after_editor() {
    if (!empty($_GET['post_type']) && $_GET['post_type'] == 'wppum_popup') {
        echo '<span>This title is for saving the popup on admin side</span>';
    }
}

add_action('edit_form_after_editor', function( $post ) {
    if (!empty($_GET['post_type']) && $_GET['post_type'] == 'wppum_popup') {
//        echo '<h1 style="color:#333">The content of Popup</h1>';
    }
});


/**
 * @Theme Option Admin bar link
 * @return 
 */
if (!function_exists('wppum_toolbar_link_to_theme_options')) {
    add_action('admin_bar_menu', 'wppum_toolbar_link_to_theme_options', 999);

    function wppum_toolbar_link_to_theme_options($wp_admin_bar) {
        flush_rewrite_rules();
        $args = array(
            'id' => 'wppum_theme_options',
            'title' => esc_html__('WP Popup Magic', 'law-firm'),
            'href' => admin_url('edit.php?post_type=wppum_popup&page=wppum_create_popup'),
        );
        $wp_admin_bar->add_node($args);
    }

}



