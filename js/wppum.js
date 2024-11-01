(function () {
    "use strict";

    var originalCreateWrapper = jQuery.effects.createWrapper;

    var originalRemoveWrapper = jQuery.effects.removeWrapper;

    jQuery.extend(jQuery.effects, {
        // Don't create wrapper for .wppum elements with toggle open button, to prevent reloading of iframes
        createWrapper: function (element) {

            // if element isn't a .wppum element with a toggle open button, use original createWrapper function
            if (!jQuery(element).hasClass('wppum') || jQuery(element).data('toggle_open_button').length === 0) {
                return originalCreateWrapper(element);

            }

            // if the element is already wrapped, return it
            if (element.parent().is(".ui-effects-wrapper")) {
                return element.parent();
            }

            // wrap the element
            var props = {
                width: element.outerWidth(true),
                height: element.outerHeight(true),
                "float": element.css("float")
            },
            wrapper = jQuery(element).parent()
                    .addClass("ui-effects-wrapper")
                    .css({
                        fontSize: "100%",
                        background: "transparent",
                        border: "none",
                        margin: 0,
                        padding: 0
                    }),
                    // Store the size in case width/height are defined in % - Fixes #5245
                    size = {
                        width: element.width(),
                        height: element.height()
                    },
            active = document.activeElement;

            // support: Firefox
            // Firefox incorrectly exposes anonymous content
            // https://bugzilla.mozilla.org/show_bug.cgi?id=561664
            try {
                active.id;
            } catch (e) {
                active = document.body;
            }

            // Fixes #7595 - Elements lose focus when wrapped.
            if (element[ 0 ] === active || jQuery.contains(element[ 0 ], active)) {
                jQuery(active).focus();
            }

            wrapper = element.parent(); //Hotfix for jQuery 1.4 since some change in wrap() seems to actually lose the reference to the wrapped element

            // transfer positioning properties to the wrapper
            if (element.css("position") === "static") {
                wrapper.css({position: "relative"});
                element.css({position: "relative"});
            } else {
                jQuery.extend(props, {
                    position: element.css("position"),
                    zIndex: element.css("z-index")
                });
                jQuery.each(["top", "left", "bottom", "right"], function (i, pos) {
                    props[ pos ] = element.css(pos);
                    if (isNaN(parseInt(props[ pos ], 10))) {
                        props[ pos ] = "auto";
                    }
                });
                element.css({
                    position: "relative",
                    top: 0,
                    left: 0,
                    right: "auto",
                    bottom: "auto"
                });
            }
            element.css(size);

            return wrapper.css(props).show();
        },
        removeWrapper: function (element) {
            // if element isn't a .wppum element with a toggle open button, use original removeWrapper function
            if (!jQuery(element).hasClass('wppum') || jQuery(element).data('toggle_open_button').length === 0) {
                return originalRemoveWrapper(element);
            }

            var active = document.activeElement;

            if (element.parent().is(".ui-effects-wrapper")) {
                element.parent().removeClass("ui-effects-wrapper")
                        .css('position', 'static')
                        .css('top', 'auto')
                        .css('left', 'auto')
                        .css('bottom', 'auto')
                        .css('right', 'auto');

                // Fixes #7595 - Elements lose focus when wrapped.
                if (element[ 0 ] === active || jQuery.contains(element[ 0 ], active)) {
                    jQuery(active).focus();
                }
            }

            return element;
        }
    });

    jQuery.fn.wppumCenterVertical = function () {
        this.css("top", Math.max(0, parseInt((jQuery(window).height() - jQuery(this).outerHeight()) / 2, 10)) + "px");
        return this;
    };
    jQuery.fn.wppumCenterHorizontal = function () {
        this.css("left", Math.max(0, parseInt((jQuery(window).width() - jQuery(this).outerWidth()) / 2, 10)) + "px");
        return this;
    };

    var i, wppumPopup, $wppumPopup, $wppumPopupOverlay, opacity, lastDocumentSize;

    // set cookie for specified popup name (for frequency limit)
    function setCookie(c_name, value, exdate) {
        var c_value = escape(value) + "; path=/;" + ((exdate === -1) ? '' : (" expires=" + exdate.toUTCString()));
        document.cookie = c_name + "=" + c_value;
    }

    // get cookie for specified popup name (for frequency limit)
    function getCookie(c_name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x === c_name) {
                return unescape(y);
            }
        }
    }

    // reset src of specified iframe to blank, while storing original src attribute, if containing popup is not visible
    function resetIframe($iframe) {
        var $wppum = $iframe.closest('.wppum');
        if ($wppum.length > 0) {
            var iframeSrc = $iframe.attr('src');
            if (iframeSrc !== '') {
                if ($wppum.data('is_hidden')) {
                    $iframe.attr('src', '').data('src', iframeSrc);
                }
            }
        }
    }

    // parse each iframe of specified popup and set src to blank, while storing original src attribute
    function resetIframes($wppumPopup) {
        $wppumPopup.find('iframe').each(function () {
            resetIframe(jQuery(this));
        });
    }

    for (i = 0; i < wppum.popups.length; i++) {
        // inject CSS into HTML head
        wppumPopup = wppum.popups[i];
        if (wppumPopup.styles.length > 0) {
            try {
                jQuery(wppumPopup.styles).appendTo('head');
            } catch (e) {
                jQuery('head').append('<style>' + wppumPopup.styles + '</style>');
            }
        }

        jQuery(wppumPopup.fonts).appendTo('head');

        // init vertical position offset values
        wppumPopup.position = '';
        if (wppumPopup.vertical_offset_type === 'top' ||
                wppumPopup.vertical_offset_type === 'bottom')
        {
            wppumPopup.position += wppumPopup.vertical_offset_type + ':' + wppumPopup.vertical_offset + ';';
        }

        // init horizontal position offset values
        if (wppumPopup.horizontal_offset_type === 'left' ||
                wppumPopup.horizontal_offset_type === 'right')
        {
            wppumPopup.position += wppumPopup.horizontal_offset_type + ':' + wppumPopup.horizontal_offset + ';';
        }


        if (wppumPopup.border_radius !== '') {
            wppumPopup.border_radius += 'px;';
        }
        // init padding values
        wppumPopup.padding = '';
        if (wppumPopup.padding_top !== '') {
            wppumPopup.padding += 'padding-top:' + wppumPopup.padding_top + 'px;';
        }
        if (wppumPopup.padding_bottom !== '') {
            wppumPopup.padding += 'padding-bottom:' + wppumPopup.padding_bottom + 'px;';
        }
        if (wppumPopup.padding_left !== '') {
            wppumPopup.padding += 'padding-left:' + wppumPopup.padding_left + 'px;';
        }
        if (wppumPopup.padding_right !== '') {
            wppumPopup.padding += 'padding-right:' + wppumPopup.padding_right + 'px;';
        }


        // add event classes
        if (wppumPopup.trigger_browser_scroll === '1') {
            wppumPopup.classes += ' wppum-trigger-browser-scroll';
        }
        if (wppumPopup.trigger_on_leaving_viewport === '1') {
            wppumPopup.classes += ' wppum-trigger-leaving-viewport';
        }
        if (wppumPopup.trigger_on_timing === '1') {
            wppumPopup.classes += ' wppum-trigger-timing';
        }
        if (wppumPopup.trigger_on_link_click === '1') {
            wppumPopup.classes += ' wppum-trigger-on-link-click wppum-link-click-popup-' + wppumPopup.link_click_popup_type;
        }

        // prepare the embedded CSS for the popup
        wppumPopup.embeddedStyle = 'display:inline-block; visibility:hidden; ' +
                'z-index:' + (99999 + parseInt(wppumPopup.order, 10)) + '; ' +
                'height: ' + wppumPopup.height + '; width: ' + wppumPopup.width + '; ' +
                (
                        (wppumPopup.background_img === '') ?
                        'background-color:' + wppumPopup.background_color + '; '
                        :
                        'background: url(\'' + wppumPopup.background_img + '\') repeat left top; '
                        ) +
                'color:' + wppumPopup.content_color + '; '+
                'outline:' + wppumPopup.border_width + 'px ' + wppumPopup.border_style + ' ' + wppumPopup.border_color + '; ' +
                'border-radius:' + wppumPopup.border_radius + '; ' +
                'position: fixed; ' + wppumPopup.position + wppumPopup.padding + "outline-offset: "+wppumPopup.padding_top+"px;";

        // modify the popup in HTML body
        $wppumPopup = jQuery('#' + wppumPopup.popup_id)
                .attr('class', 'wppum snpanel ' + wppumPopup.classes)
                .attr('style', wppumPopup.embeddedStyle);

        // create and inject overlay (if any) into HTML body
        $wppumPopupOverlay = null;
        if (wppumPopup.overlay === '1') {
            opacity = wppumPopup.overlay_opacity / 100.0;
            $wppumPopupOverlay =
                    jQuery('<div class="wppum-overlay" style="display: none; position: absolute; ' +
                            'margin: 0; padding: 0; top: 0; left 0; right: 0; bottom: 0; width: 100%; ' +
                            'background-color: ' + wppumPopup.overlay_color + '; ' +
                            'z-index: ' + (90000 + parseInt(wppumPopup.order, 10)) + '; ' +
                            '-moz-opacity: ' + opacity + '; opacity: ' + opacity + '; ' +
                            'filter: alpha(opacity=' + wppumPopup.overlay_opacity + ');' +
                            '"></div>'
                            )
                    .appendTo('body');
        }

        // ensure popup is hidden
        $wppumPopup
                .hide()
                .css('visibility', 'visible');  // IE7 requires display:inline-block to be set initially for offsetHeight to work

        // copy relevant parameters to HTML element
        $wppumPopup
                .data('allow_show', true)
                .data('is_hidden', true)
                .data('width', wppumPopup.width)
                .data('height', wppumPopup.height)
                .data('animation_effect', wppumPopup.animation_effect)
                .data('border_radius', isNaN(parseInt(wppumPopup.border_radius, 10)) ? 0 : parseInt(wppumPopup.border_radius, 10))
                .data('border_width', isNaN(parseInt(wppumPopup.border_width, 10)) ? 0 : parseInt(wppumPopup.border_width, 10))
                .data('padding_top', isNaN(parseInt(wppumPopup.padding_top, 10)) ? 0 : parseInt(wppumPopup.padding_top, 10))
                .data('padding_bottom', isNaN(parseInt(wppumPopup.padding_bottom, 10)) ? 0 : parseInt(wppumPopup.padding_bottom, 10))
                .data('padding_left', isNaN(parseInt(wppumPopup.padding_left, 10)) ? 0 : parseInt(wppumPopup.padding_left, 10))
                .data('padding_right', isNaN(parseInt(wppumPopup.padding_right, 10)) ? 0 : parseInt(wppumPopup.padding_right, 10))
                .data('popup_id', wppumPopup.popup_id)
                .data('name', wppumPopup.name)
                .data('trigger_pages', wppumPopup.trigger_pages)
                .data('trigger_pages_ids', wppumPopup.trigger_pages_ids)
                .data('current_page', wppumPopup.current_page)
                .data('post_type', wppumPopup.post_type)
                .data('show_all_include_homepage_options', wppumPopup.show_all_include_homepage_options)
                .data('show_all_exclude_homepage_options', wppumPopup.show_all_exclude_homepage_options)
                .data('show_homepage_and_shortcode_options', wppumPopup.show_homepage_and_shortcode_options)
                .data('show_pages_options', wppumPopup.show_pages_options)
                .data('hide_pages_options', wppumPopup.hide_pages_options)
                .data('hide_all_options', wppumPopup.hide_all_options)
                .data('exclude_posts_options', wppumPopup.exclude_posts_options)
                .data('exclude_pages_options', wppumPopup.exclude_pages_options)
                .data('specific_cat_options', wppumPopup.specific_cat_options)
                .data('url_pattern_options', wppumPopup.url_pattern_options)
                .data('web_referring_url_options', wppumPopup.web_referring_url_options)
                .data('show_pages_val', wppumPopup.show_pages_val)
                .data('hide_pages_val', wppumPopup.hide_pages_val)
                .data('exclude_posts_val', wppumPopup.exclude_posts_val)
                .data('exclude_pages_val', wppumPopup.exclude_pages_val)
                .data('specific_category_val', wppumPopup.specific_category_val)
                .data('term_id', wppumPopup.term_id)
                .data('post_category', wppumPopup.post_category)
                .data('url_pattern_val', wppumPopup.url_pattern_val)
                .data('web_referring_url_val', wppumPopup.web_referring_url_val)
                .data('frequency_type', wppumPopup.frequency_type)
                .data('frequency_limit_checked', false)
                .data('trigger_browser_scroll', (wppumPopup.trigger_browser_scroll === '1'))
                .data('vertical_offset_type', wppumPopup.vertical_offset_type)
                .data('horizontal_offset_type', wppumPopup.horizontal_offset_type)
                .data('vertical_offset', wppumPopup.vertical_offset)
                .data('horizontal_offset', wppumPopup.horizontal_offset)
                .data('slide_direction', wppumPopup.slide_direction)
                .data('slide_speed', parseInt(wppumPopup.slide_speed, 10))
                .data('trigger_delay', parseInt(wppumPopup.trigger_delay, 10))
                .data('target_type', wppumPopup.target_type)
                .data('target_element', wppumPopup.target_element)
                .data('target_offset', parseInt(wppumPopup.target_offset, 10))
                .data('end_target_type', wppumPopup.end_target_type)
                .data('end_target_element', wppumPopup.end_target_element)
                .data('end_target_offset', parseInt(wppumPopup.end_target_offset, 10))
                .data('frequency_limit_times', parseInt(wppumPopup.frequency_limit_times, 10))
                .data('frequency_limit_days', parseInt(wppumPopup.frequency_limit_days, 10))
                .data('overlay_element', $wppumPopupOverlay)
                .data('scroll_with_page', (wppumPopup.scroll_with_page === '1'))
                .data('close_button_type', wppumPopup.close_button_type)
                .data('toggle_state', wppumPopup.toggle_state)
                .data('toggle_open_button', [])
                .data('popup_contents', typeof wppumPopup.sanitized_contents !== 'undefined' ? wppumPopup.sanitized_contents : '')
                .data('whitelisted_domains', wppumPopup.whitelisted_domains);
    }

    // returns true if specifed href is whitelisted for the specified popup
    function isHrefWhitelisted($wppumPopup, href) {
        var whitelist = $wppumPopup.data('whitelisted_domains');
        for (var i = 0; i < whitelist.length; i++) {
            var domain = whitelist[ i ];
            if (href.substr(0, domain.length) === domain) {
                return true;
            }
        }
        return false;
    }

    // Resize specified popup if it has percentage width/height, and also reposition any toggle open buttons.
    function resizePopup($wppumPopup) {

        var width, height, widthInPixels, heightInPixels, $toggleOpenButton;

        width = $wppumPopup.data('width');
        if (width.length > 0 && width.substr(width.length - 1, 1) === '%') {
            // calculate actual width in pixels, and deduct border/padding widths
            widthInPixels = parseInt(width, 10) / 100 * jQuery(window).width();
            widthInPixels -= $wppumPopup.data('padding_left') + $wppumPopup.data('padding_right') + $wppumPopup.data('border_width') * 2;
            $wppumPopup.css('width', widthInPixels + 'px');
        } else {
            $wppumPopup.css('width', width);
        }
        height = $wppumPopup.data('height');
        if (height.length > 0 && height.substr(height.length - 1, 1) === '%') {
            // calculate actual height in pixels, and deduct border/padding widths
            heightInPixels = parseInt(height, 10) / 100 * jQuery(window).height();
            heightInPixels -= $wppumPopup.data('padding_top') + $wppumPopup.data('padding_bottom') + $wppumPopup.data('border_width') * 2;
            $wppumPopup.height(heightInPixels);
        } else {
            $wppumPopup.css('height', height);
        }

        // reposition popup vertically and horizontally if necessary
        if ($wppumPopup.data('is_hidden')) {
            $wppumPopup.css('position', 'fixed').css('top', '').css('left', '').css('right', '').css('bottom', '');
            if ($wppumPopup.data('vertical_offset_type') === 'center') {
                $wppumPopup.wppumCenterVertical();
            } else {
                $wppumPopup.css($wppumPopup.data('vertical_offset_type'), $wppumPopup.data('vertical_offset'));
            }
            if ($wppumPopup.data('horizontal_offset_type') === 'center') {
                $wppumPopup.wppumCenterHorizontal();
            } else {
                $wppumPopup.css($wppumPopup.data('horizontal_offset_type'), $wppumPopup.data('horizontal_offset'));
            }

            // change fixed position to absolute and recalculate position if scroll_with_page is enabled
            if ($wppumPopup.data('scroll_with_page')) {
                var offset = $wppumPopup.show().offset();
                $wppumPopup
                        .hide()
                        .css('right', '').css('bottom', '')
                        .css('position', 'absolute')
                        .css('top', offset.top)
                        .css('left', offset.left);
            }

            // reposition any toggle open buttons
            $toggleOpenButton = $wppumPopup.data('toggle_open_button');
            if ($toggleOpenButton.length > 0) {
                $wppumPopup.show();
                repositionToggleOpenButton($wppumPopup, $toggleOpenButton);
                $wppumPopup.hide();
                $toggleOpenButton.show();
            }
        }
    }

    // Reposition the specified toggle open button (upon window resize or upon close of popup).
    function repositionToggleOpenButton($wppumPopup, $toggleOpenButton) {
        if ($toggleOpenButton.length > 0) {
            // reattach toggle open button to be child of wppum div
            $toggleOpenButton.css('position', 'absolute').remove().appendTo($wppumPopup);

            // update position of toggle open button
            var animationEffect = $wppumPopup.data('animation_effect');
            if (animationEffect === 'slide' || animationEffect === 'drop') {
                // if animation effect is "slide" or "drop", position is based on the animation direction
                var direction = $wppumPopup.data('slide_direction');
                var topOffset = '0px', rightOffset = '0px', leftOffset = '', bottomOffset = '';
                if (direction === 'left') {
                    rightOffset = '';
                    leftOffset = '0px';
                } else if (direction === 'down') {
                    topOffset = '';
                    bottomOffset = '0px';
                }
                $toggleOpenButton
                        .css('top', topOffset)
                        .css('right', rightOffset)
                        .css('bottom', bottomOffset)
                        .css('left', leftOffset);
            } else {

                // otherwise, position of toggle open button is in middle of popup
                $toggleOpenButton
                        .css('top', (($wppumPopup.outerHeight() - $toggleOpenButton.find('img').height()) / 2) + 'px')
                        .css('left', (($wppumPopup.outerWidth() - $toggleOpenButton.find('img').width()) / 2) + 'px');
            }

            // recalculate position of toggle open button (change from absolute to fixed position)
            var position = $toggleOpenButton.show().offset();
            var $thatPopup = $wppumPopup;
            position.top -= jQuery(document).scrollTop();
            position.left -= jQuery(document).scrollLeft();

            $wppumPopup.data('toggle_open_button', $toggleOpenButton
                    .hide()
                    .css('position', 'fixed')
                    .css('top', position.top + 'px')
                    .css('left', position.left + 'px')
                    .remove()
                    .appendTo('body')
                    .click(function () {
                        // handle toggle open button click
                        showPopup($thatPopup, true, true, false, false);
                    })
                    );
        }
    }

    // Shows the popup on screen.
    function showPopup($wppumPopup, isNotBrowserScroll, isManualOpen, isExternalLinkTriggered, isInternalLinkTriggered) {

        var $wppumPopupOverlay, exdate, cookie, numberOfTimes, $toggleOpenButton;
        var cookie_name = getCookie2("wppm_cook_status");

        if (false === isInternalLinkTriggered) {
            var showpost = 0;
            var notshowpost = 0;
            var showrefURL = 1;
            var showpostcategory = 1;
            if ($wppumPopup.data('url_pattern_options') === 'url_pattern') {
                var url_val = location.href;
                var url_val_array = url_val.split('/');
                var arrayLength = parseInt(url_val_array.length) - 1;
                var checkString = '/' + url_val_array[arrayLength];
                if ($wppumPopup.data('url_pattern_val') === checkString) {
                    showpostcategory = 0;
                }
            }

            //alert($wppumPopup.data( 'show_all_include_homepage_options'));
            var indexOfStar = 0;

            if ($wppumPopup.data('web_referring_url_options') === 'web_referring_url')
            {
                indexOfStar = $wppumPopup.data('web_referring_url_val').indexOf("*");
                if (indexOfStar >= 0) {
                    //URL have *
                    var refURL = document.referrer;
                    var web_referring_url_val = $wppumPopup.data('web_referring_url_val').substring(0, $wppumPopup.data('web_referring_url_val').length - 1);
                    var refVal = refURL.search(web_referring_url_val);
                    if (refVal >= 0) {
                        showrefURL = 0;
                    }
                } else { //URL have no *
                    if ($wppumPopup.data('web_referring_url_val') === document.referrer) {
                        showrefURL = 0;
                    }
                }
            }

            if ($wppumPopup.data('show_pages_options') === 'show_pages') {
                var show_pages_val_array = $wppumPopup.data('show_pages_val');
                var aFirst = show_pages_val_array.toString().split(',');
                for (var i = 0; i < aFirst.length; i++) {
                    if (parseInt(aFirst[i]) === parseInt($wppumPopup.data('current_page'))) {
                        showpost = 1;
                    }
                }
            }

            if ($wppumPopup.data('hide_pages_options') === 'hide_pages') {
                var trigger_pages2 = $wppumPopup.data('hide_pages_val');
                var aFirst2 = trigger_pages2.toString().split(',');
                for (var i = 0; i < aFirst2.length; i++) {
                    var arrayFirstVal = parseInt(aFirst2[i]);
                    var current_pageVal = parseInt($wppumPopup.data('current_page'));

                    if (parseInt(aFirst2[i]) == parseInt($wppumPopup.data('current_page'))) {
                        notshowpost = 1;
                    }

                }
            }

            //Check for excluded posts
            if ($wppumPopup.data('exclude_posts_options') === 'exclude_posts' && $wppumPopup.data('post_type') === 'post') {
                var trigger_pages4 = $wppumPopup.data('exclude_posts_val');
                var aFirst4 = trigger_pages4.toString().split(',');
                for (var i = 0; i < aFirst4.length; i++) {
                    if (parseInt(aFirst4[i]) === parseInt($wppumPopup.data('current_page'))) {
                        notshowpost = 1;
                    }
                }
            }

            //Check for excluded pages
            if ($wppumPopup.data('exclude_pages_options') === 'exclude_pages' && $wppumPopup.data('post_type') === 'page') {
                var trigger_pages3 = $wppumPopup.data('exclude_pages_val');
                var aFirst3 = trigger_pages3.toString().split(',');
                for (var i = 0; i < aFirst3.length; i++) {
                    if (parseInt(aFirst3[i]) === parseInt($wppumPopup.data('current_page'))) {
                        notshowpost = 1;
                    }
                }
            }

            if ($wppumPopup.data('specific_cat_options') === 'specific_cat' && $wppumPopup.data('term_id') != "") {
                var trigger_pages5 = $wppumPopup.data('specific_category_val');
                var aFirst5 = trigger_pages5.toString().split(',');
                for (var i = 0; i < aFirst5.length; i++) {
                    if (parseInt(aFirst5[i]) === parseInt($wppumPopup.data('term_id'))) {
                        showpostcategory = 0;
                    }
                }
            } else {
                showpostcategory = 0;
            }
            if (notshowpost === 1) {
                return null;
            }
            else if (showpost === 1 && notshowpost === 1) {
                return null;
            }
            else if (showpostcategory === 1 && notshowpost === 1) {
                return null;
            }

            if (showrefURL === 1 && $wppumPopup.data('show_all_include_homepage_options') === 'show_all_include_homepage' && $wppumPopup.data('web_referring_url_options') === 'web_referring_url') {
                return null;
            }
            /*if(notshowpost===1 || showpost===1 || showpostcategory===1 || showrefURL===1){
             return null;
             }*/
        } // if (isInternalLinkTriggered===false)

        if ("1" != cookie_name) {

            if ((!$wppumPopup.data('is_hidden') || $wppumPopup.data('manual_closed')) && !isExternalLinkTriggered && !isInternalLinkTriggered) {
                return null;   // popup's already shown, or was already manually closed!
            }

            // if toggle open button exists, then ignore all show events besides manual open/external link trigger
            $toggleOpenButton = $wppumPopup.data('toggle_open_button');
            if ($toggleOpenButton.length > 0 && !isManualOpen && !isExternalLinkTriggered && !isInternalLinkTriggered) {
                return null;
            }

            // do we need to bother about frequency limit?
            // if ( ! $wppumPopup.data( 'frequency_limit_checked' ) ) {   // not yet checked for this page
            $wppumPopup.data('frequency_limit_checked', true);

            if ($wppumPopup.data('frequency_type') !== 'none') {
                // check whether cookie has been set
                cookie = getCookie($wppumPopup.data('popup_id'));
                if (cookie !== undefined) {
                    cookie = cookie.split(',');
                }

                // If this popup has no cookie it must be the first time it was shown, so setup state
                if (cookie === undefined || cookie[0] === undefined || cookie[1] === undefined) {
                    // cookie has not been set, or is invalid; (re)set cookie
                    // based on frequency type.  There are four possible types:
                    // (1) none - not handled here because of the IF above
                    // (2) session - once per session
                    // (3) custom - custom, X times per Y days
                    // (4) userpersession -until closed in a session

                    // For session or userpersession, drop a cookie showing this popup has been shown once.
                    // No expiration date on the cookie so it's a session cookie
                    if ($wppumPopup.data('frequency_type') === 'session'
                            || $wppumPopup.data('frequency_type') === 'userpersession') {
                        // Set the cookie to have a count of once and an expiration of -1 (session cookie)
                        setCookie($wppumPopup.data('popup_id'), '1,-1', -1);
                    }
                    // For a custom setting, drop a cookie with an expiration date for the number of days out
                    // and a count of one (first time shown)
                    else if ($wppumPopup.data('frequency_type') === 'custom') {
                        exdate = new Date();
                        exdate.setDate(exdate.getDate() + $wppumPopup.data('frequency_limit_days'));
                        setCookie($wppumPopup.data('popup_id'), '1,' + exdate.getTime(), exdate);
                    }
                } else {   // valid cookie already exists

                    // cookie HAS been set. Handle this based on frequency type.  There are four possible types:
                    // (1) none - always show (no limit)
                    // (2) session - once per session
                    // (3) custom - custom, X times per Y days
                    // (4) userpersession - until closed in a session

                    // If we're showing once per session and we already have a cookie, then we've shown the max
                    if ('session' === $wppumPopup.data('frequency_type')) {
                        return null;
                    }
                    // We're set to custom (X times per Y) so check the situation
                    else if ('custom' === $wppumPopup.data('frequency_type')) {
                        // Already exceeded number of times to show popup?
                        if (cookie[0] >= $wppumPopup.data('frequency_limit_times')) {
                            // popup shown max times, don't show
                            return null;
                        } else {
                            // not yet exceeded number of times; increment cookie count value
                            numberOfTimes = (parseInt(cookie[0], 10)) + 1;
                            exdate = new Date(parseInt(cookie[1], 10));
                            setCookie($wppumPopup.data('popup_id'), numberOfTimes + ',' + exdate.getTime(), exdate);
                        }
                    }
                    // We're set to userpersession - until closed in a session
                    else if ('userpersession' === $wppumPopup.data('frequency_type')) {
                        // Has this popup ever been manually closed?

                        var manuallyClosedCookie = getCookie($wppumPopup.data('popup_id') + "_manually_closed");
                        if (undefined === manuallyClosedCookie) {
                            // This popup was never manually closed so do nothing
                        } else if (1 == manuallyClosedCookie) {
                            // This popup has been closed before, so don't let it open
                            return null;
                        }
                    }
                }
            }
            // } // if bother checking freq limit // RML @TODO

            if ($wppumPopup.data('toggle_state') !== 'close' || $toggleOpenButton.length > 0) {
                //fade in overlay (if any)
                $wppumPopupOverlay = $wppumPopup.data('overlay_element');
                if ($wppumPopupOverlay !== null) {
                    $wppumPopupOverlay
                            .height(jQuery(document).height())
                            .fadeIn($wppumPopup.data('slide_speed'));
                }
            }
            // reload popup contents and resize if necessary
            if ($toggleOpenButton.length === 0) {
                $wppumPopup.find('iframe').each(function () {
                    if (jQuery(this).data('src') !== undefined) {
                        jQuery(this).attr('src', jQuery(this).data('src'));
                    }
                });
            }

            if (isExternalLinkTriggered) {

                $wppumPopup.find('.wppum-buttons-wrapper, .wppum-cancel, .wppum-ok').show();

                if ($wppumPopup.hasClass('wppum-link-click-popup-alert')) {
                    // show alert blockers
                    alert($wppumPopup.data('popup_contents'));
                    return true;
                } else if ($wppumPopup.hasClass('wppum-link-click-popup-confirm')) {
                    return confirm($wppumPopup.data('popup_contents'));
                }
            } else {
                $wppumPopup.find('.wppum-buttons-wrapper, .wppum-cancel, .wppum-ok').hide();
            }

            resizePopup($wppumPopup);
            // hide the toggle open button if any
            if ($toggleOpenButton.length > 0) {
                $toggleOpenButton.hide();
            }

            // show the popup
            if ($wppumPopup.data('toggle_state') !== 'close' || $toggleOpenButton.length > 0) {
                $wppumPopup.data('is_hidden', false).show($wppumPopup.data('animation_effect'),
                        {direction: $wppumPopup.data('slide_direction')},
                $wppumPopup.data('slide_speed'),
                        function () {
                            $wppumPopup.parent().height(0);
                        }
                );
            } else {
                if ($toggleOpenButton.length === 0) {
                    $toggleOpenButton = $wppumPopup.find('.wppum-open');
                }
                repositionToggleOpenButton($wppumPopup, $toggleOpenButton);
                $toggleOpenButton = $wppumPopup.data('toggle_open_button');
                var top2 = parseInt(jQuery(window).height()) - 239;
                var left2 = parseInt(jQuery(window).width()) - 40;

                $toggleOpenButton.show().css('top', top2 + 'px').css('left', left2 + 'px');
            }

            // if triggered by non-browser scroll event, prevent future automatic hidePopup
            if (isNotBrowserScroll) {
                $wppumPopup.data('not_browser_scroll', true);
            }

            return true;
        }
    }

    // Hides the specified popup.
    function hidePopup($wppumPopup, isManualClose) {
        var $toggleOpenButton, $wppumPopupOverlay;
        $wppumPopup.find(".wppum_form_loader").hide();

        if ($wppumPopup.data('is_hidden')) {
            return;   // popup's already hidden
        }

        // if toggle open button exists, then ignore all hide events besides manual close
        $toggleOpenButton = $wppumPopup.data('toggle_open_button');
        if ($toggleOpenButton.length > 0 && !isManualClose) {
            return;
        }

        // fade out overlay (if any)
        $wppumPopupOverlay = $wppumPopup.data('overlay_element');
        if ($wppumPopupOverlay !== null) {
            $wppumPopupOverlay.fadeOut($wppumPopup.data('slide_speed'));
        }

        $wppumPopup
                .width($wppumPopup.width())
                .height($wppumPopup.height());

        // re-attach the toggle open button (if any) to fixed position in DOM
        if ($toggleOpenButton.length === 0) {
            $toggleOpenButton = $wppumPopup.find('.wppum-open');
        }
        repositionToggleOpenButton($wppumPopup, $toggleOpenButton);
        $toggleOpenButton = $wppumPopup.data('toggle_open_button');

        // hide the popup
        $wppumPopup
                .data('is_hidden', true)
                .hide(
                        $wppumPopup.data('animation_effect'),
                        {direction: $wppumPopup.data('slide_direction')},
                $wppumPopup.data('slide_speed'),
                        function () {
                            $wppumPopup.parent().height(0);
                            if (isManualClose && $wppumPopup.data('close_button_type') === 'close' && !$wppumPopup.hasClass('wppum-link-click-popup-html') && !$wppumPopup.hasClass('wppum-internal-link-click')) {
                                $wppumPopup.remove();
                            } else {
                                if ($toggleOpenButton.length > 0) {
                                    $toggleOpenButton.show();
                                } else {
                                    resetIframes($wppumPopup);
                                }
                            }
                        }
                );

        // if manually closed, store that fact in a cookie prevent all future show_popups (if pop-up has close button)
        if (isManualClose && $wppumPopup.data('close_button_type') === 'close') {
            // Store a session cookie to 1 letting everyone know this popup has been manually closed
            setCookie($wppumPopup.data('popup_id') + '_manually_closed', 1, -1 /* session cookie */);
            $wppumPopup.data('manual_closed', true);
        }
    }

    // track mouse movement and show popup as necessary ("leave viewport" event)
    wppum.triggerLeaveViewports = jQuery('.wppum-trigger-leaving-viewport');
    if (wppum.triggerLeaveViewports.length > 0) {
        wppum.enteredLowerViewport = false;
        jQuery('body').mousemove(function (event) {
            var pageY;
            pageY = event.pageY - jQuery(window).scrollTop();
            if (pageY < 50) {
                if (wppum.enteredLowerViewport) {

                    // trigger all popups with "leave viewport" event
                    wppum.triggerLeaveViewports.each(function () {
                        var $wppumPopup = jQuery(this);

                        // show the popup
                        showPopup($wppumPopup, true, false, false, false);
                    });
                    wppum.prevScroll = jQuery(window).scrollTop() + jQuery(window).height();
                }
            } else if (pageY < 100) {
                wppum.enteredLowerViewport = true;
            } else {
                wppum.enteredLowerViewport = true;
            }
        });
    }

    function addIntervalForTiming($wppumPopup) {
        return setInterval(
                function () {
                    $wppumPopup.data('allow_show', true);
                    if (!$wppumPopup.data('trigger_browser_scroll')) {
                        showPopup($wppumPopup, true, false, false, false);
                    }
                    clearInterval($wppumPopup.data('allow_show_interval_function'));
                },
                $wppumPopup.data('trigger_delay')
                );
    }

    // set delay before allowing popup to show up ("timing after page load" event)
    wppum.triggerTiming = jQuery('.wppum-trigger-timing');
    if (wppum.triggerTiming.length > 0) {
        // trigger all popups with "timing after page load" event
        wppum.triggerTiming.each(function () {
            var $wppumPopup = jQuery(this);

            $wppumPopup
                    .data('allow_show', false)
                    .data('allow_show_interval_function', addIntervalForTiming($wppumPopup));
        });
    }

    // periodically check current viewport and show/hide each popup if necessary
    wppum.prevScroll = null;
    wppum.intervalFunction = setInterval(
            function () {
                var targetTop, targetType, wppumPopupScroll, $targets, endTargetTop, endTargetType;

                // reset all iframes of all popups if they're not visible
                jQuery('.wppum').each(function () {
                    if (jQuery(this).data('toggle_open_button').length > 0) {
                        return;      // don't reset iframe of popups that can be toggled
                    }
                    resetIframes(jQuery(this));
                });

                wppumPopupScroll = jQuery(window).scrollTop() + jQuery(window).height();
                if (wppumPopupScroll === wppum.prevScroll) {
                    // no change in scroll value; no need to do anything
                    return;
                }

                // process each browser-scroll-triggered popup
                jQuery('.wppum-trigger-browser-scroll').each(function () {
                    var $wppumPopup = jQuery(this);

                    if (!$wppumPopup.data('allow_show')) {
                        // trigger timing value not yet past
                        return;
                    }

                    // (re)determine scroll target each time, in case page elements change
                    targetTop = 0;
                    targetType = $wppumPopup.data('target_type');
                    if (targetType === 'element') {
                        // html element
                        targetTop = jQuery($wppumPopup.data('target_element')).first().offset().top;
                    } else if (targetType === 'top') {
                        // absolute y-offset from page top
                        targetTop = $wppumPopup.data('target_offset');
                    } else if (targetType === 'bottom') {
                        // absolute y-offset from page bottom
                        targetTop = jQuery(document).height() - $wppumPopup.data('target_offset');
                    } else if (targetType === 'shortcode') {
                        // shortcode position
                        $targets = jQuery('.wppum_scroll_shortcode_target[data-popup-name="' + $wppumPopup.data('name') + '"]');
                        if ($targets.length === 0) {
                            return;
                        }
                        targetTop = $targets.first().offset().top;
                    } else {
                        // unknown target type!
                        return;
                    }

                    // (re)determine end scroll target, if any
                    endTargetTop = -1;
                    endTargetType = $wppumPopup.data('end_target_type');
                    if (endTargetType === 'element') {
                        // html element
                        endTargetTop = jQuery($wppumPopup.data('end_target_element')).first().offset().top;
                    } else if (endTargetType === 'top') {
                        // absolute y-offset from page top
                        endTargetTop = jQuery($wppumPopup.data('end_target_offset'));
                    } else if (endTargetType === 'bottom') {
                        // absolute y-offset from page bottom
                        endTargetTop = jQuery(document).height() - $wppumPopup.data('end_target_offset');
                    } else if (endTargetType === 'shortcode') {
                        // shortcode position
                        $targets = jQuery('.wppum_scroll_shortcode_end_target[data-popup-name=""], .wppum_scroll_shortcode_end_target[data-popup-name="' + $wppumPopup.data('name') + '"]');
                        if ($targets.length > 0) {
                            endTargetTop = $targets.first().offset().top;
                        }
                    } else if (endTargetType !== 'none') {
                        // unknown end target type!
                        return;
                    }
                    if (endTargetTop < targetTop) { // end target can't be smaller than target!
                        endTargetTop = -1;
                    }

                    // determine if popup should be triggered/hidden
                    if (wppumPopupScroll >= targetTop && (endTargetTop === -1 || wppumPopupScroll <= endTargetTop)) {
                        // show the popup
                        showPopup($wppumPopup, false, false, false, false);
                    } else {
                        // close the popup
                        hidePopup($wppumPopup, false);
                    }
                });

                wppum.prevScroll = wppumPopupScroll;
            },
            250
            );

    // handle OK button click
    jQuery('a.wppum-ok').click(function () {
        var $wppumPopup = jQuery(this).closest('.wppum');

        $wppumPopup.attr('data-is-awaiting-response', 'false');
        if (jQuery('.wppum[data-is-awaiting-response="true"]').length === 0 && wppum.blockedHref !== '') {
            // all pending popups have been confirmed
            wppum.blockedHref = '';
            return true;   // proceed to open link in new tab
        }

        // close or toggle the popup
        hidePopup($wppumPopup, true);
        return false;
    });











