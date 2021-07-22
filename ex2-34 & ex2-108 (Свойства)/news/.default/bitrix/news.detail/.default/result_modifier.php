<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arParams['EX2_CANONICAL']) && is_numeric($arParams['EX2_CANONICAL'])) {
    $order = array();
    $filter = array(
        'IBLOCK_ID' => $arParams['EX2_CANONICAL'],
        'PROPERTY_NEWS' => $arResult['ID'],
    );
    $group = false;
    $nav = array('nTopCount' => 1);
    $select = array('IBLOCK_ID', 'ID', 'NAME');
    
    $dbResult = CIBlockElement::GetList($order, $filter, $group, $nav, $select);
    if ($result = $dbResult->Fetch()) {
        $arResult['CANONICAL'] = $result['NAME'];
        $this->getComponent()->setResultCacheKeys(array('CANONICAL'));
    }
}
?>