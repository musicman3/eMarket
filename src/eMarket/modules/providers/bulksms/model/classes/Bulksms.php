<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Providers;

use eMarket\Core\{
    DataBuffer,
    Interfaces\ProvidersModulesInterface,
    Messages,
    Modules,
    Pdo,
    Valid
};

/**
 * Module Bulksms
 *
 * @package Providers modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Bulksms implements ProvidersModulesInterface {

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
    }

    /**
     * Install
     *
     * @param array $module (input data)
     */
    public static function install(array $module): void {
        Modules::install($module);
    }

    /**
     * Uninstall
     *
     * @param array $module (input data)
     */
    public static function uninstall(array $module): void {
        Modules::uninstall($module);
    }

    /**
     * Load data
     *
     * @return array $interface (data)
     */
    public static function load(): void {

        $DataBuffer = new DataBuffer();

        $interface = [
            'chanel_module_name' => 'bulksms'
        ];

        $DataBuffer->save('providers', 'bulksms', $interface);
    }

    /**
     * Save
     *
     */
    public function save(): void {
        if (Valid::inPOST('save')) {

            $MODULE_DB = Modules::moduleDatabase();

            $data = Pdo::getValue("SELECT * FROM " . $MODULE_DB, []);
            if ($data == FALSE) {
                Pdo::action("INSERT INTO " . $MODULE_DB . " SET login=?, password=?, sender=?", [Valid::inPOST('login'), Valid::inPOST('password'), Valid::inPOST('sender')]);
            } else {
                Pdo::action("UPDATE " . $MODULE_DB . " SET login=?, password=?, sender=?", [Valid::inPOST('login'), Valid::inPOST('password'), Valid::inPOST('sender')]);
            }

            Messages::alert('save_providers_bulksms', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    public static function data(): void {
        $data = Pdo::getAssoc("SELECT * FROM " . DB_PREFIX . 'modules_providers_bulksms', []);
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
        $messages = [
            ['from' => $sender, 'to' => $to_phone_number, 'body' => $body]
        ];

        $result = self::curl(json_encode($messages), 'https://api.bulksms.com/v1/messages?auto-unicode=true&longMessageMaxParts=30', $username, $password);

        if ($result['http_status'] != 201) {
            echo 'error';
        } else {
            echo 'ok';
        }
    }

    /**
     * Curl 
     *
     * @param array $post_body (json post body)
     * @param string $url (url)
     * @param string $username (username)
     * @param string $password (password)
     * @return array Output data
     */
    public static function curl(array $post_body, string $url, string $username, string $password): array {
        $ch = curl_init();
        $headers = [
            'Content-Type:application/json',
            'Authorization:Basic ' . base64_encode("$username:$password")
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
        return $output;
    }

}
