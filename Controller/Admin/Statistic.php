<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;

class Statistic extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $model = Phpfox::getService('cmlanding.statistic');

        if (($names = $this->request()->getArray('delete', []))) {
            $model->delete($names);
            $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                _p('Successfully deleted'));
        }
        $this->template()
            ->setTitle(_p('Statistics'))
            ->setBreadCrumb(_p('Statistics'))
            ->setHeader('cache', array(
                    'drag.js' => 'static_script',
                    'jquery/plugin/jquery.scrollTo.js' => 'static_script',
                )
            )
            ->assign('statistics', $model->all());
    }

}