<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Admin\HeaderMenu;
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Modules/Edit
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class ModulesEdit {

    public static $routing_parameter = 'modules/edit';
    public static $middleware = 'AdminAuthorize';
    public $title;
    public static string $switch_active = '';

    /**
     * Constructor
     *
     */
    function __construct() {
        new HeaderMenu();
        $this->title();
        $this->switchActive();
    }

    /**
     * Title
     *
     */
    function title() {
        $this->title = 'modules_' . Valid::inGET('type') . '_' . Valid::inGET('name') . '_name';
    }

    /**
     * Bootstrap class helper
     *
     */
    private function switchActive(): void {

        $active = Db::connect()
                        ->read(TABLE_MODULES)
                        ->selectValue('active')
                        ->where('type=', Valid::inGET('type'))
                        ->and('name=', Valid::inGET('name'))
                        ->save()[0];

        if ($active == 1) {
            self::$switch_active = 'checked';
        }
    }
}
