<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

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
            if ($file != '.' && $file != '..' && $file != '.gitkeep' && $file != '.gitignore') { //Исключаемые данные
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

    /**
     * ФУНКЦИЯ ПЕРЕМЕЩЕНИЯ ИЛИ УДАЛЕНИЯ ФАЙЛОВ
     *
     * @param строка $dir
     * @param строка $new_dir = null (директория для перемещения)
     * @param строка $rename = null (префикс к имени файла)
     */
    public function filesDirAction($dir, $new_dir = null, $rename = null) { // $dir - путь к директории с файлами
        $files = glob($dir . '*');
        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                if (isset($new_dir)) {
                    copy($file, $new_dir . $rename . basename($file)); // Переименовываем и копируем файлы в новое место
                }
                chmod($file, 0777);
                unlink($file); // Удаляем старые файлы
            }
        }
    }

}

?>