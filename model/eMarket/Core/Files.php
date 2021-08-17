<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Func,
    Pdo,
    Tree,
    Valid
};

/**
 * Class for working with files
 *
 * @package Files
 * @author eMarket
 * 
 */
class Files {

    /**
     * Images uploader
     *
     * @param string $TABLE DB table
     * @param string $dir Directory for uploaded images
     * @param array $resize_param Resize param
     */
    public static function imgUpload($TABLE, $dir, $resize_param) {

        self::imgThumbAndSize($resize_param);

        $prefix = time() . '_';
        $files = glob(ROOT . '/uploads/temp/files/*');
        $count_files = count($files);

        if (Valid::inPostJson('file_upload') == 'empty') {
            Tree::filesDirAction(ROOT . '/uploads/temp/originals/');
            Tree::filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            Tree::filesDirAction(ROOT . '/uploads/temp/files/');
            exit;
        }

        if (Valid::inPOST('add')) {
            if ($count_files > 0) {
                self::imgResize($dir, $files, $prefix, $resize_param);
            }

            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                if (Valid::inPOST('set_language')) {
                    $language = Valid::inPOST('set_language');
                } else {
                    $language = lang('#lang_all')[0];
                }

                $id_max = Pdo::selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [$language]);
                $id = intval($id_max);

                $image_list = [];
                foreach ($files as $file) {
                    if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                        array_push($image_list, basename($file));
                    }
                }

                if (count($image_list) > 0) {
                    $general_image_add = $image_list[0];
                }

