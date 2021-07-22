<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>---</p>
<strong><?= GetMessage('SIMPLECOMP_EXAM2_70_CAT_TITLE') ?>:</strong>
<ul>
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <li>
            <strong><?= $arItem['NAME'] ?></strong> - <?= $arItem['ACTIVE_FROM'] ?> (<?= implode(', ', $arItem['SECTIONS']) ?>)
            <ul>
                <? foreach ($arItem['ELEMENTS'] as $arElement): ?>
                    <li>
                        <?= $arElement['NAME'] ?> - <?= $arElement['PROPERTY_PRICE'] ?> - <?= $arElement['PROPERTY_MATERIAL'] ?> - <?= $arElement['PROPERTY_ARTNUMBER'] ?>
                    </li>
                <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
</ul>
<? // ex2-60 >>> ?>
<? if (!empty($arResult['NAV_STRING'])): ?>
    <p>---</p>
    <p><strong><?= GetMessage('SIMPLECOMP_EXAM2_70_NAV_TITLE') ?>:</strong></p>
    <div><?= $arResult['NAV_STRING'] ?></div>
<? endif; ?>
<? // <<< ex2-60 ?>