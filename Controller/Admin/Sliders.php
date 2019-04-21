<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;

class Sliders extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $model = Phpfox::getService('cmlanding.sliders');

        if (($names = $this->request()->getArray('delete', []))) {
            $model->delete($names);
            $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                _p('Successfully deleted'));
        }
        $this->template()
            ->setTitle(_p('Sliders'))
            ->setBreadCrumb(_p('Sliders'))
            ->setHeader('cache', array(
                    'drag.js' => 'static_script',
                    'jquery/plugin/jquery.scrollTo.js' => 'static_script',
                )
            )->setHeader([
                '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'.js_drag_drop\', ajax: \'cmlanding.sliderOrdering\'}); }</script>',
            ])
            ->assign('slides', $model->getGrouped());
    }

}