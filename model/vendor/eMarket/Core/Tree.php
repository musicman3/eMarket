<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для древовидных структур
 *
 * @package Tree
 * @author eMarket
 * 
 */
class Tree {

    /**
     * ФУНКЦИЯ ПОСТРОЕНИЯ ДЕРЕВА К ФАЙЛАМ (ПУСТЫЕ ПАПКИ ИГНОРИРУЮТСЯ)
     *
     * @param string $dir (путь к директории с файлами)
     * @return array $files (список файлов)
     */
    public function filesTree($dir) {
        $handle = opendir($dir) or die("Error: Can't open directory $dir");
        $files = [];
        $subfiles = [];
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
     * @param string $dir (путь к директории с файлами)
     * @param string|null $new_dir опционально (директория для перемещения)
     * @param string|null $rename опционально (префикс к имени файла)
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

    /**
     * ФУНКЦИЯ ВЫВОДА КАТЕГОРИЙ
     *
     * @param string $parent_id опционально (начальная директория)
     * @param array $array_cat (путь к директории с файлами)
     * @param string $marker (маркер для добавления класса в первый ul)
     */
    public function categories($parent_id = 0, $marker = null) {

        $PDO = new \eMarket\Core\Pdo;

        $result = $PDO->getObj("SELECT id, name, parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? ORDER BY sort_category DESC", [lang('#lang_all')[0]]);

        $array_cat = [];
        foreach ($result as $value) {
            $array_cat[$value->parent_id][] = $value;
        }

        if (empty($array_cat[$parent_id])) {
            return;
        }

        if ($marker != TRUE) {
            echo '<ul class="box-category treeview">';
        } else {
            echo '<ul>';
        }

        foreach ($array_cat[$parent_id] as $value) {
            echo '<li><a href="/listing/?category_id=' . $value->id . '&parent_id=' . $value->parent_id . '">' . $value->name . '</a>';
            self::categories($value->id, TRUE);
            echo '</li>';
        }


        if ($marker != TRUE) {
            echo '</ul>';
        } else {
            echo '</ul>';
        }
    }

}

?>