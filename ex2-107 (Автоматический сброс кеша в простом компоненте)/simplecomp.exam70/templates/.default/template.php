<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? // ex2-107 >>> ?>
<p><?= GetMessage('SIMPLECOMP_EXAM2_70_TIME_TITLE', array('#TIME#' => time())) ?></p>
<? // <<< ex2-107 ?>
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