<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $wppum, $post;
$frontend = new WPPUM_Frontend();
$final_popups = [];
$popup_id = intval($_GET['wppum_preview']);
$popup_post = get_post($popup_id);
$popup = $wppum->get_popup($popup_id);
$popup['name'] = $popup_post->post_title;
$popup['ID'] = $popup_post->ID;
$popup['raw_contents'] = $popup_post->post_content;
$popup['contents'] = wpautop($popup_post->post_content);
$popup['order'] = $popup_post->menu_order;
$popup['status'] = $popup_post->post_status;
$final_popups[] = $popup;
$localized_data = $frontend->get_localize_array($final_popups);

$javascript_dependencies = array('jquery', 'jquery-ui-core', /* 'jquery-effects-core' */);

if (1 == 1) {
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
            $countent .= getNewsLetterHtml($popup);

            $popup['contents'] = $countent;
        }
        ?>
        <div id="<?php echo esc_attr($popup['popup_id']); ?>-effects-wrapper" class="th_<?php echo esc_attr($popup['popup_theme']); ?> wppum-effects-wrapper">
            <div id="<?php echo esc_attr($popup['popup_id']); ?>" class="d-none">
                <div id="<?php echo esc_attr($popup['popup_id']); ?>-responsive" class="wppum-responsive mx-full-wh">
                    <?php
                    echo $popup['close_button_type'] === 'toggle' ? '<span class="wppum-open popup-open-mains"><img src="' . $popup['open_button_img'] . '" title="Open" /></span>' : '';

                    if ($popup['self_close_type'] == 1) {
                        // Add class for self close
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
                    if ($popup['self_close_type'] != 1) {
                        // Add class for self close
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
                    if ($popup['popup_theme'] == 2) {
                        ?>
                        <div class="wppum_footer ">

                            <?= $popup['close_button_type'] === 'hide' ? '' : $popup['close_button_html']; ?>
                        </div>
                        <?php
                    }
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
                    if ($popup['popup_theme'] == 1 || $popup['popup_theme'] == 3) { ?>
                        <div class="wppum_footer">
                            <?= $popup['close_button_type'] === 'hide' ? '' : $popup['close_button_html']; ?>
                        </div>
                        <?php
                    }

                    if ($popup['trigger_on_link_click'] === '1' && $popup['link_click_popup_type'] === 'html' && ( $popup['ok_button'] === '1' || $popup['cancel_button'] === '1' )) { ?>
                        <div class="wppum-buttons-wrapper" style="display: none; text-align: center; margin: 5px 5px;">
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
}

function getNewsLetterHtml($popup) {
    $form = "<form id = 'wppum_nl_form' action = '#' class='wppum_nl_form'>";
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
    return $form;
}

wp_register_script('wppumjs', WPPUM_PLUGIN_URL . 'js/wppum.js', $javascript_dependencies, WPPUM_PLUGIN_VERSION);
wp_localize_script('wppumjs', 'wppum', $localized_data);
wp_enqueue_script('wppumjs');
wp_enqueue_style('wppum_front.css', WPPUM_PLUGIN_URL . 'css/wppum_front.css', false, WPPUM_PLUGIN_VERSION);
?>
<div class="bootstrap-wrapper"><h1>"<?= $popup_post->post_title?>" <?= esc_html__e('Popup Preview', WPPUM_I18N_DOMAIN) ?></h1>
</div>
