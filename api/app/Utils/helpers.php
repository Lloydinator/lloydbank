<?php

if (!function_exists('generateRandomString')){
    function generateRandomString($length){
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        $charLength = strlen($chars);
        $randStr = '';
        $finalStr = '';
        $i = 0;
        $randomNum = mt_rand(10,99);

        while ($i < $length) {
            $randStr .= $chars[mt_rand(0, $charLength - 1)];
            $i++;
        }

        $finalStr = 'F'.$randomNum.strtoupper($randStr);
        return $finalStr;
    }
}

if (!function_exists('scrub')){
    function scrub($message){
        $scrubbed = $message == "undefined" ? null : $message;
        return $scrubbed;                                 
    }
}
