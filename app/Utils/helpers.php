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

        $finalStr = 'TXN'.$randomNum.strtoupper($randStr);
        return $finalStr;
    }
}

if (!function_exists('scrub')){
    function scrub($message){
        $scrubbed = $message == "undefined" ? null : $message;
        return $scrubbed;                                 
    }
}

if (!function_exists('name_explode')){
    function name_explode($name){
        $newArr = explode(' ', $name);
        $shortArr = array();
        
        if (count($newArr) >= 3){
            $first_name = array_shift($newArr);
            $last_name = implode(' ', $newArr);
            array_push($shortArr, $first_name, $last_name);
            return $shortArr;
        }
        return $newArr;
    }
}