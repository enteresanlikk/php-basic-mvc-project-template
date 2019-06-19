<?php
namespace App\Helpers;

use App\Services\Config;

class R {
    public static function t($key) {
        $resources = (new Config())->getResource();
        foreach($resources as $a => $val) {
            if($a == $key) {
                return $val;
            }
        }
        return $key;
    }
}