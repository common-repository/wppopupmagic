<?php
if (!class_exists('Mobile_Detect')) {
    require_once( WPPUM_PLUGIN_PATH . 'vendor/Mobile_Detect.php' );
}

/**
 * WP Popup Magic - Frontend functions.
 * */
class WPPUM_Frontend {

    private $inactive_popups = array();
    private $current_popups = array();
    private $is_mobile = false;
    private $preview_popup = null;

    function __construct() {
        if (!is_admin()) {
            // register/load frontend scripts
            add_action('wp_enqueue_scripts', array(&$this, 'register_script'));
            add_action('wp_footer', array(&$this, 'print_script'));
            add_action("wp_head", function() {
                echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
            });
            // handle wppum shortcodes
            add_shortcode('wppum', array(&$this, 'wppum_shortcode'));
            add_shortcode('wppum_end', array(&$this, 'wppum_end_shortcode'));
            add_shortcode('wppum_link', array(&$this, 'wppum_link_shortcode'));
            add_shortcode('wppum_close', array(&$this, 'wppum_close'));

            // enable shortcodes in nav menu and widgets
            add_filter('wp_nav_menu', 'do_shortcode');
            add_filter('widget_text', 'do_shortcode');
            add_filter('the_content', 'do_shortcode');

            // backwards compatibility; support snpanel shortcodes
            add_shortcode('snpanel', array(&$this, 'wppum_shortcode'));
            add_shortcode('snpanelend', array(&$this, 'wppum_end_shortcode'));

            // handle preview of a single popup
            add_action('wp', array(&$this, 'handle_preview'));
        } elseif (isset($_REQUEST['wppum_preview'])) {
            
        }
    }

