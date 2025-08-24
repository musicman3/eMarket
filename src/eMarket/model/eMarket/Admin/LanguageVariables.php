<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Valid
};

/**
 * Language Variables
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class LanguageVariables {

    public static $routing_parameter = 'language_variables';
    public $title = 'title_language_variables_index';
    public static $admin_lang_data = FALSE;
    public static $catalog_lang_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->edit();
        $this->adminLanguageData();
        $this->catalogLanguageData();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=language_variables', 'bi-body-text', lang('title_language_variables_index'), '', 'false'];
    }

    /**
     * Admin language data
     *
     * @return string
     */
    private function adminLanguageData(): string {
        if (is_file(getenv('DOCUMENT_ROOT') . '/custom/language/' . $_SESSION['DEFAULT_LANGUAGE'] . '/admin/custom.lng')) {
            self::$admin_lang_data = file_get_contents(getenv('DOCUMENT_ROOT') . '/custom/language/' . $_SESSION['DEFAULT_LANGUAGE'] . '/admin/custom.lng');
        }
        return self::$admin_lang_data;
    }

    /**
     * Catalog language data
     *
     * @return string
     */
    private function catalogLanguageData(): string {
        if (is_file(getenv('DOCUMENT_ROOT') . '/custom/language/' . $_SESSION['DEFAULT_LANGUAGE'] . '/catalog/custom.lng')) {
            self::$catalog_lang_data = file_get_contents(getenv('DOCUMENT_ROOT') . '/custom/language/' . $_SESSION['DEFAULT_LANGUAGE'] . '/catalog/custom.lng');
        }
        return self::$catalog_lang_data;
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {

            if (Valid::inPOST('admin_lang')) {
                file_put_contents(getenv('DOCUMENT_ROOT') . '/custom/language/' . $_SESSION['DEFAULT_LANGUAGE'] . '/admin/custom.lng', Valid::inPOST('admin_lang'));
            }
            if (Valid::inPOST('catalog_lang')) {
                file_put_contents(getenv('DOCUMENT_ROOT') . '/custom/language/' . $_SESSION['DEFAULT_LANGUAGE'] . '/catalog/custom.lng', Valid::inPOST('catalog_lang'));
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }
}
