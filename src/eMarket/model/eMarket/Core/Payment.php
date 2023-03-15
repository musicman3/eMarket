<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
};

/**
 * Payment
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Payment {

    /**
     * List of payment modules that are available for the selected delivery module
     * @param string $name Payment module name
     * @return array
     */
    private function paymentModulesAvailable(string $name): array {
        $data = Pdo::getAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE active=? AND type=?", [1, 'payment']);

        $output = [];
        foreach ($data as $payment_module) {
            $shipping_val = json_decode(Pdo::getValue("SELECT shipping_module FROM " . DB_PREFIX . 'modules_payment_' . $payment_module['name'], []), true);
            if (is_array($shipping_val) && in_array($name, $shipping_val) && !in_array($payment_module['name'], $output)) {
                array_push($output, $payment_module['name']);
            }
        }
        return $output;
    }

    /**
     * Loading data from payment modules
     * 
     * @param string $input Data on available names of delivery modules
     */
    public function loadData(string $input): void {

        $modules_names = $this->paymentModulesAvailable($input);

        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Core\Modules\Payment\\' . ucfirst($name);
            $namespace::load();
        }
    }

}
