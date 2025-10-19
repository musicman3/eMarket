<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Constructor;

use eMarket\Core\{
    Interfaces\ConstructorInterface,
    Settings,
    Valid
};

/**
 * CatalogWithoutCallback class
 *
 * @package Constructor
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class CatalogWithoutCallback implements ConstructorInterface {

    /**
     * Init
     *
     */
    #[\Override]
    public static function init(): string|bool {

        if (Settings::path() == 'catalog' && Valid::inGET('route') !== 'callback') {
            return getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/catalog/constructor.php';
        }
        return false;
    }
}
