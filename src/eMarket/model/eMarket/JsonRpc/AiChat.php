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
    Settings
};
use Cruder\Db;

/**
 * AiChat
 *
 * @package JsonRpc
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class AiChat extends JsonRpc {

    public static $routing_parameter = 'AiChat';
    public static $jsonrpc;
    private $token = 'My_token';
    public static $chat_name = 'ChatGPT';

    /**
     * Constructor
     *
     */
    public function __construct() {
        header('Content-Type: application/json');
        $this->jsonRpcVerification();
        self::getChatName();
        $this->setChatName();
        $this->request();
        $this->apiKey();
    }

    /**
     * AiChat Checked
     *
     * @param string $name AiChat name
     * @return string
     */
    public static function checked(string $name): string {
        self::getChatName();
        if ($name == self::$chat_name) {
            return 'checked';
        } else {
            return '';
        }
    }

    /**
     * Set chat name
     *
     */
    private function setChatName(): void {
        if (isset(self::$jsonrpc['param']['aichat_name'])) {

            $other = json_decode(Settings::basicSettings('other'), true);

            $other['aichat_name'] = self::$jsonrpc['param']['aichat_name'];

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('other', json_encode($other))
                    ->save();

            $this->responseBuilder([lang('aichat_checked')], self::$jsonrpc['id']);
        }
    }

    /**
     * Get chat name
     *
     */
    public static function getChatName(): void {
        $other = json_decode(Settings::basicSettings('other'), true);

        if (isset($other['aichat_name'])) {
            self::$chat_name = $other['aichat_name'];
        }
    }

    /**
     * Get token
     *
     */
    private function getToken(): void {
        $decrypt_login = Cryptography::decryption(DB_PASSWORD, self::$jsonrpc['param']['login'], CRYPT_METHOD);

        $token = Db::connect()
                ->read(TABLE_ADMINISTRATORS)
                ->selectValue('my_data')
                ->where('login=', $decrypt_login)
                ->save();

        if ($token != 'null') {
            $data = json_decode($token, true);
            if (isset($data['aichat_token'])) {
                $this->token = $data['aichat_token'];
            }
        }
    }

    /**
     * Request
     *
     */
    private function request(): void {
        if (isset(self::$jsonrpc['param']['message'])) {
            if (self::$chat_name == 'ChatGPT') {
                $this->chatGptApi();
            }

            if (self::$chat_name == 'DeepSeek') {
                $this->deepSeekApi();
            }
        }
    }

    /**
     * ChatGPT API
     *
     */
    private function chatGptApi(): void {
        $this->getToken();

        $request = (object) ['model' => 'gpt-5-nano',
                    'messages' => [(object) [
                            'role' => 'user',
                            'content' => self::$jsonrpc['param']['message']
                        ]],
                    'temperature' => 1
        ];

        $output = json_decode($this->curl($request,
                        'https://api.openai.com/v1/chat/completions',
                        ['Content-Type: application/json',
                            'Accept: application/json',
                            'User-Agent: eMarket',
                            'Authorization: Bearer ' . $this->token]));

        $this->responseBuilder([$output], self::$jsonrpc['id']);
    }

    /**
     * DeepSeek API
     *
     */
    private function deepSeekApi(): void {
        $this->getToken();

        $request = (object) ['model' => 'deepseek-chat',
                    'messages' => [(object) [
                            'role' => 'user',
                            'content' => self::$jsonrpc['param']['message']
                        ]],
                    'stream' => false
        ];

        $output = json_decode($this->curl($request,
                        'https://api.deepseek.com/chat/completions',
                        ['Content-Type: application/json',
                            'Accept: application/json',
                            'User-Agent: eMarket',
                            'Authorization: Bearer ' . $this->token]));

        $this->responseBuilder([$output], self::$jsonrpc['id']);
    }

    /**
     * Api Key
     *
     */
    private function apiKey(): void {
        if (isset(self::$jsonrpc['param']['api_key'])) {
            $decrypt_login = Cryptography::decryption(DB_PASSWORD, self::$jsonrpc['param']['login'], CRYPT_METHOD);

            $aichat_token = json_encode(['aichat_token' => self::$jsonrpc['param']['api_key']]);

            Db::connect()
                    ->update(TABLE_ADMINISTRATORS)
                    ->set('my_data', $aichat_token)
                    ->where('login=', $decrypt_login)
                    ->save();

            $this->responseBuilder([lang('aichat_api_key_saved')], self::$jsonrpc['id']);
        }
    }
}
