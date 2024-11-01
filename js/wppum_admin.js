jQuery(function ($) {
    $('.meta-box-sortables').sortable({
        disabled: true
    });

    $('.postbox .hndle').css('cursor', 'pointer');

    $('#post_status option[value="pending"]').remove();
    $('#minor-publishing-actions').prepend('<div id="preview-action"><a target="_blank" class="preview button" href="' + $('#wppum_preview_link').val() + '" id="popup-preview">Preview</a></div>');

    $(document).on('change', '#wppum_horizontal_offset_type', function () {
        if ($(this).find('option:selected').val() === 'center') {
            $('#wppum-horizontal-offset-container').fadeOut();
        } else {
            $('#wppum-horizontal-offset-container').fadeIn();
        }
    });

    $(document).on('change', '#wppum_vertical_offset_type', function () {
        if ($(this).find('option:selected').val() === 'center') {
            $('#wppum-vertical-offset-container').fadeOut();
        } else {
            $('#wppum-vertical-offset-container').fadeIn();
        }
    });

    $(document).on('click', '#wppum_position_centered', function () {
        if ($(this).is(':checked')) {
            $('#wppum_vertical_offset_type').val('center').trigger('change');
            $('#wppum_horizontal_offset_type').val('center').trigger('change');
            $('#wppum_position_centered').attr('checked', 'checked');
        } else {

            $('#wppum_vertical_offset_type').val('bottom').trigger('change');
            $('#wppum_horizontal_offset_type').val('right').trigger('change');
            $('#wppum_position_centered').removeAttr('checked');
        }
    });

    $(document).on('change', '#wppum_vertical_offset_type, #wppum_horizontal_offset_type', function () {
        if ($('#wppum_vertical_offset_type').val() === 'center' && $('#wppum_horizontal_offset_type').val() === 'center') {
            //$( '#wppum_position_centered' ).attr( 'checked', 'checked' );
        } else {
            //$( '#wppum_position_centered' ).removeAttr( 'checked' );
        }

    });

    $(document).on('click', 'input[name=wppum_size_type]', function () {
        if ($(this).val() === 'custom') {
            $('.wppum-hide-if-size-type-not-custom').fadeIn();
        } else {
            $('.wppum-hide-if-size-type-not-custom').fadeOut();
        }
    });

    $(document).on('click', 'input[name=wppum_background_type]', function () {
        if ($(this).val() === 'image') {
            $('.wppum-hide-if-background-type-color').fadeIn();
            $('.wppum-hide-if-background-type-image').fadeOut();
        } else {
            $('.wppum-hide-if-background-type-color').fadeOut();
            $('.wppum-hide-if-background-type-image').fadeIn();
        }
    });

    $(document).on('click', 'input[name=wppum_close_button_type]', function () {
        if ($(this).val() !== 'hide') {
            $('.wppum-hide-if-close-button-empty').fadeIn();
        } else {
            $('.wppum-hide-if-close-button-empty').fadeOut();
        }

        if ($(this).val() === 'toggle') {
            $('.wppum-hide-if-open-button-empty').fadeIn();
        } else {
            $('.wppum-hide-if-open-button-empty').fadeOut();
        }
    });

    $(document).on('click', '.wppum-show-close-button-advanced', function () {
        $('.wppum-hide-if-close-button-advanced').fadeOut();
        $('.wppum-hide-if-not-close-button-advanced').fadeIn();
        return false;
    });

    $(document).on('click', '.wppum-hide-close-button-advanced', function () {
        $('.wppum-hide-if-close-button-advanced').fadeIn();
        $('.wppum-hide-if-not-close-button-advanced').fadeOut();
        return false;
    });

    $(document).on('click', 'input[name=wppum_title]', function () {
        if ($(this).val() === '1') {
            $('.wppum-hide-if-no-title').fadeIn();
        } else {
            $('.wppum-hide-if-no-title').fadeOut();
        }
    });

    $(document).on('click', '.wppum-show-title-advanced', function () {
        $('.wppum-hide-if-title-advanced').fadeOut();
        $('.wppum-hide-if-not-title-advanced').fadeIn();
        return false;
    });

    $(document).on('click', '.wppum-hide-title-advanced', function () {
        $('.wppum-hide-if-title-advanced').fadeIn();
        $('.wppum-hide-if-not-title-advanced').fadeOut();
        return false;
    });

    $(document).on('click', '#wppum_trigger_on_timing', function () {
        if ($(this).is(':checked')) {
            $('.wppum-hide-if-no-delay').fadeIn();
        } else {
            $('.wppum-hide-if-no-delay').fadeOut();
        }
    });

    $(document).on('click', '#wppum_trigger_on_link_click', function () {
        if ($(this).is(':checked')) {
            $('.wppum-hide-if-no-link-click').fadeIn();
            if ($('input[name=wppum_link_click_popup_type]:checked').val() !== 'html') {
                $('.wppum-hide-if-no-link-click-popup').fadeOut();
            } else {
                $('.wppum-hide-if-no-link-click-popup').fadeIn();
            }
        } else {
            $('.wppum-hide-if-no-link-click').fadeOut();
        }
    });

    $(document).on('click', 'input[name=wppum_link_click_popup_type]', function () {
        if ($('#wppum_trigger_on_link_click').is(':checked') && $(this).val() === 'html') {
            $('.wppum-hide-if-no-link-click-popup').fadeIn();
        } else {
            $('.wppum-hide-if-no-link-click-popup').fadeOut();
        }
    });

    $(document).on('click', 'input[name=wppum_ok_button]', function () {
        if ($(this).val() === '1') {
            $('.wppum-hide-if-no-ok-button').fadeIn();
        } else {
            $('.wppum-hide-if-no-ok-button').fadeOut();
        }
    });

    $(document).on('click', '.wppum-show-ok-button-advanced', function () {
        $('.wppum-hide-if-ok-button-advanced').fadeOut();
        $('.wppum-hide-if-not-ok-button-advanced').fadeIn();
        return false;
    });

    $(document).on('click', '.wppum-hide-ok-button-advanced', function () {
        $('.wppum-hide-if-ok-button-advanced').fadeIn();
        $('.wppum-hide-if-not-ok-button-advanced').fadeOut();
        return false;
    });

    $(document).on('click', 'input[name=wppum_cancel_button]', function () {
        if ($(this).val() === '1') {
            $('.wppum-hide-if-no-cancel-button').fadeIn();
        } else {
            $('.wppum-hide-if-no-cancel-button').fadeOut();
        }
    });

    $(document).on('click', '.wppum-show-cancel-button-advanced', function () {
        $('.wppum-hide-if-cancel-button-advanced').fadeOut();
        $('.wppum-hide-if-not-cancel-button-advanced').fadeIn();
        return false;
    });

    $(document).on('click', '.wppum-hide-cancel-button-advanced', function () {
        $('.wppum-hide-if-cancel-button-advanced').fadeIn();
        $('.wppum-hide-if-not-cancel-button-advanced').fadeOut();
        return false;
    });

    $(document).on('click', 'input[name=wppum_frequency_type]', function () {
        if ($(this).val() === 'custom') {
            $('.wppum-hide-if-no-frequency').fadeIn();
        } else {
            $('.wppum-hide-if-no-frequency').fadeOut();
        }
    });

    $(document).on('click', '#wppum_trigger_browser_scroll', function () {
        if ($(this).is(':checked')) {
            $('.wppum-hide-if-not-browser-scroll').fadeIn();
        } else {
            $('.wppum-hide-if-not-browser-scroll').fadeOut();
        }
    });

    $(document).on('change', '.wppum_target_type', function () {
        var selected = $(this).find('option:selected').val();
        if (selected === 'top' || selected === 'bottom') {
            $(this).parents(".row").find('.wppum-hide-if-not-target-offset').fadeIn();
        } else {
            $(this).parents(".row").find('.wppum-hide-if-not-target-offset').fadeOut();
        }

        if (selected === 'element') {
            $(this).parents(".row").find('.wppum-hide-if-not-target-css').fadeIn();
        } else {
            $(this).parents(".row").find('.wppum-hide-if-not-target-css').fadeOut();
        }
    });

    $(document).on('change', '#wppum_trigger_pages', function () {
        var selected = $(this).find('option:selected').val();
        if (selected === 'show_pages' || selected === 'hide_pages' || selected === 'exclude_posts' || selected === 'exclude_pages' || selected === 'url_pattern' || selected === 'web_referring_url') {
            $('.wppum-hide-if-not-specific-page-trigger').fadeIn();
            if (selected === 'exclude_posts') {
                $('#wppum_trigger_pages_text').html("Post IDs");
            } else if (selected === 'exclude_pages') {
                $('#wppum_trigger_pages_text').html("Page IDs");
            } else if (selected === 'url_pattern' || selected === 'web_referring_url') {
                $('#wppum_trigger_pages_text').html("URL");
            } else if (selected === 'show_pages' || selected === 'hide_pages') {
                $('#wppum_trigger_pages_text').html("Page/post IDs");
            }

        } else if (selected === 'specific_cat') {
            $('.wppum-hide-if-not-specific-cat-trigger').fadeIn();
        } else {
            $('.wppum-hide-if-not-specific-page-trigger').fadeOut();
        }
    });

    $(document).on('click', '.wppum-show-hide-post-list', function () {
        var textSpan = $(this).find('span')
        var text = textSpan.html();
        if (text === 'view') {
            textSpan.html('hide');
            $($(this).data('target')).fadeIn();
        } else {
            textSpan.html('view');
            $($(this).data('target')).fadeOut();
        }
        return false;
    });

    $(document).on('click', '.wppum-revert-close-button-html', function () {
        $('#wppum_close_button_html').val($(this).attr('data-html'));
        return false;
    });

    $(document).on('click', 'input[name=wppum_overlay]', function () {
        if ($(this).val() === '1') {
            $('.wppum-hide-if-no-overlay').fadeIn();
        } else {
            $('.wppum-hide-if-no-overlay').fadeOut();
        }
    });

    $(document).on('change', '#wppum_animation_effect', function () {
        var selected = $(this).find('option:selected').val();
        if (selected === 'slide' || selected === 'drop') {
            $('.wppum-hide-if-effect-no-direction').fadeIn();
            $('.wppum-hide-if-effect-direction-not-blind').fadeIn();
            $('.wppum-hide-if-effect-direction-blind').fadeOut();
            $('#wppum_blind_direction').attr('disabled', 'disabled');
            $('#wppum_slide_direction').removeAttr('disabled');
        } else if (selected === 'blind') {
            $('.wppum-hide-if-effect-no-direction').fadeIn();
            $('.wppum-hide-if-effect-direction-not-blind').fadeOut();
            $('.wppum-hide-if-effect-direction-blind').fadeIn();
            $('#wppum_slide_direction').attr('disabled', 'disabled');
            $('#wppum_blind_direction').removeAttr('disabled');
        } else {
            $('.wppum-hide-if-effect-no-direction').fadeOut();
            $('#wppum_blind_direction').attr('disabled', 'disabled');
        }
    });

    $(document).on('click', '.wppum-meta-box .hndle', function () {
        $('.' + $(this).closest('.wppum-meta-box').attr('id') + '-child-meta-box').toggle();
    });
    $('.wppum-meta-box').each(function () {
        if ($(this).hasClass('closed')) {
            $('.' + $(this).attr('id') + '-child-meta-box').fadeOut();
        } else {
            $('.' + $(this).attr('id') + '-child-meta-box').fadeIn();
        }
    });
});


