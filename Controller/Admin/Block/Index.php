<?php

namespace Apps\CM_Landing\Controller\Admin\Block;

use Phpfox;
use Phpfox_Component;

class Index extends Phpfox_Component
{
    public function process()
    {
        $sConnection = 'cmlanding.index-visitor';
        $iStyleId = $this->request()->get('style_id', 0);

        if ($iDeleteId = $this->request()->getInt('delete')) {
            if (Phpfox::getService('admincp.block.process')->delete($iDeleteId)) {
                $this->url()->send('admincp.app', ['id' => 'CM_Landing'], _p('successfully_deleted'));
            }
        }

        if ($aVals = $this->request()->getArray('val')) {
            if (Phpfox::getService('admincp.block.process')->updateOrder($aVals)) {
                $this->url()->send('admincp.block');
            }
        }

        $aBlocks = array();
        $aRows = Phpfox::getService('admincp.block')->get();
        foreach ($aRows as $iKey => $aRow) {
            if (!Phpfox::isModule($aRow['module_id'])) {
                continue;
            }
            $sArrayKeyConnection = (isset($aRow['m_connection']) && !empty($aRow['m_connection'])) ? $aRow['m_connection'] : 'site_wide';
            $aBlocks[$sArrayKeyConnection][$aRow['location']][] = $aRow;
        }

        ksort($aBlocks);
        $aSubBlocks = Phpfox::getService('admincp.block')->get($sConnection, $iStyleId);
        $aModules = [];
        foreach ($aSubBlocks as $iKey => $aRow) {
            $aModules[$aRow['location']][] = $aRow;
        }
        // when have no block of current connection => redirect to connection `core.index-member`
        if (empty($aModules) && $sConnection != 'cmlanding.index-visitor') {
            $this->url()->send('admincp.block');
        }

        $this->template()
            ->setSectionTitle(_p('blocks'))
            ->setActionMenu([
                _p('add_block') => [
                    'url' => $this->url()->makeUrl('admincp.block.add', ['m_connection' => $sConnection]),
                ]
            ])
            ->setBreadCrumb(_p('block_manager'))
            ->setTitle(_p('block_manager'))
            ->setHeader('cache', array(
                    'drag.js' => 'static_script',
                    'jquery/plugin/jquery.scrollTo.js' => 'static_script',
                )
            )->setHeader([
                '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'.js_drag_drop\', ajax: \'admincp.blockOrdering\'}); }</script>',
            ])
            ->setActiveMenu('admincp.appearance.block')
            ->assign(array(
                'aModules' => $aModules,
                'sConnection' => $sConnection,
                'iStyleId' => $iStyleId,
                'aBlocks' => $aBlocks,
            ));
    }

}