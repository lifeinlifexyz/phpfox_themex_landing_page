<?php

defined('PHPFOX') or exit('NO DICE!');

?>
<div class="table_header">
    {_p('Section rows')}
    <ul class="list-inline pull-right">
        <li>
            <a href="{url link='admincp.cmlanding.rows.add'}" class="btn btn-primary popup">{_p('Add')}</a>
        </li>
    </ul>
</div>
{if count($rows)}
<div class="panel panel-default">
    <form method="post" action="{url link='current'}">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-admin js_drag_drop" id="_sort"
                               data-sort-url="{url link='admincp.cmlanding.rows.order'}">
                            <tr>
                                <th style="width:10px;">
                                    <input type="checkbox" name="delete[]" value="" id="js_check_box_all"
                                           class="main_checkbox"/>
                                </th>
                                <th style="width:20px;"></th>
                                <th style="width:20px;"></th>
                                <th>{_p('Id')}</th>
                                <th>{_p('Title')}</th>
                                <th>{_p('Subtitle')}</th>
                                <th>{_p('Link')}</th>
                                <th>{_p('Image')}</th>
                                <th>{_p('Background')}</th>
                                <th>{_p('Image position')}</th>
                            </tr>
                            {foreach from=$rows key=iKey item=aItem}
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
                                                   href="{url link='admincp.cmlanding.rows.add' id=$aItem.id}">{_p('Edit')}</a>
                                            </li>
                                            <li><a href="{url link='current' delete[]=$aItem.id}"
                                                   onclick="return confirm('{phrase var='core.are_you_sure'}');">{_p('Delete')}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    {$aItem.id}
                                </td>
                                <td>
                                    {_p var=$aItem.title}
                                </td>
                                <td>
                                    {_p var=$aItem.subtitle}
                                </td>
                                <td>
                                    {$aItem.link}
                                </td>
                                <td style="width: 120px">
                                    {img path='core.url_pic' file='landing/'.$aItem.image_path suffix='_50'
                                    max_width=40 server_id=$aItem.server_id}
                                </td>
                                <td>
                                    {$aItem.background}
                                </td>
                                <td>
                                    {$aItem.image_position}
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="table_bottom">
            <input type="submit" value="{_p('Delete selected')}"
                   class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true"/>
        </div>
    </form>
</div>
{/if}