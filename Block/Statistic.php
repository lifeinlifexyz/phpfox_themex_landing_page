<?php
namespace Apps\CM_Landing\Block;

class Statistic extends \Phpfox_Component
{
    public function process()
    {
        $this->template()->assign([
            'statistics' => \Phpfox::getService('cmlanding.statistic')->getActive(),
        ]);
        return 'block';
    }
}