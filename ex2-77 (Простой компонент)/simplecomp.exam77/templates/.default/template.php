<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?>:</b></p>
<p>---</p>
<? if (!empty($arResult['ITEMS'])): ?>
<ul>
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <li><strong><?= $arItem['NAME'] ?></strong> (<?= implode(', ', $arItem['SECTIONS']) ?>)</li>
        <ul>
            <? foreach ($arItem['ELEMENTS'] as $arElement): ?>
                <li><?= $arElement['NAME'] ?> - <?= $arElement['PRICE'] ?> - <?= $arElement['MATERIAL'] ?> - <?= $arElement['ART'] ?></li>
            <? endforeach; ?>
        </ul>
    <? endforeach; ?>
</ul>
<? endif; ?>