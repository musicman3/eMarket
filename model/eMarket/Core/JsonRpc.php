<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Valid
};

/**
 * jsonRPC
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class JsonRpc {

    private $decode_data = FALSE;

    /**
     * Loading data from Services
     * 
     * @return array
     */
    public function loadData() {
        if (Valid::inPostJson('jsonrpc') == '2.0' && Valid::inPostJson('method') && Valid::inPostJson('id')) {
            $namespace = '\eMarket\JsonRpc\\' . Valid::inPostJson('method');
            if (class_exists($namespace)) {
                new $namespace;
            } else {
                $this->error(-32601, 'Method not found', Valid::inPostJson('id'));
            }
        }
        if (Valid::inGET('request') && $this->decodeGetData('jsonrpc') == '2.0' && $this->decodeGetData('method') && $this->decodeGetData('id')) {
            $namespace = '\eMarket\JsonRpc\\' . $this->decodeGetData('method');
            if (class_exists($namespace)) {
                new $namespace;
            } else {
                $this->error(-32601, 'Method not found', $this->decodeGetData('id'));
            }
        }
    }

    /**
     * jsonRPC data for GET request
     *
     * @param string $id ID
     * @param string $method Method
     * @param array $param param data
     * @return string jsonRPC data
     */
    public static function encodeGetData($id, $method, $param = []) {
        $data = urlencode(json_encode([
            'jsonrpc' => '2.0',
            'method' => $method,
            'param' => $param,
            'id' => $id,
        ]));
        return '/services/jsonrpc/?request=' . $data;
    }

    /**
     * jsonRPC data from GET request
     * 
     * @param string $name Name
     * @return array jsonRPC data
     */
    public function decodeGetData($name) {
        if (!$this->decode_data) {
            $this->decode_data = json_decode(urldecode(Valid::inGET('request')), 1);
        }
        if ($name == null) {
            return $this->decode_data;
        } else {
            return $this->decode_data[$name];
        }
    }

    /**
     * Error message
     * 
     * @param string $code Error code
     * @param string $message Error message
     * @param string $id ID
     */
    public function error($code, $message, $id) {
        $data = json_encode([
            'jsonrpc' => '2.0',
            'error' => ['code' => $code, 'message' => $message],
            'id' => $id
        ]);
        header('Content-Type: application/json');
        echo $data;
        exit;
    }

    /**
     * Curl
     *
     * @param array $data (request data)
     * @param string $host (request host)
     */
    public function curl($data, $host) {
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
