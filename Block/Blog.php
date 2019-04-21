<?php
namespace Apps\CM_Landing\Block;

use Phpfox;
use Phpfox_Plugin;

class Blog extends \Phpfox_Component
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
                'info' => _p('Sort blogs'),
                'value' => 'main',
                'var_name' => 'sort',
                'type' => 'select',
                'options' => [
                    'latest' => _p('Latest blogs'),
                    'most_discussed' => _p('Most discussed blogs'),
                    'most_viewed' => _p('Most viewed blogs')
                ]
            ],
            [
                'info' => _p('How many blogs to show?'),
                'value' => 9,
                'var_name' => 'limit',
                'type' => 'integer',
            ]
        ];
    }

    public function process()
    {
        if (!Phpfox::isModule('blog')) {
            return false;
        }

        if (!Phpfox::getUserParam('blog.view_blogs')) {
            return false;
        }

        $aType = $this->_getType();

        $sRequestView = $this->request()->get('view');
        $sView = 'blogs';
        $this->request()->set('view', $sView);

        $aSort = $aType['sort'];

        $sViewMoreUrl = $this->url()->makeUrl('blog', [
            'view' => $sView,
            'sort' => key($aType['sort']),
        ]);

        $aBlogDisplays = [
            Phpfox::getParam('limit'),
        ];
        $aSearchParam = [
            'type' => 'blog',
            'field' => 'blog.blog_id',
            'search_tool' => [
                'table_alias' => 'blog',
                'sort' => $aSort,
                'show' => (array)$aBlogDisplays,
            ],
        ];

        $this->search()->browse()->reset();
        $this->search()->reset();

        $this->search()->set($aSearchParam);
        $aBrowseParams = [
            'module_id' => 'blog',
            'alias' => 'blog',
            'field' => 'blog_id',
            'table' => Phpfox::getT('blog'),
            'hide_view' => ['pending', 'my']
        ];

        $aPage = $this->getParam('aPage');
        $sCondition = "AND blog.is_approved = 1 AND blog.post_status = 1" . (Phpfox::getUserParam('privacy.can_comment_on_all_items') ? "" : " AND blog.privacy IN(%PRIVACY%)");
        if (isset($aPage['privacy']) && $aPage['privacy'] == 1) {
            $sCondition = "AND blog.is_approved = 1 AND blog.privacy IN(%PRIVACY%, 1) AND blog.post_status = 1";
        }
        $this->search()->setCondition($sCondition);

        http_cache()->set();

        $this->search()->browse()->params($aBrowseParams)->execute();

        $ablogs = $this->search()->browse()->getRows();
        if (!count($ablogs)) {
            return false;
        }

        foreach ($ablogs as $iKey => $ablog) {
            $ablog['can_view'] = true;
            $ablog['url_photo'] = $this->_getStringBetween($ablog['text'], '[img]', '[/img]');
            $ablog['link'] = Phpfox::permalink('blog', $ablog['blog_id'], $ablog['title']);
            $ablog['parsed_text'] = preg_replace("/\[img\].*\[\/img\]/",'',$ablog['text']);
            $ablogs[$iKey] = $ablog;
        }

        $this->template()->assign([
            'sTitle' => $aType['title'],
            'aBlogs' => $ablogs,
            'sViewMoreUrl' => $sViewMoreUrl,
        ]);

        (($sPlugin = Phpfox_Plugin::get('cmmaterial.component_block_blogs_process')) ? eval($sPlugin) : false);

        // Revert request view
        $this->request()->set('view', $sRequestView);

        return 'block';
    }

    private function _getStringBetween($sStr, $sFrom, $sTo)
    {
        $sSub = substr($sStr, strpos($sStr,$sFrom)+strlen($sFrom),strlen($sStr));
        return  substr($sSub,0,strpos($sSub,$sTo));
    }

    private function _getType()
    {
        $aTypes = [
            'latest' => [
                'title' => _p('Latest blogs'),
                'sort' => [
                    'latest' => ['blog.blog_id', _p('Latest blogs')],
                ],
            ],
            'most_viewed' => [
                'title' => _p('Most viewed blogs'),
                'sort' => [
                    'most-viewed' => ['blog.total_view', _p('blog.most_viewed')],
                ],
            ],
            'most_discussed' => [
                'title' => _p('Most discussed blogs'),
                'sort' => [
                    'most-talked' => ['blog.total_comment', _p('blog.most_discussed')],
                ],
            ],
        ];

        $sParam = Phpfox::getParam('sort');

        return isset($aTypes[$sParam]) ? $aTypes[$sParam] : $aTypes['latest'];
    }
}