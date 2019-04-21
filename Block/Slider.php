<?php
namespace Apps\CM_Landing\Block;

class Slider extends \Phpfox_Component
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
                'info' => _p('Slider Group'),
                'description' => _p('Slides from group'),
                'value' => 'main',
                'var_name' => 'group_name',
                'type' => 'select',
                'options' => \Phpfox::getService('cmlanding.slider_group')->pluck()
            ]
        ];
    }

    public function process()
    {
        $group = $this->getParam('group_name', 'main');
        $this->template()->assign([
            'sliders' => \Phpfox::getService('cmlanding.sliders')->getByGroup($group),
            'group' => str_replace(' ', '', $group)
        ]);
        return 'block';
    }
}