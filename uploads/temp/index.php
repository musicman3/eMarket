<?php
/**
* Simple Ajax Uploader
* Version 2.6.6
* https://github.com/LPology/Simple-Ajax-Uploader
*
* Copyright 2012-2019 LPology, LLC
* Released under the MIT license
*
* View the documentation for an example of how to use this class.
*/

error_reporting(E_ALL | E_STRICT);
require_once('../../model/vendor/autoload.php');

$upload_dir = '../../uploads/temp/files/';
$valid_extensions = array('gif', 'png', 'jpeg', 'jpg');

$Upload = new FileUpload('uploadfile');
$result = $Upload->handleUpload($upload_dir, $valid_extensions);

if (!$result) {
    echo json_encode(array('success' => false, 'msg' => $Upload->getErrorMsg()));   
} else {
    echo json_encode(array('success' => true, 'file' => $Upload->getFileName()));
}
