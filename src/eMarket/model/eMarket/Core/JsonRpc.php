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
use Cruder\Db;

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
     * Constructor
     *
     */
    public function __construct() {
        $this->verifyMethod();
    }

    /**
     * Verify method
     * 
     */
    public function verifyMethod(): void {
        if ($this->routing('jsonrpc') && $this->routing('method') && $this->routing('id')) {
            $namespace = $this->routing('method');
            if (!class_exists($namespace)) {
                $this->error('-32601', 'Method not found', $this->routing('id'));
            }
        }
    }

    /**
     * Verify Admin & permission
     *
     * @param array $available_pages List of available pages ['?route=basic_settings']
     */
    public function jsonRpcVerification(array $available_pages = []): void {

        if (!Valid::inPostJson('param')['login']) {
            $this->error('-32601', 'Access denied', '');
        } else {

            $login = Cryptography::decryption(DB_PASSWORD, Valid::inPostJson('param')['login'], CRYPT_METHOD);

            $permission = Db::connect()
                    ->read(TABLE_ADMINISTRATORS)
                    ->selectValue('permission')
                    ->where('login=', $login)
                    ->save();

            if ($permission != 'admin') {

                $staff_data_prepare = Db::connect()
                        ->read(TABLE_STAFF_MANAGER)
                        ->selectValue('permissions')
                        ->where('id=', $permission)
                        ->save();

                $staff_data = json_decode($staff_data_prepare, true);

                $count = 0;
                if (count($available_pages) == 0) {
                    $count = 1;
                } else {
                    foreach ($staff_data as $value) {
                        if (in_array($value, $available_pages)) {
                            $count++;
                        }
                    }
                }
                if ($count == 0) {
                    $this->error('-32601', 'Access denied', Valid::inPostJson('id'));
                }
            }
        }
    }

    /**
     * Response
     *
     * @param array $result Result data
     */
    public function response(array|bool $result = []): void {

        if ($result) {
            $data = json_encode([
                'jsonrpc' => '2.0',
                'result' => $result,
                'id' => $this->routing('id'),
            ]);
            echo $data;
        }
        exit;
    }

    /**
     * jsonRPC routind
     * 
     * @param string $name Name
     * @return array|string jsonRPC data
     */
    public function routing(?string $name): array|string {

        if (!Valid::inPostJson('jsonrpc') || !Valid::inPostJson('method') || !Valid::inPostJson('id')) {
            $this->error('-32600', 'Invalid Request', '');
        }
        if (!$this->decode_data) {
            $param = [];
            if (Valid::inPostJson('param')) {
                $param = Valid::inPostJson('param');
            }
            $this->decode_data = [
                'jsonrpc' => Valid::inPostJson('jsonrpc'),
                'method' => Valid::inPostJson('method'),
                'param' => $param,
                'id' => Valid::inPostJson('id'),
            ];
        }
        if ($this->decode_data == null) {
            $this->error('-32700', 'Parse error', '');
        }
        if (!isset($this->decode_data[$name])) {
            $this->error('-32602', 'Invalid name', '');
        }
        if ($this->decode_data['jsonrpc'] !== '2.0') {
            $this->error('-32602', 'Invalid jsonrpc version', '');
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
        header('Content-Type: application/json');
        $data = json_encode([
            'jsonrpc' => '2.0',
            'error' => ['code' => $code, 'message' => $message],
            'id' => $id
        ]);
        echo $data;
        exit;
    }

    /**
     * Curl from POST-request
     *
     * @param array|object $data (request data)
     * @param string $host (request host)
     * @param array $header (CURLOPT_HTTPHEADER parameters)
     * @return mixed $response_string|FALSE (request string)
     */
    public function curl(array|object $data, string $host, $header = ['Content-Type: application/json', 'Accept: application/json', 'User-Agent: eMarket']): mixed {
        $curl = curl_init($host);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSLVERSION, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $request_string = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_string);
        $response_string = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        if (!empty($response_string)) {
            return $response_string;
        } else {
            return FALSE;
        }
    }
}
