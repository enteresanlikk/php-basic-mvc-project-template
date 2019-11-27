<?php
namespace App\Services;

use App\Helpers\Url;

class Route {
    private $parPattern = "/{(.*?)}/i";
    private $configService;

    public function __construct() {
        $this->configService = new Config();
    }

    public function getActiveRoute($returnPars = false) {
        $retVal = new \stdClass();
        $url = trim($this->configService->getUrl(), "/");

        $queryStr = explode("?", $url);

        if(!empty($queryStr[0])) {
            $url = $queryStr[0];
        }

        $requestUrls = explode("/", $url);

        $routes = $this->configService->getRoutes();
        $arrayRoutes = (array)$routes;

        //#region static route
        foreach ($arrayRoutes as $route) {
            if($route->Url == $url) {
                $retVal = $route;
                break;
            }
        }
        //#endregion

        //#region dynamic route
        if(!isset($retVal->Url)) {
            foreach($arrayRoutes as $route) {
                $route = (object)$route;

                $routeUrls = explode("/", $route->Url);

                if(count($requestUrls) == count($routeUrls)) {
                    foreach ($routeUrls as $i => $routeUrl) {
                        if($routeUrl == $requestUrls[$i] || preg_match($this->parPattern, $routeUrl)) {
                            $retVal = $route;
                            break;
                        } else if($routeUrl != $requestUrls[$i] && !preg_match($this->parPattern, $routeUrl)) {
                            $retVal = new \stdClass();
                            break;
                        }
                    }
                }

                if(isset($retVal->Url)) {
                    break;
                }
            }
        }
        //#endregion

        $pars = array();
        if(isset($retVal->Url)) {
            $splittedPars = explode("/", $retVal->Url);
            foreach ($splittedPars as $i => $par) {
                if(preg_match($this->parPattern, $par)) {
                    array_push($pars, $requestUrls[$i]);
                }
            }
        }

        if($returnPars) {
            return (object)array(
                "Route" => $retVal,
                "Parameters" => $pars
            );
        }

        return $retVal;
    }

    public function getAlternateUrl($prefix, $domain = false) {
        $routeUrl = $this->configService->getRouteUrl();

        $retVal = $routeUrl;
        $active = $this->getActiveRoute();

        foreach($this->configService->getSites() as $key => $site) {
            if($site->Prefix == $prefix) {
                foreach($this->configService->getRoutesWithPrefix($site->Prefix) as $route) {
                    if(count((array)$active) > 0 && $active->Action == $route->Action && $active->Controller == $route->Controller) {
                        $alternateUrl = $this->configService->getRouteUrl($route->Url);
                        if(Tools::hasParamUrl($alternateUrl)) {
                            $retVal = $routeUrl;
                            break;
                        }
                        $retVal = Url::convertUrlWithUrl($alternateUrl, []);
                    }
                }
            }
        }
        return rtrim(($domain ? DOMAIN : "").((!empty($prefix) ? "/".$prefix."/" : "/").$retVal), "/");
    }
}