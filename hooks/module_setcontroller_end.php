<?php
if (Phpfox::isModule('cmlanding')) {
    if ($this->_sModule == 'core' && ($this->_sController == 'index-visitor') && Phpfox::getLib('request') -> get('req1') != 'hashtag') {
        $this->_sModule = 'cmlanding';
    }
}