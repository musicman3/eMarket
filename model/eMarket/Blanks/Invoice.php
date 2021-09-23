<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Blanks;

use eMarket\Core\{
    Authorize,
    Pdo,
    Valid
};
use \Mpdf\Mpdf;

/**
 * Invoice
 *
 * @package Blanks
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Invoice {

    private $mpdf = FALSE;
    private $order_data = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->createBlank();
    }

    /**
     * Authorize
     *
     */
    private function authorize() {
        $authorize = FALSE;
        if (Authorize::$customer || isset($_SESSION['login'])) {
            $authorize = TRUE;
        }
        if (!$authorize) {
            exit;
        }
    }

    /**
     * Header
     *
     */
    private function mpdf() {
        if (!$this->mpdf) {
            $this->mpdf = new Mpdf([
                'default_font' => 'freesans'
            ]);
        }
        return $this->mpdf;
    }

    /**
     * Order data
     * @param string $name Orders column name
     * @return string Output data
     */
    private function orderData($name) {
        if (!$this->order_data) {
            $this->order_data = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE id=?", [Valid::inGET('invoice_id')])[0];
        }
        return $this->order_data[$name];
    }

    /**
     * HTML
     *
     * @return string HTML data
     */
    private function html() {
        $data = [
            'invoice_id' => $this->orderData('id'),
            'invoice_email' => $this->orderData('email'),
            'invoice_title' => lang('blanks_invoice_title'),
            'invoice_to' => lang('blanks_invoice_to'),
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
        ];
        $html = $this->curl($data, HTTP_SERVER . 'controller/admin/blanks/invoice.php');
        return $html;
    }

    /**
     * Create blank
     *
     */
    private function createBlank() {
        $this->authorize();
        $this->mpdf()->WriteHTML($this->html());
        $this->mpdf()->Output('invoice.pdf', 'D');
    }

    /**
     * Curl
     *
     * @param array $data (request data)
     * @param string $host (request host)
     */
    private function curl($data, $host) {
        $curl = curl_init($host);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSLVERSION, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json', 'User-Agent: eMarket']);
        $request_string = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_string);
        $response_string = curl_exec($curl);
        if (curl_errno($curl)) {
            return FALSE;
        }
        if (!empty($response_string)) {
            return $response_string;
        } else {
            return FALSE;
        }
    }

}
