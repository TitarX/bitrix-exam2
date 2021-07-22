<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASSIF_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIF_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASSIF_PROPERTY_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIF_PROPERTY_CODE"),
			"TYPE" => "STRING",
		),
		"CLASSIF_ELEMENTS_PER_PAGE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIF_ELEMENTS_PER_PAGE"),
			"TYPE" => "STRING",
		),
		"CLASSIF_ELEMENTS_PAGES_NAME" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIF_ELEMENTS_PAGES_NAME"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => Array("DEFAULT" => 36000000),
	),
);