// sdb - add class for [link shortcode] for all links not in popup


// jQuery('a[href="#"]').addClass("wppum-internal-link-click");





    // handle links which trigger popups
    jQuery('a[data-popup-name]').each(function () {
        var name = jQuery(this).attr('data-popup-name');
        jQuery(this).addClass('wppum-internal-link-click');
    });


// end sdb - add class for [link shortcode] for all links not in popup










    // handle close/cancel button click
    jQuery('.wppum-close, .snpanel-close, a.wppum-cancel').click(function () {
        var $wppumPopup = jQuery(this).closest('.wppum');

        if ($wppumPopup.attr('data-is-awaiting-response') === 'true') {
            // cancel chain of confirm popups
            wppum.blockedHref = '';
            jQuery('.wppum').attr('data-is-awaiting-response', 'false');
        }

        // close or toggle the popup
        hidePopup($wppumPopup, true);
    });
    jQuery('.wppm-cook').click(function () {
        setCookie2("wppm_cook_status", 1, 1);
        return false;
    });

    jQuery('a.all-close,.all-close').click(function () {
        jQuery('.wppum').hide("slow");
        return false;
    });
    jQuery(".wppum_nl_form").submit(function (e) {
        e.preventDefault();
        var form_ = jQuery(this);
        var re = /\S+@\S+\.\S+/;
        var toEmail = jQuery(this).find('.wppum_nl_email_to').val();
        var fromEmail = jQuery(this).find('.wppum_nl_email').val();
        var fromName = jQuery(this).find('.wppum_nl_name').val();
        var errors = 0;
        if (!re.test(fromEmail)) {
            errors = 1;
            jQuery(this).find('.wppum_nl_email').addClass('error');
        }
//        if (jQuery(this).find('.wppum_nl_name').length > 0 && jQuery(this).find('.wppum_nl_name').attr('required') == true && fromName == "") {
//            errors = 1;
//            jQuery(this).find('.wppum_nl_name').addClass('error');
//        }
        if (errors) {
            return false;
        }
        var data = {
            'action': 'newsletter_submit_callback',
            'toEmail': toEmail,
            'fromEmail': fromEmail,
            'fromName': fromName,
        };

        form_.parents(".wppum").find(".wppum_form_loader").show();
        form_.parents(".wppum").find(".wppum_form_loader_content").show();
        form_.parents(".wppum").find(".wppum_form_loader_success").hide();
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function (response) {

            form_.parents(".wppum").find(".wppum_form_loader_content").hide();
            if (response.type == "error") {
                form_.parents(".wppum").find(".wppum_form_loader_error_message").text(response.message);
                form_.parents(".wppum").find(".wppum_form_loader_success").hide();

                form_.parents(".wppum").find(".wppum_form_loader_error").show();
                setTimeout(function () {
                    form_.parents(".wppum").find(".wppum_form_loader_error").hide();
                    form_.parents(".wppum").find(".wppum_form_loader").hide();
                }, 1000)

            } else {
                form_.parents(".wppum").find(".wppum_form_loader_error").hide();

                form_.parents(".wppum").find(".wppum_form_loader_success").show();
            }


//            form_.parents(".wppum").find(".wppum-close").trigger('click');
        });
        return false;
    })
    // on window resize, resize all popup overlays and popups with percentage widths/heights
    lastDocumentSize = {
        width: jQuery(document).width(),
        height: jQuery(document).height()
    };
    function resizeAll() {
        if (lastDocumentSize.width !== jQuery(document).width() || lastDocumentSize.height !== jQuery(document).height()) {
            lastDocumentSize = {
                width: jQuery(document).width(),
                height: jQuery(document).height()
            };
            jQuery('.wppum').each(function () {
                var $wppumPopup, $wppumPopupOverlay;

                $wppumPopup = jQuery(this);
                resizePopup($wppumPopup);
                $wppumPopupOverlay = $wppumPopup.data('overlay_element');
                if ($wppumPopupOverlay !== null) {
                    $wppumPopupOverlay.height(jQuery(document).height());
                }
            });
        }
    }
    setInterval(resizeAll, 500);
    jQuery(window).resize(resizeAll);







    jQuery(function () {
        // handle click of external links
        wppum.blockedHref = '';
        jQuery('a').click(function (e) {
            if (jQuery('.wppum-trigger-on-link-click').length === 0 || jQuery(this).closest('.wppum').length > 0 || jQuery(this).hasClass('.wppum-ok-button') || jQuery(this).hasClass('.wppum-cancel-button')) {
                return;
            }
            if (jQuery('.wppum[data-is-awaiting-response="true"]').length > 0) {
                return false;
            }

            // extract and sanitize href
            var originalHref = jQuery(this).attr('href');
            var href = this.hostname + this.pathname;
            if (href.charAt(href.length - 1) === '/') {
                href = href.substr(0, href.length - 1);
            }
            href = href.toLowerCase();

            // show all blocker popups
            var allPopupsConfirmed = true;
            jQuery('.wppum-trigger-on-link-click').each(function () {
                if (!allPopupsConfirmed) {
                    return;
                }
                var $wppumPopup = jQuery(this);
                if (!isHrefWhitelisted($wppumPopup, href)) {
                    var result = showPopup($wppumPopup, true, false, true, false);
                    if (result === null) {
                        return;
                    }
                    allPopupsConfirmed = result;
                    if ($wppumPopup.hasClass('wppum-link-click-popup-html')) {
                        $wppumPopup
                                .attr('data-is-awaiting-response', 'true')
                        $wppumPopup.find('a.wppum-ok').attr('href', originalHref).attr('target', '_blank');
                    }
                }
            });

            if (!allPopupsConfirmed) {
                return false;
            }

            if (jQuery('.wppum[data-is-awaiting-response="true"]').length === 0) {
                return true;
            }

            wppum.blockedHref = href;
            return false;
        });

        // make all images and iframes in popups responsive
        jQuery('.wppum').find('img, iframe').each(function () {
            // exclude open/close button images
            var $parent = jQuery(this).parent();
            if ($parent.hasClass('wppum-close') || $parent.hasClass('wppum-open')) {
                return;
            }

            if (this.tagName !== 'IFRAME' && jQuery(this).css('width') !== 'auto' && jQuery(this).css('height') !== 'auto') {
                jQuery(this).css('height', 'auto');
            }

            jQuery(this)
                    .css('max-width', '100%')
                    .css('max-height', '100%');
        });
    });

    // handle links which trigger popups
    jQuery('a[data-popup-name]').each(function () {
        var name = jQuery(this).attr('data-popup-name');
        jQuery('.wppum').each(function () {
            if (jQuery(this).data('name') === name) {
                jQuery(this).addClass('wppum-internal-link-click');
            }
        });
    });
    jQuery('a.wppum-internal-link-click').click(function (e) {
        e.preventDefault();
        var name = jQuery(this).attr('data-popup-name');
        jQuery('.wppum').each(function () {
            if (jQuery(this).data('name') === name) {
                var $wppumPopup = jQuery(this);
                showPopup($wppumPopup, true, false, false, true);
                //showPopup( $thatPopup, true, true, false, false );
            }
        });
        return false;
    });


    function setCookie2(cname, cvalue, exdays)
    {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie2(cname)
    {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++)
        {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


}());