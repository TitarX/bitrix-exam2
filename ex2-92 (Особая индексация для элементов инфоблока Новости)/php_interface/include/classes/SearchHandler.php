<?

class SearchHandler
{
    function beforeIndex($arFields)
    {
        if ($arFields['MODULE_ID'] == 'iblock' && $arFields['PARAM2'] == '1') {
            $arFields['TITLE'] = TruncateText($arFields['BODY'], 50);
        }
        
        return $arFields;
    }
}