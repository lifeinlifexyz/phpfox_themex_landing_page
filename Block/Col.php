<?php
namespace Apps\CM_Landing\Block;

class Col extends \Phpfox_Component
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
                'info' => _p('Section cols'),
                'value' => [],
                'var_name' => 'ids',
                'type' => 'multi_checkbox',
                'options' => \Phpfox::getService('cmlanding.col')->pluck()
            ]
        ];
    }

    public function process()
    {
        $ids = $this->getParam('ids', []);
        $this->template()->assign([
            'aItems' => \Phpfox::getService('cmlanding.col')->getByIds($ids),
        ]);
        return 'block';
    }
}