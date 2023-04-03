<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\JsonRpc;

use eMarket\Core\{
    JsonRpc
};

/**
 * Update class
 *
 * @package JsonRpc
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Update extends JsonRpc {

    public static $routing_parameter = 'Update';

    /**
     * Constructor
     *
     */
    public function __construct() {
        echo json_encode($this->responseVersion());
    }

    /**
     * This version
     *
     * @return string Version
     */
    private function thisVersion(): string {
        return 'v 1.0 Beta 4';
    }

    /**
     * Check version
     *
     * @return bool|array Version Data
     */
    private function checkVersion(): bool|array {

        if ($this->eMarketData() != FALSE) {
            return [
                'this_version' => $this->thisVersion(),
                'new_version' => $this->eMarketData()
            ];
        }
        if ($this->gitHubData() != FALSE) {
            return [
                'this_version' => $this->thisVersion(),
                'new_version' => $this->gitHubData()
            ];
        }

        return false;
    }

    /**
     * Response version
     *
     * @return bool|array Version Data
     */
    private function responseVersion(): bool|array {

        $version = $this->checkVersion();

        if ($version && $version['this_version'] >= $version['new_version']) {
            return [
                'status' => 'ok',
                'this_version' => $this->thisVersion(),
                'new_version' => $this->gitHubData(),
                'message' => $this->thisVersion()
            ];
        }

        if ($version && $version['this_version'] < $version['new_version']) {
            return [
                'status' => 'false',
                'this_version' => $this->thisVersion(),
                'new_version' => $this->gitHubData(),
                'message' => lang('new_version_available')
            ];
        }

        return false;
    }

    /**
     * GitHub Data
     *
     * @return mixed GitHub latest release data
     */
    private function gitHubData(): mixed {
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
    private function eMarketData(): mixed {
        $data = [
            'jsonrpc' => '2.0',
            'method' => 'CheckVersion',
            'param' => [
                'this_version' => $this->thisVersion()
            ]
        ];

        $response_string = $this->curl($data, 'https://data.emarketforum.com/services/jsonrpc/');

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

}
