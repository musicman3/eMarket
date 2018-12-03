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

//Подключение и парсинг языковых файлов
$files_path = $TREE->filesTree(getenv('DOCUMENT_ROOT') . '/language/' . $DEFAULT_LANGUAGE . '/' . $SET->path());

$lang = parse_ini_file($files_path[0], FALSE, INI_SCANNER_RAW);
for ($i = 0; $i < count($files_path); $i++) {
    $ini = parse_ini_file($files_path[$i], FALSE, INI_SCANNER_RAW);
    $lang = array_merge($lang, $ini); // Установка языкового массива
}

// Получаем список языков в массиве (для использования в мультиязычных функциях и т.п.)
$lang_all = array(); // массив с языками
$lang_dir = scandir(getenv('DOCUMENT_ROOT') . '/language/');
$_lang = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $DEFAULT_LANGUAGE . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
array_push($lang_all, $DEFAULT_LANGUAGE); // первым в массиве идет язык по умолчанию

foreach ($lang_dir as $lang_name) {
    // Собираем данные для списка языков
    if (!in_array($lang_name, array('.', '..', $DEFAULT_LANGUAGE))) {
        array_push($lang_all, $lang_name);

        // Собираем данные из всех general.lng
        $ini_lang = parse_ini_file(getenv('DOCUMENT_ROOT') . '/language/' . $lang_name . '/admin/lang.lng', TRUE, INI_SCANNER_RAW);
        $_lang = array_merge($_lang, $ini_lang);
    }
}

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
    global $lang, $_lang;
    // Вывод для основных языковых переменных
    if ($b == null) {
        if (isset($lang[$a])) {
            return $lang[$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
    // Вывод для языковых переменных из lang.lng
    if ($b != null) {
        if (isset($_lang[$b][$a])) {
            return $_lang[$b][$a]; // Если языковая переменная найдена, то выводим ее значение
        } else {
            return $a; // Если языковая переменная не найдена, то выводим ее название
        }
    }
}

?>