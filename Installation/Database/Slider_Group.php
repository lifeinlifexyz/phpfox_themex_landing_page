<?php

namespace Apps\CM_Landing\Installation\Database;

use Core\App\Install\Database\Field as Field;
use Core\App\Install\Database\Table as Table;

defined('PHPFOX') or exit('NO DICE!');

class Slider_Group extends Table
{
    protected function setTableName()
    {
        $this->_table_name = 'cm_slider_group';
    }

    protected function setFieldParams()
    {
        $this->_aFieldParams = [
            'name' => [
                Field::FIELD_PARAM_PRIMARY_KEY => true,
                Field::FIELD_PARAM_TYPE => Field::TYPE_CHAR,
                Field::FIELD_PARAM_TYPE_VALUE => 255,
                Field::FIELD_PARAM_OTHER => 'NOT NULL'
            ],
        ];
    }
}
