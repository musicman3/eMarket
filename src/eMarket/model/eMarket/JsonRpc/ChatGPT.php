<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\JsonRpc;

use eMarket\Core\{
    Cryptography,
    JsonRpc
};
use Cruder\Db;

/**
 * ChatGPT
 *
 * @package JsonRpc
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class ChatGPT extends JsonRpc {

    public static $routing_parameter = 'ChatGPT';
    private $jsonrpc = FALSE;
    private $token = '';

    /**
     * Constructor
     *
     */
    public function __construct() {
        header('Content-Type: application/json');
        $this->jsonrpc = $this->jsonRpcData('eMarket\\JsonRpc\\ChatGPT');
        $this->jsonRpcVerification();
        $this->request();
        $this->apiKey();
    }

    /**
     * Get token
     *
     */
    private function getToken(): void {
        $decrypt_login = Cryptography::decryption(DB_PASSWORD, $this->jsonrpc['param']['login'], CRYPT_METHOD);

        $token = Db::connect()
                ->read(TABLE_ADMINISTRATORS)
                ->selectValue('my_data')
                ->where('login=', $decrypt_login)
                ->save();

        if ($token != 'null') {
            $this->token = json_decode($token, true)['chatgpt_token'];
        }
    }

    /**
     * Request
     *
     */
    private function request(): void {
        if (isset($this->jsonrpc['param']['message'])) {
            $this->getToken();

            $request = (object) ['model' => 'gpt-3.5-turbo',
                        'messages' => [(object) [
                                'role' => 'user',
                                'content' => $this->jsonrpc['param']['message']
                            ]],
                        'temperature' => 0.7
            ];

            $output = json_decode($this->curl($request,
                    'https://api.openai.com/v1/chat/completions',
                    ['Content-Type: application/json',
                        'Accept: application/json',
                        'User-Agent: eMarket',
                        'Authorization: Bearer ' . $this->token]));
            
            $this->responseBuilder([$output], $this->jsonrpc['id']);
        }
    }

    /**
     * Api Key
     *
     */
    private function apiKey(): void {
        if (isset($this->jsonrpc['param']['api_key'])) {
            $decrypt_login = Cryptography::decryption(DB_PASSWORD, $this->jsonrpc['param']['login'], CRYPT_METHOD);

            $chatgpt_token = json_encode(['chatgpt_token' => $this->jsonrpc['param']['api_key']]);

            Db::connect()
                    ->update(TABLE_ADMINISTRATORS)
                    ->set('my_data', $chatgpt_token)
                    ->where('login=', $decrypt_login)
                    ->save();
            
            $this->responseBuilder([lang('chatgpt_api_key_saved')], $this->jsonrpc['id']);
        }
    }
}
