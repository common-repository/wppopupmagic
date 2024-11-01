<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$popus = [
    'shortcode' => [
        'type' => "shortcode",
        'title' => esc_html__("Shortcode Popup", WPPUM_I18N_DOMAIN),
    ],
    'toggle' => [
        'type' => "toggle",
        'title' => esc_html__("Toggled Popups", WPPUM_I18N_DOMAIN),
    ],
    'mexit' => [
        'type' => "mexit",
        'title' => esc_html__("Magical Exit Popup", WPPUM_I18N_DOMAIN),
    ],
    'elink' => [
        'type' => "elink",
        'title' => esc_html__("External Link Popups", WPPUM_I18N_DOMAIN),
    ],
    'fscreen' => [
        'type' => "fscreen",
        'title' => esc_html__("Full Screen Popover", WPPUM_I18N_DOMAIN),
    ],
    'linkp' => [
        'type' => "linkp",
        'title' => esc_html__("Link to Popup", WPPUM_I18N_DOMAIN),
    ],
    'video' => [
        'type' => "video",
        'title' => esc_html__("Side Slider Popup", WPPUM_I18N_DOMAIN),
    ],
    'slider' => [
        'type' => "slider",
        'title' => esc_html__("Side Slider Popup", WPPUM_I18N_DOMAIN),
    ],
    'newsletter' => [
        'type' => "newsletter",
        'title' => esc_html__("Newsletter Sign Up", WPPUM_I18N_DOMAIN),
    ],
    'mfborder' => [
        'type' => "mfborder",
        'title' => esc_html__("Magic Frame Borders", WPPUM_I18N_DOMAIN),
    ],
    'iframe' => [
        'type' => "iframe",
        'title' => esc_html__("iFrame a Website", WPPUM_I18N_DOMAIN),
    ],
];
?>
<div class="wppum bootstrap-wrapper">
    <div class="row" >
        <div class="col-md-9">
            <h2><?php echo esc_html__('Welcome to Magic Popup', WPPUM_I18N_DOMAIN); ?></h2>
            <h6 class="ln-h-14"><?php echo esc_html__('No Other WordPress Popup / Slider Plugin Gives You This Many Options and Features. It will be the game changer. It\'s help you made your website popup easy.', WPPUM_I18N_DOMAIN); ?></h6>
        </div>
        <div class="col-md-3">
            <img class="image image-responsive" src="<?= WPPUM__POPUP_URL . "/images/logo_new.png" ?>"/>
        </div>
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#make_new_popups"><?php echo esc_html__('Make New Popups', WPPUM_I18N_DOMAIN); ?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="make_new_popups" class="active tab-pane ">
                    <?php
                    foreach (array_chunk($popus, 4) as $chunked) { ?>
                        <div class="row popups_row" >
                        <?php foreach ($chunked as $key => $item) { ?>
                            <div class="col-md-3">
                                <a class="" href="<?= WPPUM_POPUP_ADMIN_URL ?>post-new.php?post_type=wppum_popup&popup_type=<?= $item['type'] ?>"><div class="mk_popup_cont">
                                        <div class="mk_body">
                                            <img class="resposive" src="<?= WPPUM__POPUP_URL . "/images/popups/" . $item['type'] . ".png" ?>"/>
                                        </div>
                                        <div class="mk_footer">
                                            <a class="" href="<?= WPPUM_POPUP_ADMIN_URL ?>post-new.php?post_type=wppum_popup&popup_type=<?= $item['type'] ?>">
                                                <h5><?= $item['title']; ?></h5>
                                                <p><?php echo esc_html__('Click to start', WPPUM_I18N_DOMAIN); ?></p>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        } ?>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>