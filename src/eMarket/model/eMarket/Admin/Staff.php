<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Authorize,
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
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Staff {

    public static $routing_parameter = 'staff_manager/staff';
    public $title = 'title_staff_manager_staff_index';
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
    private function staffManagerId(): void {
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
    private function add(): void {
        if (Valid::inPOST('add')) {

            $chatgpt_token = json_encode([]);
            if (Valid::inPOST('chatgpt_token')) {
                $chatgpt_token = json_encode([Valid::inPOST('chatgpt_token')]);
            }

            $user_detected = Pdo::getValue("SELECT chatgpt_token FROM " . TABLE_ADMINISTRATORS . " WHERE login=?",
                            [Valid::inPOST('email')]);

            if (!$user_detected) {
                Pdo::action("INSERT INTO " . TABLE_ADMINISTRATORS . "  SET login=?, password=?, permission=?, language=?, note=?, chatgpt_token=?", [Valid::inPOST('email'),
                    Authorize::passwordHash(Valid::inPOST('password')), self::$staff_manager_id, Settings::primaryLanguage(), Valid::inPOST('note'), $chatgpt_token]);
                Messages::alert('add', 'success', lang('action_completed_successfully'));
            }
            Messages::alert('add', 'danger', lang('staff_user_error'));
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [Valid::inPOST('delete')]);

            if ($_SESSION['login'] == Valid::inPOST('delete')) {
                unset($_SESSION['login']);
            }

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE permission=?", [self::$staff_manager_id]);
        Pages::data(self::$sql_data);
    }

}
