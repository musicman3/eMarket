<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

/**
 * Cryptography
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Cryptography {

    /**
     * Token
     *
     * @param int|string $length Length
     * @return string
     */
    public static function getToken(int|string $length): string {
        $token = '';
        $symbols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $symbols .= 'abcdefghijklmnopqrstuvwxyz';
        $symbols .= '0123456789';
        $max = strlen($symbols);

        for ($i = 0; $i < (int) $length; $i++) {
            $token .= $symbols[random_int(0, $max - 1)];
        }

        return $token;
    }

    /**
     * Encryption
     *
     * @param int|string $password Password
     * @param int|string $data Data
     * @param string|null $method Crypt method
     * @return string|false
     */
    public static function encryption(int|string $password, int|string $data, ?string $method): string|false {
        $key = substr(hash('sha256', $password, true), 0, 32);
        $cipher = $method;
        $iv_len = openssl_cipher_iv_length($cipher);
        $tag_length = 16;
        $iv = openssl_random_pseudo_bytes($iv_len);
        $tag = '';
        $ciphertext = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, '', $tag_length);
        return $encrypted = base64_encode($iv . $ciphertext . $tag);
    }

    /**
     * Decryption
     *
     * @param int|string $password Password
     * @param int|string $data Data
     * @param string|null $method Crypt method
     * @return string|false
     */
    public static function decryption(int|string $password, int|string $data, ?string $method): string|false {
        $encrypted = base64_decode($data);
        $key = substr(hash('sha256', $password, true), 0, 32);
        $cipher = $method;
        $iv_len = openssl_cipher_iv_length($cipher);
        $tag_length = 16;
        $iv = substr($encrypted, 0, $iv_len);
        $ciphertext = substr($encrypted, $iv_len, -$tag_length);
        $tag = substr($encrypted, -$tag_length);
        return $decrypted = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
    }

    /**
     * Password hashing
     *
     * @param string Password
     * @return string $password Hash
     */
    public static function passwordHash(string $password): string {

        if (HASH_METHOD == 'PASSWORD_DEFAULT') {
            $options = ['cost' => 10];
            $METHOD = PASSWORD_DEFAULT;
        }
        if (HASH_METHOD == 'PASSWORD_BCRYPT') {
            $options = ['cost' => 10];
            $METHOD = PASSWORD_BCRYPT;
        }
        if (HASH_METHOD == 'PASSWORD_ARGON2I') {
            $options = ['time_cost' => 2];
            $METHOD = PASSWORD_ARGON2I;
        }
        $password_hash = password_hash($password, $METHOD, $options);

        return $password_hash;
    }

}
