<?php

namespace Apps\CM_Landing\Service;

use Apps\CM_Landing\Lib\Form\DataBinding\FormlyTrait;
use Apps\CM_Landing\Lib\Form\DataBinding\IFormly;
use Phpfox;

class User extends \Phpfox_Service
{
    protected $_sTable = ':user';
    protected $sTableFields = ':user_field';
    protected $sTablePhoto = ':photo';


    public function get($sort='popular', $limit = 9)
    {
        $oCache = $this->cache()->set('popular_users_' . $sort . $sort);
        $aUsers = $this->cache()->get($oCache, 360);
        if ($aUsers === false) {
            $sortMaps = [
              'popular' => 'popular_field DESC',
              'latest' => 'user DESC',
            ];
            $aUsers = $this->database()->select('u.*,uf.*,(0.3*uf.total_view)+(1*uf.total_friend) AS popular_field')
                ->from($this->sTableFields, 'uf')
                ->join($this->_sTable, 'u', 'u.user_id = uf.user_id')
                ->order($sortMaps[$sort])
                ->where("profile_page_id = 0")
                ->limit($limit)
                ->executeRows();
            $this->cache()->save($oCache, $aUsers);
        }
        return  $aUsers;
    }
}