    /**
     * Set dummy post content and disable all other popups except the one being previewed.
     * */
    function handle_preview() {
        global $post, $wppum;

        if (empty($_GET['wppum_preview'])) {
            return;
        }

        // don't do anything if not logged in
        if (!is_user_logged_in()) {
            return;
        }

        // retrieve the popup details
        $popup_id = intval($_GET['wppum_preview']);
        if (isset($_POST['post_title'])) {
            // preview values are in $_POST parameters
            $popup = $wppum->sanitize_popup();
            $popup['name'] = stripslashes($_POST['post_title']);
            $popup['ID'] = stripslashes($_POST['post_ID']);
            $popup['raw_contents'] = $popup_post->post_content;
            $popup['contents'] = wpautop(stripslashes($_POST['content']));
            $popup['order'] = stripslashes($_POST['menu_order']);
            $popup['status'] = 'publish';      // always show this popup in preview no matter what
        } else {
            $popup_post = get_post($popup_id);
            $popup = $wppum->get_popup($popup_id);
            $popup['name'] = $popup_post->post_title;
            $popup['ID'] = $popup_post->ID;
            $popup['raw_contents'] = $popup_post->post_content;
            $popup['contents'] = wpautop($popup_post->post_content);
            $popup['order'] = $popup_post->menu_order;
            $popup['status'] = $popup_post->post_status;
        }

        // set dummy post content
        $post->post_title = $popup['name'] . ' Preview';
        $post->post_content = '<p>This is a dummy post for previewing of popups. Dummy start/end target shortcodes for the popup being previewed have been inserted into this post below. Scroll down to view them. All other popups have been disabled on this page.</p>' .
                ( ( $popup['trigger_on_link_click'] === '1' ) ? '<p><a href="http://test.com">This is a sample exernal link.</a> Click on it to trigger your popup.' : '' ) .
                '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum molestie mi id blandit. Vivamus consequat pellentesque aliquam. Nulla adipiscing arcu eget elit ultrices sed faucibus urna fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eu gravida arcu. Sed viverra varius purus vitae pellentesque. Duis venenatis adipiscing mauris, ac facilisis justo egestas at. Duis aliquet magna nec purus ornare sit amet aliquet ipsum placerat. Pellentesque consequat urna eu justo imperdiet sit amet mollis orci egestas. Donec non ligula eros, at blandit neque. Donec ultrices ornare nulla non cursus. In hac habitasse platea dictumst. Quisque varius eleifend ante vel lobortis. Pellentesque suscipit diam et nisl ultricies eu lobortis ante tempus.</p>' .
                '<p>Phasellus vel lectus at nulla pretium pulvinar. Etiam dolor arcu, blandit nec tincidunt sed, faucibus ut lorem. In arcu dolor, varius sed congue ac, elementum eget sem. Maecenas tempus varius rhoncus. Praesent eu mi dolor, ac porttitor quam. Donec rutrum dolor ut elit lacinia ut semper nulla volutpat. Praesent bibendum dictum enim eu varius. Nunc euismod massa ut justo vehicula condimentum. Fusce suscipit diam in mi sodales eget tempor turpis varius. Aliquam id purus sed nisl lobortis gravida. Aliquam sed magna id felis porttitor posuere. Vestibulum et lacus lorem. Phasellus nec ligula arcu. Vivamus tincidunt tortor fermentum erat adipiscing lacinia. Pellentesque id eros id eros laoreet bibendum eu vitae dolor. Donec in vehicula erat.</p>' .
                '<p style="font-size: 14px; text-align: center; border: 1px solid #DEDEDE; background-color: black; color: white;"><strong><code>START TRIGGER TARGET SHORTCODE HERE!<br /> [wppum name="' . $popup['name'] . '"] Use the shortcode <br />[[wppum name="' . $popup['name'] . '"]]<br /> in your posts to insert the start trigger target shortcode for this popup.</code></strong></p>' .
                '<p>Sed semper ipsum eget massa ornare sollicitudin. Proin vitae nisi et nisl fringilla vehicula porta id neque. Sed a sem ipsum, eget placerat sem. Vestibulum justo turpis, lacinia nec vehicula eu, cursus vel nisi. Aliquam ligula ligula, rutrum sed tempor vitae, luctus at odio. Maecenas tincidunt enim suscipit quam accumsan consequat. Nulla condimentum vehicula nulla nec hendrerit. Maecenas id blandit nulla. Nullam adipiscing augue eu nibh vehicula viverra.</p>' .
                '<p>Ut commodo ante id nulla cursus gravida. Praesent posuere scelerisque justo vitae convallis. Sed vestibulum, odio pellentesque consectetur congue, purus arcu rhoncus ante, a tincidunt augue sem eu sem. Suspendisse ac massa felis. Sed et blandit orci. Suspendisse potenti. Vestibulum eu cursus felis. Etiam fermentum rhoncus nibh et lacinia. In eget ligula diam, et facilisis nulla. Etiam sed nisi lorem, non volutpat nibh. In id ipsum sed purus fermentum malesuada nec id ante. Cras pretium, arcu eu adipiscing condimentum, nisi nulla ullamcorper sem, et tincidunt diam purus et quam. Nam sollicitudin ultricies lectus sed dignissim.</p>' .
                '<p style="font-size: 14px; text-align: center; border: 1px solid #DEDEDE; background-color: black; color: white;"><strong><code>END TRIGGER TARGET SHORTCODE HERE!<br /> [wppum_end name="' . $popup['name'] . '"] Use the shortcode <br />[[wppum_end name="' . $popup['name'] . '"]]<br /> in your posts to insert the end trigger target shortcode for this popup.</code></strong></p>' .
                '<p>In hac habitasse platea dictumst. Cras varius dolor vel eros porttitor tincidunt. In hac habitasse platea dictumst. Aliquam ante risus, aliquet vulputate vehicula quis, pulvinar id urna. Mauris pretium consequat tortor, ac ullamcorper risus tempus vel. Nullam quis eros elit, tincidunt vestibulum risus. Donec faucibus tristique dui quis congue. Nulla elementum fermentum euismod. In congue pellentesque diam ac fermentum.</p>';

        $this->preview_popup = $popup;
    }

    /**
     * Ensure specified popup has not been disabled on mobile devices (if user is on one),
     * or popup has not been set to be shown on mobile-only devices (if user is not on one).
     * */
    function check_mobile($popup) {
        if (( $popup['show_mobile'] === 'disable_mobile' && $this->is_mobile ) ||
                ( $popup['show_mobile'] === 'mobile_only' && !( $this->is_mobile ) )) {
            return false;
        }

        return true;
    }

