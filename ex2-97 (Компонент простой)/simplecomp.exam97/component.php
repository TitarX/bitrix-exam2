<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_97_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams['NEWS_IBLOCK_ID']) || !is_numeric($arParams['NEWS_IBLOCK_ID']) || empty($arParams['NEWS_IBLOCK_AUTHOR_CODE']) || empty($arParams['UF_AUTHOR'])) {
	ShowError(GetMessage('SIMPLECOMP_97_EXAM2_NO_PARAMS'));
	return;
}

global $USER;
$currentUserId = '';
$currentUserType = '';
if ($USER->IsAuthorized()) {
	$currentUserId = $USER->GetID();
	$rsUser = CUser::GetList(
		($by = 'timestamp_x'),
		($order = 'desc'),
		array('ID' => $currentUserId),
		array(
			'SELECT' => array($arParams['UF_AUTHOR']),
			'NAV_PARAMS' => array('nTopCount' => 1),
			'FIELDS' => array('ID')
		)
	);
	if ($arUser = $rsUser->Fetch()) {
		$currentUserType = $arUser[$arParams['UF_AUTHOR']];
	}
} else {
	return;
}

if (empty($currentUserType)) {
	return;
}

if ($this->startResultCache(false, $currentUserId)) {
	// Выбираем авторов
	$arAuthorsResult = array();
	$rsUser = CUser::GetList(
		($by = 'timestamp_x'),
		($order = 'desc'),
		array(
			$arParams['UF_AUTHOR'] => $currentUserType,
			'!ID' => $currentUserId
		),
		array(
			'FIELDS' => array('ID', 'LOGIN')
		)
	);
	while ($arUser = $rsUser->Fetch()) {
		$arAuthorsResult[$arUser['ID']] = array('LOGIN' => $arUser['LOGIN']);
	}
	
	// Выбираем новости текущего пользователя
	$arCurrentUserNews = array();
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
			"PROPERTY_{$arParams['NEWS_IBLOCK_AUTHOR_CODE']}" => $currentUserId
		),
		false,
		false,
		array('IBLOCK_ID', 'ID')
	);
	while ($arElement = $rsElement->Fetch()) {
		$arCurrentUserNews[] = $arElement['ID'];
	}
	
	// Выбираем новости авторов
	$rsElement = CIBlockElement::GetList(
		array(),
		array(
			'IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
			"PROPERTY_{$arParams['NEWS_IBLOCK_AUTHOR_CODE']}" => array_keys($arAuthorsResult),
			'!ID' => $arCurrentUserNews
		),
		false,
		false,
		array('IBLOCK_ID', 'ID', 'NAME', 'ACTIVE_FROM', "PROPERTY_{$arParams['NEWS_IBLOCK_AUTHOR_CODE']}")
	);
	$arNewsId = array();
	while ($arElement = $rsElement->Fetch()) {
		foreach ($arAuthorsResult as $arAuthorId => &$arAuthor) {
			if ($arElement["PROPERTY_{$arParams['NEWS_IBLOCK_AUTHOR_CODE']}_VALUE"] == $arAuthorId) {
				$arAuthor['NEWS'][$arElement['ID']] = array(
					'NAME' => $arElement['NAME'],
					'DATE' => $arElement['ACTIVE_FROM']
				);
			}
		}
		
		$arNewsId[] = $arElement['ID'];
	}
	
	$arResult['ITEMS'] = $arAuthorsResult;
	$arResult['COUNT'] = count(array_unique($arNewsId));
	
	$this->setResultCacheKeys(array('COUNT'));
	
	$this->includeComponentTemplate();
}

$titleText = GetMessage('SIMPLECOMP_97_EXAM2_TITLE_TEXT', array('#COUNT#' => $arResult['COUNT']));
$APPLICATION->SetTitle($titleText);
?>