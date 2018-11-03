<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 

if (isset($DEFAULT_LANGUAGE)) {
    $lang_default = $DEFAULT_LANGUAGE; //Язык авторизованного администратора/пользователя
} else {
    $lang_default = DEFAULT_LANGUAGE; //Язык по умолчанию базовый
}
//Подключение и парсинг языковых файлов
$files_path = $TREE->filesTree(ROOT . '/language/' . $lang_default . '/' . $PATH);

$parse_temp = parse_ini_file($files_path[0]);
for ($i = 0; $i < count($files_path); $i++) {
    $ini = parse_ini_file($files_path[$i]);
    $lang = array_merge($parse_temp, $ini); // Установка языкового массива
}

// Получаем список языков в массиве (для использования в мультиязычных функциях и т.п.)
$lang_all = array(); // массив с языками
$lang_dir = scandir(ROOT . '/language/');
array_push($lang_all, ucfirst($lang_default)); // первым в массиве идет язык по умолчанию
foreach ($lang_dir as $lang_name) {
    if (!in_array($lang_name, array('.', '..', $lang_default))) {
        array_push($lang_all, ucfirst($lang_name));
    }
}

//Функция для вывода языковой переменной вида: lang('pass');
function lang($a) {
    global $lang;
    
    if (isset($lang[$a]) == true) {
        return $lang[$a];
    } else {
        return $a;
    }
}

?>