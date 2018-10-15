<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//ФУНКЦИЯ ПОЛУЧЕНИЯ ПОЛНОГО ПУТИ К ФАЙЛАМ С УЧЕТОМ ПОДКАТЕГОРИЙ (БЕЗ ПУСТЫХ ПАПОК)
function FilesPatch($dir) {
    $handle = opendir($dir) or die("Error: Can't open directory $dir");
    $files = Array();
    $subfiles = Array();
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != '.gitkeep') {
            if (is_dir($dir . "/" . $file)) {

                // Получим список файлов вложенной папки...  
                $subfiles = FilesPatch($dir . "/" . $file);

                // ...и добавим их к общему списку  
                $files = array_merge($files, $subfiles);
            } else {
                $files[] = $dir . "/" . $file;
            }
        }
    }
    closedir($handle);
    return $files;
}

//Текущий основной путь (admin или catalog)
$uri_explode = explode('/', ($VALID->inSERVER('REQUEST_URI')));
$patch = $uri_explode[2];

//Подключение и парсинг языкового файла
$lang_default = DEFAULT_LANGUAGE; //Язык по умолчанию

$files_patch = FilesPatch($VALID->inSERVER('DOCUMENT_ROOT') . '/language/' . $lang_default . '/' . $patch);
$parse_temp = parse_ini_file($files_patch[0]);
for ($i = 0; $i < count($files_patch); $i++) {
    $ini = parse_ini_file($files_patch[$i]);
    $lang = array_merge($parse_temp, $ini); // Установка языкового массива
}

// Получаем список языков в массиве (для использования в мультиязычных функциях и т.п.)
$lang_all = array(); // массив с языками
$lang_dir = scandir($VALID->inSERVER('DOCUMENT_ROOT') . '/language/');
array_push($lang_all, ucfirst($lang_default)); // первым в массиве идет язык по умолчанию
foreach ($lang_dir as $lang_name) {
    if (!in_array($lang_name, array('.', '..', $lang_default))){
        array_push($lang_all, ucfirst($lang_name));
    }
}

?>