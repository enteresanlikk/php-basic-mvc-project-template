<?php
namespace App\Services;

class Tools {
    public static function getCss($path, $id = "") {
        try {
            $id=!empty($id) ? "id=\"$id\"" : "";
            $css=file_get_contents($path);
            echo '<style'.(!empty($id) ? ' '.$id : '').'>';
            echo $css;
            echo '</style>';
        } catch (\Exception $e) {

        }
    }

    public static function getJavascript($path, $id="", $isAsync=false) {
        try {
            $id=!empty($id) ? "id=\"$id\"" : "";
            $js=file_get_contents($path);
            $isAsync=$isAsync?"async":"";
            echo '<script'.(!empty($id) && $isAsync ? ' '.$id.' '.$isAsync : (!empty($id) ? ' '.$id : ($isAsync ? ' '.$isAsync : ''))).'>';
            echo $js;
            echo '</script>';
        } catch (\Exception $e) {

        }
    }

    public static function realPath($path) {
        return ROOT.$path;
    }

    public static function hasParamUrl($url) {
        $parPattern = "/{(.*?)}/i";
        return preg_match($parPattern, $url);
    }

    public static function redirect($url, $status = 302) {
        header("Location: ".$url, true, $status);
        exit();
    }

    public static function arrayToObject($data) {
        try {
            $obj = new \stdClass;
            foreach($data as $k => $v) {
                if(strlen($k)) {
                    if(is_array($v)) {
                        $obj->{$k} = self::arrayToObject($v);
                    } else {
                        $obj->{$k} = $v;
                    }
                }
            }
            return $obj;
        } catch (\Exception $e) {
            //print_r($e);
        }
    }

    public static function objectToArray($data) {
        $retVal = json_decode(json_encode($data), true);
        return $retVal;
    }

    public static function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function urlValid($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function isLocalhost() {
        $whitelist = array(
            '127.0.0.1',
            "::1",
            "localhost"
        );

        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return true;
        }
        return false;
    }
}