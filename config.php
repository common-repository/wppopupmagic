<?php

// Specify the URL for the .JSON file containing plugin update information.
define('WPPUM_UPDATE_JSON_URL', 'http://wppopupmagic.com/wp-popup-magic.json');

// Specify the URL for the plugin's PDF file, linked from the Plugins page.
define('WPPUM_PLUGIN_PDF_URL', 'http://wppopupmagic.com/wp-popup-magic3.pdf');

// Specify the URL for the file containing fonts retrieved from Google.
define('WPPUM_FONTS_URL', 'http://wppopupmagic.com/fonts.php');

// Number of seconds to cache Google Fonts data locally.
define('WPPUM_FONTS_CACHE_EXPIRY', 7 * 24 * 60 * 60);

// Default number of popups to be shown per page in "Manage Popups".
// User can change this via Screen Options (top-right corner of page).
define('WPPUM_DEFAULT_ITEMS_PER_PAGE', 10);
define('WPPUM_POPUP_PATH', dirname(__FILE__));
define('WPPUM__POPUP_URL', plugins_url('', __FILE__));
define('WPPUM_POPUP_ADMIN_URL', admin_url());
define('WPPUM_POPUP_FILE', plugin_basename(__FILE__));
define('WPPUM_POPUP_ADMIN_FILES', WPPUM_POPUP_PATH . '/admin/templates');
// Specify text of tooltip in admin area.
global $wppum_tooltip_text;
$wppum_tooltip_text = array(
    'Size' => 'This determines the size of your popup in pixels or percentages. You can also choose to have the popup size be determined by its contents (this assumes the content has its own fixed size, which is common for embedded videos), or even by the size of the background image you upload. For popups to be responsive, the size must be set in percentages.',
    'Size Fit To Contents' => 'Select this option to give the popup an auto width/height. The popup will simply take up the size of its contents. However, this will only work for content that has an explicitly set width and height (e.g. an embedded video).',
    'Size Background Image' => 'Choose or upload a background image in the \\\'Background\\\' settings box, and select this option to have the popup be the same size as the background image.',
    'Size Custom' => 'You can specify an exact pixel height and width to get the exact size you want for the popup, or you can set the size as a percentage of your reader\\\'s screen. For example, if you put 100% height and 100% width, your popup will take up the full browser of your reader, no matter what size their monitor is!',
    'Background' => 'This sets the background of your popup. You can either choose a solid (or transparent) color, or upload your own background image.',
    'Background Color' => 'When you click in the field, a simple color picker appears so you can grab the exact color you need. If you\\\'re a power user who has an exact hexadecimal color you want to use, you can type that right in the field, too. Or, you can leave the field blank and your background will be transparent!',
    'Background Image' => 'If you select this option, you can choose from a set of default background images, or upload your own. You can then set the popup size to the image\\\'s size in the \\\'Size\\\' settings box. Note that if you specify a popup size larger than the selected background image, the background image will appear tiled in the popup.',
    'Border' => 'Here you can set the style, thickness, and color of your border. Color is set with the same simple color picker as the Background Color setting. You can pick from a few different border styles from the simple drop-down menu. Thickness is measured with pixels, so just type in how many pixels thick you want your border to be and you\\\'re done!',
    'CSS' => 'This allows you to customize the CSS of the popup. If you don\\\'t know what CSS means, don\\\'t worry about it. The amount of settings WP Popup Magic offers to customize your popup\\\'s look will let you craft attractive popups \\\'til the cows come home, even without touching this setting.',
    'Classes' => 'This is used to give the popup one or more HTML classes, in case your stylesheet on your webpage applies certain features that you want your popup to have. You\\\'ll probably almost never use this unless you have some really specific plans for a complicated webpage. If you understand what an HTML class is, you can use this to create custom popups that tie in to your webpage beautifully. If you don\\\'t, don\\\'t worry about it. 95% of WP Popup Magic users will never touch this area and it will not impact your ability to make unique and exciting popups for your website.',
    'Styles' => 'This field lets you enter any CSS styling code that you want your popup to have. If you\\\'re a power user who wants a really specific look, or if you are copying/pasting CSS code from an external vendor such as AWeber, this is where you should drop your CSS code.',
    'Border/Content Padding' => 'This setting adds some white space between your popup\\\'s content and the popup\\\'s border. The default of 5 pixels is fine for almost all popups, so you might not ever need to touch this setting. If you want, though, you can adjust the amount of whitespace on the top, bottom, left, and right all independently.',
    'Position' => 'This governs where your popups show up on your user\\\'s screen. Just like popup size, you can set this with both exact pixel count and percentage of screen size, measured from the side of the screen indicated. For example, to have the popup appear a bit away from the bottom of the screen, you might put "5px" or "1%" for the vertical offset and select "Bottom" for Vertical position!',
    'Animation' => 'This sets the animation for the popup. For example, to have a popup slide from the bottom of the screen, select "Slide" for the effect, and "From bottom" for direction, and the popup will slide in moving up from the bottom. You can also change the speed of the animation using the Speed field. Default speed is 1000 milliseconds (1 second). If you set it to 500 milliseconds, it will go twice as fast. If you set it to 2000 milliseconds, it will move at half the speed.',
    'Close/Toggle Button' => 'Here, you can select whether to have a close button or a toggle button. You can also upload a custom image for the close button on the popup. In addition, advanced users can edit the HTML of the close button to modify its location from the default top-right corner.',
    'Toggle Button' => 'Toggle button allows your user to re-open a closed popup. Instead of disappearing completely when closed, the popup will minimize, leaving behind a clickable toggle button for your users to re-open it when they want.',
    'Close Button Image' => 'You can upload one or more custom images for the popup\\\'s close button, or select from the list of default images. Once you save the popup, images that you have uploaded will be available for selection in other popups as well. The selected image for the current popup is marked with a solid border. Simply click on another image to change the selection.',
    'Close Button HTML' => 'This is the HTML for the close button on the popup. The default location of the close button is in the top right, and for 99% of popups this will work just fine. Heavy customizers might want want to change the location of the close button, and this section lets you do that easily.',
    'Triggers' => 'Here, you can specify mobile display settings, which pages/posts of the site the popup will appear in, which events will trigger the popup on the individual pages/posts, and the number of times the popup will appear across the entire site for each visitor.',
    'Trigger Frequency' => 'By default, when no frequency limit is specified, popups will be shown after every single trigger event across all pages/posts they have been set to appear in. This can become annoying for visitors to your site. You can change this by setting the frequency limit here. For example, you can specify the popup to appear a maximum of only once (1 time) every 2 days across all pages/posts for each visitor to your site. Or, disable the popup from appearing more than once across a single user\\\'s session (i.e. until the user closes the browser).',
    'Trigger Pages' => 'Popups are, by default, not triggered on any pages or posts unless the popup\\\'s shortcode is specified in the page/post content. Change this setting to have the popup appear on some or all pages and posts even when no shortcode is specified.',
    'Trigger Events' => 'You can select the trigger events which will cause the popup to appear.',
    'Trigger Event Timing' => 'This field sets the amount of time in milliseconds to wait after a webpage load, before the popup is shown on that webpage. So, if you want a popup to only show up if the user has been on the webpage for 5 seconds, put in 5000. If browser scroll is selected as well, the popup will appear only when the user has scrolled past the start trigger target, AND the specified amount of timing has passed after the initial webpage load.',
    'Trigger Event Leave Viewport' => 'If you check this box, the popup will appear when the user moves their mouse off the top of their browser viewport; for example, to go for the back button or address bar! This works in addition to your browser scroll trigger targets, so if you want to, you can have the same popup appear both at your normal trigger targets and if the user tries to leave the webpage.',
    'Trigger Event Browser Scroll' => 'This option will cause the popup to be triggered whenever the user scrolls within the specified Start and End Trigger Targets.',
    'Start Trigger Target' => 'This option specifies which part of the webpage, when the user scrolls to it, will trigger the popup. The simplest trigger target is y-offset from the top or bottom of the webpage. This is an exact pixel number away from the top or bottom of the webpage that, when the user scrolls to it, will cause your popup to appear. Most WP Popup Magic users can craft perfect popups using just these two options, but advanced users can check the other options! By choosing "wherever shortcode appears", you can make the popup appear exactly where you want it to by putting the shortcode at that exact spot on your page/post (if you pick another trigger target, the location of the shortcode in your page/post doesn\\\'t matter at all). You can also trigger the popup to appear whenever the user scrolls to a certain HTML element or an element with a certain HTML class, like a comments box!',
    'End Trigger Target' => 'If you want the popup to disappear once the user has scrolled past a certain point, you can use this setting. It works exactly like Start Trigger Target, except when the user reaches this spot, the popup will close itself!',
    'Trigger Mobile' => 'Select whether this popup should be displayed or hidden on mobile devices, or if it should be displayed only on mobile devices and nowhere else.',
    'Overlay' => 'Enable this setting to add a lightbox overlay effect under this popup. Opacity should be a percentage number between 0 and 100 inclusive, indicating how transparent the overlay effect is.',
    'Scroll With Page' => 'By default, if this setting is disabled, the displayed popup will remain at its fixed position on screen even when the user scrolls through the page. With this setting enabled, the popup will instead scroll with the page. Enable this setting for popups with long content that take up more than the available screen height when viewed on smaller displays, so that the user can scroll the page to view the rest of the popup\\\'s content.',
    'Title Bar' => 'You can specify a title bar to be displayed at the top of your popup content. By default, the title bar will contain white text against a black background. Advanced users can change this with the inline CSS in the HTML for the title bar.',
    'Trigger On Link Click' => 'With this enabled, the popup will appear whenever a visitor clicks on a link leading to an external domain. The generated popup can be a plain Javascript alert or confirm box, or the normal HTML popup with editable title, content and OK/Cancel buttons. You can also specify a whitelist of domains that will be excluded from this trigger event.',
    'Popup Type' => 'If you select "plain Javascript alert" or "confirm", the popup triggered when a visitor clicks a link on the site will be a typical Javascript popup. The OK/Cancel buttons will be set by the browser, and you can only change the content of the popup. Note that the content for plain Javascript popups cannot contain any HTML. In contrast, if you select "normal HTML" popup type, the current popup settings will be used, and you will be able to change the OK/Cancel buttons as well.',
    'OK Button' => 'When a visitor clicks on the OK button, the link they were originally clicking on will be opened in a new tab. By default, the OK button will appear to the left of the Cancel button at the bottom of the popup content. You can change the text or width of the button here. You can also disable this default button and/or use your own HTML link element in your popup\\\'s content by specifying class "wppum-ok-button" for the link element.',
    'Cancel Button' => 'When a visitor clicks on the Cancel button, the popup is simply closed (i.e. it works the same way as the Close button). By default, the Cancel button will appear to the right of the OK button at the bottom of the popup content. You can change the text or width of the button here. You can also disable this default button and/or use your own HTML link element in your popup\\\'s content by specifying class "wppum-cancel-button" for the link element.',
    'Whitelisted Domains' => 'When a visitor clicks on an external link leading to a whitelisted domain, they will not be presented with the popup. Whitelisted domains should exclude the http:// prefix and do not require a trailing slash, and should be listed one per line. To facilitate exporting of popups to other sites, you should not include the local internal domain here as it will automatically be whitelisted.',
    'Link Shortcode' => 'Copy/paste this shortcode into the URL field when creating links in the \n page & post editor. The resulting link will then trigger the respective popup. \n You can also paste this shortcode directly into the href attribute of HTML link tags. \n Note: This will not work within the WordPress Menu or within other shortcodes at this time.',
);

