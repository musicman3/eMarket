<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Modules\Providers;

use eMarket\Core\{
    DataBuffer,
    Interfaces\ProvidersModulesInterface,
    Messages,
    Modules
};
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Module Smsc
 *
 * @package Providers modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
final class Smsc implements ProvidersModulesInterface {

    public static $data;
    public static $order_status;
    public static $order_status_selected;
    public static $shipping_val;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->load();
        $this->save();
        self::data();
        Modules::setJs('providers/smsc');
    }

    /**
     * Install
     *
     * @param array $module (input data)
     */
    #[\Override]
    public static function install(array $module): void {
        Modules::install($module);
    }

    /**
     * Uninstall
     *
     * @param array $module (input data)
     */
    #[\Override]
    public static function uninstall(array $module): void {
        Modules::uninstall($module);
    }

    /**
     * Load data
     *
     * @return array $interface (data)
     */
    #[\Override]
    public static function load(): void {

        $DataBuffer = new DataBuffer();

        $interface = [
            'chanel_module_name' => 'smsc'
        ];

        $DataBuffer->save('providers', 'smsc', $interface);
    }

    /**
     * Save
     *
     */
    #[\Override]
    public function save(): void {
        if (Valid::inPOST('save')) {

            $MODULE_DB = Modules::databaseName();

            $data = Db::connect()
                    ->read($MODULE_DB)
                    ->selectValue('*')
                    ->save();

            if ($data == FALSE) {

                Db::connect()
                        ->create($MODULE_DB)
                        ->set('login', Valid::inPOST('login'))
                        ->set('password', Valid::inPOST('password'))
                        ->set('sender', Valid::inPOST('sender'))
                        ->save();
            } else {

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('login', Valid::inPOST('login'))
                        ->set('password', Valid::inPOST('password'))
                        ->set('sender', Valid::inPOST('sender'))
                        ->save();
            }

            Messages::alert('save_providers_smsc', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    #[\Override]
    public static function data(): void {

        $data = Db::connect()
                ->read(DB_PREFIX . 'modules_providers_smsc')
                ->selectAssoc('*')
                ->save();

        if (count($data) > 0) {
            self::$data = $data[0];
        } else {
            self::$data = ['login' => '', 'password' => '', 'sender' => ''];
        }
    }

    /**
     * Send message to server
     *
     * @param string $to_phone_number ('To' phone_number)
     * @param string $body (message)
     */
    public static function send(string $to_phone_number, string $body): void {
        $username = self::$data['login'];
        $password = self::$data['password'];
        $sender = self::$data['sender'];
        $messages = ['sender' => $sender, 'phones' => $to_phone_number, 'mes' => $body, 'login' => $username, 'psw' => $password];
        $encoded = '';
        foreach ($messages as $name => $value) {
            $encoded .= urlencode($name) . '=' . urlencode($value) . '&';
        }

        $result = self::curl($encoded, 'https://smsc.ru/sys/send.php');

        if ($result['http_status'] != 201) {
            echo 'error';
        } else {
            echo 'ok';
        }
    }

    /**
     * Curl
     *
     * @param string $post_body (json post body)
     * @param string $url (url)
     */
    public static function curl(string $post_body, string $url): void {
        $ch = curl_init();
        $headers = [
            'Content-Type:application/x-www-form-urlencoded'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $output = [];
        $output['server_response'] = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        $output['http_status'] = $curl_info['http_code'];
        $output['error'] = curl_error($ch);
        curl_close($ch);
    }
}
