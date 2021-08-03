<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Update class
 *
 * @package Update
 * @author eMarket
 * 
 */
class Update {

    /**
     * This version
     *
     * @return string Version
     */
    public static function thisVersion() {
        return 'v 1.0 Beta 2';
    }

    /**
     * Check version
     *
     * @return array Version Data
     */
    public static function checkVersion() {

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
     * @return array GitHub latest release data
     */
    static function gitHubData() {
        $connect = curl_init();
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connect, CURLOPT_HTTPHEADER, ['User-Agent: eMarket']);
        curl_setopt($connect, CURLOPT_URL, 'https://api.github.com/repos/musicman3/eMarket/releases/latest');
        $response_string = curl_exec($connect);
        curl_close($connect);
        if (!empty($response_string)) {
            $response = json_decode($response_string, 1);
            if (isset($response['name'])) {
                return $response['name'];
            }
        } else {
            return FALSE;
        }
    }

    /**
     * eMarket Data
     *
     * @return array eMarket update data
     */
    static function eMarketData() {
        $data = [
            'jsonrpc' => '2.0',
            'method' => 'CheckVersion',
            'param' => [
                'this_version' => self::thisVersion()
            ]
        ];

        $response_string = self::curl($data, 'https://demo.emarketforum.com/services/jsonrpc/');

        if ($response_string != FALSE) {
            if (isset($response_string->result)) {
                return $response_string->result;
            }
            if (isset($response_string->error)) {
                return $response_string->error;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Curl
     *
     * @param array $data (request data)
     * @param string $host (request host)
     */
    static function curl($data, $host) {
        $curl = curl_init($host);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSLVERSION, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json', 'User-Agent: eMarket']);
        $request_string = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_string);
        $response_string = curl_exec($curl);
        if (!empty($response_string)) {
            $response = json_decode($response_string);
            if (isset($response)) {
                return $response;
            }
        } else {
            return false;
        }
    }

}
