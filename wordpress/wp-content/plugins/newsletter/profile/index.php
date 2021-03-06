<?php
defined('ABSPATH') || exit;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';

$controls = new NewsletterControls();
$module = NewsletterProfile::instance();

// Profile options are still inside the main options
if ($controls->is_action()) {
    if ($controls->is_action('save')) {
        $module->save_options($controls->data);
        $controls->add_message_saved();
    }
    if ($controls->is_action('reset')) {
        $module->reset_options();
        $controls->data = $module->get_options();
        $controls->add_message_reset();
    }
} else {
    $controls->data = $module->get_options();
}
?>

<div class="wrap tnp-profile tnp-profile-index" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>

    <div id="tnp-heading">

        <h2><?php _e('The subscriber profile page', 'newsletter') ?></h2>

    </div>

    <div id="tnp-body">

        <form id="channel" method="post" action="">
            <?php $controls->init(); ?>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-general"><?php _e('General', 'newsletter') ?></a></li>

                </ul>

                <div id="tabs-general">


                    <table class="form-table">

                        <tr>
                            <th><?php _e('Profile page', 'newsletter') ?>
                                <br><?php $controls->help('https://www.thenewsletterplugin.com/documentation/subscription#profile') ?>
                            </th>
                            <td>
                                <?php $controls->wp_editor('text'); ?>
                            </td>
                        </tr>

                        <tr>
                            <th><?php _e('Alternative profile page URL', 'newsletter') ?></th>
                            <td>
                                <?php $controls->text('url', 70); ?>
                            </td>
                        </tr>

                    </table>

                    <h3><?php _e('Messages', 'newsletter')?></h3>
                    <table class="form-table">
                        <tr>
                            <th>Profile saved</th>
                            <td>
                                <?php $controls->text('saved', 80); ?>
                            </td>
                        </tr>

                        <tr>
                        <tr>
                            <th><?php _e('Email changed alert', 'newsletter')?></th>
                            <td>
                                <?php $controls->text('email_changed', 80); ?>
                            </td>
                        </tr>

                        <tr>

                        <tr>
                        <tr>
                            <th><?php _e('General error', 'newsletter')?></th>
                            <td>
                                <?php $controls->text('error', 80); ?>
                                <p class="description">
                                    Email not valid or already used.
                                </p>
                            </td>
                        </tr>

                    </table>

                    <h3>Labels</h3>
                    <table class="form-table">
                        <tr>
                            <th><?php _e('"Save" label', 'newsletter')?></th>
                            <td>
                                <?php $controls->text('save_label'); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <th><?php _e('Privacy link text', 'newsletter')?></th>
                            <td>
                                <?php $controls->text('privacy_label', 80); ?>
                                <p class="description">
                                    
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </div>

            </div>

            <p>
                <?php $controls->button_save() ?>
                <?php $controls->button_reset() ?>
            </p>

        </form>
    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
