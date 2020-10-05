<?php

if (!function_exists('genRandStr')){
    function genRandStr($length = 0){
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