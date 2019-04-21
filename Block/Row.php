<?php
namespace Apps\CM_Landing\Block;

class Row extends \Phpfox_Component
{
    //..
    /**
     * Settings of block
     * @return array
     */
    public function getSettings()
    {
        return [
            [
                'info' => _p('Section rows'),
                'value' => [],
                'var_name' => 'ids',
                'type' => 'multi_checkbox',
                'options' => \Phpfox::getService('cmlanding.row')->pluck()
            ]
        ];
    }

    public function process()
    {
        $ids = $this->getParam('ids', []);
        $this->template()->assign([
            'aItems' => \Phpfox::getService('cmlanding.row')->getByIds($ids),
        ]);
        return 'block';
    }
}