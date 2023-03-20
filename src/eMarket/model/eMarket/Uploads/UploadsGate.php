<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Uploads;

/**
 * UploadsGate class
 *
 * @package Uploads
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class UploadsGate {

    public static $routing_parameter = 'uploads';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->init();
    }

    /**
     * Init
     *
     */
    private function init(): void {

        $upload_dir = ROOT . '/uploads/temp/files/';
        $valid_extensions = array('gif', 'png', 'jpeg', 'jpg');

        $Upload = new \FileUpload('uploadfile');
        $result = $Upload->handleUpload($upload_dir, $valid_extensions);

        if (!$result) {
            echo json_encode(array('success' => false, 'msg' => $Upload->getErrorMsg()));
        } else {
            echo json_encode(array('success' => true, 'file' => $Upload->getFileName()));
        }
    }

}
