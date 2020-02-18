<?php
/**
 * TDS Matomo embedding
 *
 * Copyright 2020 - TDSystem Beratung & Training - Thomas Dausner
 */

namespace Concrete\Package\TdsMatomo;

use Events;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;
use Concrete\Core\View\View;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends Package
{
    protected $pkgHandle = 'tds_matomo';
    protected $appVersionRequired = '8.0';
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
        /** @var $pkg \Concrete\Core\Package\Package() */
        $pkg = parent::install();

        //install single pages
        $single_page = Single::add('/dashboard/system/seo/tds_matomo', $pkg);
        if ($single_page)
        {
            $single_page->update(['cName' => t('Matomo embedding'), 'cDescription' => t('Setup Matomo server and site ID for webtracking of your site.')]);
        }
    }

    public function uninstall()
    {
        $pkg = parent::uninstall();
    }

    public function on_start()
    {
        Events::addListener('on_before_render', function ($event) {

            # - it is not loaded or run for dashboard pages
            # - it is not loaded or run when in edit mode
            $c = Page::getCurrentPage();
            if ($c->getPageTypeID() != 0 && !$c->isEditMode())
            {
                $config = $this->app->make('config/database');
                $matomoUrl = $config->get('tds_matomo.serverurl');
                $siteID = $config->get('tds_matomo.siteid');
                if (!empty($matomoUrl) && !empty($siteID))
                {
                    if (!preg_match("/^[0-9a-z.-]+$/i", $matomoUrl) && function_exists('idn_to_ascii'))
                    {
                        $matomoUrl = idn_to_ascii($matomoUrl);
                    }
                    $v = View::getInstance();
                    $v->addFooterItem('<script type="text/javascript">
    if ( typeof ( _paq ) === "undefined" )
    {
        var _paq = _paq || [];
        _paq.push( ["trackPageView"] );
        _paq.push( ["enableLinkTracking"] );
        ( function () {
            var u = "/' . $matomoUrl . '/";
            _paq.push( ["setTrackerUrl", u + "piwik.php"] );
            _paq.push( ["setSiteId", "' . $siteID . '"] );
            var d = document, g = d.createElement( "script" ), s = d.getElementsByTagName( "script" )[0];
            g.type = "text/javascript";
            g.async = true;
            g.defer = true;
            g.src = u + "piwik.js";
            s.parentNode.insertBefore( g, s );
        } )();
    }
</script>');
                }
            }
        });
    }
}