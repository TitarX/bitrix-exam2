<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

// ex2-81
if (empty($arParams['PRODUCTS_IBLOCK_ID']) || !is_numeric($arParams['PRODUCTS_IBLOCK_ID']) || empty($arParams['NEWS_IBLOCK_ID']) || !is_numeric($arParams['NEWS_IBLOCK_ID']) || empty($arParams['UF_NEWS_LINK_CODE']) || empty($arParams['PRODUCT_DETAIL_URL_TEMPLATE'])) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_PARAMETER_NONE"));
	return;
}

if ($arParams['CACHE_TIME']) {
	$arParams['CACHE_TIME'] = 36000000;
}

if ($this->startResultCache(false)) {
	$arComponentResult = array();
	
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
	$rsElement = CIBlockElement::GetList(
		array(
			'NAME' => 'ASC', // ex2-81
			'SORT' => 'ASC' // ex2-81
		),
		array(
			'IBLOCK_ID' => $arParams['PRODUCTS_IBLOCK_ID'],
			'ACTIVE' => 'Y',
			'IBLOCK_SECTION_ID' => $arResultSections
		),
		false,
		false,
		array('IBLOCK_ID', 'IBLOCK_SECTION_ID', 'ID', 'NAME', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'PROPERTY_PRICE', 'DETAIL_PAGE_URL') // ex2-81
	);
	$rsElement->SetUrlTemplates($arParams['PRODUCT_DETAIL_URL_TEMPLATE']); // ex2-81
	while ($arElement = $rsElement->GetNext()) {
		foreach ($arResultNews as &$arNews) {
			foreach ($arNews['SECTIONS'] as $sectionId => &$section) {
				if ($sectionId == $arElement['IBLOCK_SECTION_ID']) {
					$section['ELEMENTS'][$arElement['ID']] = array(
						'NAME' => $arElement['NAME'],
						'MATERIAL' => $arElement['PROPERTY_MATERIAL_VALUE'],
						'ARTNUMBER' => $arElement['PROPERTY_ARTNUMBER_VALUE'],
						'PRICE' => $arElement['PROPERTY_PRICE_VALUE'],
						'URL' => $arElement['DETAIL_PAGE_URL'] // ex2-81
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
	
	$this->setResultCacheKeys(array('ELEMENTS_COUNT'));
	
	$this->includeComponentTemplate();
}

$titleText = GetMessage('SIMPLECOMP_EXAM2_ELEMENTS_COUNT', array('#COUNT#' => $arResult['ELEMENTS_COUNT']));
$APPLICATION->SetTitle($titleText);
?>