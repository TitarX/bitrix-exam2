<?
include __DIR__ . '/include/classes/SearchHandler.php';

AddEventHandler('search', 'BeforeIndex', array('SearchHandler', 'beforeIndex'));
