<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

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

        if (\eMarket\Core\Valid::inPOST('file_upload') == 'empty') {
            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/originals/');
            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/files/');
        }

        if (\eMarket\Core\Valid::inPOST('add')) {
            if ($count_files > 0) {
                self::imgResize($dir, $files, $prefix, $resize_param);
            }

            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                if (\eMarket\Core\Valid::inPOST('set_language')) {
                    $language = \eMarket\Core\Valid::inPOST('set_language');
                } else {
                    $language = lang('#lang_all')[0];
                }

                $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [$language]);
                $id = intval($id_max);

                $image_list = [];
                foreach ($files as $file) {
                    if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                        array_push($image_list, basename($file));
                    }
                }

                if (count($image_list) > 0) {
                    $general_image_add = $image_list[0];
                }

                if (\eMarket\Core\Valid::inPOST('general_image_add')) {
                    $general_image_add = $prefix . \eMarket\Core\Valid::inPOST('general_image_add');
                }

                \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

                \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_add, $id]);
            }
        }

        if (\eMarket\Core\Valid::inPOST('edit')) {

            $id = \eMarket\Core\Valid::inPOST('edit');

            self::imgResize($dir, $files, $prefix, $resize_param);

            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list = json_decode(\eMarket\Core\Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    array_push($image_list, basename($file));
                }
            }

            if (count($image_list) > 0) {
                $general_image_edit = $image_list[0];
            }

            if (\eMarket\Core\Valid::inPOST('general_image_edit')) {
                $general_image_edit = \eMarket\Core\Valid::inPOST('general_image_edit');
            }

            if (\eMarket\Core\Valid::inPOST('general_image_edit_new')) {
                $general_image_edit = $prefix . \eMarket\Core\Valid::inPOST('general_image_edit_new');
            }

            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            if (isset($general_image_edit)) {
                \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_edit, $id]);
            } else {
                \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list), $id]);
            }

            if (\eMarket\Core\Valid::inPOST('delete_image')) {
                $delete_image_arr = explode(',', \eMarket\Core\Valid::inPOST('delete_image'), -1);

                $image_list_arr = json_decode(\eMarket\Core\Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
                $image_list_new = [];
                foreach ($image_list_arr as $key => $file) {
                    if (!in_array($file, $delete_image_arr)) {
                        array_push($image_list_new, $file);
                    } else {
                        foreach ($resize_param as $key => $value) {
                            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                        }
                        \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        if ($file == \eMarket\Core\Pdo::selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$id])) {
                            \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo_general=? WHERE id=?", [NULL, $id]);
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update) && count($image_list_new) > 0) {
                    \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list_new), $image_list_new[0], $id]);
                } else {
                    \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list_new), $id]);
                }
            }
        }

        if (\eMarket\Core\Valid::inPOST('delete')) {
            if (!is_array(\eMarket\Core\Valid::inPOST('delete'))) {
                $idx = [\eMarket\Core\Valid::inPOST('delete')];
            } else {
                $idx = \eMarket\Core\Func::deleteEmptyInArray(\eMarket\Core\Valid::inPOST('delete'));
            }
            if (is_countable($idx)) {
                for ($i = 0; $i < count($idx); $i++) {
                    if (strstr($idx[$i], '_', true) != 'product') {
                        $id = $idx[$i];

                        $logo_delete = json_decode(\eMarket\Core\Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
                        if (is_countable($logo_delete)) {
                            foreach ($logo_delete as $file) {
                                foreach ($resize_param as $key => $value) {
                                    \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                                }
                                \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                            }
                        }
                    }
                }
            }
        }

        if (\eMarket\Core\Valid::inPOST('delete_new_image') == 'ok' && \eMarket\Core\Valid::inPOST('delete_image')) {
            $id = \eMarket\Core\Valid::inPOST('delete_image');

            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/temp/files/' . $id);
            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . $id);
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

        if (\eMarket\Core\Valid::inPOST('file_upload') == 'empty') {
            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/originals/');
            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/files/');
        }

        if (\eMarket\Core\Valid::inPOST('add_product')) {
            if ($count_files > 0) {
                self::imgResize($dir, $files, $prefix, $resize_param);
            }

            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                if (\eMarket\Core\Valid::inPOST('set_language')) {
                    $language = \eMarket\Core\Valid::inPOST('set_language');
                } else {
                    $language = lang('#lang_all')[0];
                }

                $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . $TABLE . " WHERE language=? ORDER BY id DESC", [$language]);
                $id = intval($id_max);

                $image_list = [];
                foreach ($files as $file) {
                    if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                        array_push($image_list, basename($file));
                    }
                }

                if (count($image_list) > 0) {
                    $general_image_add = $image_list[0];
                }
 
                if (\eMarket\Core\Valid::inPOST('general_image_add_product')) {
                    $general_image_add = $prefix . \eMarket\Core\Valid::inPOST('general_image_add_product');
                }

                \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

                \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_add, $id]);
            }
        }

        if (\eMarket\Core\Valid::inPOST('edit_product')) {

            $id = \eMarket\Core\Valid::inPOST('edit_product');

            self::imgResize($dir, $files, $prefix, $resize_param);

            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list = json_decode(\eMarket\Core\Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') { // Исключаемые данные
                    array_push($image_list, basename($file));
                }
            }

            if (count($image_list) > 0) {
                $general_image_edit = $image_list[0];
            }

            if (\eMarket\Core\Valid::inPOST('general_image_edit_product')) {
                $general_image_edit = \eMarket\Core\Valid::inPOST('general_image_edit_product');
            }
 
            if (\eMarket\Core\Valid::inPOST('general_image_edit_new_product')) {
                $general_image_edit = $prefix . \eMarket\Core\Valid::inPOST('general_image_edit_new_product');
            }

            \eMarket\Core\Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $dir . '/originals/');

            if (isset($general_image_edit)) {
                \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list), $general_image_edit, $id]);
            } else {
                \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list), $id]);
            }

            if (\eMarket\Core\Valid::inPOST('delete_image_product')) {
                $delete_image_arr = explode(',', \eMarket\Core\Valid::inPOST('delete_image_product'), -1);

                $image_list_arr = json_decode(\eMarket\Core\Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id]), 1);
                $image_list_new = [];
                foreach ($image_list_arr as $key => $file) {
                    if (!in_array($file, $delete_image_arr)) {
                        array_push($image_list_new, $file);
                    } else {
                        foreach ($resize_param as $key => $value) {
                            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                        }
                        \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        if ($file == \eMarket\Core\Pdo::selectPrepare("SELECT logo_general FROM " . $TABLE . " WHERE id=?", [$id])) {
                            \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo_general=? WHERE id=?", [NULL, $id]);
                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update) && is_array($image_list_new)) {
                    \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=?, logo_general=? WHERE id=?", [json_encode($image_list_new), $image_list_new[0], $id]);
                } else {
                    \eMarket\Core\Pdo::action("UPDATE " . $TABLE . " SET logo=? WHERE id=?", [json_encode($image_list_new), $id]);
                }
            }
        }

        if (\eMarket\Core\Valid::inPOST('delete')) {
            $idx = \eMarket\Core\Func::deleteEmptyInArray(\eMarket\Core\Valid::inPOST('delete'));

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) == 'product') {
                    $id = explode('product_', $idx[$i]);

                    $logo_delete = json_decode(\eMarket\Core\Pdo::selectPrepare("SELECT logo FROM " . $TABLE . " WHERE id=?", [$id[1]]), 1);
                    if (is_countable($logo_delete)) {
                        foreach ($logo_delete as $file) {
                            foreach ($resize_param as $key => $value) {
                                \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $file);
                            }
                            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/images/' . $dir . '/originals/' . $file);
                        }
                    }
                }
            }
        }

        if (\eMarket\Core\Valid::inPOST('delete_new_image_product') == 'ok' && \eMarket\Core\Valid::inPOST('delete_image_product')) {
            $id = \eMarket\Core\Valid::inPOST('delete_image_product');

            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/temp/files/' . $id);
            \eMarket\Core\Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . $id);
        }
    }

    /**
     * РImages resize
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
                        if (\eMarket\Core\Valid::inPOST('effect-edit-product') == 'effect-sepia' OR \eMarket\Core\Valid::inPOST('effect-add-product') == 'effect-sepia') {
                            $IMAGE->sepia();
                        }
                        if (\eMarket\Core\Valid::inPOST('effect-edit-product') == 'effect-black-white' OR \eMarket\Core\Valid::inPOST('effect-add-product') == 'effect-black-white') {
                            $IMAGE->desaturate();
                        }
                        if (\eMarket\Core\Valid::inPOST('effect-edit-product') == 'effect-blur-1' OR \eMarket\Core\Valid::inPOST('effect-add-product') == 'effect-blur-1') {
                            $IMAGE->blur('selective', 1);
                        }
                        if (\eMarket\Core\Valid::inPOST('effect-edit-product') == 'effect-blur-2' OR \eMarket\Core\Valid::inPOST('effect-add-product') == 'effect-blur-2') {
                            $IMAGE->blur('selective', 2);
                        }
                        $IMAGE->toFile(ROOT . '/uploads/images/' . $dir . '/resize_' . $key . '/' . $prefix . basename($file));
                    }
                }

                \eMarket\Core\Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . basename($file));
                \eMarket\Core\Func::deleteFile(ROOT . '/uploads/temp/files/' . basename($file));
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

        if (\eMarket\Core\Valid::inPOST('image_data')) {
            $file = \eMarket\Core\Valid::inPOST('image_data');

            $image_data = getimagesize(ROOT . '/uploads/temp/files/' . $file);
            $width = $image_data[0];
            $height = $image_data[1];

            $quality_width = $resize_max[0];
            $quality_height = $resize_max[1];

            if ($width >= $quality_width OR $height >= $quality_height) {
                $IMAGE->fromFile(ROOT . '/uploads/temp/files/' . $file)
                        ->autoOrient()
                        ->bestFit($resize_param[0][0], $resize_param[0][1]);
                if (\eMarket\Core\Valid::inPOST('effect_edit') == 'effect-sepia' OR \eMarket\Core\Valid::inPOST('effect_add') == 'effect-sepia') {
                    $IMAGE->sepia();
                }
                if (\eMarket\Core\Valid::inPOST('effect_edit') == 'effect-black-white' OR \eMarket\Core\Valid::inPOST('effect_add') == 'effect-black-white') {
                    $IMAGE->desaturate();
                }
                if (\eMarket\Core\Valid::inPOST('effect_edit') == 'effect-blur-1' OR \eMarket\Core\Valid::inPOST('effect_add') == 'effect-blur-1') {
                    $IMAGE->blur('selective', 1);
                }
                if (\eMarket\Core\Valid::inPOST('effect_edit') == 'effect-blur-2' OR \eMarket\Core\Valid::inPOST('effect_add') == 'effect-blur-2') {
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
