<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\JsonRpc;

use eMarket\Core\{
    Clock\SystemClock,
    JsonRpc
};
use \Mpdf\Mpdf;
use Cruder\Db;

/**
 * Invoice
 *
 * @package JsonRpc
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Invoice extends JsonRpc {

    public static $routing_parameter = 'Invoice';
    private $mpdf = FALSE;
    private $order_data = FALSE;
    private $uid = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->createBlank();
    }

    /**
     * Header
     *
     * @return object mpdf object
     */
    private function mpdf(): object {
        if (!$this->mpdf) {
            $this->mpdf = new Mpdf([
                'default_font' => 'freesans'
            ]);
        }
        return $this->mpdf;
    }

    /**
     * Order data
     * @param string|int $name Orders column name
     * @return mixed Output data
     */
    private function data(string|int $name): mixed {
        if (!$this->order_data) {

            $order_data = Db::connect()
                    ->read(TABLE_ORDERS)
                    ->selectAssoc('*')
                    ->where('uid=', $this->uid)
                    ->save();

            if (count($order_data) > 0) {
                $this->order_data = $order_data[0];
            }
        }
        if ($this->order_data) {
            return $this->order_data[$name];
        } else {
            return FALSE;
        }
    }

    /**
     * HTML
     *
     * @return mixed HTML data
     */
    private function html(): mixed {
        if ($this->data('id')) {
            $data = [
                'invoice_id' => $this->data('id'),
                'invoice_email' => $this->data('email'),
                'invoice_date_purchased' => SystemClock::getDate($this->data('date_purchased')),
                'invoice_customer_data' => json_decode($this->data('customer_data'), true),
                'invoice_customer_address_book' => json_decode(json_decode($this->data('customer_data'), true)['address_book'], true),
                'invoice_data' => json_decode($this->data('invoice'), true),
                'invoice_order_total' => json_decode($this->data('order_total'), true),
                'invoice_title' => lang('blanks_invoice_title'),
                'invoice_to' => lang('blanks_invoice_to'),
                'invoice_name' => lang('blanks_invoice_name'),
                'invoice_date_of' => lang('blanks_invoice_date_of'),
                'invoice_company_name' => lang('blanks_invoice_company_name'),
                'invoice_company_data' => lang('blanks_invoice_company_data'),
                'invoice_company_contacts' => lang('blanks_invoice_company_contacts'),
                'invoice_description' => lang('blanks_invoice_description'),
                'invoice_quantity' => lang('blanks_invoice_quantity'),
                'invoice_price' => lang('blanks_invoice_price'),
                'invoice_amount' => lang('blanks_invoice_amount'),
                'invoice_no' => lang('blanks_invoice_no'),
                'invoice_subtotal' => lang('blanks_invoice_subtotal'),
                'invoice_estimated_taxes' => lang('blanks_invoice_estimated_taxes'),
                'invoice_shipping' => lang('blanks_invoice_shipping'),
                'invoice_total' => lang('blanks_invoice_total'),
                'invoice_thank' => lang('blanks_invoice_thank'),
                'invoice_end' => lang('blanks_invoice_end'),
                'invoice_notice' => lang('blanks_invoice_notice'),
                'invoice_notice_text' => lang('blanks_invoice_notice_text'),
            ];
            $html = $this->curl($data, HTTP_SERVER . 'uploads/temp/?blank=invoice');
            return $html;
        } else {
            return FALSE;
        }
    }

    /**
     * Create blank
     *
     */
    private function createBlank(): void {
        $this->uid = $this->decodeGetData('id');
        if (!$this->html()) {
            $this->error('-32000', 'Incorrect ID', $this->uid);
        }
        $this->mpdf()->WriteHTML($this->html());
        $this->mpdf()->Output('invoice.pdf', 'D');
    }

}
