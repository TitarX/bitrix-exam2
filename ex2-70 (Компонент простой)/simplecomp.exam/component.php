<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!is_numeric($arParams['PRODUCTS_IBLOCK_ID']) || !is_numeric($arParams['NEWS_IBLOCK_ID']) || empty($arParams['CLASSIF_CODE'])) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_PARAMS_NONE"));
	return;
}

if ($this->StartResultCache(false)) {
	$arResultItems = array();
	
	// Выбираем разделы каталога
	$arSections = array();
	$arClassifId = array();
	$rsSection = CIBlockSection::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			'ACTIVE' => 'Y',
			"!{$arParams['CLASSIF_CODE']}" => false
		),
		false,
		array('IBLOCK_ID', 'ID', $arParams['CLASSIF_CODE'], 'NAME'),
		false
	);
	while ($arSection = $rsSection->Fetch()) {
		$arSections[$arSection['ID']] = array(
			'NAME' => $arSection['NAME'],
			'CLASSIF' => $arSection[$arParams['CLASSIF_CODE']]
		);
		
		array_push($arClassifId, ...$arSection[$arParams['CLASSIF_CODE']]);
	}
	$arClassifId = array_unique($arClassifId);
	
	// Выбираем элементы новостей
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
			'ID' => $arClassifId,
			'ACTIVE' => 'Y'
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'NAME', 'ACTIVE_FROM')
	);
	while ($arElement = $rsElement->Fetch()) {
		$arCurrentElementSections = array();
		foreach ($arSections as $sectionId => $arSection) {
			if (array_search($arElement['ID'], $arSection['CLASSIF']) !== false) {
				$arCurrentElementSections[$sectionId] = $arSection;
			}
		}
		
		$arResultItems[$arElement['ID']] = array(
			'NAME' => $arElement['NAME'],
			'DATE' => $arElement['ACTIVE_FROM'],
			'SECTIONS' => $arCurrentElementSections
		);
	}
	
	// Выбираем элементы каталога
	$arElementsId = array();
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			'IBLOCK_SECTION_ID' => array_keys($arSections),
			'ACTIVE' => 'Y'
		),
		false,
		false,
		array('IBLOCK_ID', 'IBLOCK_SECTION_ID', 'ID', 'NAME', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'PROPERTY_PRICE')
	);
	while ($arElement = $rsElement->Fetch()) {
		foreach ($arResultItems as &$arResultItem) {
			$arResultItemSectionsId = array_keys($arResultItem['SECTIONS']);
			if (array_search($arElement['IBLOCK_SECTION_ID'], $arResultItemSectionsId) !== false) {
				$arResultItem['ELEMENTS'][$arElement['ID']] = array(
					'NAME' => $arElement['NAME'],
					'MATERIAL' => $arElement['PROPERTY_MATERIAL_VALUE'],
					'ARTNUMBER' => $arElement['PROPERTY_ARTNUMBER_VALUE'],
					'PRICE' => $arElement['PROPERTY_PRICE_VALUE']
				);
			}
		}
		
		$arElementsId[] = $arElement['ID'];
	}
	$arElementsId = array_unique($arElementsId);
	
	$arResult['ITEMS'] = $arResultItems;
	$arResult['COUNT'] = count($arElementsId);
	
	$this->SetResultCacheKeys(array('COUNT'));
	
	$this->includeComponentTemplate();
}

$titleText = GetMessage('SIMPLECOMP_EXAM2_TITLE_TEXT', array('#COUNT#' => $arResult['COUNT']));
$APPLICATION->SetTitle($titleText);
?>