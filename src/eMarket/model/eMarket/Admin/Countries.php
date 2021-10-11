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

/**
 * Countries
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Countries {

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
     * Add
     *
     */
    public function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_COUNTRIES . " SET id=?, name=?, language=?, alpha_2=?, alpha_3=?, address_format=?", [
                    $id, Valid::inPOST('name_countries_' . $x), lang('#lang_all')[$x], Valid::inPOST('alpha_2_countries'),
                    Valid::inPOST('alpha_3_countries'), Valid::inPOST('address_format_countries')
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

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_COUNTRIES . " SET name=?, alpha_2=?, alpha_3=?, address_format=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_countries_' . $x), Valid::inPOST('alpha_2_countries'), Valid::inPOST('alpha_3_countries'),
                    Valid::inPOST('address_format_countries'), Valid::inPOST('edit'), lang('#lang_all')[$x]
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

            Pdo::action("DELETE FROM " . TABLE_COUNTRIES . " WHERE id=?", [Valid::inPOST('delete')]);
            Pdo::action("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $_SESSION['country_page'] = Valid::inSERVER('REQUEST_URI');
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_COUNTRIES . " ORDER BY name", []);
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
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $alpha_2[$modal_id] = $sql_modal['alpha_2'];
                        $alpha_3[$modal_id] = $sql_modal['alpha_3'];
                        $address_format[$modal_id] = $sql_modal['address_format'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'alpha_2' => $alpha_2,
                    'alpha_3' => $alpha_3,
                    'address_format' => $address_format
                ]);
            }
        }
    }

}
