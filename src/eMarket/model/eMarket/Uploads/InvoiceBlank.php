<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Uploads;

use eMarket\Core\Settings;

/**
 * Invoice Blank
 *
 * @package Uploads
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class InvoiceBlank {

    public static $routing_parameter = 'invoice_blank';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->tracert();
    }

    /**
     * Tracert blank
     *
     */
    public function tracert(): void {
        require_once (getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/blanks/invoice.php');
    }
}
