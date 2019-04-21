<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;
use Phpfox_Validator;

class AddSlider extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $bIsEdit = false;
        $model = Phpfox::getService('cmlanding.sliders');
        if ($iEditId = $this->request()->getInt('id')) {
            $bIsEdit = true;
            $aItem = $model->get($iEditId);
            $this->template()->assign('aForms', $aItem);
        }

        $aValidation = [
            'title_en' => [
                'def' => 'required',
                'title' => _p('Title is required'),
            ],
            'description_en' => [
                'def' => 'required',
                'title' => _p('Description is required'),
            ],
        ];


        $oValid = Phpfox_Validator::instance()->set([
            'sFormName' => 'cmlanding_js_slider_form',
            'aParams' => $aValidation,
        ]);

        if ($aInput = $this->request()->getArray('val')) {
            if ($aImage = $this->request()->get('image')) {
                if (!empty($aImage['name'])) {
                    $aInput['image'] = $aImage['name'];
                }
            }

            if ($oValid->isValid($aInput)) {
                if ($bIsEdit) {
                    $model->update($iEditId, $aInput);
                } else {
                    $model->create($aInput);
                }
                $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                    _p('Successfully saved the slide'));
            }
        }

        $title = !empty($iEditId) ? _p('Edit slide') : _p('Add slide');
        $this->template()
            ->setTitle($title)
            ->setBreadCrumb($title)
            ->assign([
                'sCreateJs' => $oValid->createJS(),
                'sGetJsForm' => $oValid->getJsForm(),
                'aGroups' => Phpfox::getService('cmlanding.slider_group')->pluck()
            ]);
    }
}