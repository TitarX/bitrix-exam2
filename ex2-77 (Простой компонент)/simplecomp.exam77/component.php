<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!is_numeric($arParams['PRODUCTS_IBLOCK_ID']) && !is_numeric($arParams['CLASSIF_IBLOCK_ID']) && empty($arParams['CLASSIF_PROPERTY_CODE'])) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_NO_PARAMS"));
	return;
}

if ($this->StartResultCache(false)) {
	$arItemsResult = array();
	
	// Выбираем разделы каталога
	$arProductsSections = array();
	$arClassifSectionsId = array();
	$rsSection = CIBlockSection::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			'ACTIVE' => 'Y',
			"!{$arParams['CLASSIF_PROPERTY_CODE']}" => false
		),
		false,
		array('IBLOCK_ID', 'ID', 'NAME', $arParams['CLASSIF_PROPERTY_CODE']),
		false
	);
	while ($arSection = $rsSection->Fetch()) {
		$arClassifSectionsId[] = $arSection[$arParams['CLASSIF_PROPERTY_CODE']];
		
		$arProductsSections[$arSection['ID']] = array(
			'NAME' => $arSection['NAME'],
			'CLASSIF' => $arSection[$arParams['CLASSIF_PROPERTY_CODE']]
		);
	}
	$arClassifSectionsId = array_unique($arClassifSectionsId);
	
	// Выбираем разделы классификатора
	$rsSection = CIBlockSection::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['CLASSIF_IBLOCK_ID'],
			'ACTIVE' => 'Y',
			'ID' => $arClassifSectionsId
		),
		false,
		array('IBLOCK_ID', 'ID', 'NAME'),
		false
	);
	while ($arSection = $rsSection->Fetch()) {
		$arItemsResult[$arSection['ID']] = array(
			'NAME' => $arSection['NAME'],
			'SECTIONS' => array(),
			'ELEMENTS' => array()
		);
		
		foreach ($arProductsSections as $arProductsSectionId => $arProductsSection) {
			if ($arSection['ID'] == $arProductsSection['CLASSIF']) {
				$arItemsResult[$arSection['ID']]['SECTIONS'][$arProductsSectionId] = $arProductsSection['NAME'];
			}
		}
	}
	
	// Выбираем элементы каталога
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			'IBLOCK_SECTION_ID' => array_keys($arProductsSections),
			'ACTIVE' => 'Y'
		),
		false,
		false,
		array('IBLOCK_ID', 'IBLOCK_SECTION_ID', 'ID', 'NAME', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER')
	);
	while ($arElement = $rsElement->Fetch()) {
		foreach ($arItemsResult as &$arItem) {
			if (array_search($arElement['IBLOCK_SECTION_ID'], array_keys($arItem['SECTIONS'])) !== false) {
				$arItem['ELEMENTS'][$arElement['ID']] = array(
					'NAME' => $arElement['NAME'],
					'PRICE' => $arElement['PROPERTY_PRICE_VALUE'],
					'MATERIAL' => $arElement['PROPERTY_MATERIAL_VALUE'],
					'ART' => $arElement['PROPERTY_ARTNUMBER_VALUE']
				);
			}
		}
	}
	
	$arResult['ITEMS'] = $arItemsResult;
	$arResult['COUNT'] = count($arClassifSectionsId);
	
	$this->SetResultCacheKeys(array('COUNT'));
	
	$this->includeComponentTemplate();	
}

$titleText = GetMessage('SIMPLECOMP_EXAM2_COUNT_TEXT', array('#COUNT#' => $arResult['COUNT']));
$APPLICATION->SetTitle($titleText);
?>