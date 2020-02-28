<?php defined('C5_EXECUTE') or die('Access Denied.');

/**
 * TDS Matomo embedding
 *
 * Copyright 2020 - TDSystem Beratung & Training - Thomas Dausner
 */

use Concrete\Core\Support\Facade\Facade;

$app = Facade::getFacadeApplication();

/**
 * @var $form Concrete\Core\Form\Service\Form
 * @var $tds_matomo_serverurl string
 * @var $tds_matomo_siteid integer
 */
$form = $app->make('helper/form');
?>

<p class="help-block"><?php echo t("Specify Matomo server URL (including http:// or https:// protocol) and site ID supplied by your Matomo web tracking provider."); ?></p>

<form id="tracking-code-form" action="<?php echo $view->action(''); ?>" method="post">
    <?php echo $app->make('helper/validation/token')->output('update_tracking_code'); ?>

    <div class="form-group">
        <p>
            <?php echo $form->label('tds_matomo_serverurl', t('Matomo server URL')); ?>
            <?php echo $form->text('tds_matomo_serverurl', $tds_matomo_serverurl); ?>
        </p>
        <p>
            <?php echo $form->label('tds_matomo_siteid', t('Site ID')); ?>
            <?php echo $form->number('tds_matomo_siteid', $tds_matomo_siteid, ["min" => "1"]); ?>
        </p>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="button" class="btn btn-default pull-left"
                    name="tracking-code-form-remove"><?php echo t('Remove'); ?></button>
            <button type="submit" class="btn btn-primary pull-right"
                    name="tracking-code-form"><?php echo t('Save'); ?></button>
        </div>
    </div>
</form>

<script type="text/javascript">
    ( function ( $ ) {
        $( document ).ready( function () {
            $( '.ccm-dashboard-form-actions button[type=button]' ).click( function ( e ) {

                e.preventDefault();
                ConcreteAlert.confirm( '<p><?php echo t('Remove Matomo tracking data?'); ?></p>', function () {
                    location.href = location.href.replace(/\/(saved|removed)$/, '') + '/removed';
                }, 'btn-danger', '<?php echo t('Remove'); ?>' );

            } );
        } );
    } )( window.jQuery );
</script>