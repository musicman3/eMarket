<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\JsonRpc;

use eMarket\Core\{
    Func,
    JsonRpc,
    Pdo,
    Valid
};

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
    private $token = '';

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->request();
    }

    /**
     * Get token
     *
     */
    private function getToken(): void {
        $decrypt_login = Func::decryption(DB_PASSWORD, Valid::inPostJson('login'));
        $token = Pdo::getValue("SELECT chatgpt_token FROM " . TABLE_ADMINISTRATORS . " WHERE login=?",
                        [$decrypt_login]);
        if ($token != 'null') {
            $this->token = json_decode($token, true)[0];
        }
    }

    /**
     * Request
     *
     */
    private function request(): void {
        if (Valid::inPostJson('message')) {
            $this->getToken();

            $request = (object) ['model' => 'gpt-3.5-turbo',
                        'messages' => [(object) [
                                'role' => 'user',
                                'content' => Valid::inPostJson('message')
                            ]],
                        'temperature' => 0.7
            ];

            echo $this->curl($request,
                    'https://api.openai.com/v1/chat/completions',
                    ['Content-Type: application/json',
                        'Accept: application/json',
                        'User-Agent: eMarket',
                        'Authorization: Bearer ' . $this->token]);
        }
    }

}
