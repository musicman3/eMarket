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
     * @param array $sql (массив категорий в виде объекта)
     * @param string $id (id от которого нужно собирать предков вверх, передается через GET)
     * @param array $array_cat2 (вспомогательный массив)
     * @param string $parent_id (родительская категория для дерева)
     * @param string $marker (маркер для добавления класса в первый ul)
     * @return array $array_cat2 (массив всех предков для breadcrumb)
     */
    public function categories($sql, $id = null, $array_cat2 = [], $parent_id = 0, $marker = null) {
        $VALID = new \eMarket\Core\Valid;

        $array_cat = [];
        foreach ($sql as $value) {
            $array_cat[$value->parent_id][] = $value;
            
            if ($value->id == $id && $value->parent_id > 0) {
                $array_cat2[] = $value->parent_id;
                return self::categories($sql, $value->parent_id, $array_cat2);
            }
            
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
            if ($value->id == $VALID->inGET('category_id') OR in_array($value->id, $array_cat2)) {
                echo '<li class="collapsable open" id="' . $value->id . '"><a href="?route=listing&category_id=' . $value->id . '&parent_id=' . $value->parent_id . '">' . $value->name . '</a>';
            } else {
                echo '<li class="expandable" id="' . $value->id . '"><a href="?route=listing&category_id=' . $value->id . '&parent_id=' . $value->parent_id . '">' . $value->name . '</a>';
            }
            self::categories($sql, null, $array_cat2, $value->id, TRUE);
            echo '</li>';
        }

        if ($marker != TRUE) {
            echo '</ul>';
        } else {
            echo '</ul>';
        }
        return $array_cat2;
    }

}

?>