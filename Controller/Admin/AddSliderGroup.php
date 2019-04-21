<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;
use Phpfox_Validator;

class AddSliderGroup extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $model = Phpfox::getService('cmlanding.slider_group');
        $aValidation = [
            'name' => [
                'def' => 'required',
                'title' => _p('Name is required'),
            ],
        ];

        $oValid = Phpfox_Validator::instance()->set(array(
            'sFormName' => 'cmlanding_js_slider_group_form',
            'aParams' => $aValidation,
        ));
        if ($aInput = $this->request()->getArray('val')) {
            if ($oValid->isValid($aInput)) {
                $model->create($aInput);
                $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                    _p('Successfully saved the slider group'));
            }
        }

        $title = _p('Add slider group');
        $this->template()
            ->setTitle($title)
            ->setBreadCrumb($title)
            ->assign([
                'sCreateJs' => $oValid->createJS(),
                'sGetJsForm' => $oValid->getJsForm(),
            ]);
    }
}