// Specify default values for a new popup.
global $wppum_default_popup;
$wppum_default_popup = array(
    'classes' => '',
    'size_type' => 'contents',
    'width' => '680px',
    'height' => '460px',
    'vertical_offset_type' => 'center',
    'horizontal_offset_type' => 'center',
    'horizontal_offset' => '10px',
    'vertical_offset' => '10px',
    'background_color' => 'FFFFFF',
    'content_color' => 'FFFFFF',
    'background_img' => '',
    'border_style' => 'solid',
    'border_width' => '0',
    'border_radius' => '0',
    'border_color' => '333333',
    'padding_left' => '5',
    'padding_top' => '5',
    'padding_right' => '5',
    'padding_bottom' => '5',
    'close_button_type' => 'close',
    'toggle_state' => 'open',
    'close_button_html' => '<span class="wppum-close snpanel-close" style="cursor:pointer;z-index:99999999;position:absolute;right:5px;top:5px;"><img src="[CLOSE_BUTTON]" title="Close" /></span>',
    'close_button_img' => WPPUM_PLUGIN_URL . WPPUM_CLOSE_BUTTONS_REL_PATH . 'black-circle.png',
    'open_button_img' => WPPUM_PLUGIN_URL . WPPUM_OPEN_BUTTONS_REL_PATH . 'black-plus.png',
    'contents' => "",
    'styles' => "",
    'trigger_browser_scroll' => '0',
    'target_type' => 'bottom',
    'target_element' => '',
    'target_offset' => '600',
    'end_target_type' => 'none',
    'end_target_element' => '',
    'end_target_offset' => '',
    'animation_effect' => 'slide',
    'slide_direction' => 'up',
    'clip_direction' => 'vertical',
    'slide_speed' => '1000',
    'self_close_type' => '0',
    'all_close_type' => '0',
    'trigger_on_timing' => '1',
    'trigger_delay' => '0',
    'trigger_on_leaving_viewport' => '0',
    'trigger_pages' => 'hide_all',
    'trigger_pages_ids' => '',
    'frequency_type' => 'none',
    'frequency_limit_times' => '0',
    'frequency_limit_days' => '0',
    'show_mobile' => 'show_all',
    'overlay' => '1',
    'overlay_color' => '000000',
    'overlay_opacity' => '70',
    'scroll_with_page' => '0',
    'title' => '0',
    'title_text' => '',
    'title_html' => '<div class="wppum-title-bar" style="margin-bottom: 5px; background-color: black; color: white; width: 100%; text-align: left; font-size: 1.1em; font-weight: bold;"><div style="padding: 10px 10px;">[TITLE]</div></div>',
    'trigger_on_link_click' => '0',
    'link_click_popup_type' => 'html',
    'ok_button' => '1',
    'ok_button_text' => 'OK',
    'ok_button_width' => '200px',
    'ok_button_html' => '<a href="#" class="wppum-ok"><button style="width: [OK_WIDTH]; max-width: 100%; margin: 5px 5px;">[OK]</button></a>',
    'cancel_button' => '1',
    'cancel_button_text' => 'Cancel',
    'cancel_button_width' => '200px',
    'cancel_button_html' => '<a href="#" class="wppum-cancel"><button class="wppum-cancel" style="width: [CANCEL_WIDTH]; max-width: 100%; margin 5px 5px;">[CANCEL]</button></a>',
    'whitelisted_domains' => '',
    'show_all_include_homepage_options' => 'show_all_include_homepage',
    'show_all_exclude_homepage_options' => '',
    'show_homepage_and_shortcode_options' => '',
    'show_pages_options' => '',
    'hide_pages_options' => '',
    'hide_all_options' => '',
    'exclude_posts_options' => '',
    'exclude_pages_options' => '',
    'specific_cat_options' => '',
    'url_pattern_options' => '',
    'web_referring_url_options' => '',
    'show_pages_val' => '',
    'hide_pages_val' => '',
    'exclude_posts_val' => '',
    'exclude_pages_val' => '',
    'specific_category_val' => '',
    'url_pattern_val' => '',
    'web_referring_url_val' => '',
    'trigger_on_newsletter_email' => '',
    'newsletter_email' => '',
    'require_name_newsletter_email' => '1',
    'newsletter_email_placeholder' => 'Enter your email...',
    'newsletter_name_placeholder' => 'Your name...',
    'newsletter_submit_btn' => 'Subscribe Now',
    'newsletter_submit_btn_loading' => 'Please wait...',
    'newsletter_submit_btn_success' => 'Subscribed Successfully.',
    'newsletter_submit_btn_color' => '',
    'newsletter_submit_btn_hover' => '',
    'newsletter_submit_btn_text_color' => '',
    'popup_theme' => '1',
    'popup_type' => '',
    'newsletter_template' => '1',
    'newsletter_heading' => '',
    'newsletter_sub_heading' => '',
    'newsletter_logo' => '',
);
global $wppum_default_popup_instructions;
$wppum_default_popup_instructions = [
    'shortcode' => [
        "1" => "Enter popup title",
        "2" => "Insert WordPress shortcode in Shortcode field",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'toggle' => [
           "1" => "Enter popup title",
        "2" => "Insert WordPress shortcode in Shortcode field",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'mexit' => [
         "1" => "Enter popup title",
        "2" => "Enter popup content and format as desired",
        "3" => "Select Popup theme",
        "4" => "Select <strong>On Page Exit</strong> options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'elink' => [
        "1" => "Enter popup title",
        "2" => "Enter popup content and format as desired",
        "3" => "Select Popup theme",
        "4" => "Select <strong>Click of an external link</strong> options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'fscreen' => [
        "1" => "Enter popup title",
        "2" => "Enter popup content and format as desired",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "Under Popup Size selection Custom size and set height and width 100%",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'linkp' => [
       "1" => "Enter popup title",
        "2" => "Enter popup content and format as desired",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'video' => [
       "1" => "Enter popup title",
        "2" => "Insert youtube video link",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'slider' => [
        "1" => "Enter popup title",
        "2" => "Enter popup content and format as desired",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "Select Effect, Direction and Speed under Popup Animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'newsletter' => [
        "1" => "Enter popup title",
        "2" => "Configure newsletter options, update texts and headings",
        "3" => "Choose newsletter template",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'mfborder' => [
           "1" => "Enter popup title",
        "2" => "Enter popup content and format as desired",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
    'iframe' => [
        "1" => "Enter popup title",
        "2" => "Insert iframe content in iframe field",
        "3" => "Select Popup theme",
        "4" => "Select options for when to display the popup",
        "5" => "Select Pages/posts/categories To Show Popup",
        "6" => "You can set the popup animations",
        "7" => "You can set the popup position",
        "8" => "Choose the close button to close popup",
        "9" => "Click publish button to save popup",
        "10" => "Visit the selected page to see the popup",
    ],
];

// Ad code to be inserted next to the logo in admin backend pages.
global $wppum_ad;
ob_start();
$wppum_ad = ob_get_clean();
