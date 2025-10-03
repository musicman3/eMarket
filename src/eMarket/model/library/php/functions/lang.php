<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Lang function 
 * 
 * Example: 
 * 
 * lang('name') - language variable in the current language
 * lang('name', 'english') - language variable in the english language
 * lang('#lang_all') - all language variables for the current path in the current language (ex. admin + modules, catalog + modules)
 * lang('#admin') - language variables for admin path only in the current language
 * lang('#catalog') - language variables for catalog path only in the current language
 *
 * @param string $a
 * @param string $b
 * @param string $c
 * @return string|array
 */
function lang(?string $a = null, ?string $b = null, ?string $c = null): string|array {
    static $lang_var = null, $lang_trans = null, $lang_all = null, $admin = null, $catalog = null, $lang_default = null, $lang_all_trans = null;

    if ($lang_default == null) {
        \eMarket\Core\Lang::defaultLang();
        $lang_default = 'true';
    }

    if ($lang_all_trans == null && $b != null && $c == 'all') {
        $lang_all_trans = \eMarket\Core\Lang::lang($b);
    }

    if ($lang_all == null) {
        $lang_all = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'all');
    }

    if ($admin == null) {
        $admin = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'admin');
    }

    if ($catalog == null) {
        $catalog = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'catalog');
    }

    if ($lang_trans == null) {
        $lang_trans = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'translate');
    }

    if ($lang_var == null) {
        $lang_var = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE']);
    }

    if ($a == '#lang_all') {
        return $lang_all;
    }

    if ($a == '#admin') {
        return $admin;
    }

    if ($a == '#catalog') {
        return $catalog;
    }

    if ($a == null) {
        $lang_var['translate_name'] = $_SESSION['DEFAULT_LANGUAGE'];
        return $lang_var;
    }

    if ($b != null && $c == 'all') {
        if (isset($lang_all_trans[$a])) {
            return $lang_all_trans[$a];
        } else {
            return $a;
        }
    }

    if ($b == null) {
        if (isset($lang_var[$a])) {
            return $lang_var[$a];
        } else {
            return $a;
        }
    }

    if ($b != null) {
        if (isset($lang_trans[$b][$a])) {
            return $lang_trans[$b][$a];
        } else {
            return $a;
        }
    }
}
