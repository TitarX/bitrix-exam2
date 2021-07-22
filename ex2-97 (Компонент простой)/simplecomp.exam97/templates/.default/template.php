<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<? if (!empty($arResult['ITEMS'])): ?>
<ul>
    <? foreach ($arResult['ITEMS'] as $arItemId => $arItem): ?>
        <li>[<?= $arItemId ?>] - <?= $arItem['LOGIN'] ?></li>
        <ul>
            <? foreach ($arItem['NEWS'] as $arItemNews): ?>
                <li>- <?= $arItemNews['NAME'] ?> - <?= $arItemNews['DATE'] ?></li>
            <? endforeach; ?>
        </ul>
    <? endforeach; ?>
</ul>
<? endif; ?>