<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Lang function (example: lang('name'), lang('name', 'english') or lang('#lang_all'))
 *
 * @param string $a
 * @param string $b
 * @param string $c
 * @return string|array
 */
function lang(?string $a = null, ?string $b = null, ?string $c = null): string|array {
    static $lang_var = null, $lang_trans = null, $lang_all = null, $lang_default = null, $lang_all_trans = null;

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

    if ($lang_trans == null) {
        $lang_trans = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE'], 'translate');
    }

    if ($lang_var == null) {
        $lang_var = \eMarket\Core\Lang::lang($_SESSION['DEFAULT_LANGUAGE']);
    }

    if ($a == '#lang_all') {
        return $lang_all;
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