    /**
     * Registers Javascript required for front-end.
     * */
    function register_script() {
        wp_enqueue_style('wppum_front.css', WPPUM_PLUGIN_URL . 'css/wppum_front.css', false, WPPUM_PLUGIN_VERSION);

        global $wppum, $post;

        $debug = false;

        // detect whether user is on a mobile device
        $mobile_detect = new Mobile_Detect();
        $this->is_mobile = $mobile_detect->isMobile();

        // grab all popups
        $popups = $wppum->get_all_popups();

        // get ID of static page that's been set as homepage
        $frontpage_id = get_option('page_on_front');

        // Initially lists are empty
        $this->current_popups = array();
        $this->inactive_popups = array();

        // Loop over all pop-ups and determine if they should be current (active) or not
        // Other things happen in JS to determine if they actually show or not...we're just determining if they are
        // eligible according to the settings under "rules"
        foreach ($popups as $index => $popup) {
            // If this popup isn't even published, skip it altogether and don't make it inactive or active
            if ('publish' != $popup['status']) {
                if ($debug) {
                    printf('<p>[%s] Skipped, not published.</p>', $popup['name']);
                }
                continue;
            }

            // Add information to the popup for storage and later use
            // ..
            // Get the categories this post is in
            $categories = get_the_category($post->ID);
            // Make a CSV of categories this post is in
            if (is_array($categories)) {
                $cat_array = array();
                foreach ($categories as $category) {
                    $cat_array[] = $category->term_id;
                }
                $cat_array_val = implode(',', $cat_array);
            }

            $popup['post_category'] = $cat_array_val;
            $popup['current_page'] = $post->ID;
            $popup['post_type'] = get_post_type($post->ID);

            $queried_object = get_queried_object();
            $popup['term_id'] = ($queried_object) ? $queried_object->term_id : '';


            // Examine the "Rules" portion.  These are checkboxes so ANY one can apply but once you've matched
            // one just go ahead and continue on, one match makes it active/current
            // i.e. these conditionals only add to current pop-ups... the fall through adds to inactive
            // If we're supposed to show on all pages including the home page, add this popup
            if ('show_all_include_homepage' == $popup['show_all_include_homepage_options']) {
                $this->current_popups[] = $popup;
                if ($debug) {
                    printf('<p>[%s] Added for show on all pages.</p>', $popup['name']);
                }
                continue; // examine the next pop-up
            }

            // Are we set to show on all web pages EXCEPT the homepage?
            if ('show_all_exclude_homepage' == $popup['show_all_exclude_homepage_options']) {
                // Are we NOT on the front page?
                if (!is_front_page()) {
                    $this->current_popups[] = $popup;
                    if ($debug) {
                        printf('<p>[%s] Added for show on all web pages EXCEPT the homepage.</p>', $popup['name']);
                    }
                    continue; // examine the next pop-up
                }
            }
            // Are we showing only on the home page and pages with the shortcode?
            if ('show_homepage_and_shortcode' == $popup['show_homepage_and_shortcode_options']) {
                // If we're on the home page, we're good
                if (is_front_page()) {
                    $this->current_popups[] = $popup;
                    if ($debug) {
                        printf('<p>[%s] Added for showing only on the home page.</p>', $popup['name']);
                    }
                    continue; // examine the next pop-up
                }
                // ... else if we're not on the home page, we don't do anything else (i.e. let it fall through and become
                // inactive or hit by another rule). The shortcode stuff is handled elsewhere
            }

            // Are we supposed to hide on all pages except those with the shortcode?
            if ('hide_all' == $popup['hide_all_options']) {
                // NOP: This rule has no effect here. We fall through and become inactive or hit by another rule below.
                // The shortcode stuff is handled elsewhere
                if ($debug) {
                    printf('<p>[%s] NOOP - hide on all pages.</p>', $popup['name']);
                }
            }

            //
            //    -----
            //    Begin combined rules EACH of these set must be matched before we show the popup
            //    -----
            //
            $numRulesMustMatch = 0;
            $numRulesMatched = 0;

            // Are we showing only on specific pages/posts?
            if ('show_pages' == $popup['show_pages_options']) {
                $numRulesMustMatch++; // Count that this rule must be matched
                // Get the list of pages we want to be shown on into an array
                $pagesToShowOn = isset($popup['show_pages_val']) ? explode(',', $popup['show_pages_val']) : array();
                // Are we on one of those pages?
                if (false !== array_search($post->ID, $pagesToShowOn)) {
                    $numRulesMatched++; // Consider this rule matched
                    if ($debug) {
                        printf('<p>[%s] matched show specific page.</p>', $popup['name']);
                    }
                }
            }

            // Are we supposed to Hide only on specific pages/posts?
            // (implies it shows on others)
            if ('hide_pages' == $popup['hide_pages_options']) {
                $numRulesMustMatch++; // Count that this rule must be matched
                // Get the list of pages we want to be hidden on into an array
                $pagesToHideOn = isset($popup['hide_pages_val']) ? explode(',', $popup['hide_pages_val']) : array();
                // Are we on one of those pages?
                if (false === array_search($post->ID, $pagesToHideOn)) {
                    // The current page isn't in our list of pages to hide on so show
                    $numRulesMatched++; // Consider this rule matched
                    if ($debug) {
                        printf('<p>[%s] matched hide specific page.</p>', $popup['name']);
                    }
                }
                // ... else fall through, if no other rule catches us it'll be inactive due to the hide request above
            }

            // Are we showing on posts in a specific category?
            if ('specific_cat' == $popup['specific_cat_options']) {
                $numRulesMustMatch++; // Count that this rule must be matched
                // We only want to do this when we're NOT on an archive page.  It's too confusing to show those if
                // one of the loop posts happens to be in the category
                if (is_page() || is_single()) {
                    $categoriesToShowIn = explode(',', $popup['specific_category_val']);
                    $categoriesThisPostIsIn = explode(',', $popup['post_category']);
                    // If these two sets have any intersection add this popup
                    if (count(array_intersect($categoriesToShowIn, $categoriesThisPostIsIn)) > 0) {
                        $numRulesMatched++; // Consider this rule matched
                        if ($debug) {
                            printf('<p>[%s] matched show specific category.</p>', $popup['name']);
                        }
                    }
                }
            }

            // Are we showing on a particular URL pattern?
            if ('url_pattern' == $popup['url_pattern_options']) {
                $numRulesMustMatch++; // Count that this rule must be matched

                if (false !== strstr(get_permalink(), $popup['url_pattern_val'])) {
                    // We found the url match in our URL so add this one
                    $numRulesMatched++; // Consider this rule matched
                    if ($debug) {
                        printf('<p>[%s] matched URL pattern.</p>', $popup['name']);
                    }
                }
            }

            // Are we showing for particular referring URLs?
            if ('web_referring_url' == $popup['web_referring_url_options']) {
                $numRulesMustMatch++; // Count that this rule must be matched

                $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

                if (false !== strstr($referer, $popup['web_referring_url_val'])) {
                    // We found the url match in our referring URL so add this one
                    $numRulesMatched++; // Consider this rule matched
                    if ($debug) {
                        printf('<p>[%s] matched referring URL.</p>', $popup['name']);
                    }
                }
            }

            if ($debug) {
                printf('<p>[%s] %s matched, %s must match.</p>', $popup['name'], $numRulesMatched, $numRulesMustMatch);
            }

            //
            // Now that we're done evaluating combined rules, see how the matches worked out
            //
            // If the counters are both zero, we're inactive
            if (0 == $numRulesMatched && 0 == $numRulesMustMatch) {
                // you made it this far and found no reason to add this popup to current_popups so it's not
                // eligible to be shown (per the rules settings)
                $this->inactive_popups[] = $popup;
                continue; // examine the next pop-up
            }
            // elseif they match (and aren't 0 from above) we're active
            elseif ($numRulesMatched == $numRulesMustMatch) {
                $this->current_popups[] = $popup;
                continue; // examine the next pop-up
            }

            // else... if they don't match (and aren't 0 from above) we're not active
            $this->inactive_popups[] = $popup;
        } // foreach
    }

