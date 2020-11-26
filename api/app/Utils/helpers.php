<?php

if (!function_exists('generateRandomString')){
    function generateRandomString($length = 0){
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        $charLength = strlen($chars);
        $randStr = '';
        $i = 0;

        while ($i < $length) {
            $randStr .= $chars[mt_rand(0, $charLength - 1)];
            $i++;
        }

        return $randStr;
    }
}

if (!function_exists('finalCheck')){
    function finalCheck($from, $to){
        if ($from == $to){
            return false;
        }
        return true;
    }
}

if (!function_exists('scrub')){
    function scrub($message){
        $scrubbed = $message == "undefined" ? null : $message;
        return $scrubbed;                                 
    }
}
