<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP71_EXAM2_PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP71_EXAM2_CLASS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASS_BINDING_PRODUCT_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP71_EXAM2_CLASS_BINDING_PRODUCT_CODE"),
			"TYPE" => "STRING",
		),
		"LINK_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP71_EXAM2_LINK_TEMPLATE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => Array("DEFAULT" => 36000000),
	),
);