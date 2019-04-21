<?php

namespace Apps\CM_Landing\Service;

use Phpfox;

class Callback extends \Phpfox_Service
{

    protected $_sTable = ':cm_slider';

    public function getUploadParams()
    {
        return array(
            'max_size' => null,
            'type_list' => ['jpg', 'jpeg', 'gif', 'png'],
            'upload_dir' => Phpfox::getParam('core.dir_pic') . 'landing' . PHPFOX_DS,
            'upload_path' => Phpfox::getParam('core.url_pic') . 'landing/' ,
            'thumbnail_sizes' => array(120, 240, 1024),
            'label' => _p('Image'),
            'is_required' => true
        );
    }
}