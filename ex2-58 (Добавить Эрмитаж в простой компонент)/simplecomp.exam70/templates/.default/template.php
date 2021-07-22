<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<p>---</p>

<? if (!empty($arResult['ITEMS'])): ?>
    <? $this->AddEditAction('iblock_' . $arParams['PRODUCTS_IBLOCK_ID'], $arResult['ADD_ELEMENT_LINK'], CIBlock::GetArrayByID($arParams['PRODUCTS_IBLOCK_ID'], 'ELEMENT_ADD')); ?>
    <ul id="<?= $this->GetEditAreaId('iblock_' . $arParams['PRODUCTS_IBLOCK_ID']); ?>">
    <? foreach ($arResult['ITEMS'] as $arItemId => $arItem): ?>
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
            <? foreach ($arItemSectionsElements as $arItemSectionsElementId => $arItemSectionsElement): ?>
                <?
                $itemElementId = "{$arItemId}_{$arItemSectionsElementId}"; // Для использования в панели Эрмитаж, так как элементы инфоблока продуктов повторяются, создаём уникальный идентификатор для каждого элемента из текущего идентификатора элемента и текущего идентификатора классификатора (новости).
                $this->AddEditAction($itemElementId, $arItemSectionsElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams['PRODUCTS_IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($itemElementId, $arItemSectionsElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams['PRODUCTS_IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('SIMPLECOMP_EXAM2_ELEMENT_DELETE_CONFIRM')));
                ?>
            
                <li id="<?= $this->GetEditAreaId($itemElementId) ?>"><?= $arItemSectionsElement['NAME'] ?> - <?= $arItemSectionsElement['PRICE'] ?> - <?= $arItemSectionsElement['MATERIAL'] ?> - <?= $arItemSectionsElement['ARTNUMBER'] ?></li>
            <? endforeach; ?>
            </ul>
        </li>
    <? endforeach; ?>
    </ul>
<? endif; ?>