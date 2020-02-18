<?php
/**
 * TDS Matomo embedding
 *
 * Copyright 2020 - TDSystem Beratung & Training - Thomas Dausner
 */
namespace Concrete\Package\TdsMatomo\Controller\SinglePage\Dashboard\System\Seo;

use Concrete\Core\Cache\Page\PageCache;
use Concrete\Core\Http\ResponseFactoryInterface;
use Concrete\Core\Page\Controller\DashboardPageController;

class TdsMatomo extends DashboardPageController  {

    public function view()
    {
        $config = $this->app->make('config/database');
        $this->set('tds_matomo_serverurl', $config->get('tds_matomo.serverurl'));
        $this->set('tds_matomo_siteid', $config->get('tds_matomo.siteid'));

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST')
        {
            $errmsg = '';
            if ($this->token->validate('update_tracking_code'))
            {
                $matomoUrl = trim($request->get('tds_matomo_serverurl'));
                $matomoUrl = $checkUrl = preg_replace("#(https?://)?([^/]+)#", "$2", $matomoUrl);
                if (!preg_match("/^[0-9a-z.-]+$/i", $matomoUrl))
                {
                    if (function_exists('idn_to_ascii'))
                    {
                        $checkUrl = idn_to_ascii($matomoUrl);
                    }
                    else
                    {
                        $errmsg = t('No support for internationalized domain names (IDN).<br><br>
To utilize an internationalized domain name (IDN) you must have <code>php_intl</code> enabled in php.ini of your web server.');
                    }
                }
                if ($errmsg == '')
                {
                    $siteId = $request->get('tds_matomo_siteid');
                    if (empty($matomoUrl))
                    {
                        $errmsg = t('Matomo server URL must not be empty.');
                    }
                    elseif (!preg_match('/^([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?\.){1,2}[a-z0-9]{0,63}$/i', $checkUrl))
                    {
                        $errmsg = t('Matomo server URL must be a valid server URL.');
                    }
                    elseif (empty($siteId))
                    {
                        $errmsg = t('Matomo site ID must by a number greater equal 1.');
                    } else
                    {
                        $config->save('tds_matomo.serverurl', trim($matomoUrl));
                        $config->save('tds_matomo.siteid', $request->get('tds_matomo_siteid'));

                        $pageCache = PageCache::getLibrary();
                        if (is_object($pageCache))
                        {
                            $pageCache->flush();
                        }
                        return $this->app->make(ResponseFactoryInterface::class)->redirect('/dashboard/system/seo/tds_matomo/saved', 302);
                    }
                }
            }
            else
            {
                $errmsg = $this->token->getErrorMessage();
            }
            if ($errmsg != '')
            {
                $this->error->add($errmsg);
            }
        }
    }

    public function saved()
    {
        $this->set('message', implode(PHP_EOL, [
            t('Matomo webtracking settings updated successfully.'),
            t('Cached files removed.')
        ]));
        $this->view();
    }

}

