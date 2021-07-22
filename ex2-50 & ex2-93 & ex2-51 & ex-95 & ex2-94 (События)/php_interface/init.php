<?
include realpath(__DIR__ . '/include/IblockEventHandler.php');
include realpath(__DIR__ . '/include/MainEventHandler.php');

AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', array('IblockEventHandler', 'showCountActivePage')); // ex2-50
AddEventHandler('main', 'OnEpilog', array('MainEventHandler', 'pageNotFoundLog')); // ex2-93
AddEventHandler('main', 'OnBeforeEventAdd', array('MainEventHandler', 'feedbackMessageChange')); // ex2-51
AddEventHandler('main', 'OnBuildGlobalMenu', array('MainEventHandler', 'adminMenuForContentManager')); // ex2-95
AddEventHandler('main', 'OnPageStart', array('MainEventHandler', 'superToolContentManager')); // ex2-94
