<?
class IblockEventHandler
{
    function showCountActivePage(&$arFields) // ex2-50
    {
        if ($arFields['IBLOCK_ID'] == 2 && $arFields['ACTIVE'] == 'N') {
            $order = array();
            $filter = array(
                'IBLOCK_ID' => $arFields['IBLOCK_ID'],
                'ID' => $arFields['ID'],
                'ACTIVE' => 'Y',
                '>SHOW_COUNTER' => 1
            );
            $group = false;
            $nav = array('nTopCount' => 1);
            $select = array('IBLOCK_ID', 'ID', 'SHOW_COUNTER');
            
            $dbResult = CIBlockElement::GetList($order, $filter, $group, $nav, $select);
            if ($result = $dbResult->Fetch()) {
                global $APPLICATION;
                $APPLICATION->throwException(GetMessage('EX2_SHOW_COUNTER', array('#COUNT#' => $result['SHOW_COUNTER'])));
                return false;
            }
        }
    }
}
