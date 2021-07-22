<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;
use Bitrix\Main\Type\DateTime;

CJScore::Init();

global $APPLICATION;
global $USER;

$reportNid = '';
if (!empty($arParams['EXAM2_REPORT_AJAX']) && $arParams['EXAM2_REPORT_AJAX'] == 'Y') {
    $reportNid = Application::getInstance()->getContext()->getRequest()->getPost('report_nid');
} else {
    $reportNid = Application::getInstance()->getContext()->getRequest()->getQuery('report_nid');
}

if (!empty($reportNid)) {
    $newReportElement = new CIBlockElement();
    
    $userInfo = '';
    if ($USER->IsAuthorized()) {
        $userInfo .= $USER->GetID();
        $userInfo .= ', ';
        $userInfo .= $USER->GetLogin();
        $userInfo .= ', ';
        $userInfo .= $USER->GetFullName();
    } else {
        $userInfo = GetMessage('EXAM2_REPORT_NEW_ELEMENT_USER_NOT_AUTHORIZED_INFO');
    }
    
    $arNewReportElementPropertyValues = array(
        'USER' => $userInfo,
        'NEWS' => $reportNid
    );
    
    $arNewReportElementValues = array(
        'IBLOCK_ID' => 5,
        'ACTIVE' => 'Y',
        'ACTIVE_FROM' => DateTime::createFromTimestamp(time()),
        'NAME' => GetMessage('EXAM2_REPORT_NEW_ELEMENT_NAME', array('#ID#' => $reportNid)),
        'PROPERTY_VALUES' => $arNewReportElementPropertyValues
    );
    
    $arAddReportResult = array();
    if ($newElementId = $newReportElement->Add($arNewReportElementValues)) {
        $arAddReportResult['result_text'] = GetMessage('EXAM2_REPORT_AJAX_SUCCESS_TEXT', array('#NUMBER#' => $newElementId));
    } else {
        $arAddReportResult['result_text'] = GetMessage('EXAM2_REPORT_AJAX_ERROR_TEXT');
    }
    
    if (!empty($arParams['EXAM2_REPORT_AJAX']) && $arParams['EXAM2_REPORT_AJAX'] == 'Y') {
        $APPLICATION->RestartBuffer();
        print json_encode($arAddReportResult);
        exit;
    } else {
        ?>
        <script>
            BX.ready(function () {
                BX.adjust(BX('report-result'), {text: '<?= $arAddReportResult['result_text'] ?>'});
            });
            
            window.history.pushState(null, null, '<?= $APPLICATION->GetCurPage() ?>');
        </script>
        <?
    }
}
?>