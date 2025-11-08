<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Middleware;

use R2D2\R2\Valid;
use Cruder\Db;

/**
 * General Check class
 *
 * @package Middleware
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class GeneralCheck {

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->currencyCheck();
        $this->langCheck();
    }

    /**
     * Checking the availability of currency
     *
     * @return bool FALSE
     */
    private function currencyCheck(): bool {

        if (Valid::inGET('currency_default')) {
            $currency = Db::connect()
                    ->read(TABLE_CURRENCIES)
                    ->selectValue('name')
                    ->where('id=', Valid::inGET('currency_default'))
                    ->save();
            if ($currency == false) {
                header('Location: /');
                exit;
            }
        }
        return false;
    }

    /**
     * Checking the availability of language
     *
     * @return bool FALSE
     */
    private function langCheck(): bool {

        if (Valid::inGET('language') && !file_exists(getenv('DOCUMENT_ROOT') . '/language/' . Valid::inGET('language'))) {
            header('Location: /');
            exit;
        }

        return false;
    }
}
