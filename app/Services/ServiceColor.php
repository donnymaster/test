<?php

namespace App\Services;

class ServiceColor{

    public static function color($str)
    {
        $hash = 0;

        for($i = 0; $i < strlen($str); $i++)
        {
            $hash = self::utf8_char_code_at($str, $i) + (($hash << 3) - $hash);
        }

        $colour = '#';

        for($j = 0; $j < 3; $j++)
        {
            $value = ($hash >> ($j * 8)) & 0xFF;
            $foo = substr(strval(('10' . dechex($value))), -2);
            $colour .= $foo;
        }

        return $colour;

    }

    private static function utf8_char_code_at($str, $index)
    {
        $char = '';
        $str_index = 0;

        $str = self::utf8_scrub($str);
        $len = strlen($str);

        for ($i = 0; $i < $len; $i += 1) {

            $char .= $str[$i];

            if (self::utf8_check_encoding($char)) {

                if ($str_index === $index) {
                    return self::utf8_ord($char);
                }

                $char = '';
                $str_index += 1;
            }
        }

        return null;
    }

    private static function utf8_scrub($str)
    {
        return htmlspecialchars_decode(htmlspecialchars($str, ENT_SUBSTITUTE, 'UTF-8'));
    }

    private static function utf8_check_encoding($str)
    {
        return $str === self::utf8_scrub($str);
    }

    private static function utf8_ord($char)
    {
        $lead = ord($char[0]);

        if ($lead < 0x80) {
            return $lead;
        } else if ($lead < 0xE0) {
            return (($lead & 0x1F) << 6)
        | (ord($char[1]) & 0x3F);
        } else if ($lead < 0xF0) {
            return (($lead &  0xF) << 12)
        | ((ord($char[1]) & 0x3F) <<  6)
        |  (ord($char[2]) & 0x3F);
        } else {
            return (($lead &  0x7) << 18)
        | ((ord($char[1]) & 0x3F) << 12)
        | ((ord($char[2]) & 0x3F) <<  6)
        |  (ord($char[3]) & 0x3F);
        }
    }
}
