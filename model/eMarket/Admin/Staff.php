<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use \eMarket\Core\{
    Autorize,
    Func,
    Lang,
    Messages,
    Pages,
    Pdo,
    Valid,
    Settings
};

/**
 * Staff
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Staff {

    public static $sql_data = FALSE;
    public static $staff_manager_id = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->staffManagerId();
        $this->add();
        $this->delete();
        $this->data();
    }

    /**
     * Staff manager id
     *
     */
    public function staffManagerId() {
        if (Valid::inGET('staff_manager_id')) {
            self::$staff_manager_id = Valid::inGET('staff_manager_id');
        }
        if (Valid::inPOST('staff_manager_id')) {
            self::$staff_manager_id = Valid::inPOST('staff_manager_id');
        }
        if (self::$staff_manager_id == FALSE) {
            self::$staff_manager_id = 0;
        }
    }

    /**
     * Add
     *
     */
    public function add() {
        if (Valid::inPOST('add')) {
            Pdo::action("INSERT INTO " . TABLE_ADMINISTRATORS . "  SET login=?, password=?, permission=?, language=?, note=?", [Valid::inPOST('email'),
                Autorize::passwordHash(Valid::inPOST('password')), self::$staff_manager_id, Settings::primaryLanguage(), Valid::inPOST('note')]);

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [Valid::inPOST('delete')]);

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = Pdo::getColAssoc("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE permission=?", [self::$staff_manager_id]);
        Pages::data(self::$sql_data);
    }

}
