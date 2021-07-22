<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP71_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams['PRODUCTS_IBLOCK_ID']) || !is_numeric($arParams['PRODUCTS_IBLOCK_ID']) || empty($arParams['CLASS_IBLOCK_ID']) || !is_numeric($arParams['CLASS_IBLOCK_ID']) || empty($arParams['CLASS_BINDING_PRODUCT_CODE']) || empty($arParams['LINK_TEMPLATE'])) {
	ShowError(GetMessage("SIMPLECOMP71_EXAM2_NO_PARAMS"));
	return;
}

if (empty($arParams['CACHE_TIME'])) {
	$arParams['CACHE_TIME'] = 36000000;
}

global $USER;
if ($this->startResultCache(false, $USER->GetGroups())) {
	// Выбираем классификаторы
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'CHECK_PERMISSIONS' => 'Y',
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => $arParams['CLASS_IBLOCK_ID']
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'NAME')
	);
	$arClass = array();
	while ($arElement = $rsElement->Fetch()) {
		$arClass[$arElement['ID']]['NAME'] = $arElement['NAME'];
	}
	
	// Выбираем товары
	$classifProperty = "PROPERTY_{$arParams['CLASS_BINDING_PRODUCT_CODE']}";
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'CHECK_PERMISSIONS' => 'Y',
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			$classifProperty => array_keys($arClass)
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'NAME', 'DETAIL_PAGE_URL', $classifProperty, 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER')
	);
	$rsElement->SetUrlTemplates($arParams['LINK_TEMPLATE']);
	while ($arElement = $rsElement->GetNext()) {
		$arClass[$arElement["{$classifProperty}_VALUE"]]['PRODUCTS'][$arElement['ID']] = array(
			'NAME' => $arElement['NAME'],
			'URL' => $arElement['DETAIL_PAGE_URL'],
			'PRICE' => $arElement['PROPERTY_PRICE_VALUE'],
			'MATERIAL' => $arElement['PROPERTY_MATERIAL_VALUE'],
			'ARTNUMBER' => $arElement['PROPERTY_ARTNUMBER_VALUE']
		);
	}
	
	$arResult['ITEMS'] = $arClass;
	$arResult['COUNT'] = count($arClass);
	
	$this->setResultCacheKeys(array('COUNT'));
	
	$this->includeComponentTemplate();
}

$titleText = GetMessage('SIMPLECOMP71_EXAM2_TITLE', array('#COUNT#' => $arResult['COUNT']));
$APPLICATION->SetTitle($titleText);
?>