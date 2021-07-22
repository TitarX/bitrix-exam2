<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_70_EXAM2_PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_70_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"UF_NEWS_LINK_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_70_EXAM2_UF_NEWS_LINK"),
			"TYPE" => "STRING",
		),
		// ex2-81
		"PRODUCT_DETAIL_URL_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_70_EXAM2_PRODUCT_DETAIL_URL_TEMPLATE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => Array("DEFAULT" => 36000000),
	),
);
