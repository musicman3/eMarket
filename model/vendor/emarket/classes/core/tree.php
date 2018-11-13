<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

namespace eMarket\Classes\Core;

class Tree {

    /**
     * ФУНКЦИЯ ПОСТРОЕНИЯ ДЕРЕВА К ФАЙЛАМ (ПУСТЫЕ ПАПКИ ИГНОРИРУЮТСЯ)
     *
     * @param строка $dir
     * @return массив $files
     */
    public function filesTree($dir) { // $dir - путь к директории с файлами
        $handle = opendir($dir) or die("Error: Can't open directory $dir");
        $files = Array();
        $subfiles = Array();
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && $file != '.gitkeep') { //Исключаемые данные
                if (is_dir($dir . '/' . $file)) {

                    // Получим список файлов вложенной папки...  
                    $subfiles = $this->filesTree($dir . '/' . $file);

                    // ...и добавим их к общему списку  
                    $files = array_merge($files, $subfiles);
                } else {
                    $files[] = $dir . '/' . $file;
                }
            }
        }
        closedir($handle);
        return $files;
    }

}

?>