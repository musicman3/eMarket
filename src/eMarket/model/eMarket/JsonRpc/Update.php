<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\JsonRpc;

use eMarket\Core\{
    Cryptography,
    JsonRpc,
    Valid
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
        header('Content-Type: application/json');
        $this->jsonRpcVerification(['?route=basic_settings']);
        $this->init();
    }

    /**
     * Init
     * 
     */
    public function init(): void {
        if (isset(Valid::inPostJson('jsonrpc')[0]['param']['message']) && Valid::inPostJson('jsonrpc')[0]['param']['message'] == 'update' && copy(getenv('DOCUMENT_ROOT') . '/storage/updater/update.php', getenv('DOCUMENT_ROOT') . '/update.php')) {
            $this->response(['status' => 'update']);
        } else {
            $this->response($this->responseVersion());
        }
    }

    /**
     * This version
     *
     * @return string Version
     */
    private function thisVersion(): string {

        if (file_get_contents(getenv('DOCUMENT_ROOT') . '/storage/updater/version.cfg')) {
            return file_get_contents(getenv('DOCUMENT_ROOT') . '/storage/updater/version.cfg');
        }
        return '';
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

        if ($version && version_compare($version['this_version'], $version['new_version'], '>=')) {
            return [
                'status' => 'ok',
                'this_version' => $version['this_version'],
                'new_version' => $version['new_version'],
                'message' => $version['this_version']
            ];
        }

        if ($version && version_compare($version['this_version'], $version['new_version'], '<')) {
            return [
                'status' => 'false',
                'this_version' => $version['this_version'],
                'new_version' => $version['new_version'],
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
        $response_string = $this->curlFromGet('https://api.github.com/repos/musicman3/eMarket/releases/latest');

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
     * @return mixed eMarket latest release data
     */
    private function eMarketData(): mixed {

        $response = $this->curlFromGet('https://data.emarkets.su/services/jsonrpc/request/');

        if (empty($response)) {
            return false;
        }

        if ($response !== false && $response !== null && $response !== '') {
            if (json_last_error() === JSON_ERROR_NONE) {
                return false;
            }
        }

        if (is_string($response) && strpos($response, 'v 1.')) {
            return $response;
        }

        return false;
    }

    /**
     * Curl from GET-request
     *
     * @param string $host (request host)
     * @param array $header (CURLOPT_HTTPHEADER parameters)
     * @return mixed $response_string|bool (request string)
     */
    public function curlFromGet(string $host, $header = ['Content-Type: application/json', 'Accept: application/json', 'User-Agent: eMarket']): mixed {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            return FALSE;
        }
        curl_close($curl);
        return $response;
    }
}
