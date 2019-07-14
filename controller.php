<?php
/**
 * TDS Matomo embedding
 *
 * Copyright 2019 - TDSystem Beratung & Training - Thomas Dausner
 */

namespace Concrete\Package\TdsMatomo;

use Concrete\Core\Package\Package;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{
    protected $pkgHandle = 'tds_matomo';
    protected $appVersionRequired = '8.1';
    protected $pkgVersion = '0.9.0';

    public function getPackageName()
    {
        return t('TDS Matomo embedding');
    }

    public function getPackageDescription()
    {
        return t('Add Matomo web tracking on your pages.');
    }

    public function install()
    {
        $pkg = parent::install();

        $blk = BlockType::getByHandle($this->pkgHandle);
        if (!is_object($blk))
        {
            BlockType::installBlockType($this->pkgHandle, $pkg);
        }
    }

    public function uninstall()
    {
        $pkg = parent::uninstall();
    }
}