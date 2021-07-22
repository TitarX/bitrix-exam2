<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>---</p>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?>:</b></p>
<? if (!empty($arResult['ITEMS'])): ?>
    <ul>
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <?
        $arSectionsNames = array();
        foreach ($arItem['SECTIONS'] as $arSections) {
            $arSectionsNames[] = $arSections['NAME'];
        }
        ?>
        <li>
            <strong><?= $arItem['NAME'] ?></strong> - <?= $arItem['DATE'] ?> (<?= (implode(', ', $arSectionsNames)) ?>)
            <ul>
            <? foreach ($arItem['ELEMENTS'] as $arElement): ?>
                <li><?= $arElement['NAME'] ?> - <?= $arElement['MATERIAL'] ?> - <?= $arElement['ARTNUMBER'] ?> - <?= $arElement['PRICE'] ?></li>
            <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
    </ul>
<? endif; ?>