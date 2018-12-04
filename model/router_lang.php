<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 

/**
 * Функция для вывода языковой переменной вида: lang('pass') или lang('pass', 'english');
 *
 * @param строка $a
 * @param строка $b
 * @return строка $a
 */
function lang($a = null, $b = null) {
    static $LANG_VAR = null, $LANG_TRANS = null, $LANG_ALL = null;

    $LANG = new \eMarket\Core\Lang;
    $SET = new \eMarket\Core\Set;
    $VALID = new \eMarket\Core\Valid;

    //Если пользователь не авторизован, то устанавливаем язык по умолчанию
    if (!isset($_SESSION['DEFAULT_LANGUAGE']) && $SET->path() != 'install') {
        $_SESSION['DEFAULT_LANGUAGE'] = DEFAULT_LANGUAGE;
    }

    //Если первый раз в инсталляторе, то устанавливаем язык по умолчанию Russian
    if (!$VALID->inPOST('language') && $SET->path() == 'install') {
        $_SESSION['DEFAULT_LANGUAGE'] = 'russian';
    }

    //Если переключили язык не авторизованно или в инсталляторе
    if ($VALID->inPOST('language')) {
        $_SESSION['DEFAULT_LANGUAGE'] = $VALID->inPOST('language');
    }

    if (!isset($LANG_ALL)) {
        $LANG_ALL = $LANG->lang($_SESSION['DEFAULT_LANGUAGE'], 'all');
    }

    if (!isset($LANG_TRANS)) {
        $LANG_TRANS = $LANG->lang($_SESSION['DEFAULT_LANGUAGE'], 'translate');
    }

    if (!isset($LANG_VAR)) {
        $LANG_VAR = $LANG->lang($_SESSION['DEFAULT_LANGUAGE']);
    }

    if ($a == '#lang_all') {

        return $LANG_ALL;
    }

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