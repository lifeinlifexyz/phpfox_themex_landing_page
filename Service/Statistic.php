<?php

namespace Apps\CM_Landing\Service;

use Phpfox;
use Phpfox_Error;

class Statistic extends \Phpfox_Service
{

    protected $_sTable = ':cm_statistic';

    public function all()
    {
        return $this->database()
            ->select("*")
            ->from($this->_sTable)
            ->order('ordering')
            ->executeRows();
    }

    public function get($id)
    {
        return $this->database()->select('*')->from($this->_sTable)->where('id='.$id)->executeRow();
    }

    public function getActive()
    {
        return $this->database()
            ->select('*')
            ->from($this->_sTable)
            ->where('is_active=1')
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

        return [
          'title' => $titlePhrase,
        ];
    }

    public function create($aVals)
    {
        $aInsert = $this->getText($aVals);
        $aInsert['icon'] = $aVals['icon'];
        $aInsert['count'] = $aVals['count'];
        $aInsert['is_active'] = $aVals['is_active'] ?: 1;
        $this->database()->insert($this->_sTable, $aInsert);
    }

    public function update($id, $aVals)
    {
        $aInsert = $this->getText($aVals);
        $aInsert['icon'] = $aVals['icon'];
        $aInsert['count'] = $aVals['count'];
        $aInsert['is_active'] = $aVals['is_active'] ?: 1;
        $this->database()->update($this->_sTable, $aInsert, 'id='.$id);
    }

    public function delete($ids)
    {
        foreach ((array)$ids as $id) {
            $this->database()->delete($this->_sTable, '`id`= ' . $id);
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