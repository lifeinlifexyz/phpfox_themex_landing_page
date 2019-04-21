<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;

class Cols extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $model = Phpfox::getService('cmlanding.col');

        if (($names = $this->request()->getArray('delete', []))) {
            $model->delete($names);
            $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                _p('Successfully deleted'));
        }
        $this->template()
            ->setTitle(_p('Section cols'))
            ->setBreadCrumb(_p('Section cols'))
            ->setHeader('cache', array(
                    'drag.js' => 'static_script',
                    'jquery/plugin/jquery.scrollTo.js' => 'static_script',
                )
            )
            ->assign('cols', $model->all());
    }

}