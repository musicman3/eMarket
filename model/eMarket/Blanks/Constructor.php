<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Blanks;

use eMarket\Core\{
    Authorize,
    Settings
};
use \Mpdf\Mpdf;

/**
 * Constructor
 *
 * @package Blanks
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Constructor {

    private $mpdf = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->authorize();
        $this->header();
        $this->mpdf()->Output();
    }

    /**
     * Authorize
     *
     */
    public function authorize() {
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
    public function mpdf() {

        if ($this->mpdf == FALSE) {
            $this->mpdf = new Mpdf();
        }

        return $this->mpdf;
    }

    /**
     * Header
     *
     */
    public function header() {
        $template = file_get_contents(HTTP_SERVER . '/view/' . Settings::template() . '/admin/blanks/invoice/default.php');
        $search = ['{COMPANY_NAME}'];
        $replace = ['Моя шарага'];
        $html = str_replace($search, $replace, $template);

        return $this->mpdf()->WriteHTML($html);
    }

    /**
     * Output
     *
     */
    public function template() {
        $this->header();
        $this->mpdf()->Output();
    }

}
