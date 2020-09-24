<?php namespace App\Helpers;

class CaesarCipher
{

    public static function encrypt($text, $shift=3)
    {
        $result = '';

        for($i = 0; $i < strlen($text); $i++) {
            if (!ctype_digit($text[$i])) {
                if (ctype_upper($text[$i])) {
                    $result .= chr((ord($text[$i]) + $shift - 65) % 26 + 65);
                } else {
                    $result .= chr((ord($text[$i]) + $shift - 97) % 26 + 97);
                }
            } else {
                $result .= $text[$i];
            }
        }

        return $result;
    }

    public static function decrypt($text, $shift=3)
    {
        $result = '';

        for($i = 0; $i < strlen($text); $i++) {
            if (!ctype_digit($text[$i])) {
                if (ctype_upper($text[$i])) {
                    $result .= chr(((ord($text[$i]) - $shift) - (65 + 25)) % 26 + (65 + 25));
                } else {
                    $result .= chr(((ord($text[$i]) - $shift) - (97 + 25)) % 26 + (97 + 25));
                }
            } else {
                $result .= $text[$i];
            }
        }

        return $result;
    }

}