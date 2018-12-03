<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Если пользователь не авторизован, то устанавливаем язык по умолчанию
if (!isset($DEFAULT_LANGUAGE) && $SET->path() != 'install') {
    $DEFAULT_LANGUAGE = DEFAULT_LANGUAGE;
}
//Если первый раз в инсталляторе, то устанавливаем язык по умолчанию Russian
if (!$VALID->inPOST('language') && $SET->path() == 'install') {
    $DEFAULT_LANGUAGE = 'russian';
}
//Если переключили язык не авторизованно или в инсталляторе
if ($VALID->inPOST('language')) {
    $DEFAULT_LANGUAGE = $VALID->inPOST('language');
}

$LANG_ALL = $LANG->lang($DEFAULT_LANGUAGE, 'all');
$LANG_TRANS = $LANG->lang($DEFAULT_LANGUAGE, 'translate');
$LANG_VAR = $LANG->lang($DEFAULT_LANGUAGE);

/**
 * Функция для вывода языковой переменной вида: lang('pass') или lang('pass', 'english');
 *
 * @param строка $a
 * @param строка $b
 * @return строка [$a]
 * @return строка [$b][$a]
 * @return строка $a
 */
function lang($a, $b = null) {
    global $LANG_VAR, $LANG_TRANS;
    // Вывод для основных языковых переменных
    if ($b == null) {
        if (isset($LANG_VAR[$a])) {
            return $LANG_VAR[$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
    // Вывод для языковых переменных из lang.lng
    if ($b != null) {
        if (isset($LANG_TRANS[$b][$a])) {
            return $LANG_TRANS[$b][$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
}

?>