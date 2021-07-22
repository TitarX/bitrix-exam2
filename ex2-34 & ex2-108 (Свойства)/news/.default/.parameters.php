<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"EX2_SPECIALDATE_SET" => Array(
		"NAME" => GetMessage("EX2_SPECIALDATE_SET_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"EX2_CANONICAL" => Array(
		"NAME" => GetMessage("EX2_CANONICAL_TEXT"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
);
?>