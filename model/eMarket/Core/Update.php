<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

/**
 * Update class
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Update {

    /**
     * This version
     *
     * @return string Version
     */
    public static function thisVersion(): string {
        return 'v 1.0 Beta 2';
    }

    /**
     * Check version
     *
     * @return array Version Data
     */
    public static function checkVersion(): string|array {

        if (isset($_SESSION['version']['time']) && (time() - $_SESSION['version']['time']) / 60 > 60) {
            unset($_SESSION['version']);
        }

        if (!isset($_SESSION['version'])) {
            if (self::eMarketData() != FALSE) {
                $_SESSION['version'] = [
                    'status' => 'ok',
                    'this_version' => self::thisVersion(),
                    'new_version' => self::eMarketData(),
                    'time' => time(),
                    'message' => ''
                ];
            } elseif (self::gitHubData() != FALSE) {
                $_SESSION['version'] = [
                    'status' => 'ok',
                    'this_version' => self::thisVersion(),
                    'new_version' => self::gitHubData(),
                    'time' => time(),
                    'message' => ''
                ];
            }
        }
        if (isset($_SESSION['version'])) {
            return $_SESSION['version'];
        } else {
            $output = [
                'status' => 'false',
                'this_version' => self::thisVersion(),
                'new_version' => '',
                'time' => time(),
                'message' => ''
            ];
            return $output;
        }
    }

    /**
     * GitHub Data
     *
     * @return mixed GitHub latest release data
     */
    public static function gitHubData(): mixed {
        $connect = curl_init();
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connect, CURLOPT_HTTPHEADER, ['User-Agent: eMarket']);
        curl_setopt($connect, CURLOPT_URL, 'https://api.github.com/repos/musicman3/eMarket/releases/latest');
        curl_setopt($connect, CURLOPT_CONNECTTIMEOUT, 3);
        $response_string = curl_exec($connect);
        if (curl_errno($connect)) {
            return FALSE;
        }
        curl_close($connect);
        if (!empty($response_string)) {
            $response = json_decode($response_string, true);
            if (isset($response['name'])) {
                return $response['name'];
            }
        }
        return FALSE;
    }

    /**
     * eMarket Data
     *
     * @return mixed eMarket update data
     */
    public static function eMarketData(): mixed {
        $data = [
            'jsonrpc' => '2.0',
            'method' => 'CheckVersion',
            'param' => [
                'this_version' => self::thisVersion()
            ]
        ];

        $response_string = self::curl($data, 'https://data.emarketforum.com/services/jsonrpc/');

        if ($response_string != FALSE) {
            if (isset($response_string->result)) {
                return $response_string->result;
            }
            if (isset($response_string->error)) {
                return $response_string->error;
            }
        }
        return FALSE;
    }

    /**
     * Curl
     *
     * @param array $data (request data)
     * @param string $host (request host)
     * @return mixed $response_string|FALSE (request string)
     */
    public static function curl(array $data, string $host): mixed {
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
            $response = json_decode($response_string);
            if (isset($response)) {
                return $response;
            }
        }
        return FALSE;
    }

}
