<?php defined('C5_EXECUTE') or die('Access Denied.');

/** @var Concrete\Core\Form\Service\Form $form */
$form = \Core::make('helper/form');
?>

<p class="help-block"><?php echo t("Specify Matomo server URL and site ID supplied by your Matomo web tracking provider.
Server URL protocol (http|hhtps) can be ommitted as it is replaced by the web site's protocol."); ?></p>

<form id="tracking-code-form" action="<?php echo $view->action(''); ?>" method="post">
    <?php echo Core::make('helper/validation/token')->output('update_tracking_code'); ?>

    <div class="form-group">
        <p>
            <?php echo $form->label('tds_matomo_serverurl', t('Matomo server URL')); ?>
            <?php echo $form->text('tds_matomo_serverurl', $tds_matomo_serverurl); ?>
        </p>
        <p>
            <?php echo $form->label('tds_matomo_siteid', t('Site ID')); ?>
            <?php echo $form->number('tds_matomo_siteid', $tds_matomo_siteid, [ "min" => "1" ]); ?>
        </p>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="submit" class="btn btn-primary pull-right" name="tracking-code-form"><?php echo t('Save'); ?></button>
        </div>
    </div>
</form>