(function ($) {

    //Upload step assets

    jQuery(".upload_newsletter_logo").on('click', function () {
        var _this = jQuery(this);

        var _inputfield = _this.parents('.td').find('.media_id');
        //_media_url     = _this.parents('.tg-displaybox').find('.media_url');
        var _screenshot = _this.parents('.td').find('._screenshot img');
        var wppum_background_img = $("input[name='wppum_newsletter_logo']");
        var custom_uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Add File'
            },
            multiple: false
        })
                .on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    var _itemurl = attachment.url;
                    var _itemid = attachment.id;
                    _inputfield.val(_itemid);
                    //_media_url.val(_itemurl);
                    _screenshot.attr("src", _itemurl);
                    wppum_background_img.val(_itemurl);
                    // jQuery('.upload_step_asset').hide();
                    // jQuery('.remove-slider-image').show();

                    _this.parents('.td').find('._screenshot img').show();
                    _this.parents('.td').find('.upload_step_asset').hide();
                    _this.parents('.td').find('.remove-slider-image').css('display', 'inline-block');
                }).open();

    });
    jQuery(".upload_step_asset").on('click', function () {
        var _this = jQuery(this);

        var _inputfield = _this.parents('.td').find('.media_id');
        //_media_url     = _this.parents('.tg-displaybox').find('.media_url');
        var _screenshot = _this.parents('.td').find('._screenshot img');
        var wppum_background_img = $("input[name='wppum_background_img']");
        var custom_uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Add File'
            },
            multiple: false
        })
                .on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    var _itemurl = attachment.url;
                    var _itemid = attachment.id;
                    _inputfield.val(_itemid);
                    //_media_url.val(_itemurl);
                    _screenshot.attr("src", _itemurl);
                    wppum_background_img.val(_itemurl);
                    // jQuery('.upload_step_asset').hide();
                    // jQuery('.remove-slider-image').show();

                    _this.parents('.td').find('._screenshot img').show();
                    _this.parents('.td').find('.upload_step_asset').hide();
                    _this.parents('.td').find('.remove-slider-image').css('display', 'inline-block');
                }).open();

    });

    jQuery(".remove-slider-image").on('click', function () {
        var _this = jQuery(this);
        var _inputfield = _this.parents('.td').find('.media_id');
        //_media_url     = _this.parents('.tg-displaybox').find('.media_url');
        var _screenshot = _this.parents('.td').find('._screenshot img');

        _inputfield.val('');
        //_media_url.val(_itemurl);
        _screenshot.attr("src", '');

        _this.parents('.td').find('.upload_step_asset').css('display', 'inline-block');
        _this.parents('.td').find('.remove-slider-image').hide();

    });



})(jQuery);


