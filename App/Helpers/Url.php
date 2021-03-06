<?php
namespace App\Helpers;

use App\Services\Config;

class Url {
    public static function Action($action, $controller, $params = array()) {
        $retVal = "";

        $configService = new Config();
        $currentSite = $configService->getCurrentSite();
        $prefix = isset($params["lang"]) ? $params["lang"] : $currentSite->Prefix;

        $isPath = false;

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
            $retVal = $controller."/".$action;
        }
        $retVal = rtrim((!empty($prefix) ? "/".$prefix."/" : "/").$retVal, "/");

        return !empty($retVal) ? DOMAIN . $retVal : DOMAIN;
    }

    public static function convertUrlWithUrl($url, $pars) {
        $retVal = $url;
        foreach ($pars as $key => $par) {
            $retVal = preg_replace("/{($key)}/i", $par, $retVal);
        }
        return $retVal;
    }

    public static function Content($path) {
        return rtrim(DOMAIN."/".$path, "/");
    }
}