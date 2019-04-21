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
            {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=255
            required=true}
            {field_language phrase='Subtitle' label='subtitle' field='subtitle' format='val[subtitle_' size=30 maxlength=255
            required=true}
            {field_language phrase='description' type='textarea' label='description' field='description' format='val[description_'
            size=30 maxlength=1000 required=true}

            <div class="table form-group">
                <div class="table_left">
                    {phrase var='Link'}:
                </div>
                <div class="table_right">
                    <input class="form-control" type="text" name="val[link]" value="{value id='link' type='input'}" size="30" maxlength="64" />
                </div>
                <div class="clear"></div>
            </div>

            <div class="table form-group">
                <div class="table_left">
                    {phrase var='Background'}:
                </div>
                <div class="table_right">
                    <input class="form-control" type="text" name="val[background]"
                           value="{value id='background' type='input'}" size="30" maxlength="64" placeholder="#fafafa" />
                </div>
                <div class="clear"></div>
            </div>

            {if !empty($aForms.image_path) && !empty($aForms.id)}
            {module name='core.upload-form' type='cmlanding' current_photo=$aForms.image_path id=$aForms.id}
            {else}
            {module name='core.upload-form' type='cmlanding'}
            {/if}

            <div class="table form-group">
                <div class="table_left">
                    {required}{phrase var='Image position'}:
                </div>
                <div class="table_right">
                    <select name="val[image_position]" id="image_position" class="form-control">
                        <option value="left" {value type='select' id='image_position' default='left'}>{_p('Left')}</option>
                        <option value="right" {value type='select' id='image_position' default='right'}>{_p('Right')}</option>
                    </select>
                </div>
                <div class="clear"></div>
            </div>


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