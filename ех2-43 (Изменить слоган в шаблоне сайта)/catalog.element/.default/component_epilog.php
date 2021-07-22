<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['SLOGAN'])) {
    $APPLICATION->SetPageProperty('slogan_head', $arResult['SLOGAN']);
}
?>