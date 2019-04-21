<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;

class Rows extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $model = Phpfox::getService('cmlanding.row');

        if (($names = $this->request()->getArray('delete', []))) {
            $model->delete($names);
            $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                _p('Successfully deleted'));
        }
        $this->template()
            ->setTitle(_p('Section rows'))
            ->setBreadCrumb(_p('Section rows'))
            ->setHeader('cache', array(
                    'drag.js' => 'static_script',
                    'jquery/plugin/jquery.scrollTo.js' => 'static_script',
                )
            )
            ->assign('rows', $model->all());
    }

}