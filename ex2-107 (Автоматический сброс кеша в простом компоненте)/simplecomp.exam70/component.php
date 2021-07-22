<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

$newsIblockId = trim($arParams['NEWS_IBLOCK_ID']);
$productsIblockId = trim($arParams['PRODUCTS_IBLOCK_ID']);
$newsLinkFieldCode = trim($arParams['UF_NEWS_LINK_CODE']);
if (intval($newsIblockId) <= 0 || intval($productsIblockId) <= 0 || empty($newsLinkFieldCode)) {
	ShowError(GetMessage('SIMPLECOMP_EXAM2_70_PARAMETERS_NONE'));
	return;
}

if (empty($arParams['CACHE_TIME'])) {
	$arParams['CACHE_TIME'] = 36000000;
}

if ($this->StartResultCache(false)) {
	// ex2-107 >>>
	global $CACHE_MANAGER;
	$CACHE_MANAGER->RegisterTag('iblock_id_3');
	// <<< ex2-107
	
	$arItems = array();
	$arNews = array();
	$arNewsIds = array();
	$dbResult = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $newsIblockId,
			'ACTIVE' => 'Y'
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'NAME', 'ACTIVE_FROM')
	);
	while ($result = $dbResult->Fetch()) {
		$arNewsIds[] = $result['ID'];
		$arNews[$result['ID']]['NAME'] = $result['NAME'];
		$arNews[$result['ID']]['ACTIVE_FROM'] = $result['ACTIVE_FROM'];
	}
	
	$arSections = array();
	$dbResult = CIBlockSection::GetList(
		array(),
		array(
			'IBLOCK_ID' => $productsIblockId,
			'ACTIVE' => 'Y',
			$newsLinkFieldCode => $arNewsIds,
		),
		false,
		array('IBLOCK_ID', 'ID', 'NAME', $newsLinkFieldCode),
		false
	);
	$results = array();
	while ($result = $dbResult->Fetch()) {
		$arSections[] = $result['ID'];
		foreach ($result[$newsLinkFieldCode] as $productSectionNewsId) {
			if (empty($arItems[$productSectionNewsId]['SECTIONS'])) {
				$arItems[$productSectionNewsId]['NAME'] = $arNews[$productSectionNewsId]['NAME'];
				$arItems[$productSectionNewsId]['ACTIVE_FROM'] = $arNews[$productSectionNewsId]['ACTIVE_FROM'];
			}
			$arItems[$productSectionNewsId]['SECTIONS'][$result['ID']] = $result['NAME'];
		}
	}
	unset($arNews);
	
	$dbResult = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $productsIblockId,
			'ACTIVE' => 'Y',
			'IBLOCK_SECTION_ID' => $arSections
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'IBLOCK_SECTION_ID', 'NAME', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'PROPERTY_PRICE')
	);
	
	$displayedProductCount = 0;
	while ($result = $dbResult->Fetch()) {
		foreach ($arItems as &$arItem) {
			if (array_key_exists($result['IBLOCK_SECTION_ID'], $arItem['SECTIONS'])) {
				if (empty($arItem['ELEMENTS'][$result['ID']])) {
					$arItem['ELEMENTS'][$result['ID']] = array(
						'NAME' => $result['NAME'],
						'PROPERTY_MATERIAL' => $result['PROPERTY_MATERIAL_VALUE'],
						'PROPERTY_ARTNUMBER' => $result['PROPERTY_ARTNUMBER_VALUE'],
						'PROPERTY_PRICE' => $result['PROPERTY_PRICE_VALUE']
					);
				}
			}
		}
		
		$displayedProductCount++;
	}
	
	$arResult['ITEMS'] = $arItems;
	$arResult['PRODUCT_COUNT'] = $displayedProductCount;
	
	$this->SetResultCacheKeys(array('PRODUCT_COUNT'));
	
	$this->IncludeComponentTemplate();
}

$titleText = GetMessage('SIMPLECOMP_EXAM2_70_TITLE_TEXT') . ': ' . $arResult['PRODUCT_COUNT'];
$APPLICATION->SetTitle($titleText);
?>