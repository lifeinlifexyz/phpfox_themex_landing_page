<?php

defined('PHPFOX') or exit('NO DICE!');

?>
<div class="table_header">
    {_p('Slides')}
    <ul class="list-inline pull-right">
        <li>
            <a href="{url link='admincp.cmlanding.slider.groups.add'}" class="btn btn-primary popup">{_p('Add Slider Group')}</a>
        </li>
        <li>
            <a href="{url link='admincp.cmlanding.sliders.add'}" class="btn btn-primary popup">{_p('Add Slider')}</a>
        </li>
    </ul>
</div>
{if count($slides)}
<div class="panel panel-default">
    <form method="post" action="{url link='current'}">
        <div class="panel-group" id="accordion">
            {foreach from=$slides item=aSlides key=group}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="toggle-slider" data-toggle="collapse" data-parent="#accordion" href="#{md5($group)}" style="display: block">
                            <span class="glyphicon glyphicon-plus"></span>
                            {$group}
                        </a>
                    </h4>
                </div>
                <div id="{md5($group)}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-admin js_drag_drop" id="_sort" data-sort-url="{url link='admincp.cmlanding.sliders.order'}">
                                <tr>
                                    <th style="width:10px;">
                                        <input type="checkbox" name="delete[]" value="" id="js_check_box_all"
                                               class="main_checkbox"/>
                                    </th>
                                    <th style="width:20px;"></th>
                                    <th style="width:20px;"></th>
                                    <th style="width: 120px">{_p('Slide photo')}</th>
                                    <th>{_p('Title')}</th>
                                    <th>{_p('Description')}</th>
                                </tr>
                                {foreach from=$aSlides key=iKey item=aItem}
                                <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" data-sort-id="{$aItem.id}">
                                    <td><input type="checkbox" name="delete[]" class="checkbox" value="{$aItem.id}"
                                               id="js_id_row{$aItem.id}"/></td>
                                    <td class="t_center">
                                        <i class="fa fa-sort"></i>
                                    </td>
                                    <td class="t_center">
                                        <a href="#" class="js_drop_down_link" title="Manage">{img
                                            theme='misc/bullet_arrow_down.png'
                                            alt=''}</a>

                                        <div class="link_menu">
                                            <ul>
                                                <li><a class="popup"
                                                       href="{url link='admincp.cmlanding.sliders.add' id=$aItem.id}">{_p('Edit')}</a>
                                                </li>
                                                <li><a href="{url link='current' delete[]=$aItem.id}"
                                                       onclick="return confirm('{phrase var='core.are_you_sure'}');">{_p('Delete')}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td style="width: 120px">
                                        {img path='core.url_pic' file='landing/'.$aItem.image_path suffix='_50'
                                        max_width=40 server_id=$aItem.server_id}
                                    </td>
                                    <td>
                                        {_p var=$aItem.title}
                                    </td>
                                    <td>
                                        {_p var=$aItem.description}
                                    </td>
                                    {*<td class="t_center">
                                        <div class="js_item_is_active"{if !$aItem.is_active} style="display:none;"{/if}>
                                            <a href="#?call=cmlanding.setSliderStatus&amp;id={$aItem.id}&amp;active=0" class="js_item_active_link" title="{_p var='Deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
                                        </div>
                                        <div class="js_item_is_not_active"{if $aItem.is_active} style="display:none;"{/if}>
                                            <a href="#?call=cmlanding.setSliderStatus&amp;id={$aItem.id}&amp;active=1" class="js_item_active_link" title="{_p var='Activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
                                        </div>
                                    </td>*}
                                </tr>
                                {/foreach}
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            {/foreach}
        </div>
        <div class="table_bottom">
            <input type="submit" value="{_p('Delete selected')}"
                   class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true"/>
        </div>
    </form>
</div>
{literal}
<script type="text/javascript">
    $Ready(function() {
        $('.toggle-slider').click(function(){
            if ($(this).find('.glyphicon').hasClass('glyphicon-minus')) {
                $(this).find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
            } else {
                $(this).find('.glyphicon').addClass('glyphicon-minus').removeClass('glyphicon-plus');
            }
        });
    });
</script>
{/literal}
{/if}