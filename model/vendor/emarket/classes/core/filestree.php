<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class FilesTree {

//ФУНКЦИЯ ПОСТРОЕНИЯ ДЕРЕВА К ФАЙЛАМ С УЧЕТОМ ПОДКАТЕГОРИЙ (ПУСТЫЕ ПАПКИ НЕ ВКЛЮЧАЮТСЯ)
function Tree($dir) {
    $handle = opendir($dir) or die("Error: Can't open directory $dir");
    $files = Array();
    $subfiles = Array();
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != '.gitkeep') { //Исключаемые данные
            if (is_dir($dir . "/" . $file)) {

                // Получим список файлов вложенной папки...  
                $subfiles = $this->Tree($dir . "/" . $file);

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

}

?>