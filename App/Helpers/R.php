<?php
namespace App\Helpers;

use App\Services\Config;

class R {
    public static function t($key) {
        $resources = (new Config())->getResource();

        $newKey = explode('.', $key);
        $text = $key;
        if (isset($resources->{$newKey[0]})) {
            $text = $resources->{$newKey[0]};
            for ($i=1; $i<count($newKey); $i++) {
                $val = $newKey[$i];
                if(!isset($text->{$val})) {
                    $text = $key;
                    break;
                }
                $text = $text->{$val};
            }
        }

        return $text;
    }
}