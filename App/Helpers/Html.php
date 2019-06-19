<?php
namespace App\Helpers;

use App\Services\Config;
use App\Services\Tools;

class Html {
    protected static $Model;

    public static function partial($path, $pars = array()) {
        $currentSite = Config::getCurrentSite();
        $prefix = !empty($currentSite->Prefix) ? "-".$currentSite->Prefix : "";

        $data = debug_backtrace();
        $folder = dirname($data[0]["file"]);
        $file =  $folder.DIRECTORY_SEPARATOR.$path.$prefix.".php";

        $includePath = $file;

        if(!file_exists($includePath)) {

            $includePath = VIEWS."Shared".DIRECTORY_SEPARATOR.$path.$prefix.".php";
            if(!file_exists($includePath)) {

                $includePath =  $folder.DIRECTORY_SEPARATOR.$path.".php";
                if(!file_exists($includePath)) {

                    $includePath = VIEWS."Shared".DIRECTORY_SEPARATOR.$path.".php";
                    if(!file_exists($includePath)) {

                        $includePath = VIEWS.$path;
                        if(!file_exists($includePath)) {
                            return false;
                        }
                    }
                }
            }
        }

        self::$Model = Tools::arrayToObject($pars);
        include $includePath;
    }

    public static function section($func, $pars = array()) {
        if(function_exists($func)) {
            call_user_func_array($func, $pars);
        }
    }

    public static function menuItem($text, $action, $controller, $params = array(), $class="", $active = true) {
        $configService = new Config();
        $currentSite = Config::getCurrentSite();

        $requestUrl = trim($configService->getUrl(), "/");

        $url = Url::Action($action, $controller, $params);
        $tempUrl = trim(str_replace(DOMAIN.(!empty($currentSite->Prefix) ? "/".$currentSite->Prefix : ""), "", $url), "/");

        if($active && Tools::startsWith($requestUrl, $tempUrl)) {
            $class .= " active";
        }

        $class = trim($class);

        echo "<a href=\"$url\" title=\"".strip_tags($text)." ".(!empty($class) ? "\"class=\"$class\"\"" : "").">$text</a>";
    }
}