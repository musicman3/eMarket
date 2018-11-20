<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Если пользователь не авторизован, то устанавливаем язык по умолчанию
if (isset($DEFAULT_LANGUAGE) == FALSE && $PATH != 'install') {
    $DEFAULT_LANGUAGE = DEFAULT_LANGUAGE;
}
//Если первый раз в инсталляторе, то устанавливаем язык по умолчанию Russian
if ($VALID->inPOST('language') == FALSE && $PATH == 'install') {
    $DEFAULT_LANGUAGE = 'Russian';
}
//Если переключили язык не авторизованно или в инсталляторе
if ($VALID->inPOST('language') == TRUE) {
    $DEFAULT_LANGUAGE = $VALID->inPOST('language');
}

// Получаем список языков в массиве (для использования в мультиязычных функциях и т.п.)
$lang_all = array(); // массив с языками
$lang_dir = scandir(getenv('DOCUMENT_ROOT') . '/language/');
array_push($lang_all, ucfirst($DEFAULT_LANGUAGE)); // первым в массиве идет язык по умолчанию
foreach ($lang_dir as $lang_name) {
    if (!in_array($lang_name, array('.', '..', $DEFAULT_LANGUAGE))) {
        array_push($lang_all, ucfirst($lang_name));
    }
}

/**
 * Функция для вывода языковой переменной вида: lang('name') или lang('name', 'english')
 *
 * @param строка $a
 * @param строка $b
 * @return строка $a
 */
function lang($a, $b = null) {
    global $TREE, $PATH, $DEFAULT_LANGUAGE;

    // Если указан дополнительный параметр $b (название другого языка, напр. english)
    if ($b != null) {
        // То подключаем файл другого языка, чтобы оттуда взять нужную языковую переменную
        if (!isset($_SESSION['files_path2']) OR isset($_SESSION['files_path_temp2']) == TRUE && $_SESSION['files_path_temp2'] != strtolower($b) . '/' . $PATH) {
            $_SESSION['files_path2'] = $TREE->filesTree(getenv('DOCUMENT_ROOT') . '/language/' . strtolower($b) . '/' . $PATH);
            $_SESSION['files_path_temp2'] = strtolower($b) . '/' . $PATH;
        
        $parse_temp = parse_ini_file($_SESSION['files_path2'][0]);
        for ($i = 0; $i < count($_SESSION['files_path2']); $i++) {
            $ini = parse_ini_file($_SESSION['files_path2'][$i]);
            $_SESSION['lang2'] = array_merge($parse_temp, $ini); // Установка языкового массива
        }
        }
        if (isset($_SESSION['lang2'][$a])) {
            return $_SESSION['lang2'][$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    } else {
        // Если дополнительного параметра нет, то выводим стандартно
        if (!isset($_SESSION['files_path']) OR isset($_SESSION['files_path_temp']) == TRUE && $_SESSION['files_path_temp'] != strtolower($DEFAULT_LANGUAGE) . '/' . $PATH) {
            $_SESSION['files_path'] = $TREE->filesTree(getenv('DOCUMENT_ROOT') . '/language/' . strtolower($DEFAULT_LANGUAGE) . '/' . $PATH);
            $_SESSION['files_path_temp'] = strtolower($DEFAULT_LANGUAGE) . '/' . $PATH;
        
        $parse_temp = parse_ini_file($_SESSION['files_path'][0]);
        for ($i = 0; $i < count($_SESSION['files_path']); $i++) {
            $ini = parse_ini_file($_SESSION['files_path'][$i]);
            $_SESSION['lang'] = array_merge($parse_temp, $ini); // Установка языкового массива
        }
        }
        if (isset($_SESSION['lang'][$a])) {
            return $_SESSION['lang'][$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
}

?>