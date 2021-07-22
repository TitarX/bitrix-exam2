<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?= GetMessage("EXAM_EXAMPAGE_LABEL_TEXT") ?>:
<? foreach ($arResult["VARIABLES"] as $varKey => $varValue): ?>
    <div><?= ("{$varKey} = {$varValue}") ?></div>
<? endforeach; ?>