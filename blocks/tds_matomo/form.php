<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div class="form-group">
    <?php  echo $form->label('url', t('Matomo url (without http/https)'))?>
    <?php  echo $form->text('url', $url); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('websiteId', t('Matomo website ID'))?>
    <?php  echo $form->number('websiteId', $websiteId); ?>
</div>
