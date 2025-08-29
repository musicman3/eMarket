<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Func
};

/**
 * Tree
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Tree {

    /**
     * Building tree to files
     *
     * @param string $dir Path to directory with files
     * @return array
     */
    public static function filesTree(string $dir): array {

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
     * @param string $new_dir Directory to move
     * @param string $rename Prefix
     */
    public static function filesDirAction(string $dir, ?string $new_dir = null, ?string $rename = null): void {

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
    public static function allDirForPath(string $path, ?string $marker = null): array {

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
     * @param array $categories Array of categories
     * @param mixed $id Id
     * @param array $output Auxiliary array
     * @param int|string $parent_id Parrent id
     * @param bool $marker Marker
     * @return array
     */
    public static function categories(array $categories, mixed $id = null, array $output = [], int|string $parent_id = 0, ?bool $marker = null): mixed {

        $array_cat = [];
        foreach ($categories as $value) {
            $array_cat[$value->parent_id][] = $value;

            if ($value->id == $id && $value->parent_id > 0) {
                $output[] = $value->parent_id;
                return self::categories($categories, $value->parent_id, $output);
            }
        }

        if (empty($array_cat[$parent_id])) {
            return null;
        }

        if ($marker != TRUE) {
            echo '<ul class="box-category">';
        } else {
            echo '<ul>';
        }

        foreach ($array_cat[$parent_id] as $value) {
            echo '<li id="cat_' . $value->id . '"><a id="namecat_' . $value->id . '" href="?route=listing&category_id=' . $value->id . '">' . Func::outputDataFiltering($value->name) . '</a><span></span>';
            self::categories($categories, null, $output, $value->id, TRUE);
            echo '</li>';
        }

        echo '</ul>';

        return $output;
    }

    /**
     * Autoloading class files for modules
     *
     * @return array $output
     */
    public static function modulesClasses(): array {

        $list_cat = self::allDirForPath(getenv('DOCUMENT_ROOT') . '/modules/', 'true');
        $output = [];

        foreach ($list_cat as $key => $val) {
            foreach ($val as $val_2) {
                if (file_exists(getenv('DOCUMENT_ROOT') . '/modules/' . $key . '/' . $val_2 . '/model/')) {
                    $list_val = self::allDirForPath(getenv('DOCUMENT_ROOT') . '/modules/' . $key . '/' . $val_2 . '/model/');
                    foreach ($list_val as $val_files) {
                        array_push($output, getenv('DOCUMENT_ROOT') . '/modules/' . $key . '/' . $val_2 . '/model/' . $val_files);
                    }
                }
            }
        }

        return $output;
    }

}
