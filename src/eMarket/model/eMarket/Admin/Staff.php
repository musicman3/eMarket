<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Cryptography,
    Messages,
    Pages,
    Settings
};
use eMarket\Admin\HeaderMenu;
use R2D2\R2\Valid;
use Cruder\Db;

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
    public static $middleware = 'AdminAuthorize';
    public $title = 'title_staff_manager_staff_index';
    public static $sql_data = FALSE;
    public static $staff_manager_id = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        new HeaderMenu();
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

            $aichat_token = json_encode([]);
            if (Valid::inPOST('aichat_token')) {
                $aichat_token = json_encode(['aichat_token' => Valid::inPOST('aichat_token')]);
            }

            $user_detected = Db::connect()
                    ->read(TABLE_ADMINISTRATORS)
                    ->selectValue('password')
                    ->where('login=', Valid::inPOST('email'))
                    ->save();

            if (!$user_detected) {

                Db::connect()
                        ->create(TABLE_ADMINISTRATORS)
                        ->set('login', Valid::inPOST('email'))
                        ->set('password', Cryptography::passwordHash(Valid::inPOST('password')))
                        ->set('permission', self::$staff_manager_id)
                        ->set('language', Settings::primaryLanguage())
                        ->set('note', Valid::inPOST('note'))
                        ->set('my_data', $aichat_token)
                        ->save();

                Messages::alert('add', 'success', lang('action_completed_successfully'));
            } else {
                Messages::alert('add', 'danger', lang('staff_user_error'));
            }
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Db::connect()
                    ->delete(TABLE_ADMINISTRATORS)
                    ->where('login=', Valid::inPOST('delete'))
                    ->save();

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

        self::$sql_data = Db::connect()
                ->read(TABLE_ADMINISTRATORS)
                ->selectAssoc('*')
                ->where('permission=', self::$staff_manager_id)
                ->save();

        Pages::data(self::$sql_data);
    }
}
