<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<p>---</p>

<? if (!empty($arResult['ITEMS'])): ?>
    <ul>
    <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <li>
            <?
            $arItemSections = array();
            $arItemSectionsElements = array();
            foreach ($arItem['SECTIONS'] as $arItemSection) {
                $arItemSections[] = $arItemSection['NAME'];
                array_push($arItemSectionsElements, ...$arItemSection['ELEMENTS']);
            }
            ?>
            <strong><?= $arItem['NAME'] ?></strong> - <?= $arItem['DATE'] ?> (<?= implode(', ', $arItemSections) ?>)
            <ul>
            <? foreach ($arItemSectionsElements as $arItemSectionsElement): ?>
                <li><?= $arItemSectionsElement['NAME'] ?> - <?= $arItemSectionsElement['PRICE'] ?> - <?= $arItemSectionsElement['MATERIAL'] ?> - <?= $arItemSectionsElement['ARTNUMBER'] ?></li>
            <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
    </ul>
<? endif; ?>