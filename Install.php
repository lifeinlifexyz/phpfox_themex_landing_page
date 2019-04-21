<?php

namespace Apps\CM_Landing;

use Core\App;

/**
 * Class Install
 * @author  Neil J. <neil@phpfox.com>
 * @version 4.6.0
 * @package Apps\CM_Landing
 */
class Install extends App\App
{
    private $_app_phrases = [

    ];

    protected function setId()
    {
        $this->id = 'CM_Landing';
    }

    protected function setAlias()
    {
        $this->alias = 'cmlanding';
    }

    protected function setName()
    {
        $this->name = 'Landing Page';
    }

    protected function setVersion()
    {
        $this->version = '4.1.0';
    }

    protected function setSupportVersion()
    {
        $this->start_support_version = '4.6.1';
        $this->end_support_version = '4.6.1';
    }

    protected function setSettings()
    {
        $this->settings = [
        ];
    }

    protected function setUserGroupSettings()
    {
    }

    protected function setComponent()
    {
        $this->component = [
            'block'      => [
                'slider' => 'cmlanding.slider',
                'user' => 'cmlanding.user',
                'blog' => 'cmlanding.blog',
                'photo' => 'cmlanding.photo',
                'statistic' => 'cmlanding.statistic',
                'feed' => 'cmlanding.feed',
                'col' => 'cmlanding.col',
                'row' => 'cmlanding.row',
            ],
            'controller' => [
                'index-visitor'   => 'cmlanding.index-visitor',
            ]
        ];
    }

    protected function setComponentBlock()
    {
        $this->component_block = [
            "Visitor main slider" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "slider",
                "location"     => "6",
                "is_active"    => "1",
                "ordering"     => "1"
            ],
            "Section collumns" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "col",
                "location"     => "7",
                "is_active"    => "1",
                "ordering"     => "1"
            ],
            "Blogs" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "blog",
                "location"     => "2",
                "is_active"    => "1",
                "ordering"     => "1"
            ],
            "Photos" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "photo",
                "location"     => "2",
                "is_active"    => "1",
                "ordering"     => "2"
            ],
            "Statistics" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "statistic",
                "location"     => "2",
                "is_active"    => "1",
                "ordering"     => "3"
            ],
            "Members" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "user",
                "location"     => "2",
                "is_active"    => "1",
                "ordering"     => "4"
            ],
            "Section rows" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "row",
                "location"     => "2",
                "is_active"    => "1",
                "ordering"     => "5"
            ],
            "News feed" => [
                "type_id"      => "0",
                "m_connection" => "cmlanding.index-visitor",
                "component"    => "feed",
                "location"     => "2",
                "is_active"    => "1",
                "ordering"     => "6"
            ],
        ];
    }

    protected function setPhrase()
    {
        $this->phrase = $this->_app_phrases;
    }

    protected function setOthers()
    {
        $this->_writable_dirs = [
            'PF.Base/file/pic/landing/'
        ];
        $this->_publisher = 'CodeMake It';
        $this->_publisher_url = 'http://codemake.org/';

        $this->admincp_route = 'admincp.cmlanding.blocks';

        $this->admincp_menu = [
            'Sliders' => 'cmlanding.sliders',
            'Statistics' => 'cmlanding.statistics',
            'Landing' => 'cmlanding.blocks',
            'Section rows' => 'cmlanding.rows',
            'Section cols' => 'cmlanding.cols',
        ];

        $this->database = [
            'SectionRow',
            'SectionCol',
            'Slider',
            'Statistic',
            'Slider_Group',
            'Slider_Text'
        ];
    }
}