<?
function CheckUserCount() {
    $lastDateCheck = COption::GetOptionString('main', 'last_date_check');
    $currentDateCheck = date('d.m.Y');
    
    // Количество новый пользователей
    $arFilter = array(
        'DATE_REGISTER_2' => $currentDateCheck
    );
    if (!empty($lastDateCheck)) {
        $arFilter['DATE_REGISTER_1'] = $lastDateCheck;
    }
    $rsUser = CUser::GetList(
        ($by = 'timestamp_x'),
        ($order = 'desc'),
        $arFilter,
        array('FIELDS' => array('ID'))
    );
    $newUserCount = $rsUser->SelectedRowsCount();
    
    // Количество дней
    $daysForCheck = intval(round((strtotime($currentDateCheck) - strtotime($lastDateCheck)) / 86400));
    
    // Администраторы
    $rsUser = CUser::GetList(
        ($by = 'timestamp_x'),
        ($order = 'desc'),
        array(
            'GROUPS_ID' => array('1')
        ),
        array('FIELDS' => array('ID', 'EMAIL'))
    );
    $arAdminEmails = array();
    while ($arUser = $rsUser->Fetch()) {
        $arAdminEmails[] = $arUser['EMAIL'];
    }
    
    // Отправка сообщений
    $arFields = array(
        'COUNT' => $newUserCount,
        'DAYS' => $daysForCheck,
        'ADMIN_EMAILS' => implode(',', $arAdminEmails)
    );
    CEvent::Send('REG_USER_COUNT', 's1', $arFields);
    
     COption::SetOptionString('main', 'last_date_check', $currentDateCheck);
    
    return 'CheckUserCount();';
}
