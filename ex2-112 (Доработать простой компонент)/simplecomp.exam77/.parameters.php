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
		"CACHE_TIME" => Array("DEFAULT" => 36000000),
	),
);