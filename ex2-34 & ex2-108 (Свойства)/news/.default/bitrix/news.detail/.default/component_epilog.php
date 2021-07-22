<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arParams['EX2_CANONICAL']) && is_numeric($arParams['EX2_CANONICAL']) && !empty($arResult['CANONICAL'])) {
    $APPLICATION->SetPageProperty('canonical', $arResult['CANONICAL']);
}
?>