    /**
     * Prints the Javascript required for front-end, along with the HTML for the current active popups.
     * */
    function print_script() {

        $final_popups = array();
        if (!empty($this->preview_popup)) {
            $final_popups[] = $this->preview_popup;
        } else {
            foreach ($this->current_popups as $popup) {
                // ensure each popup mobile settings are ok
                if (!( $this->check_mobile($popup) )) {
                    continue;
                }
                // ensure draft popups are not shown
                if ($popup['status'] === 'draft') {
                    continue;
                }
                $final_popups[] = $popup;
            }
        }

        if (empty($final_popups)) {
            // no need to print anything if no popups are active
            return;
        }

        // print out the basic HTML and its contents for each popup
        $javascript_dependencies = array('jquery', 'jquery-ui-core', /* 'jquery-effects-core' */);
        $localized_data = $this->get_localize_array($final_popups);
        //print_r($localized_data['popups']);

        foreach ($localized_data['popups'] as $index => $popup) {
            if ($popup['popup_type'] == 'video') {
                $countent = $popup['raw_contents'];
                $countent = "[video src='$countent']";
                $popup['contents'] = $countent;
            }
            if ($popup['popup_type'] == 'iframe') {
                $countent = $popup['raw_contents'];

                $popup['contents'] = $countent;
            }
            if ($popup['popup_type'] == 'newsletter') {
                $countent = $popup['raw_contents'];
                $countent .= $this->getNewsLetterHtml($popup);

                $popup['contents'] = $countent;
            }
            ?>
            <div id="<?php echo $popup['popup_id']; ?>-effects-wrapper" class="th_<?= $popup['popup_theme']; ?> wppum-effects-wrapper">
                <div id="<?php echo $popup['popup_id']; ?>" class="" style="display: none;">
                    <div id="<?php echo $popup['popup_id']; ?>-responsive" class="wppum-responsive" style="max-height: 100%; max-width: 100%;">
                        <?php
                        echo $popup['close_button_type'] === 'toggle' ? '<span class="wppum-open" style="cursor:pointer;z-index:99999999;position:absolute;display:none;"><img src="' . $popup['open_button_img'] . '" title="Open" /></span>' : '';

                        if ($popup['self_close_type'] == 1) {
                            // Add class for self close
                            if ($popup['contents'] == "") {
                                $popup['contents'] = "";
                            } {
                                $newDom = new DOMDocument();
                                @$newDom->loadHTML($popup['contents']);
                                $newDom->removeChild($newDom->doctype);


                                $tag = $newDom->getElementsByTagName('a');

                                foreach ($tag as $tag1) {

                                    if ($tag1->getAttribute('href')) {

                                        $hrefVal = $tag1->getAttribute('href');
                                        $class_exist = $tag1->getAttribute('class');
                                        if (strpos($hrefVal, '[') !== false) {
                                            $classVal = $classVal . "wppum-close snpanel-close wppum-internal-link-click";
                                        } else {
                                            $classVal = $classVal . "wppum-close snpanel-close";
                                        }
                                        $tag1->setAttribute("class", $classVal);
                                        $classVal = "";
                                    }

                                    $popup['contents'] = $newDom->saveHTML();

                                    $popup['contents'] = str_replace("<html><body>", " ", $popup['contents']);
                                }
                            }
                        }
                        if ($popup['self_close_type'] != 1) {
                            // Add class for self close
                            if ($popup['contents'] == "") {
                                $popup['contents'] = "";
                            } else {
                                $newDom = new DOMDocument();
                                @$newDom->loadHTML($popup['contents']);
                                $newDom->removeChild($newDom->doctype);
                                $newDom->replaceChild($newDom->firstChild->firstChild->firstChild, $newDom->firstChild);
                                $tag = $newDom->getElementsByTagName('a');

                                foreach ($tag as $tag1) {

                                    if ($tag1->getAttribute('href')) {

                                        $hrefVal = $tag1->getAttribute('href');
                                        $class_exist = $tag1->getAttribute('class');
                                        if (strpos($hrefVal, '[') !== false) {
                                            $classVal = $classVal . "wppum-internal-link-click";
                                        } else {
                                            // $classVal=$classVal."wppum-close snpanel-close";
                                        }
                                        $tag1->setAttribute("class", $classVal);
                                        $classVal = "";
                                    }

                                    $popup['contents'] = $newDom->saveHTML();
                                }
                            }
                        }
                        if ($popup['popup_theme'] == 2 && 1 == 2) {
                            ?>
                            <div class="wppum_footer ">

                                <?= $popup['close_button_type'] === 'hide' ? '' : $popup['close_button_html']; ?>
                            </div>
                            <?php
                        }
                        echo $popup['close_button_type'] === 'hide' ? '' : $popup['close_button_html'];
                        echo $popup['title'] === '1' ? $popup['title_html'] : '';
                        $start_tag = '[wppm_close]';
                        $end_tag = '[/wppm_close]';
                        $rp_start_tag = '<a href="#" class="wppum-close snpanel-close wppm-cook">';
                        $rp_end_tag = '</a>';
                        $popup['contents'] = str_replace($start_tag, $rp_start_tag, $popup['contents']);
                        $popup['contents'] = str_replace($end_tag, $rp_end_tag, $popup['contents']);

                        // Cleaning up shortcode bits - sdb
                        $popup['contents'] = str_replace("%20", " ", $popup['contents']);
                        $popup['contents'] = str_replace("%5B", "[", $popup['contents']);
                        $popup['contents'] = str_replace("%5D", "]", $popup['contents']);
                        // End cleaning up shortcode bits - sdb

                        echo apply_filters('the_content', $popup['contents']);
                        if (1 == 2 && ($popup['popup_theme'] == 1 || $popup['popup_theme'] == 3)) {
                            ?>
                            <div class="wppum_footer">

                                <?= $popup['close_button_type'] === 'hide' ? '' : $popup['close_button_html']; ?>
                            </div>
                            <?php
                        }

                        if ($popup['trigger_on_link_click'] === '1' && $popup['link_click_popup_type'] === 'html' && ( $popup['ok_button'] === '1' || $popup['cancel_button'] === '1' )) {
                            ?>
                            <div class="wppum-buttons-wrapper" style="display: none;
                                 text-align: center;
                                 margin: 5px 5px;
                                 ">
                                     <?php echo $popup['ok_button'] === '1' ? $popup['ok_button_html'] : ''; ?>
                                     <?php echo $popup['cancel_button'] === '1' ? $popup['cancel_button_html'] : ''; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            // no need to send out contents and close button data to Javascript
            unset($localized_data['popups'][$index]['contents']);
            unset($localized_data['popups'][$index]['close_button_img']);
            unset($localized_data['popups'][$index]['close_button_html']);

            // add javascript dependency for this animation effect
            $effect_name = $popup['animation_effect'];
            if ($effect_name === 'puff' || $effect_name === 'size') {
                $effect_name = 'scale';
            }
            if (!in_array('jquery-effects-' . $effect_name, $javascript_dependencies)) {
                if (!empty($effect_name)) {
                    $javascript_dependencies[] = 'jquery-effects-' . $effect_name;
                }
            }
        }

        wp_register_script('wppumjs', WPPUM_PLUGIN_URL . 'js/wppum.js', $javascript_dependencies, WPPUM_PLUGIN_VERSION);
        wp_localize_script('wppumjs', 'wppum', $localized_data);
        wp_enqueue_script('wppumjs');
    }

    /**
     * Returns multi-dimensional array of values of current active popups, to be sent via wp_localize_script.
     * */
    function get_localize_array($popups) {
        global $wppum_fonts;

        $localized_popups = array();
        foreach ($popups as $popup) {
            $popup['fonts'] = '';

            // if color is blank, set it to transparent. Otherwise, prefix # to it.
            $color_check_keys = array('background_color', 'border_color', 'overlay_color', 'content_color');
            foreach ($color_check_keys as $color_check_key) {
                if (empty($popup[$color_check_key])) {
                    $popup[$color_check_key] = 'transparent';
                } else {
                    $popup[$color_check_key] = '#' . $popup[$color_check_key];
                }
            }

            // set hashed name as ID
            $popup['popup_id'] = 'wppum_' . hash('md5', $popup['name']);

            if ($popup['trigger_on_link_click'] === '1' && $popup['link_click_popup_type'] !== 'html') {
                // need to send out contents HTML for Javascript alert/confirm popups
                $popup['sanitized_contents'] = strip_tags($popup['contents']);
            }

            // replace [CLOSE_BUTTON] tag in close button HTML
            $popup['close_button_html'] = str_replace('[CLOSE_BUTTON]', $popup['close_button_img'], $popup['close_button_html']);

            // replace [TITLE] tag in title bar HTML
            $popup['title_html'] = str_replace('[TITLE]', $popup['title_text'], $popup['title_html']);

            // replace [OK] and [OK_WIDTH] tags in OK button HTML
            $popup['ok_button_html'] = str_replace(array('[OK]', '[OK_WIDTH]'), array($popup['ok_button_text'], $popup['ok_button_width']), $popup['ok_button_html']);

            // replace [CANCEL] and [CANCEL_WIDTH] tags in Cancel button HTML
            $popup['cancel_button_html'] = str_replace(array('[CANCEL]', '[CANCEL_WIDTH]'), array($popup['cancel_button_text'], $popup['cancel_button_width']), $popup['cancel_button_html']);

            // pass whitelisted domains as array
            $popup['whitelisted_domains'] = array_map('strtolower', array_filter(explode("\n", $popup['whitelisted_domains'])));
            $popup['whitelisted_domains'][] = str_ireplace(array('http://', 'https://'), '', home_url());   // whitelist local domain
            // sanitize HTML
            $html_check_keys = array('styles');
            foreach ($html_check_keys as $html_check_key) {
                $popup[$html_check_key] = str_replace('-->', '// -->', html_entity_decode($popup[$html_check_key]));
            }

            // set width and height
            if ($popup['size_type'] === 'contents') {
                $popup['width'] = 'auto';
                $popup['height'] = 'auto';
            } else if ($popup['size_type'] === 'bgimage') {
                list( $width, $height ) = getimagesize($popup['background_img']);
                $popup['width'] = ( $width - intval($popup['padding_left']) - intval($popup['padding_right']) - intval($popup['border_width']) * 2 ) . 'px';
                $popup['height'] = ( $height - intval($popup['padding_top']) - intval($popup['padding_bottom']) - intval($popup['border_width']) * 2 ) . 'px';
            } else {
                // for exact custom pixel widths/heights, deduct the padding and border widths
                if (( strlen($popup['width']) > 1 ) && substr($popup['width'], -1) !== '%') {
                    $popup['width'] = intval($popup['width']) - intval($popup['padding_left']) - intval($popup['padding_right']) - intval($popup['border_width']) * 2;
                    if ($popup['width'] < 0) {
                        $popup['width'] = 0;
                    }
                    $popup['width'] .= 'px';
                }
                if (( strlen($popup['height']) > 1 ) && substr($popup['height'], -1) !== '%') {
                    $popup['height'] = intval($popup['height']) - intval($popup['padding_left']) - intval($popup['padding_right']) - intval($popup['border_width']) * 2;
                    if ($popup['height'] < 0) {
                        $popup['height'] = 0;
                    }
                    $popup['height'] .= 'px';
                }
            }

            // Track which fonts we've already loaded
            $fontsAdded = array();

            // add any required font CSS files, if they have not yet been loaded
            foreach ($wppum_fonts as $font_name => $font) {
                $searchString = sprintf("font-family: %s", $font[0]);
                $searchBody = str_replace("'", "", $popup['contents']);

                // If the current font is in our content and NOT YET in our already loaded array, add it
                if (false !== strstr($searchBody, $searchString)   // needed by content
                        && !isset($fontsAdded[$font[0]])) {                // not already loaded
                    // load the CSS by adding it to "fonts" setting
                    $popup['fonts'] .= "<link href='" . str_replace(',', '%2C', $font[1]) . "' rel='stylesheet' type='text/css'>\n";
                    // Note that we've already loaded this one
                    $fontsAdded[$font[0]] = true;
                }
            }
            $localized_popups[] = $popup;
        }
        $data = array('popups' => $localized_popups);
        return $data;
    }

    /**
     * Replaces wppum end target shortcode with .wppum_scroll_shortcode_end_target HTML element.
     * */
    function wppum_end_shortcode($atts) {
        extract(shortcode_atts(array(
            'name' => ''
                        ), $atts));
        $name = stripslashes($name);

        return '<span class="wppum_scroll_shortcode_end_target" data-popup-name="' . $name . '"></span>';
    }

    /**
     * Replaces wppum_link shortcode with #popup_id.
     * */
    function wppum_link_shortcode($atts) {
        extract(shortcode_atts(array(
            'name' => ''
        ), $atts));

        if (empty($name)) {
            return '#';      // nothing to do if popup name is not set
        }

        $name = stripslashes($name);
        if (substr($name, 0, 6) === '&quot;' && substr($name, -6) === '&quot;') {
            $name = substr($name, 6, -6);
        }

        // add to current popups (if not already added)
        foreach ($this->inactive_popups as $index => $popup) {
            if (strtolower($popup['name']) === strtolower($name)) {
                $this->current_popups[] = $popup;
                unset($this->inactive_popups[$index]);
                break;
            }
        }

        $poplink = '#';
        return ($sdblink);
    }

    /*
      Function for custom text to close popup
     */

    function wppm_close($atts) {
        extract(shortcode_atts(array(
            'name' => ''
        ), $atts));

        if (empty($name)) {
            return '#';      // nothing to do if popup name is not set
        }
        $name = stripslashes($name);
        print_r($name);
        return '<span class="wppum_scroll_shortcode_end_target" data-popup-name="' . $name . '"></span>';
    }

    /**
     * Replace wppum trigger target shortcode with .wppum_scroll_shortcode_target HTML element,
     * and to setup popup parameters.
     * */
    function getNewsLetterHtml($popup) {
        ob_start();
        if ($popup["newsletter_template"] == 1) {

            include('admin/templates/newsletter_1.php');
        }
        if ($popup["newsletter_template"] == 2) {

            include('admin/templates/newsletter_2.php');
        }
        if ($popup["newsletter_template"] == 3) {

            include('admin/templates/newsletter_3.php');
        }
        if ($popup["newsletter_template"] == 4) {

            include('admin/templates/newsletter_4.php');
        }
        if ($popup["newsletter_template"] == 5) {

            include('admin/templates/newsletter_5.php');
        }
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
        $form = "<div class='wppum_newsletter theme_" . $popup["newsletter_template"] . "'>";
        $form .= "<form id = 'wppum_nl_form' action = '#' class='wppum_nl_form'>";
        if ($popup['trigger_on_newsletter_email'] == 1) {
            $form .= '
    <div class="row">
        <label class="col-md-3 form-check-label" >Name:</label>
        <div class="col-md-9">
            <input class="wppum_nl_name" name="wppum_nl_name" id="wppum_nl_name"  class="form-control" placeholder="Your Name..."/>
        </div>

    </div>';
        }
        $form .= '
    <div class="row">
        <label class="col-md-3 form-check-label" >Email:</label>
        <div class="col-md-9">
                    <input class="wppum_nl_email_to" name="wppum_nl_email_to" id="wppum_nl_email_to" value="' . $popup["newsletter_email"] . '" type="hidden"/>

            <input class="wppum_nl_email" name="wppum_nl_email" id="wppum_nl_email"  class="form-control" placeholder="Your Email..."/>
        </div>

    </div>
    <div class="row">
        <label class="col-md-3 form-check-label" ></label>
        <div class="col-md-9">
           <input class="btn btn-primary" type="submit"/>
        </div>

    </div>';
        $form .= "</form>";
        $form .= "</div>";
        return $form;
    }

    function wppum_shortcode($atts) {
        // only run shortcodes on pages/posts
        if (!is_page() && !is_single()) {
            return '';
        }

        extract(shortcode_atts(array(
            'name' => ''
        ), $atts));

        if (empty($name)) {
            return;      // nothing to do if popup name is not set
        }
        $name = stripslashes($name);

        // add to current popups (if not already added)
        foreach ($this->inactive_popups as $index => $popup) {
            if (strtolower($popup['name']) === strtolower($name)) {
                $this->current_popups[] = $popup;
                unset($this->inactive_popups[$index]);
                break;
            }
        }

        return '<span class="wppum_scroll_shortcode_target" data-popup-name="' . $name . '"></span>';
    }
}