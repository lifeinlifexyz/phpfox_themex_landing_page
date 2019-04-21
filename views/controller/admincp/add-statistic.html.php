<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{$sCreateJs}
<form id="cmlanding_js_slider_form" method="post" action="{url link='current'}" enctype="multipart/form-data"
      onsubmit="{$sGetJsForm}">
    <div class="panel panel-default">

        {field_language phrase='title' label='title' field='title' format='val[title_' size=30 maxlength=100
        required=true}

        <div class="table form-group">
            <div class="table_left">
                {required}{phrase var='Count'}:
            </div>
            <div class="table_right">
                <input type="text" name="val[count]" value="{value id='count' type='input'}" size="30" maxlength="64" />
            </div>
            <div class="clear"></div>
        </div>

        <div class="table form-group">
            <div class="table_left">
                {required}{phrase var='Icon'}:
            </div>
            <div class="table_right">
                <input type="text" name="val[icon]" value="{value id='icon' type='input'}" size="30" maxlength="64" />
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