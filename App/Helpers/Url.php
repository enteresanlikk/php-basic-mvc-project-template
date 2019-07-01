<?php
namespace App\Helpers;

use App\Services\Config;

class Url {
    public static function Action($action, $controller, $params = array()) {
        $retVal = "";
        $domain = DOMAIN.(!empty($prefix) ? "/".$prefix."/" : "/");
        $isPath = false;

        $configService = new Config();
        $currentSite = $configService->getCurrentSite();
        $prefix = $currentSite->Prefix;
        $routes = $configService->getRoutes();
        foreach((array)$routes as $route) {
            $route = (object)$route;
            if($action == $route->Action && $controller == $route->Controller) {
                $url = $route->Url;

                $retVal .= self::convertUrlWithUrl($configService->getRouteUrl($url), $params);
                $isPath = true;
            }
        }

        $retVal = rtrim($retVal, "/");
        if(empty($retVal) && !$isPath) {
            $retVal = mb_strtolower($controller)."/".mb_strtolower($action);
        }

        return rtrim($domain.$retVal, "/");
    }

    public static function convertUrlWithUrl($url, $pars) {
        $retVal = $url;
        foreach ($pars as $key => $par) {
            $retVal = preg_replace("/{($key)}/i", $par, $retVal);
        }
        return $retVal;
    }

    public static function Content($path) {
        return DOMAIN."/".$path;
    }
}