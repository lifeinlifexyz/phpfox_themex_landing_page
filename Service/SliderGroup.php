<?php

namespace Apps\CM_Landing\Service;

use Apps\CM_Landing\Lib\Form\DataBinding\FormlyTrait;
use Apps\CM_Landing\Lib\Form\DataBinding\IFormly;
use Phpfox;

class SliderGroup extends \Phpfox_Service
{
    protected $_sTable = ':cm_slider_group';


    public function all()
    {
        return $this->database()
            ->select("*")
            ->from($this->_sTable)
            ->execute('getslaverows');
    }

    public function pluck()
    {
        $list = $this->database()
            ->select("*")
            ->from($this->_sTable)
            ->execute('getslaverows');

        $result = [
            'main' => 'Main'
        ];

        foreach ($list as $item) {
            $result[$item['name']] = ucfirst($item['name']);
        }

        return $result;
    }

    public function get($name)
    {
        return $this->database()->select('*')->from($this->_sTable)->where(['name' => $name])->executeRow();
    }

    public function create($aVals)
    {
        $this->database()->insert($this->_sTable, $aVals);
    }

    public function delete($names)
    {
        foreach ((array)$names as $name) {
            $this->database()->delete($this->_sTable, '`name`= \'' . $name . '\'');
        }
        return $this;
    }
}