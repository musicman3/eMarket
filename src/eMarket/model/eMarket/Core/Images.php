<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Clock\SystemClock,
    Func,
    Tree,
    Valid
};
use Cruder\Db;

/**
 * Class for working with images
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Images {

    private $prefix = FALSE;
    private $files = FALSE;
    private $count_files = FALSE;
    private $table = FALSE;
    private $dir = FALSE;
    private $resize_param = FALSE;

    /**
     * Constructor
     *
     * @param string $table Image table name
     * @param string $dir Image directory name (Example: uploads/images/products, name is: products)
     * @param array $resize_param Resize parameters
     * @param string $marker Value after separator in POST if multiple incoming image requests (example: add_products, value is: _products)
     * 
     */
    function __construct(string $table, string $dir, array $resize_param, string $marker = '') {

        $this->table = $table;
        $this->dir = $dir;
        $this->resize_param = $resize_param;

        $this->init();
        $this->add($marker);
        $this->edit($marker);
        $this->delete();
        $this->deleteNewImages($marker);
    }

    /**
     * Init
     */
    private function init(): void {

        $this->imgThumbAndSize($this->resize_param);

        $this->prefix = SystemClock::nowUnixTime() . '_';
        $this->files = glob(ROOT . '/uploads/temp/files/*');
        $this->count_files = count($this->files);

        if (Valid::inPostJson('file_upload') == 'empty') {
            Tree::filesDirAction(ROOT . '/uploads/temp/originals/');
            Tree::filesDirAction(ROOT . '/uploads/temp/thumbnail/');
            Tree::filesDirAction(ROOT . '/uploads/temp/files/');
        }
    }

    /**
     * Add images
     * 
     * @param string $marker marker
     */
    private function add(string $marker = ''): void {
        if (Valid::inPOST('add' . $marker)) {
            if ($this->count_files > 0) {
                $this->imgResize($this->dir, $this->files, $this->prefix, $this->resize_param);
            }

            $files = glob(ROOT . '/uploads/temp/originals/*');
            $count_files = count($files);
            if ($count_files > 0) {

                if (Valid::inPOST('set_language')) {
                    $language = Valid::inPOST('set_language');
                } else {
                    $language = lang('#lang_all')[0];
                }

                $id_max = Db::connect()
                        ->read($this->table)
                        ->selectValue('id')
                        ->where('language=', $language)
                        ->orderByDesc('id')
                        ->save();

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

                if (Valid::inPOST('general_image_add' . $marker)) {
                    $general_image_add = $this->prefix . Valid::inPOST('general_image_add' . $marker);
                }

                Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $this->dir . '/originals/');

                Db::connect()
                        ->update($this->table)
                        ->set('logo', json_encode($image_list))
                        ->set('logo_general', $general_image_add)
                        ->where('id=', $id)
                        ->save();
            }
        }
    }

    /**
     * Edit images
     * 
     * @param string $marker marker
     */
    private function edit(string $marker = ''): void {

        if (Valid::inPOST('edit' . $marker)) {

            $id = Valid::inPOST('edit' . $marker);

            $this->imgResize($this->dir, $this->files, $this->prefix, $this->resize_param);

            $files = glob(ROOT . '/uploads/temp/originals/*');

            $image_list_prepare = Db::connect()
                    ->read($this->table)
                    ->selectValue('logo')
                    ->where('id=', $id)
                    ->save();

            $image_list = json_decode($image_list_prepare, true);

            foreach ($files as $file) {
                if (is_file($file) && file_exists($file) && $file != '.gitkeep' && $file != '.htaccess' && $file != '.gitignore') {
                    array_push($image_list, basename($file));
                }
            }

            if (count($image_list) > 0) {
                $general_image_edit = $image_list[0];
            }

            if (Valid::inPOST('general_image_edit' . $marker)) {
                $general_image_edit = Valid::inPOST('general_image_edit' . $marker);
            }

            if (Valid::inPOST('general_image_edit_new' . $marker)) {
                $general_image_edit = $this->prefix . Valid::inPOST('general_image_edit_new' . $marker);
            }

            Tree::filesDirAction(ROOT . '/uploads/temp/originals/', ROOT . '/uploads/images/' . $this->dir . '/originals/');

            if (isset($general_image_edit)) {

                Db::connect()
                        ->update($this->table)
                        ->set('logo', json_encode($image_list))
                        ->set('logo_general', $general_image_edit)
                        ->where('id=', $id)
                        ->save();
            } else {

                Db::connect()
                        ->update($this->table)
                        ->set('logo', json_encode($image_list))
                        ->where('id=', $id)
                        ->save();
            }

            if (Valid::inPOST('delete_image') . $marker) {

                $delete_image_arr = explode(',', Valid::inPOST('delete_image' . $marker), -1);

                $image_list_arr_prepare = Db::connect()
                        ->read($this->table)
                        ->selectValue('logo')
                        ->where('id=', $id)
                        ->save();

                $image_list_arr = json_decode($image_list_arr_prepare, true);

                $image_list_new = [];
                foreach ($image_list_arr as $key => $file) {
                    if (!in_array($file, $delete_image_arr)) {
                        array_push($image_list_new, $file);
                    } else {
                        foreach ($this->resize_param as $key => $value) {
                            Func::deleteFile(ROOT . '/uploads/images/' . $this->dir . '/resize_' . $key . '/' . $file);
                        }

                        unset($value);

                        Func::deleteFile(ROOT . '/uploads/images/' . $this->dir . '/originals/' . $file);

                        $file_prepare = Db::connect()
                                ->read($this->table)
                                ->selectValue('logo_general')
                                ->where('id=', $id)
                                ->save();

                        if ($file == $file_prepare) {

                            Db::connect()
                                    ->update($this->table)
                                    ->set('logo_general', NULL)
                                    ->where('id=', $id)
                                    ->save();

                            $logo_general_update = 'ok';
                        }
                    }
                }
                if (isset($logo_general_update, $image_list_new[0]) && count($image_list_new) > 0) {

                    Db::connect()
                            ->update($this->table)
                            ->set('logo', json_encode($image_list_new))
                            ->set('logo_general', $image_list_new[0])
                            ->where('id=', $id)
                            ->save();
                } else {

                    Db::connect()
                            ->update($this->table)
                            ->set('logo', json_encode($image_list_new))
                            ->where('id=', $id)
                            ->save();
                }
            }
        }
    }

    /**
     * Delete images
     * 
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {
            $this->deleteById(Valid::inPOST('delete'));
        }
    }

    /**
     * Delete by ID
     * 
     * @param string|int $id ID
     */
    public function deleteById(string|int $id): void {

        $logo_delete_prepare = Db::connect()
                ->read($this->table)
                ->selectValue('logo')
                ->where('id=', $id)
                ->save();

        $logo_delete = json_decode($logo_delete_prepare, true);

        if (is_countable($logo_delete)) {
            foreach ($logo_delete as $file) {
                foreach ($this->resize_param as $key => $value) {
                    Func::deleteFile(ROOT . '/uploads/images/' . $this->dir . '/resize_' . $key . '/' . $file);
                }
                unset($value);
                Func::deleteFile(ROOT . '/uploads/images/' . $this->dir . '/originals/' . $file);
            }
        }
    }

    /**
     * Deleting images by parent id
     * 
     * @param string|int $parent_id parent id
     */
    public function deleteByParentId(string|int $parent_id): void {

        $data = Db::connect()
                ->read($this->table)
                ->selectAssoc('id')
                ->where('parent_id=', $parent_id)
                ->save();

        foreach ($data as $value) {
            $this->deleteById($value['id']);
        }
    }

    /**
     * Delete new images
     * 
     * @param string $marker marker
     */
    private function deleteNewImages(string $marker = ''): void {
        if (Valid::inPostJson('delete_new_image' . $marker) == 'ok' && Valid::inPostJson('delete_image' . $marker)) {
            $file = Valid::inPostJson('delete_image' . $marker);
            Func::deleteFile(ROOT . '/uploads/temp/files/' . $file);
            Func::deleteFile(ROOT . '/uploads/temp/thumbnail/' . $file);
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
    private function imgResize(string $dir, array $files, string $prefix, array $resize_param): void {

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
                                ->bestFit((int) $value[0], (int) $value[1]);
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
     * Thumbnail slicing and image resizing function on Ajax request
     *
     * @param array $resize_param Resize parameters
     */
    private function imgThumbAndSize(array $resize_param): void {

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
                        ->bestFit((int) $resize_param[0][0], (int) $resize_param[0][1]);
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

    /**
     * Array of maximum image sizes after resize
     *
     * @param array $resize_param Resize parameters
     * @return array Resize parameters for maximum quality
     */
    public static function imgResizeMax(array $resize_param): array {

        $count_image_max = count($resize_param);
        $resize_max = [];
        array_push($resize_max, [$resize_param[$count_image_max - 1][0], $resize_param[$count_image_max - 1][1]]);
        return $resize_max[0];
    }

}
