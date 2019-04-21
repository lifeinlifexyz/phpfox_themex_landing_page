<?php

namespace Apps\CM_Landing\Controller\Admin;

use Phpfox;
use Phpfox_Component;
use Phpfox_Validator;

class AddRow extends Phpfox_Component
{
    public function process()
    {
        Phpfox::isAdmin();
        $bIsEdit = false;
        $model = Phpfox::getService('cmlanding.row');
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
            'subtitle_en' => [
                'def' => 'required',
                'title' => _p('Sub title is required'),
            ],
        ];


        $oValid = Phpfox_Validator::instance()->set([
            'sFormName' => 'cmlanding_js_row_form',
            'aParams' => $aValidation,
        ]);

        if ($aInput = $this->request()->getArray('val')) {
            if ($oValid->isValid($aInput)) {
                if ($bIsEdit) {
                    $model->update($iEditId, $aInput);
                } else {
                    $model->create($aInput);
                }
                $this->url()->send('admincp.app', ['id' => 'CM_Landing'],
                    _p('Successfully saved the row section'));
            }
        }

        $title = !empty($iEditId) ? _p('Edit row section') : _p('Add row section');
        $this->template()
            ->setTitle($title)
            ->setBreadCrumb($title)
            ->assign([
                'sCreateJs' => $oValid->createJS(),
                'sGetJsForm' => $oValid->getJsForm(),
            ]);
    }
}