                if (Valid::inPOST('general_image_add')) {
                    $general_image_add = $prefix . Valid::inPOST('general_image_add');
                }

                Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

                Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_add, $id]);
            }
        }

        if (Valid::inPOST('edit')) {

            $id = Valid::inPOST('edit');

            self::imgResize($dir, $files, $prefix, $resize_param);

            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list = json_decode(Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                    array_push($image_list, basename($file));
                }
            }

            if (count($image_list) > 0) {
                $general_image_edit = $image_list[0];
            }

            if (Valid::inPOST('general_image_edit')) {
                $general_image_edit = Valid::inPOST('general_image_edit');
            }

            if (Valid::inPOST('general_image_edit_new')) {
                $general_image_edit = $prefix . Valid::inPOST('general_image_edit_new');
            }

            Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            if (isset($general_image_edit)) {
                Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_edit, $id]);
            } else {
                Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list), $id]);
            }

            if (Valid::inPOST('delete_image')) {
                $delete_image_arr = explode(',', Valid::inPOST('delete_image'), -1);

                $image_list_arr = json_decode(Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
                $image_list_new = [];
                foreach ($image_list_arr as $key => $file) {
                    if (!in_array($file, $delete_image_arr)) {
                        array_push($image_list_new, $file);
                    } else {
                        foreach ($resize_param as $key => $value) {
                            Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                        }
                        Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        if ($file == Pdo::selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$id])) {
                            Pdo::action("UPDATE " . $TABLE . " SET logo_general=? WHERE id=?", [NULL, $id]);
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update) && count($image_list_new) > 0) {
                    Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list_new), $image_list_new[0], $id]);
                } else {
                    Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list_new), $id]);
                }
            }
        }

        if (Valid::inPOST('delete')) {
            if (!is_array(Valid::inPOST('delete'))) {
                $idx = [Valid::inPOST('delete')];
            } else {
                $idx = Func::deleteEmptyInArray(Valid::inPOST('delete'));
            }
            if (is_countable($idx)) {
                for ($i = 0; $i < count($idx); $i++) {
                    if (strstr($idx[$i], '_', true) != 'product') {
                        $id = $idx[$i];

                        $logo_delete = json_decode(Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
                        if (is_countable($logo_delete)) {
                            foreach ($logo_delete as $file) {
                                foreach ($resize_param as $key => $value) {
                                    Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                                }
                                Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                            }
                        }
                    }
                }
            }
        }

        if (Valid::inPostJson('delete_new_image') == 'ok' && Valid::inPostJson('delete_image')) {
            $id = Valid::inPostJson('delete_image');

            Func::deleteFile(ROOT . '/uploads/temp/files/' . $id);
            Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . $id);
        }
    }

    /**
     * Product images uploader
     *
     * @param string $TABLE DB table
     * @param string $dir Directory for uploaded images
     * @param array $resize_param Resize param
     */
    public static function imgUploadProduct($TABLE, $dir, $resize_param) {

        self::imgThumbAndSize($resize_param);

        $prefix = time() . '_';

        $files = glob(ROOT . '/uploads/temp/files/*');
        $count_files = count($files);

        if (Valid::inPostJson('file_upload') == 'empty') {
            Tree::filesDirAction(ROOT . '/uploads/temp/originals/');
            Tree::filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            Tree::filesDirAction(ROOT . '/uploads/temp/files/');
            exit;
        }

        if (Valid::inPOST('add_product')) {
            if ($count_files > 0) {
                self::imgResize($dir, $files, $prefix, $resize_param);
            }

            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                if (Valid::inPOST('set_language')) {
                    $language = Valid::inPOST('set_language');
                } else {
                    $language = lang('#lang_all')[0];
                }

                $id_max = Pdo::selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [$language]);
                $id = intval($id_max);

                $image_list = [];
                foreach ($files as $file) {
                    if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                        array_push($image_list, basename($file));
                    }
                }

                if (count($image_list) > 0) {
                    $general_image_add = $image_list[0];
                }

                if (Valid::inPOST('general_image_add_product')) {
                    $general_image_add = $prefix . Valid::inPOST('general_image_add_product');
                }

                Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

                Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_add, $id]);
            }
        }

        if (Valid::inPOST('edit_product')) {

            $id = Valid::inPOST('edit_product');

            self::imgResize($dir, $files, $prefix, $resize_param);

            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list = json_decode(Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                    array_push($image_list, basename($file));
                }
            }

            if (count($image_list) > 0) {
                $general_image_edit = $image_list[0];
            }

            if (Valid::inPOST('general_image_edit_product')) {
                $general_image_edit = Valid::inPOST('general_image_edit_product');
            }

            if (Valid::inPOST('general_image_edit_new_product')) {
                $general_image_edit = $prefix . Valid::inPOST('general_image_edit_new_product');
            }

            Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            if (isset($general_image_edit)) {
                Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_edit, $id]);
            } else {
                Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list), $id]);
            }

            if (Valid::inPOST('delete_image_product')) {
                $delete_image_arr = explode(',', Valid::inPOST('delete_image_product'), -1);

                $image_list_arr = json_decode(Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
                $image_list_new = [];
                foreach ($image_list_arr as $key => $file) {
                    if (!in_array($file, $delete_image_arr)) {
                        array_push($image_list_new, $file);
                    } else {
                        foreach ($resize_param as $key => $value) {
                            Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                        }
                        Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        if ($file == Pdo::selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$id])) {
                            Pdo::action("UPDATE " . $TABLE . " SET logo_general=? WHERE id=?", [NULL, $id]);
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update) && is_array($image_list_new)) {
                    Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list_new), $image_list_new[0], $id]);
                } else {
                    Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list_new), $id]);
                }
            }
        }

        if (Valid::inPOST('delete')) {
            $idx = Func::deleteEmptyInArray(Valid::inPOST('delete'));

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) == 'product') {
                    $id = explode('product_', $idx[$i]);

                    $logo_delete = json_decode(Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id[1]]), 1);
                    if (is_countable($logo_delete)) {
                        foreach ($logo_delete as $file) {
                            foreach ($resize_param as $key => $value) {
                                Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                            }
                            Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        }
                    }
                }
            }
        }

        if (Valid::inPostJson('delete_new_image_product') == 'ok' && Valid::inPostJson('delete_image_product')) {
            $id = Valid::inPostJson('delete_image_product');

            Func::deleteFile(ROOT . '/uploads/temp/files/' . $id);
            Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . $id);
        }
    }

    /**
     * Images resize
     *
     * @param string $dir Directory for uploaded images
     * @param array $files Files array
     * @param string $prefix Prefix fo files
     * @param array $resize_param Resize param
     */
    public static function imgResize($dir, $files, $prefix, $resize_param) {

        $IMAGE = new \claviska\SimpleImage;

        $resize_max = self::imgResizeMax($resize_param);

        foreach ($files as $file) {
            if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                foreach ($resize_param as $key => $value) {

                    $width = $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))->getWidth();
                    $height = $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))->getHeight();

                    $quality_width = $resize_max[0];
                    $quality_height = $resize_max[1];

                    if ($width >= $quality_width OR $height >= $quality_height) {
                        if (!file_exists(ROOT . '/uploads/temp/originals/' . $prefix . basename($file))) {
                            copy(ROOT . '/uploads/temp/files/' . basename($file), ROOT . '/uploads/temp/originals/' . $prefix . basename($file));
                        }
                        $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . basename($file))
                                ->autoOrient()
                                ->bestFit($value[0], $value[1]);
                        if (Valid::inPOST('effect-product') == 'effect-sepia') {
                            $IMAGE->sepia();
                        }
                        if (Valid::inPOST('effect-product') == 'effect-black-white') {
                            $IMAGE->desaturate();
                        }
                        if (Valid::inPOST('effect-product') == 'effect-blur-1') {
                            $IMAGE->blur('selective', 1);
                        }
                        if (Valid::inPOST('effect-product') == 'effect-blur-2') {
                            $IMAGE->blur('selective', 2);
                        }
                        $IMAGE->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                    }
                }

                Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . basename($file));
                Func::deleteFile(ROOT . '/uploads/temp/files/' . basename($file));
            }
        }
    }

    /**
     * Array of maximum image sizes after resize
     *
     * @param array $resize_param Resize param
     * @return array Resize parameters for maximum quality
     */
    public static function imgResizeMax($resize_param) {

        $count_image_max = count($resize_param);
        $resize_max = [];
        array_push($resize_max, [$resize_param[$count_image_max - 1][0], $resize_param[$count_image_max - 1][1]]);
        return $resize_max[0];
    }

    /**
     * Thumbnail slicing and image resizing function on Ajax request
     *
     * @param array $resize_param Resize param
     */
    public static function imgThumbAndSize($resize_param) {

        $IMAGE = new \claviska\SimpleImage;
        $resize_max = self::imgResizeMax($resize_param);

        if (Valid::inPostJson('image_data')) {
            $file = Valid::inPostJson('image_data');

            $image_data = getimagesize(ROOT . '/uploads/temp/files/' . $file);
            $width = $image_data[0];
            $height = $image_data[1];

            $quality_width = $resize_max[0];
            $quality_height = $resize_max[1];

            if ($width >= $quality_width OR $height >= $quality_height) {
                $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . $file)
                        ->autoOrient()
                        ->bestFit($resize_param[0][0], $resize_param[0][1]);
                if (Valid::inPostJson('effect_edit') == 'effect-sepia') {
                    $IMAGE->sepia();
                }
                if (Valid::inPostJson('effect_edit') == 'effect-black-white') {
                    $IMAGE->desaturate();
                }
                if (Valid::inPostJson('effect_edit') == 'effect-blur-1') {
                    $IMAGE->blur('selective', 1);
                }
                if (Valid::inPostJson('effect_edit') == 'effect-blur-2') {
                    $IMAGE->blur('selective', 2);
                }
                $IMAGE->toFile(ROOT . '/uploads/temp/thumbnail/' . $file);
            }
            // Ajax request
            echo json_encode($image_data);
            exit();
        }
    }

}
