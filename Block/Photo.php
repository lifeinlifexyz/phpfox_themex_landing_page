<?php
namespace Apps\CM_Landing\Block;

use Phpfox;
use Phpfox_Plugin;

class Photo extends \Phpfox_Component
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
                'info' => _p('Sort photos'),
                'value' => 'latest',
                'var_name' => 'sort',
                'type' => 'select',
                'options' => [
                    'latest' => _p('Latest photos'),
                    'most_discussed' => _p('Most discussed photos'),
                    'most_viewed' => _p('Most viewed photos')
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

    /**
     *
     */
    public function process()
    {
        if (!Phpfox::isModule('photo')) {
            return false;
        }

        if (!Phpfox::getUserParam('photo.can_view_photos')) {
            return false;
        }

        $aType = $this->_getType();

        $sRequestView = $this->request()->get('view');
        $sView = 'photos';
        $this->request()->set('view', $sView);

        $aSort = $aType['sort'];

        $sViewMoreUrl = $this->url()->makeUrl('photo', [
            'view' => $sView,
            'sort' => key($aType['sort']),
        ]);

        $aPhotoDisplays = [
            Phpfox::getParam('limit'),
        ];
        $aSearchParam = [
            'type' => 'photo',
            'field' => 'photo.photo_id',
            'search_tool' => [
                'table_alias' => 'photo',
                'sort' => $aSort,
                'show' => (array) $aPhotoDisplays,
            ],
        ];

        $this->search()->browse()->reset();
        $this->search()->reset();

        $this->search()->set($aSearchParam);
        $aBrowseParams = [
            'module_id' => 'photo',
            'alias' => 'photo',
            'field' => 'photo_id',
            'table' => Phpfox::getT('photo'),
            'hide_view' => ['pending', 'my'],
        ];

        $this->search()->setCondition('AND photo.view_id = 0 AND photo.group_id = 0 AND photo.type_id = 0 AND photo.privacy IN(%PRIVACY%)');

        if (!Phpfox::getParam('photo.display_profile_photo_within_gallery')) {
            $this->search()->setCondition('AND photo.is_profile_photo IN (0)');
        }

        $this->search()->browse()->params($aBrowseParams)->execute();

        $aPhotos = $this->search()->browse()->getRows();

        if (!count($aPhotos)) {
            return false;
        }

        foreach ($aPhotos as $key => $photo) {
            $aPhotos[$key]['can_view'] = true;
            if ($photo['user_id'] != Phpfox::getUserId()) {
                if ($photo['mature'] == 1 && Phpfox::getUserParam([
                        'photo.photo_mature_age_limit' => [
                            '>',
                            (int) Phpfox::getUserBy('age'),
                        ],
                    ])) {
                    // warning check cookie
                    $aPhotos[$key]['can_view'] = false;
                } elseif ($photo['mature'] == 2 && Phpfox::getUserParam([
                        'photo.photo_mature_age_limit' => [
                            '>',
                            (int) Phpfox::getUserBy('age'),
                        ],
                    ])) {
                    $aPhotos[$key]['can_view'] = false;
                }
            }

            $this->_processItem($aPhotos[$key]);
        }
        $this->template()->assign([
            'sTitle' => $aType['title'],
            'aPhotos' => $aPhotos,
            'sViewMoreUrl' => $sViewMoreUrl,
        ]);

        (($sPlugin = Phpfox_Plugin::get('cmlanding.component_block_photos_process')) ? eval($sPlugin) : false);

        // Revert request view
        $this->request()->set('view', $sRequestView);

        return 'block';
    }

    /**
     * @param $aPhoto
     */
    private function _processItem(&$aPhoto)
    {
        $aPhoto['original_destination'] = $aPhoto['destination'];
        $aPhoto['destination'] = Phpfox::getService('photo')->getPhotoUrl($aPhoto);

        if ($aPhoto['album_id'] > 0) {
            if ($aPhoto['album_profile_id'] > 0) {
                $aPhoto['album_title'] = _p('photo.profile_pictures');
                $aPhoto['album_url'] = Phpfox::permalink('photo.album.profile', $aPhoto['user_id'], $aPhoto['user_name']);
            } else {
                $aPhoto['album_title'] = $aPhoto['album_name'];
                $aPhoto['album_url'] = Phpfox::permalink('photo.album', $aPhoto['album_id'], $aPhoto['album_title']);
            }
        }
    }

    private function _getType()
    {
        $aTypes = [
            'latest' => [
                'title' => _p('Latest photos'),
                'sort' => [
                    'latest' => ['photo.photo_id', _p('photo.latest')],
                ],
            ],
            'most_viewed' => [
                'title' => _p('Most viewed photos'),
                'sort' => [
                    'most-viewed' => ['photo.total_view', _p('photo.most_viewed')],
                ],
            ],
            'most_discussed' => [
                'title' => _p('Most discussed photos'),
                'sort' => [
                    'most-talked' => ['photo.total_comment', _p('photo.most_discussed')],
                ],
            ],
        ];

        $sParam = Phpfox::getParam('sort');

        return isset($aTypes[$sParam]) ? $aTypes[$sParam] : $aTypes['latest'];
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('cmlanding.component_block_photos_clean')) ? eval($sPlugin) : false);
    }
}