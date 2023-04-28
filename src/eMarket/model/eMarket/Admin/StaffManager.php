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
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

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

    public static $routing_parameter = 'staff_manager';
    public $title = 'title_staff_manager_index';
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
    private function permissions(): mixed {
        $permission = Valid::inPOST('permissions');
        if (!Valid::inPOST('permissions')) {
            $permission = [];
        }
        $dashboard_count = 0;
        foreach ($permission as $value) {
            if ($value == '?route=' . Settings::defaultPage()) {
                $dashboard_count++;
            }
        }

        if ($dashboard_count == 0) {
            array_push($permission, '?route=' . Settings::defaultPage());
        }
        return $permission;
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $demo_mode = 0;
            if (Valid::inPOST('demo_mode')) {
                $demo_mode = 1;
            }

            $id_max = Db::connect()
                    ->read(TABLE_STAFF_MANAGER)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_STAFF_MANAGER)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('staff_manager_group_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('note', Valid::inPOST('staff_manager_note_' . $x))
                        ->set('permissions', json_encode($this->permissions()))
                        ->set('mode', $demo_mode)
                        ->save();
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

            $demo_mode = 0;
            if (Valid::inPOST('demo_mode')) {
                $demo_mode = 1;
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->update(TABLE_STAFF_MANAGER)
                        ->set('name', Valid::inPOST('staff_manager_group_' . $x))
                        ->set('note', Valid::inPOST('staff_manager_note_' . $x))
                        ->set('permissions', json_encode($this->permissions()))
                        ->set('mode', $demo_mode)
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            $user_check = Db::connect()
                    ->read(TABLE_ADMINISTRATORS)
                    ->selectValue('permission')
                    ->where('login=', $_SESSION['login'])
                    ->save();

            Db::connect()
                    ->delete(TABLE_STAFF_MANAGER)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Db::connect()
                    ->delete(TABLE_ADMINISTRATORS)
                    ->where('permission=', Valid::inPOST('delete'))
                    ->save();

            if ($user_check == Valid::inPOST('delete')) {
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
        $_SESSION['staff_manager_page'] = Valid::inSERVER('REQUEST_URI');

        self::$sql_data = Db::connect()
                ->read(TABLE_STAFF_MANAGER)
                ->selectAssoc('*')
                ->orderBy('name')
                ->save();

        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
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

    /**
     * Permission class
     *
     * @param string $input Route path
     * @return string Bootstrap class
     */
    public static function permissionClass(?string $input): string {
        if ($input == '?route=' . Settings::defaultPage()) {
            return ' selected disabled';
        }
        return '';
    }

}
