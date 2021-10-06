<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

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
     */
    public function loadData(): void {
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
     * @return string jsonRPC URL
     */
    public static function encodeGetData(?string $id, string $method, array $param = []): string {
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
     * @return array|string jsonRPC data
     */
    public function decodeGetData(?string $name): array|string {
        if (!$this->decode_data) {
            $this->decode_data = json_decode(urldecode(Valid::inGET('request')), true);
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
    public function error(?string $code, ?string $message, ?string $id): void {
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
     * @return mixed $response_string|FALSE (request string)
     */
    public function curl(array $data, string $host): mixed {
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
