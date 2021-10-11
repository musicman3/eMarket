<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Lang,
    Messages,
    Pages,
    Pdo,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Staff Manager
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class StaffManager {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->add();
        $this->edit();
        $this->delete();
        $this->data();
        $this->modal();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_tools][] = ['?route=staff_manager', 'bi-person-plus', lang('title_staff_manager_index'), '', 'false'];
    }

    /**
     * Permissions
     *
     * @return mixed permissions
     */
    public function permissions(): mixed {
        $permission = Valid::inPOST('permissions');
        if (!Valid::inPOST('permissions')) {
            $permission = [];
        }
        $dashboard_count = 0;
        foreach ($permission as $value) {
            if ($value == '?route=dashboard') {
                $dashboard_count++;
            }
        }

        if ($dashboard_count == 0) {
            array_push($permission, '?route=dashboard');
        }
        return $permission;
    }

    /**
     * Permission class
     *
     * @param string $input Route path
     * @return string Bootstrap class
     */
    public static function permissionClass(?string $input): string {
        if ($input == '?route=dashboard') {
            return ' selected disabled';
        }
        return '';
    }

    /**
     * Add
     *
     */
    public function add(): void {
        if (Valid::inPOST('add')) {

            if (Valid::inPOST('demo_mode')) {
                $demo_mode = 1;
            } else {
                $demo_mode = 0;
            }

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_STAFF_MANAGER . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_STAFF_MANAGER . " SET id=?, name=?, language=?, note=?, permissions=?, mode=?", [
                    $id, Valid::inPOST('staff_manager_group_' . $x), lang('#lang_all')[$x], Valid::inPOST('staff_manager_note_' . $x),
                    json_encode($this->permissions()), $demo_mode
                ]);
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {

            if (Valid::inPOST('demo_mode')) {
                $demo_mode = 1;
            } else {
                $demo_mode = 0;
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_STAFF_MANAGER . " SET name=?, note=?, permissions=?, mode=? WHERE id=? AND language=?", [
                    Valid::inPOST('staff_manager_group_' . $x), Valid::inPOST('staff_manager_note_' . $x), json_encode($this->permissions()),
                    $demo_mode, Valid::inPOST('edit'), lang('#lang_all')[$x]
                ]);
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_STAFF_MANAGER . " WHERE id=?", [Valid::inPOST('delete')]);
            Pdo::action("DELETE FROM " . TABLE_ADMINISTRATORS . " WHERE permission=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $_SESSION['staff_manager_page'] = Valid::inSERVER('REQUEST_URI');
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_STAFF_MANAGER . " ORDER BY name", []);
        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
        self::$json_data = json_encode([]);
        $name = [];
        $note = [];
        $permissions = [];
        $mode = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                        $note[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['note'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $permissions[$modal_id] = $sql_modal['permissions'];
                        $mode[$modal_id] = (int) $sql_modal['mode'];
                    }
                }

                ksort($name);
                ksort($note);

                self::$json_data = json_encode([
                    'name' => $name,
                    'note' => $note,
                    'permissions' => $permissions,
                    'mode' => $mode
                ]);
            }
        }
    }

}
