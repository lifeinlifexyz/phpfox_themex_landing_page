<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{literal}
<style>
    .table_right {
        margin-left: 0 !important;
    }
</style>
{/literal}
{$sCreateJs}
<form id="cmlanding_js_slider_form" method="post" action="{url link='current'}" enctype="multipart/form-data"
      onsubmit="{$sGetJsForm}">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table form-group">
                <div class="table_left">
                    {required}{phrase var='Slider group'}:
                </div>
                <div class="table_right">
                    <select name="val[group_name]" id="group_name" class="form-control">
                        {foreach from=$aGroups item=group}
                        <option value="{$group}" {value type='select' id='group_name' default=$group}>{$group}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="clear"></div>
            </div>

            {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=255
            required=true}
            {field_language phrase='description' type='textarea' label='description' field='description' format='val[description_'
            size=30 maxlength=500 required=true}

            {if !empty($aForms.image_path) && !empty($aForms.id)}
            {module name='core.upload-form' type='cmlanding' current_photo=$aForms.image_path id=$aForms.id}
            {else}
            {module name='core.upload-form' type='cmlanding'}
            {/if}


            <div class="form-group">
                <label>{_p var='is_active'}</label>
                <div class="item_is_active_holder">
                    <span class="js_item_active item_is_active">
                        <input type="radio" name="val[is_active]" value="1" {value type='radio' id='is_active'
                               default='1' selected='true' }/>
                    </span>
                    <span class="js_item_active item_is_not_active">
                        <input type="radio" name="val[is_active]" value="0" {value type='radio' id='is_active'
                               default='0' }/>
                    </span>
                </div>
            </div>

            <div class="table_clear">
                <input type="submit" value="{phrase var='Submit'}" class="button btn-primary"/>
            </div>
        </div>
    </div>
</form>