<?php
/**
 * TDS Matomo embedding
 *
 * Copyright 2020 - TDSystem Beratung & Training - Thomas Dausner
 */
namespace Concrete\Package\TdsMatomo\Controller\SinglePage\Dashboard\System\Seo;

use Concrete\Core\Cache\Page\PageCache;
use Concrete\Core\Page\Controller\DashboardPageController;

class TdsMatomo extends DashboardPageController  {

    public function view()
    {
        $config = $this->app->make('config/database');
        $this->set('tds_matomo_serverurl', $config->get('tds_matomo.serverurl'));
        $this->set('tds_matomo_siteid', $config->get('tds_matomo.siteid'));

        if ($this->isPost())
        {
            $errmsg = '';
            if ($this->token->validate('update_tracking_code'))
            {
                $matomoUrl = $checkUrl = trim($this->post('tds_matomo_serverurl'));
                if (!preg_match("/^[0-9a-z.-]+$/i", $matomoUrl))
                    $checkUrl = idn_to_ascii($matomoUrl);
                $siteId = $this->post('tds_matomo_siteid');
                $rlabel = '([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?)';
                if (empty($matomoUrl))
                {
                    $errmsg = t('Matomo server URL must not be empty.');
                }
                elseif (!preg_match('/^(https?:\/\/)?([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?\.){1,2}[a-z0-9]{0,63}$/i', $checkUrl))
                {
                    $errmsg = t('Matomo server URL must be a valid server URL.');
                }
                elseif(empty($siteId))
                {
                    $errmsg = t('Matomo site ID must by a number greater equal 1.');
                }
                else
                {
                    $config->save('tds_matomo.serverurl', trim($matomoUrl));
                    $config->save('tds_matomo.siteid', $this->post('tds_matomo_siteid'));

                    $pageCache = PageCache::getLibrary();
                    if (is_object($pageCache))
                    {
                        $pageCache->flush();
                    }
                    $this->redirect('/dashboard/system/seo/tds_matomo', 'saved');
                }
            } else
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

