<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arParams['EX2_SPECIALDATE_SET'] === 'Y') {
    $firstElement = current($arResult["ITEMS"]);
    $arResult['SPECIALDATE'] = $firstElement['ACTIVE_FROM'];
    $this->getComponent()->setResultCacheKeys(array('SPECIALDATE'));
}
?>