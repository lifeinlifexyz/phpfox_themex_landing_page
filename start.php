<?php
\Phpfox_Module::instance()
    ->addServiceNames([
        'cmlanding.slider_group' => \Apps\CM_Landing\Service\SliderGroup::class,
        'cmlanding.sliders' => \Apps\CM_Landing\Service\Sliders::class,
        'cmlanding.callback' => \Apps\CM_Landing\Service\Callback::class,
        'cmlanding.user' => \Apps\CM_Landing\Service\User::class,
        'cmlanding.statistic' => \Apps\CM_Landing\Service\Statistic::class,
        'cmlanding.row' => \Apps\CM_Landing\Service\Row::class,
        'cmlanding.col' => \Apps\CM_Landing\Service\Col::class,
    ])
    ->addComponentNames('controller', [
        'cmlanding.admincp.add-slider-group' => \Apps\CM_Landing\Controller\Admin\AddSliderGroup::class,
        'cmlanding.admincp.slider-groups' => \Apps\CM_Landing\Controller\Admin\SliderGroups::class,
        'cmlanding.admincp.add-slider' => \Apps\CM_Landing\Controller\Admin\AddSlider::class,
        'cmlanding.admincp.add-statistic' => \Apps\CM_Landing\Controller\Admin\AddStatistic::class,
        'cmlanding.admincp.sliders' => \Apps\CM_Landing\Controller\Admin\Sliders::class,
        'cmlanding.admincp.rows' => \Apps\CM_Landing\Controller\Admin\Rows::class,
        'cmlanding.admincp.cols' => \Apps\CM_Landing\Controller\Admin\Cols::class,
        'cmlanding.admincp.statistic' => \Apps\CM_Landing\Controller\Admin\Statistic::class,
        'cmlanding.admincp.blocks' => \Apps\CM_Landing\Controller\Admin\Block\Index::class,
        'cmlanding.admincp.block-add' => \Apps\CM_Landing\Controller\Admin\Block\Add::class,
        'cmlanding.admincp.add-row' => \Apps\CM_Landing\Controller\Admin\AddRow::class,
        'cmlanding.admincp.add-col' => \Apps\CM_Landing\Controller\Admin\AddCol::class,
        'cmlanding.index-visitor' => \Apps\CM_Landing\Controller\IndexVisitor::class,
    ])->addComponentNames('ajax', [
        'cmlanding.ajax' => \Apps\CM_Landing\Ajax\Ajax::class,
    ])->addComponentNames('block', [
        'cmlanding.slider' => \Apps\CM_Landing\Block\Slider::class,
        'cmlanding.user' => \Apps\CM_Landing\Block\User::class,
        'cmlanding.blog' => \Apps\CM_Landing\Block\Blog::class,
        'cmlanding.photo' => \Apps\CM_Landing\Block\Photo::class,
        'cmlanding.statistic' => \Apps\CM_Landing\Block\Statistic::class,
        'cmlanding.feed' => \Apps\CM_Landing\Block\Feed::class,
        'cmlanding.col' => \Apps\CM_Landing\Block\Col::class,
        'cmlanding.row' => \Apps\CM_Landing\Block\Row::class,
    ])
    ->addAliasNames('cmlanding', 'CM_Landing')
    ->addTemplateDirs([
        'cmlanding' => PHPFOX_DIR_SITE_APPS . 'CM_Landing' . PHPFOX_DS . 'views',
    ]);

group('/admincp/cmlanding/', function () {
    route('/blocks', 'cmlanding.admincp.blocks');
    route('/block-add', 'cmlanding.admincp.block-add');
    route('slider/groups/add', 'cmlanding.admincp.add-slider-group');
    route('slider/groups', 'cmlanding.admincp.slider-groups');

    route('sliders/add', 'cmlanding.admincp.add-slider');
    route('sliders', 'cmlanding.admincp.sliders');
    route('sliders/order', function(){
        \Phpfox::isAdmin(true);
        $aOrder = explode(',', request()->get('ids'));
        Phpfox::getService('cmlanding.sliders')->updateOrder($aOrder);
    });

    route('rows/add', 'cmlanding.admincp.add-row');
    route('rows', 'cmlanding.admincp.rows');
    route('rows/order', function(){
        \Phpfox::isAdmin(true);
        $aOrder = explode(',', request()->get('ids'));
        Phpfox::getService('cmlanding.row')->updateOrder($aOrder);
    });

    route('cols/add', 'cmlanding.admincp.add-col');
    route('cols', 'cmlanding.admincp.cols');
    route('cols/order', function(){
        \Phpfox::isAdmin(true);
        $aOrder = explode(',', request()->get('ids'));
        Phpfox::getService('cmlanding.col')->updateOrder($aOrder);
    });

    route('statistics/add', 'cmlanding.admincp.add-statistic');
    route('statistics', 'cmlanding.admincp.statistic');
    route('statistics/order', function(){
        \Phpfox::isAdmin(true);
        $aOrder = explode(',', request()->get('ids'));
        Phpfox::getService('cmlanding.statistic')->updateOrder($aOrder);
    });
});