<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Blanks;

use eMarket\Core\{
    Messages,
    Settings
};
use \Mpdf\Mpdf;

/**
 * Blanks
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Constructor {

    private $mpdf = FALSE;

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
        $template = file_get_contents(ROOT . '\view\\' . Settings::template() . '\admin\pages\orders\templates\order\order.php');
        $search = ['$COMPANY_NAME'];
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
