<?php
/**
 * TDS Matomo embedding
 *
 * Copyright 2019 - TDSystem Beratung & Training - Thomas Dausner
 */

namespace Concrete\Package\TdsMatomo\Block\TdsMatomo;

use Concrete\Core\Block\BlockController;
use Concrete\Core\View\View;
use Concrete\Core\Asset\AssetList;

class Controller extends BlockController
{
    protected $btInterfaceWidth = 600;
    protected $btInterfaceHeight = 200;
    protected $btCacheBlockOutput = true;
    protected $btTable = 'btTdsMatomo';
    protected $btDefaultSet = 'other';

    protected $bUID = 0;
    protected $url, $websiteId;

    public function getBlockTypeDescription()
    {
        return t('Add Matomo embeding on your pages.');
    }

    public function getBlockTypeName()
    {
        return t('Matomo embedding');
    }

    public function add()
    {
        $this->set('url', '');
        $this->set('websiteId', 0);
        $this->edit();
    }

    public function edit()
    {
        $this->set('url', $this->url);
        $this->set('websiteId', $this->websiteId);

        $al = AssetList::getInstance();
        $ph = 'tds_matomo';
        $al->register('css', $ph . '/form', 'blocks/' . $ph . '/css/form.css', [], $ph);
        $al->registerGroup($ph, [
            ['css', $ph . '/form'],
        ]);
        $v = View::getInstance();
        $v->requireAsset($ph);

        $this->view();
    }

    public function view()
    {
        #$this->app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();
    }

    public function registerViewAssets($outputContent = '')
    {
        $this->requireAsset('font-awesome');
        $this->requireAsset('javascript', 'jquery');
    }

    public function save($args)
    {
        $args['websiteId'] = intval($args['websiteId']);

        parent::save($args);
    }

}
