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
 * @param string $c
 * @return string
 * @return array $lang_all
 */
function lang($a = null, $b = null, $c = null) {
    static $lang_var = null, $lang_trans = null, $lang_all = null, $lang_default = null, $lang_all_trans = null;
    
    // Язык по-умолчанию
    if ($lang_default == null) {
        \eMarket\Lang::defaultLang();
        $lang_default = 'true';
    }

    //Устанавливаем $lang_all_trans (вывод основных языковых переменных для другого языка)
    if ($lang_all_trans == null && $b != null && $c == 'all') {
        $lang_all_trans = \eMarket\Lang::lang($b);
    }
    
        //Устанавливаем $lang_all (список языков в массиве)
    if ($lang_all == null) {
        $lang_all = \eMarket\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'all');
    }

    //Устанавливаем $lang_trans (вывод языка из lang.lng)
    if ($lang_trans == null) {
        $lang_trans = \eMarket\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'translate');
    }

    //Устанавливаем $lang_var (стандартный вывод)
    if ($lang_var == null) {
        $lang_var = \eMarket\Lang::lang($_SESSION['DEFAULT_LANGUAGE']);
    }

    //Если присутствует маркер #lang_all, то выводим $lang_all
    if ($a == '#lang_all') {
        return $lang_all;
    }
    
        // Вывод для основных языковых переменных другого языка
    if ($b != null && $c == 'all') {
        if (isset($lang_all_trans[$a])) {
            return $lang_all_trans[$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
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