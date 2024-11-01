<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    .wppum_newsletter.theme_<?= $popup["newsletter_template"] ?> .submitBtn{
        background: #<?= $popup["newsletter_submit_btn_color"] ?>;
        color: #<?= $popup["newsletter_submit_btn_text_color"] ?>;
    }
    .wppum_newsletter.theme_<?= $popup["newsletter_template"] ?> .submitBtn:hover{
        background: #<?= $popup["newsletter_submit_btn_hover"] ?>;

    }
</style>
<div class='wppum_newsletter theme_<?= $popup["newsletter_template"] ?>'>
    <div class="wppum_form_loader">
        <div class="wppum_form_loader_content">
            <h1><?= $popup["newsletter_submit_btn_loading"] ?></h1>
            <img src="<?= WPPUM__POPUP_URL . "/images/msg.gif" ?>" class="responsive"/>

        </div>
        <div class="wppum_form_loader_success">
            <h1><?= $popup["newsletter_submit_btn_success"] ?></h1>
        </div>
        <div class="wppum_form_loader_error">
            <h1 class="wppum_form_loader_error_message"></h1>
        </div>
    </div>
    <form id = 'wppum_nl_form' action = '#' class='wppum_nl_form'>
        <div class="form-right-quarter">
            <div class="row">
                <div class="col-md-12 text-right">
                    <?php
                    if ($popup["newsletter_heading"] != "") {
                        ?>
                        <h1><?= $popup["newsletter_heading"] ?></h1>
                        <?php
                    }
                    ?>
                    <?php
                    if ($popup["newsletter_sub_heading"] != "") {
                        ?>
                        <h2><?= $popup["newsletter_sub_heading"] ?></h2>
                        <?php
                    }
                    ?>
                </div>

            </div>
            <?php
            if ($popup['trigger_on_newsletter_email']) {
                ?>
                <div class="row margined_left">
                    <div class="col-md-12">
                        <input class="wppum_nl_name" name="wppum_nl_name" id="wppum_nl_name"  class="form-control" <?= $popup['require_name_newsletter_email'] == 1 ? "required" : "" ?> placeholder="<?= $popup['newsletter_name_placeholder'] ?>"/>
                    </div>

                </div>
                <?php
            }
            ?>

            <div class="row margined_left">
                <input class="wppum_nl_email_to" name="wppum_nl_email_to" id="wppum_nl_email_to" value="<?= $popup["newsletter_email"] ?>" type="hidden"/>

                <input class="wppum_nl_email" name="wppum_nl_email" id="wppum_nl_email"  required class="form-control" placeholder="<?= $popup['newsletter_email_placeholder'] ?>"/>

                <button class="btn btn-primary submitBtn" type="submit"><?= $popup['newsletter_submit_btn'] ?></button>
            </div>
        </div>
    </form>
</div>