<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core\Modules\Providers;

use eMarket\Core\{
    Interfaces,
    Messages,
    Modules,
    Pdo,
    Valid
};

/**
 * Module Smsc
 *
 * @package Smsc
 * @author eMarket
 * 
 */
class Smsc {

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
    public static function install($module) {
        Modules::install($module);
    }

    /**
     * Delete
     *
     * @param array $module (input data)
     */
    public static function uninstall($module) {
        Modules::uninstall($module);
    }

    /**
     * Send message to server
     *
     * @param string $to_phone_number ('To' phone_number)
     * @param string $body (message)
     */
    public static function send($to_phone_number, $body) {
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
     * @param array $post_body (json post body)
     * @param string $url (url)
     */
    public static function curl($post_body, $url) {
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

    /**
     * Load data
     *
     * @return array $interface (data)
     */
    public static function load() {

        $INTERFACE = new Interfaces();

        $interface = [
            'chanel_module_name' => 'smsc'
        ];

        $INTERFACE->save('providers', 'smsc', $interface);
    }

    /**
     * Save
     *
     */
    public function save() {
        if (Valid::inPOST('save')) {

            $MODULE_DB = Modules::moduleDatabase();

            $data = Pdo::getCellFalse("SELECT * FROM " . $MODULE_DB, []);
            if ($data == FALSE) {
                Pdo::action("INSERT INTO " . $MODULE_DB . " SET login=?, password=?, sender=?", [Valid::inPOST('login'), Valid::inPOST('password'), Valid::inPOST('sender')]);
            } else {
                Pdo::action("UPDATE " . $MODULE_DB . " SET login=?, password=?, sender=?", [Valid::inPOST('login'), Valid::inPOST('password'), Valid::inPOST('sender')]);
            }

            Messages::alert('save', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    public static function data() {
        $data = Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_providers_smsc', []);
        if (count($data) > 0) {
            self::$data = $data[0];
        } else {
            self::$data = ['login' => '', 'password' => '', 'sender' => ''];
        }
    }

}
