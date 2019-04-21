<?php
namespace Apps\CM_Landing\Block;

class User extends \Phpfox_Component
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
                'info' => _p('Sort users'),
                'value' => 'main',
                'var_name' => 'sort',
                'type' => 'select',
                'options' => [
                    'popular' => _p('Popular'),
                    'latest' => _p('Latest')
                ]
            ],
            [
                'info' => _p('How many user to show?'),
                'value' => 9,
                'var_name' => 'limit',
                'type' => 'integer',
            ]
        ];
    }

    public function process()
    {
        $sort = $this->getParam('sort', 'popular');
        $limit = $this->getParam('limit', 9);
        $titleMap = [
          'popular' => _p('Popular members'),
          'latest' => _p('Latest members'),
        ];
        $aUsers = \Phpfox::getService('cmlanding.user')->get($sort, $limit);
        foreach ($aUsers as &$aItem) {
            $pUsersInfo = [
                'title' => $aItem['full_name'],
                'path' => 'core.url_user',
                'file' => $aItem['user_image'],
                'suffix' => '_200_square',
                'width' => 200,
                'height' => 200,
                'no_default' => (\Phpfox::getUserId() == $aItem['user_id'] ? false : true),
                'thickbox' => true,
                'class' => 'profile_user_image _size__200',
                'no_link' => true
            ];
            $aItem['profile_image'] = \Phpfox::getLib('image.helper')->display(array_merge(['user' => \Phpfox::getService('user')->getUserFields(true, $aItem)], $pUsersInfo));
        }
        $this->template()->assign([
            'users' => $aUsers,
            'title' => $titleMap[$sort],
        ]);
        return 'block';
    }
}