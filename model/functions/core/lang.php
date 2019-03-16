<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 

/**
 * Функция для вывода языковой переменной вида: lang('name'), lang('name', 'english') или lang('#lang_all')
 *
 * @param string $a
 * @param string $b
 * @return string
 * @return array $lang_all
 */
function lang($a = null, $b = null) {
    static $lang_var = null, $lang_trans = null, $lang_all = null;

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
    if ($VALID->inGET('language')) {
        $_SESSION['DEFAULT_LANGUAGE'] = $VALID->inGET('language');
    }

    //Устанавливаем $lang_all
    if (!isset($lang_all)) {
        $lang_all = $LANG->lang($_SESSION['DEFAULT_LANGUAGE'], 'all');
    }

    //Устанавливаем $lang_trans
    if (!isset($lang_trans)) {
        $lang_trans = $LANG->lang($_SESSION['DEFAULT_LANGUAGE'], 'translate');
    }

    //Устанавливаем $lang_var
    if (!isset($lang_var)) {
        $lang_var = $LANG->lang($_SESSION['DEFAULT_LANGUAGE']);
    }

    //Если присутствует маркер #lang_all, то выводим $lang_all
    if ($a == '#lang_all') {
        return $lang_all;
    }

    // Вывод для основных языковых переменных
    if ($b == null) {
        if (isset($lang_var[$a])) {
            return $lang_var[$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
    // Вывод для языковых переменных из lang.lng
    if ($b != null) {
        if (isset($lang_trans[$b][$a])) {
            return $lang_trans[$b][$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
}

?>