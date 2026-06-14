<?php

class CCAvenueCrypto
{
    public static function encrypt($plainText, $workingKey)
    {
        $key = pack('H*', md5($workingKey));

        $iv = pack('C*',
            0x00,0x01,0x02,0x03,
            0x04,0x05,0x06,0x07,
            0x08,0x09,0x0a,0x0b,
            0x0c,0x0d,0x0e,0x0f
        );

        $encrypted = openssl_encrypt(
            $plainText,
            'AES-128-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return bin2hex($encrypted);
    }

    public static function decrypt($encryptedText, $workingKey)
    {
        $key = pack('H*', md5($workingKey));

        $iv = pack('C*',
            0x00,0x01,0x02,0x03,
            0x04,0x05,0x06,0x07,
            0x08,0x09,0x0a,0x0b,
            0x0c,0x0d,0x0e,0x0f
        );

        return openssl_decrypt(
            hex2bin($encryptedText),
            'AES-128-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }
}