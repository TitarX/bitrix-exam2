<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Main\Application;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams['PRODUCTS_IBLOCK_ID']) || !is_numeric($arParams['PRODUCTS_IBLOCK_ID']) || empty($arParams['NEWS_IBLOCK_ID']) || !is_numeric($arParams['NEWS_IBLOCK_ID']) || empty($arParams['UF_NEWS_LINK_CODE'])) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_PARAMETER_NONE"));
	return;
}

$specParam = Application::getInstance()->getContext()->getRequest()->getQuery('F'); // ex2-49
$specParamExists = isset($specParam);

if ($this->StartResultCache(false, $specParamExists)) {
	// ex2-49
	if ($specParamExists) {
		$this->AbortResultCache();
	}
	
	// Выбираем разделы инфоблока каталога
	$arResultNews = array();
	$arResultSections = array();
	$rsSection = CIBlockSection::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			'ACTIVE' => 'Y',
			"!{$arParams['UF_NEWS_LINK_CODE']}" => false
		),
		false,
		array('IBLOCK_ID', 'ID', 'NAME', $arParams['UF_NEWS_LINK_CODE']),
		false
	);
	while ($arSection = $rsSection->Fetch()) {
		$arResultSections[] = $arSection['ID'];
		
		foreach ($arSection[$arParams['UF_NEWS_LINK_CODE']] as $newsId) {
			$arResultNews[$newsId]['SECTIONS'][$arSection['ID']] = array('NAME' => $arSection['NAME']);
		}
	}
	
	// Выбираем элементы выбранных разделов
	$elCount = 0;
	
	$arFilter = array(
		'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
		'ACTIVE' => 'Y',
		'IBLOCK_SECTION_ID' => $arResultSections
	);
	
	// ex2-49
	if ($specParamExists) {
		$arFilter[] = array(
			'LOGIC' => 'OR',
			array(
				'<=PROPERTY_PRICE' => 1700,
				'PROPERTY_MATERIAL' => 'Дерево, ткань'
			),
			array(
				'<PROPERTY_PRICE' => 1500,
				'PROPERTY_MATERIAL' => 'Металл, пластик'
			)
		);
	}
	
	$rsElement = CIBlockElement::GetList(
		array(),
		$arFilter,
		false,
		false,
		array('IBLOCK_ID', 'IBLOCK_SECTION_ID', 'ID', 'NAME', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'PROPERTY_PRICE')
	);
	while ($arElement = $rsElement->Fetch()) {
		foreach ($arResultNews as &$arNews) {
			foreach ($arNews['SECTIONS'] as $sectionId => &$section) {
				if ($sectionId == $arElement['IBLOCK_SECTION_ID']) {
					$section['ELEMENTS'][$arElement['ID']] = array(
						'NAME' => $arElement['NAME'],
						'MATERIAL' => $arElement['PROPERTY_MATERIAL_VALUE'],
						'ARTNUMBER' => $arElement['PROPERTY_ARTNUMBER_VALUE'],
						'PRICE' => $arElement['PROPERTY_PRICE_VALUE']
					);
				}
			}
		}
		
		$elCount++;
	}
	
	// Выбираем новости
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
			'ID' => array_keys($arResultNews),
			'ACTIVE' => 'Y'
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'NAME', 'ACTIVE_FROM')
	);
	while ($arElement = $rsElement->Fetch()) {
		foreach ($arResultNews as $arNewsId => &$arNews) {
			if ($arElement['ID'] == $arNewsId) {
				$arNews['NAME'] = $arElement['NAME'];
				$arNews['DATE'] = $arElement['ACTIVE_FROM'];
			}
		}
	}
	
	$arResult['ELEMENTS_COUNT'] = $elCount;
	$arResult['ITEMS'] = $arResultNews;
	
	if (!$specParamExists) {
		$arResult['SPEC_PARAM_URL'] = $APPLICATION->GetCurPage() . '?F=Y';
	}
	
	$this->SetResultCacheKeys(array('ELEMENTS_COUNT'));
	
	$this->IncludeComponentTemplate();
}

$titleText = GetMessage('SIMPLECOMP_EXAM2_ELEMENTS_COUNT', array('#COUNT#' => $arResult['ELEMENTS_COUNT']));
$APPLICATION->SetTitle($titleText);
?>