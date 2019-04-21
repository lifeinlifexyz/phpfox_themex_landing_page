<?php

namespace Apps\CM_Landing\Controller;

use Phpfox;
use Phpfox_Image_Helper;
use Phpfox_Plugin;

class IndexVisitor extends \Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        if ($sPlugin = Phpfox_Plugin::get('core.component_controller_index_visitor_start')) {
            eval($sPlugin);
        }

        $image = [];
        list(, $featured) = Phpfox::getService('photo')->getFeatured();
        if (is_array($featured) && isset($featured[0])) {
            $photo = $featured[0];
            $url = Phpfox_Image_Helper::instance()->display([
                'server_id' => $photo['server_id'],
                'path' => 'photo.url_photo',
                'file' => $photo['destination'],
                'suffix' => '_1024',
                'return_url' => true
            ]);
            $image = [
                'image' => $url,
                'info' => strip_tags($photo['title']) . ' by ' . $photo['full_name']
            ];
        }

        if (!$image) {
            $images = [
                'create-a-community-for-musicians.jpg' => _p('creating_communities_for_musicians'),
                'create-a-community-for-athletes.jpg' => _p('creating_communities_for_athletes'),
                'create-a-community-for-photographers.jpg' => _p('creating_communities_for_photographers'),
                'create-a-social-network-for-fine-cooking.jpg' => _p('creating_communities_for_fine_cooking')
            ];
            $total = rand(1, (count($images)));
            $image = [];
            $cnt = 0;
            foreach ($images as $image => $info) {
                $cnt++;
                $image = [
                    'image' => 'https://cdnbg.phpfox.com/' . $image,
                    'info' => $info
                ];
                if ($cnt === $total) {
                    break;
                }
            }
        }

        $content = '';
        if ($sPlugin = Phpfox_Plugin::get('core.component_controller_index_visitor_end')) {
            eval($sPlugin);
        }

        $this->template()->setHeader('cache', [
                'owl.carousel.min.css' => '@CM_Landing',
                'owl.theme.default.min.css' => '@CM_Landing',
                'owl.carousel.min.js' => '@CM_Landing',
            ]
        )
            ->setBreadCrumb(Phpfox::getParam('core.site_title'))
            ->setPhrase([
                    'continue'
                ]
            )->assign([
                    'aSettings' => Phpfox::getService('custom')->getForEdit([
                        'user_main',
                        'user_panel',
                        'profile_panel'
                    ], null, null, true),
                    'image' => $image,
                    'content' => $content,
                    'bEnable2StepVerification' => Phpfox::getParam('user.enable_2step_verification'),
                ]
            );
    }
}