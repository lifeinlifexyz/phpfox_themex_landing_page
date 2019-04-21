<?php
defined('PHPFOX') or exit('NO DICE!');
?>
{$sCreateJs}
<form id="cmlanding_js_slider_group_form" method="post" action="{url link='current'}" onsubmit="{$sGetJsForm}">

    <div class="table form-group">
        <div class="table_left">
            {required}{phrase var='Name'}:
        </div>
        <div class="table_right">
            <input type="text" name="val[name]" value="{value id='name' type='input'}" size="30" maxlength="64" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="table_clear">
        <input type="submit" value="{phrase var='Submit'}" class="button btn-primary" />
    </div>
</form>