<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<? foreach ($arResult['ITEMS'] as $arItem): ?>
	<div>
		<div>
			<em><?= $arItem['DISPLAY_ACTIVE_FROM'] ?></em>
			<strong><?= $arItem['PROPERTIES']['NAME_EN']['VALUE'] ?></strong>
			<div><?= $arItem['PROPERTIES']['PREVIEW_TEXT_EN']['VALUE']['TEXT'] ?></div>
		</div>
	</div>
	<br>
<? endforeach; ?>