<?php

namespace helpers;

class RandomData_Helper
{
    function jumbleText($text)
    {
        $toArr = str_split($text);
        shuffle($toArr);
        return strtoupper(implode("", $toArr));
    }
    /**
     * @return string returns a string of randomized combined letters and numbers, the default length is 12
     */
    function generateRandomCode($length = 12)
    {
        $code = '';
        $total = 0;

        do {
            if (rand(0, 1) == 0) {
                $code .= chr(mt_rand(97, 122)); // ASCII code from **a(97)** to **z(122)**
            } else {
                $code .= mt_rand(0, 9); // Numbers!!
            }
            $total++;
        } while ($total < $length);

        return $code;
    }
    /**
     * @return string returns a random string of letters, the default length is 6
     */
    function generateRandomString($length = 6){
        $code = '';
        $total = 0;

        do {
            $code .= chr(mt_rand(97, 122)); // ASCII code from **a(97)** to **z(122)**
            $total++;
        } while ($total < $length);

        return $code;
    }
    /**
     * @return string returns a random string of numbers, the default length is 6
     */
    function generateRandomNumbers($length = 6)
    {
        $code = '';
        $total = 0;

        do {
            $code .= mt_rand(0, 9); // Numbers!!
            $total++;
        } while ($total < $length);

        return $code;
    }
}
