<?php
namespace App\Helpers;

use App\Services\Config;

class Url {
    public static function Action($action, $controller, $params = array()) {
        $retVal = "";

        $configService = new Config();
        $currentSite = $configService->getCurrentSite();
        $prefix = $currentSite->Prefix;
        $routes = $configService->getRoutes();
        foreach((array)$routes as $route) {
            $route = (object)$route;
            if($action == $route->Action && $controller == $route->Controller) {
                $url = $route->Url;

                $retVal = DOMAIN.(!empty($prefix) ? "/".$prefix."/" : "/");
                $retVal .= self::convertUrlWithUrl($configService->getRouteUrl($url), $params);
            }
        }

        return rtrim($retVal, "/");
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