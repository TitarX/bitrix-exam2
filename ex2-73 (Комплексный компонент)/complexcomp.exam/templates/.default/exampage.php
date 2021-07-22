<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?= GetMessage('EXAM2_COMP_VAR_VAL_LABEL_TEXT') ?>:
<? foreach ($arResult['VARIABLES'] as $index => $value): ?>
    <div><?= $index ?> = <?= $value ?></div>
<? endforeach; ?>