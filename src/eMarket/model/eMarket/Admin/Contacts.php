<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Lang
};
use eMarket\Admin\HeaderMenu;
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Contacts
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Contacts {

    public static $routing_parameter = 'contacts';
    public static $middleware = 'AdminAuthorize';
    public $title = 'title_contacts_index';
    public static $description = [];

    /**
     * Constructor
     *
     */
    function __construct() {
        new HeaderMenu();
        $this->add();
        $this->data();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     *
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_market][] = ['?route=contacts', 'bi-envelope', lang('menu_contacts'), '', 'false'];
    }

    /**
     * Add
     *
     */
    private function add(): void {

        if (Valid::inPOST('add')) {

            $contacts = Db::connect()
                    ->read(TABLE_CONTACTS)
                    ->selectAssoc('*')
                    ->save();

            if (count($contacts) > 0) {
                for ($x = 0; $x < count(lang('#lang_all')); $x++) {
                    Db::connect()
                            ->update(TABLE_CONTACTS)
                            ->set('description', Valid::inPOST('description_contacts_' . $x))
                            ->where('language=', lang('#lang_all')[$x])
                            ->save();
                }
            } else {
                for ($x = 0; $x < count(lang('#lang_all')); $x++) {
                    Db::connect()
                            ->create(TABLE_CONTACTS)
                            ->set('language', lang('#lang_all')[$x])
                            ->set('description', Valid::inPOST('description_contacts_' . $x))
                            ->save();
                }
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        $description = Db::connect()
                ->read(TABLE_CONTACTS)
                ->selectAssoc('*')
                ->save();

        for ($x = 0; $x < count(lang('#lang_all')); $x++) {
            if (isset($description[$x]['description'])) {
                self::$description[$description[$x]['language']] = $description[$x]['description'];
            } else {
                self::$description[lang('#lang_all')[$x]] = '';
            }
        }
    }
}
