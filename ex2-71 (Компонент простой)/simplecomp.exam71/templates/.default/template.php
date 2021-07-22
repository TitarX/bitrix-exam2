<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>---</p>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?>:</b></p>

<? if (!empty($arResult['ITEMS'])): ?>
<ul>
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <? if (!empty($arItem['PRODUCTS'])): ?>
            <li>
                <strong><?= $arItem['NAME'] ?></strong>
                <ul>
                <? foreach ($arItem['PRODUCTS'] as $arItemProduct): ?>
                    <li>
                        <a target="_blank" href="<?= $arItemProduct['URL'] ?>">
                            <?= $arItemProduct['NAME'] ?> - <?= $arItemProduct['PRICE'] ?> - <?= $arItemProduct['MATERIAL'] ?> - <?= $arItemProduct['ARTNUMBER'] ?> - <?= $arItemProduct['URL'] ?>
                        </a>
                    </li>
                <? endforeach; ?>
                </ul>
            </li>
        <? endif; ?>
    <? endforeach; ?>
</ul>
<? endif; ?>