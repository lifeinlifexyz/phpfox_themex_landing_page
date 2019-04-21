<?php

defined('PHPFOX') or exit('NO DICE!');

?>
<div class="table_header">
    {_p('Slider Groups')}
    <a href="{url link='admincp.cmlanding.slider.groups.add'}" class="btn btn-primary popup pull-right">{_p('Add')}</a>
</div>
{if count($groups)}
<div class="panel panel-default">
    <form method="post" action="{url link='current'}">
        <table class="table table-admin" cellpadding="0" cellspacing="0">
            <tr>
                <th style="width:10px;"><input type="checkbox" name="delete[]" value="" id="js_check_box_all"
                                               class="main_checkbox"/></th>
                <th style="width:20px;"></th>
                <th class="t_center" style="width:60px;">{_p('Name')}</th>
            </tr>
            {foreach from=$groups key=iKey item=aItem}
            <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" data-sort-id="{$aItem.field_id}">
                <td><input type="checkbox" name="delete[]" class="checkbox" value="{$aItem.name}"
                           id="js_id_row{$aItem.name}"/></td>
                <td class="t_center">
                    <a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png'
                        alt=''}</a>
                    <div class="link_menu">
                        <ul>
                            <li><a href="{url link='current' delete[]=$aItem.name}"
                                   onclick="return confirm('{phrase var='core.are_you_sure'}');">{_p('Delete')}</a></li>
                        </ul>
                    </div>
                </td>
                <td class="t_center">
                    {$aItem.name}
                </td>
            </tr>
            {/foreach}
        </table>
        <div class="table_bottom">
            <input type="submit" value="{_p('Delete selected')}"
                   class="sJsConfirm delete button sJsCheckBoxButton disabled" disabled="true"/>
        </div>
    </form>
</div>
{/if}