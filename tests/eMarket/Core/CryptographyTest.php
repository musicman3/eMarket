<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use PHPUnit\Framework\TestCase;
use eMarket\Core\{
    Cryptography
};

final class CryptographyTest extends TestCase {

    /**
     * getToken()
     * 
     */
    public function testGetToken() {
        $result = Cryptography::getToken(20);
        $this->assertIsString($result);
        $this->assertSame(iconv_strlen($result), 20);
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]+$/', $result);
    }

    /**
     * encryption() and decryption()
     * 
     */
    public function testEncryptionDecryption() {
        $result = Cryptography::encryption('pass', 'My number is 10!', 'aes-256-gcm');
        $this->assertSame(Cryptography::decryption('pass', $result, 'aes-256-gcm'), 'My number is 10!');

        $result2 = Cryptography::encryption('pass', 'My number is 10!', 'chacha20-poly1305');
        $this->assertSame(Cryptography::decryption('pass', $result2, 'chacha20-poly1305'), 'My number is 10!');
    }

}
