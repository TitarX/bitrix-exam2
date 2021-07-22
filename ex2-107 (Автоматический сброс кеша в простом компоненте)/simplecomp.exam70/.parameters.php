<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_70_PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_70_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"UF_NEWS_LINK_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_70_UF_NEWS_LINK_CODE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => array("DEFAULT" => "36000000"),
	),
);