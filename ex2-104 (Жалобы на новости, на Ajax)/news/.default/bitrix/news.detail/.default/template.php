<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJScore::Init(array('ajax'));

global $APPLICATION;
?>
<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<div class="news-date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<p>
		<? if (!empty($arParams['EXAM2_REPORT_AJAX']) && $arParams['EXAM2_REPORT_AJAX'] == 'Y'): ?>
			<a href="#" id="report-ajax-link"><?= GetMessage('EXAM2_REPORT_AJAX_LINK_TEXT') ?></a>
			<script>
				BX.ready(function () {
					BX.bind(BX('report-ajax-link'), 'click', function (event) {
						BX.PreventDefault(event);
						
						BX.ajax({
							url: '<?= $APPLICATION->GetCurPage() ?>',
							method: 'POST',
							dataType: 'json',
							start: true,
							data: {report_nid: '<?= $arResult['ID'] ?>'},
							onsuccess: function (data) {
								BX.adjust(BX('report-result'), {text: data.result_text});
							},
							onfailure: function () {
								BX.adjust(BX('report-result'), {text: '<?= GetMessage('EXAM2_REPORT_AJAX_ERROR_TEXT') ?>'});
							}
						});
					});
				});
			</script>
		<? else: ?>
			<a href="<?= $APPLICATION->GetCurPage() ?>?report_nid=<?= $arResult['ID'] ?>"><?= GetMessage('EXAM2_REPORT_AJAX_LINK_TEXT') ?></a>
		<? endif; ?>
		<span id="report-result"></span>
	</p>
	<div class="news-detail">
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
		<?echo $arResult["DETAIL_TEXT"];?>
 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;?>
	</div>
</div>
