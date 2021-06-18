<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use \eMarket\Core\{
    Valid
};

/**
 * Tree
 *
 * @package Tree
 * @author eMarket
 * 
 */
class Tree {

    /**
     * Building tree to files
     *
     * @param string $dir Path to directory with files
     * @return array
     */
    public static function filesTree($dir) {

        $handle = opendir($dir) or die("Error: Can't open directory $dir");
        $files = [];
        $subfiles = [];
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && $file != '.gitkeep' && $file != '.gitignore') {
                if (is_dir($dir . '/' . $file)) {

                    $subfiles = self::filesTree($dir . '/' . $file);

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
     * Function of moving or deleting files
     *
     * @param string $dir Path to directory with files
     * @param string|null $new_dir Directory to move
     * @param string|null $rename Prefix
     */
    public static function filesDirAction($dir, $new_dir = null, $rename = null) {

        $files = glob($dir . '*');
        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                if (isset($new_dir)) {
                    copy($file, $new_dir . $rename . basename($file));
                }
                chmod($file, 0777);
                unlink($file);
            }
        }
    }

    /**
     * List of all directories up to level 2
     *
     * @param string $path Path to directory with files
     * @param string $marker Marker
     * @return array
     */
    public static function allDirForPath($path, $marker = null) {

        $level_1 = array_values(array_diff(scandir($path), ['..', '.']));
        if ($marker == 'true') {
            $level_2 = [];
            foreach ($level_1 as $value) {
                $level_2 = array_merge($level_2, [$value => self::allDirForPath($path . $value)]);
            }
            return $level_2;
        } else {
            return $level_1;
        }
    }

    /**
     * Show Categories
     *
     * @param array $sql Array of categories
     * @param string $id Id
     * @param array $array_cat2 Auxiliary array
     * @param string $parent_id Parrent id
     * @param string $marker Marker
     * @return array
     */
    public static function categories($sql, $id = null, $array_cat2 = [], $parent_id = 0, $marker = null) {

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
            echo '<ul class="box-category">';
        } else {
            echo '<ul>';
        }

        foreach ($array_cat[$parent_id] as $value) {
            echo '<li id="cat_' . $value->id . '"><a id="namecat_' . $value->id . '" href="?route=listing&category_id=' . $value->id . '">' . $value->name . '</a><span></span>';
            self::categories($sql, null, $array_cat2, $value->id, TRUE);
            echo '</li>';
        }

        echo '</ul>';

        return $array_cat2;
    }

    /**
     * Autoloading class files for modules
     *
     * @return array $return_array
     */
    public static function treeUp() {
        $sql = \eMarket\Core\Pdo::getObj("SELECT id, name, status, parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND status=? ORDER BY sort_category DESC", [lang('#lang_all')[0], 1]);
        self::$categories_and_breadcrumb = \eMarket\Core\Func::escapeSign(\eMarket\Core\Tree::categories($sql, \eMarket\Core\Valid::inGET('category_id')));
    }

    /**
     * Autoloading class files for modules
     *
     * @return array $return_array
     */
    public static function modulesClasses() {

        $list_cat = self::allDirForPath(getenv('DOCUMENT_ROOT') . '/modules/', 'true');
        $return_array = [];

        foreach ($list_cat as $key => $val) {
            foreach ($val as $val_2) {
                if (file_exists(getenv('DOCUMENT_ROOT') . '/modules/' . $key . '/' . $val_2 . '/model/classes/')) {
                    $list_val = self::allDirForPath(getenv('DOCUMENT_ROOT') . '/modules/' . $key . '/' . $val_2 . '/model/classes/');
                    foreach ($list_val as $val_files) {
                        array_push($return_array, getenv('DOCUMENT_ROOT') . '/modules/' . $key . '/' . $val_2 . '/model/classes/' . $val_files);
                    }
                }
            }
        }

        return $return_array;
    }

}
