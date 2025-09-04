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
    private $error_messages = [];
    private $methods_available = [];
    public static $response = [];

    /**
     * Constructor
     *
     */
    public function __construct() {
        
    }

    /**
     * Return jsonRpc data from key name
     * 
     * @param array $key Key name
     * @return array jsonRPC key-data
     */
    public function thisJsonRpcData($key): array {
        return Valid::inPostJson('jsonrpc')[array_search($key, Valid::inPostJson('jsonrpc'))];
    }

    /**
     * Verify Admin & permission
     *
     * @param array $available_pages List of available pages ['?route=basic_settings']
     */
    public function jsonRpcVerification(array $available_pages = []): void {

        if (Valid::inPostJson('jsonrpc')) {

            foreach (Valid::inPostJson('jsonrpc') as $jsonrpc) {
                if (!$jsonrpc['param']['login'] && $jsonrpc['id']) {
                    $this->error('-32601', 'Access denied', '');
                } else {

                    $login = Cryptography::decryption(DB_PASSWORD, $jsonrpc['param']['login'], CRYPT_METHOD);

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
                            $this->error('-32601', 'Access denied', $jsonrpc['id']);
                        }
                    }
                }
            }
        }
    }

    /**
     * Response Builder
     *
     * @param array $result Result data
     * @param  string|null $id Response id
     */
    public function responseBuilder(array|bool $result = [], string|null $id = null): void {

        if ($result) {
            $data = [
                'jsonrpc' => '2.0',
                'result' => $result,
                'id' => $id,
            ];
            array_push(self::$response, $data);
        }
    }

    /**
     * Response Builder
     *
     */
    public function response(): void {

        if (count($this->error_messages) > 0) {
            array_push(self::$response, $this->error_messages);
        }
        if (count(self::$response) > 0) {
            echo json_encode(self::$response);
            exit;
        }
    }

    /**
     * jsonRPC routing
     * 
     * @param string $name Name
     * @return array|string jsonRPC data
     */
    public function routing(): array|string {

        if (Valid::inPostJson('jsonrpc')) {

            foreach (Valid::inPostJson('jsonrpc') as $jsonrpc) {
                if (!isset($jsonrpc['jsonrpc']) || !isset($jsonrpc['method']) || !isset($jsonrpc['id'])) {
                    $this->error('-32600', 'Invalid Request', null);
                } else {
                    if (!class_exists($jsonrpc['method'])) {
                        $this->error('-32601', 'Method not found', $jsonrpc['id']);
                    } else {
                        array_push($this->methods_available, $jsonrpc);
                    }

                    if (!$this->decode_data) {
                        $param = [];
                        if ($jsonrpc['param']) {
                            $param = $jsonrpc['param'];
                        }
                        $this->decode_data = [
                            'jsonrpc' => $jsonrpc['jsonrpc'],
                            'method' => $jsonrpc['method'],
                            'param' => $param,
                            'id' => $jsonrpc['id'],
                        ];
                    }
                    if ($this->decode_data == null) {
                        $this->error('-32700', 'Parse error', $jsonrpc['id']);
                    }
                    if ($this->decode_data['jsonrpc'] !== '2.0') {
                        $this->error('-32602', 'Invalid jsonrpc version', $jsonrpc['id']);
                    }
                }
            }
        } else {
            $this->error('-32600', 'Invalid Request', null);
        }

        return $this->methods_available;
    }

    /**
     * Error message
     * 
     * @param string $code Error code
     * @param string $message Error message
     * @param string $id ID
     */
    public function error(?string $code, ?string $message, ?string $id): void {

        $data = [
            'jsonrpc' => '2.0',
            'error' => ['code' => $code, 'message' => $message],
            'id' => $id
        ];
        $this->error_messages;
        array_push($this->error_messages, $data);
    }

    /**
     * Error message Handler
     * 
     */
    public function errorHandler(): void {

        if (count($this->error_messages) > 0) {
            header('Content-Type: application/json');
            $error = json_encode($this->error_messages);
            echo $error;
            exit;
        }
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
