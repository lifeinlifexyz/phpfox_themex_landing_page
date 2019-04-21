<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;

class SliderGroups extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $model = Phpfox::getService('cmlanding.slider_group');

        if (($names = $this->request()->getArray('delete', []))) {
            $model->delete($names);
            $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                _p('Successfully deleted'));
        }
        $this->template()
            ->setTitle(_p('Slider Groups'))
            ->setBreadCrumb(_p('Slider Groups'))
            ->assign('groups', $model->all());
    }

}