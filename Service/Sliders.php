<?php

namespace Apps\CM_Landing\Service;

use Phpfox;
use Phpfox_Error;

class Sliders extends \Phpfox_Service
{

    protected $_sTable = ':cm_slider';

    public function all()
    {
        return $this->database()
            ->select("*")
            ->from($this->_sTable)
            ->order('ordering')
            ->execute('getslaverows');
    }

    public function getGrouped()
    {
        $all = $this->all();
        $result = [];
        foreach($all as &$slide) {
            $result[$slide['group_name']][] = $slide;
        }
        return $result;
    }

    public function get($id)
    {
        return $this->database()->select('*')->from($this->_sTable)->where('id='.$id)->executeRow();
    }

    public function getByGroup($group)
    {
        return $this->database()
            ->select('*')
            ->from($this->_sTable)
            ->where('group_name="'.$group.'" and is_active=1')
            ->order('ordering')
            ->executeRows();
    }

    protected function getText($aVals, $bUpdate = false)
    {
        $aLanguages = Phpfox::getService('language')->getAll();
        $name = $aVals['title_' . $aLanguages[0]['language_id']];
        $phrase_var_name = 'slider_title_' . md5('Slider Title' . $name . PHPFOX_TIME);
        //Add phrases
        $aText = [];
        foreach ($aLanguages as $aLanguage) {
            if (isset($aVals['title_' . $aLanguage['language_id']]) && !empty($aVals['title_' . $aLanguage['language_id']])) {
                $aText[$aLanguage['language_id']] = $aVals['title_' . $aLanguage['language_id']];
            } else {
                return Phpfox_Error::set((_p('Provide a "{{ language_name }}" name.',
                    ['language_name' => $aLanguage['title']])));
            }
        }
        $aValsPhrase = [
            'var_name' => $phrase_var_name,
            'text'     => $aText,
            'update'     => $bUpdate
        ];
        $titlePhrase = Phpfox::getService('language.phrase.process')->add($aValsPhrase);

        $name = $aVals['description_' . $aLanguages[0]['language_id']];
        $phrase_var_name = 'description_title_' . md5('Description Title' . $name . PHPFOX_TIME);
        //Add phrases
        $aText = [];
        foreach ($aLanguages as $aLanguage) {
            if (isset($aVals['description_' . $aLanguage['language_id']]) && !empty($aVals['description_' . $aLanguage['language_id']])) {
                $aText[$aLanguage['language_id']] = $aVals['description_' . $aLanguage['language_id']];
            } else {
                return Phpfox_Error::set((_p('Provide a "{{ language_name }}" name.',
                    ['language_name' => $aLanguage['title']])));
            }
        }
        $aValsPhrase = [
            'var_name' => $phrase_var_name,
            'text'     => $aText,
            'update'     => $bUpdate
        ];
        $descPhrase = Phpfox::getService('language.phrase.process')->add($aValsPhrase);
        return [
          'title' => $titlePhrase,
          'description' => $descPhrase,
        ];
    }

    public function create($aVals)
    {
        $aInsert = $this->getText($aVals);
        $aInsert['group_name'] = $aVals['group_name'];
        $aInsert['is_active'] = $aVals['is_active'] ?: 1;
        if (!empty($aVals['temp_file'])) {
            //Get detail of this file
            $aFile = Phpfox::getService('core.temp-file')->get($aVals['temp_file']);
            if (!empty($aFile)) {
                //Set value for `image_path` and `server_id` column based on data of temp file
                $aInsert['image_path'] = $aFile['path'];
                $aInsert['server_id'] = $aFile['server_id'];
                Phpfox::getService('core.temp-file')->delete($aVals['temp_file']);
            }
        }
        $this->database()->insert($this->_sTable, $aInsert);
    }

    public function update($id, $aVals)
    {
        $aInsert = $this->getText($aVals);
        $aInsert['group_name'] = $aVals['group_name'];
        $aInsert['is_active'] = $aVals['is_active'] ?: 1;

        if (!empty($aVals['temp_file'])) {
            //Get detail of this file
            $aFile = Phpfox::getService('core.temp-file')->get($aVals['temp_file']);
            if (!empty($aFile)) {
                //Set value for `image_path` and `server_id` column based on data of temp file
                $aInsert['image_path'] = $aFile['path'];
                $aInsert['server_id'] = $aFile['server_id'];
                Phpfox::getService('core.temp-file')->delete($aVals['temp_file']);
            }
        }
        $this->database()->update($this->_sTable, $aInsert, 'id='.$id);
    }

    public function delete(array $ids)
    {
        foreach ($ids as $id) {
            $this->database()->delete($this->_sTable, 'id=' . (int) $id);
        }
        return $this;
    }

    public function updateOrder($aVals)
    {
        $iCnt = 0;
        foreach ($aVals as $iId) {
            $iCnt++;
            $this->database()->update($this->_sTable, ['ordering' => $iCnt], 'id = ' . (int)$iId);
        }
        return true;
    }

    public function setStatus($iId, $iStatus)
    {
        $iId = (int) $iId;
        return $this->database()->update($this->_sTable,
            ['`is_active`' => $iStatus], '`id` = ' . $iId);
    }
}