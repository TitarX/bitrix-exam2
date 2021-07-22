<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (empty($this->__template)) {
    $this->InitComponentTemplate();
}
?>
<? $this->GetTemplate()->SetViewTarget('MIN_MAX_PRICE'); ?>
<div style="color:red; margin: 34px 15px 35px 15px">
    <? if (!empty($arResult['MIN_PRICE'])): ?>
        <div><?= GetMessage('SIMPLECOMP_EXAM2_MIN_PRICE_TEXT', array('#MIN_PRICE#' => $arResult['MIN_PRICE'])) ?></div>
    <? endif; ?>
    <? if (!empty($arResult['MAX_PRICE'])): ?>
        <div><?= GetMessage('SIMPLECOMP_EXAM2_MAX_PRICE_TEXT', array('#MAX_PRICE#' => $arResult['MAX_PRICE'])) ?></div>
    <? endif; ?>
</div>
<? $this->GetTemplate()->EndViewTarget(); ?>