<?

class MainEventHandler
{
    function pageNotFoundLog() // ex2-93
    {
        global $APPLICATION;
        
        if (defined('ERROR_404') && ERROR_404 === 'Y') {
            CEventLog::Add(array(
                'SEVERITY' => 'INFO',
                'AUDIT_TYPE_ID' => 'ERROR_404',
                'MODULE_ID' => 'main',
                'DESCRIPTION' => $APPLICATION->GetCurPageParam()
            ));
        
            $APPLICATION->RestartBuffer();
            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
            include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
        }
    }
    
    function feedbackMessageChange(&$event, &$lid, &$arFields) // ex2-51
    {
        if ($event === 'FEEDBACK_FORM') {
            global $USER;
            if ($USER->IsAuthorized()) {
                $arFields['AUTHOR'] = GetMessage('EX2_FEEDBACK_MESSAGE_CHANGE_AUTHOR_TEXT_AUTH', array('#ID#' => $USER->GetID(), '#LOGIN#' => $USER->GetLogin(), '#NAME#' => $USER->GetFullName(), '#USERNAME#' => $arFields['AUTHOR']));
            } else {
                $arFields['AUTHOR'] = GetMessage('EX2_FEEDBACK_MESSAGE_CHANGE_AUTHOR_TEXT_NOT_AUTH', array('#USERNAME#' => $arFields['AUTHOR']));
            }
            
            CEventLog::Add(array(
                'SEVERITY' => 'INFO',
                'AUDIT_TYPE_ID' => 'FEEDBACK_MESSAGE_CHANGE',
                'MODULE_ID' => 'main',
                'DESCRIPTION' => $arFields['AUTHOR']
            ));
        }
    }
    
    function adminMenuForContentManager(&$aGlobalMenu, &$aModuleMenu) // ex2-95
    {
        global $USER;
        $arUserGroup = $USER->GetUserGroupArray();
        if (!$USER->IsAdmin() && array_search(5, $arUserGroup) !== false) {
            $aGlobalMenu = array('global_menu_content' => $aGlobalMenu['global_menu_content']);
            
            foreach ($aModuleMenu as $item) {
                if ($item['items_id'] === 'menu_iblock_/news') {
                    $aModuleMenu = array($item);
                    break;
                }
            }
        }
    }
    
    function superToolContentManager() // ex2-94
    {
        if (CModule::IncludeModule('iblock')) {
            global $APPLICATION;
            $currentPagePath = $APPLICATION->GetCurPageParam('');
            
            $order = array();
            $filter = array(
                'IBLOCK_ID' => 6,
                'NAME' => $currentPagePath
            );
            $group = false;
            $nav = array('nTopCount' => 1);
            $select = array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_TITLE', 'PROPERTY_DESCRIPTION');
            $dbResult = CIBlockElement::GetList($order, $filter, $group, $nav, $select);
            if ($result = $dbResult->Fetch()) {
                $APPLICATION->SetPageProperty('title', $result['PROPERTY_TITLE_VALUE']);
                $APPLICATION->SetPageProperty('description', $result['PROPERTY_DESCRIPTION_VALUE']);
            }
        }
    }
}
