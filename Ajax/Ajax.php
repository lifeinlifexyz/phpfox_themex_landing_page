<?php
namespace Apps\CM_Landing\Ajax;

use Phpfox;
use Phpfox_Ajax;

class Ajax extends Phpfox_Ajax
{
    public function setFieldStatus()
    {
        \Phpfox::isAdmin(true);
        \Phpfox::getService('cmlanding.sliders')->setStatus($this->get('id'), $this->get('active'));
    }

}