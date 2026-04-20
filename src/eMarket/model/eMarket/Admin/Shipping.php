<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Images
};
use eMarket\Admin\HeaderMenu;
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Shipping
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Shipping {

    public static $routing_parameter = 'shipping';
    public static $middleware = 'AdminAuthorize';
    public $title = 'title_shipping_index';
    public static $description = [];
    public static $resize_param;
    public static $json_data = FALSE;
    public static $switch_active = '';

    /**
     * Constructor
     *
     */
    function __construct() {
        new HeaderMenu();
        $this->status();
        $this->add();
        $this->edit();
        $this->imgUpload();
        $this->data();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     *
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_market][4] = ['?route=shipping', 'bi-truck', lang('menu_shipping'), '', 'false'];
    }

    /**
     * Add
     *
     */
    private function add(): void {

        if (Valid::inPOST('add')) {

            $shipping = Db::connect()
                    ->read(TABLE_SHIPPING)
                    ->selectAssoc('*')
                    ->save();

            $switch_active = 0;
            if (Valid::inPOST('switch_active')) {
                $switch_active = 1;
            }

            if (count($shipping) == 0) {
                for ($x = 0; $x < count(lang('#lang_all')); $x++) {
                    Db::connect()
                            ->create(TABLE_SHIPPING)
                            ->set('id', 1)
                            ->set('language', lang('#lang_all')[$x])
                            ->set('description', Valid::inPOST('description_shipping_' . $x))
                            ->set('status', $switch_active)
                            ->save();
                }
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {

        if (Valid::inPOST('edit')) {

            $shipping = Db::connect()
                    ->read(TABLE_SHIPPING)
                    ->selectAssoc('*')
                    ->save();

            $switch_active = 0;
            if (Valid::inPOST('switch_active')) {
                $switch_active = 1;
            }

            if (count($shipping) > 0) {
                for ($x = 0; $x < count(lang('#lang_all')); $x++) {
                    Db::connect()
                            ->update(TABLE_SHIPPING)
                            ->set('id', 1)
                            ->set('description', Valid::inPOST('description_shipping_' . $x))
                            ->set('status', $switch_active)
                            ->where('language=', lang('#lang_all')[$x])
                            ->save();
                }
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        $description = Db::connect()
                ->read(TABLE_SHIPPING)
                ->selectAssoc('*')
                ->save();

        if (isset($description[0]['id'])) {
            self::$json_data = json_encode([
                'id' => [$description[0]['id']],
                'logo' => [$description[0]['logo']],
                'logo_general' => $description[0]['logo_general']
            ]);
        } else {
            self::$json_data = json_encode([]);
        }

        for ($x = 0; $x < count(lang('#lang_all')); $x++) {
            if (isset($description[$x]['description'])) {
                self::$description[$description[$x]['language']] = $description[$x]['description'];
            } else {
                self::$description[lang('#lang_all')[$x]] = '';
            }
        }
    }

    /**
     * Status
     *
     * @return string
     */
    public static function status(): string {
        $shipping = Db::connect()
                ->read(TABLE_SHIPPING)
                ->selectAssoc('*')
                ->save();

        if (isset($shipping[0]['status']) && $shipping[0]['status'] == 1) {
            return 'checked';
        }
        return '';
    }

    /**
     * Image Upload
     *
     */
    private function imgUpload(): void {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '94']); // width, height
        array_push(self::$resize_param, ['200', '150']);
        array_push(self::$resize_param, ['325', '244']);
        array_push(self::$resize_param, ['525', '394']);
        array_push(self::$resize_param, ['850', '638']);

        new Images(TABLE_SHIPPING, 'shipping', self::$resize_param);
    }
}
