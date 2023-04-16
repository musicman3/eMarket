<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Valid
};
use Cruder\Cruder;

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
    public $title;
    public $db;
    public static string $switch_active = '';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->db = new Cruder();
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

        $active = $this->db
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
