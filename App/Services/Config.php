<?php
namespace App\Services;

class Config {
    public static $config;
    public static $sites;
    public static $resource;
    public static $routes;
    public static $seo;
    public static $redirects;
    private static $resourcePath = "Resource";

    public function setup() {
        self::$config = self::setConfig();
        self::$sites = self::setSites();

        self::$resource = self::setResource();
        self::$routes = self::setRoutes();
        self::$seo = self::setSeo();
        self::$redirects = self::setRedirections();
    }

    private function setConfig() {
        $configFilePath = ROOT.DIRECTORY_SEPARATOR.self::$resourcePath.DIRECTORY_SEPARATOR."config.json";
        if(!file_exists($configFilePath)) return false;
        $json = file_get_contents($configFilePath);
        return Tools::arrayToObject(json_decode($json, true));
    }

    public function getConfig() {
        return self::$config;
    }

    private function setResource() {
        $site = self::getCurrentSite();
        $path = $site->Files->Resource;
        if(!file_exists($path)) return false;
        $json = file_get_contents($path);
        return Tools::arrayToObject(json_decode($json, true));
    }

    public function getResource() {
        return self::$resource;
    }

    private function setRoutes() {
        $site = self::getCurrentSite();
        $path = $site->Files->Routes;
        if(!file_exists($path)) return false;
        $json = file_get_contents($path);
        return Tools::arrayToObject(json_decode($json, true));
    }

    public function getRoutes() {
        return self::$routes;
    }

    public function getRoutesWithPrefix($prefix) {
        $site = self::getSite($prefix);
        $path = $site->Files->Routes;
        if(!file_exists($path)) return false;
        $json = file_get_contents($path);
        return Tools::arrayToObject(json_decode($json, true));
    }

    private function setSeo() {
        $site = self::getCurrentSite();
        $path = $site->Files->Seo;
        if(!file_exists($path)) return false;
        $json = file_get_contents($path);
        return Tools::arrayToObject(json_decode($json, true));
    }

    public function getSeo() {
        return self::$seo;
    }

    private function setRedirections() {
        $path = ROOT.DIRECTORY_SEPARATOR.(self::$resourcePath).DIRECTORY_SEPARATOR."redirections.json";
        if(!file_exists($path)) return false;
        $json = file_get_contents($path);
        return Tools::arrayToObject(json_decode($json, true));
    }

    public static function getRedirections() {
        return self::$redirects;
    }

    private function setSites() {
        $sites = array();
        foreach((array)self::$config->Sites as $site) {
            $site = (object)$site;
            if($site->Active) {
                foreach($site->Files as $fileKey => $file) {
                    $site->Files->{$fileKey} = RESOURCE.$file;
                }
                array_push($sites, $site);
            }
        }
        return $sites;
    }

    public function getSites() {
        return self::$sites;
    }

    public static function getCurrentSite($prefix = "") {
        $retVal = array();
        $splittedUrl = self::splittedUrl();
        $lang = !empty($prefix) ? $prefix : $splittedUrl->lang;
        $sites = (array)self::getSites();
        foreach($sites as $site) {
            $site = (object)$site;
            if($site->Prefix == $lang) {
                $retVal = $site;
                break;
            }
        }

        if(count((array)$retVal) == 0) {
            $retVal = self::getDefaultSite();
        }
        return Tools::arrayToObject($retVal);
    }

    public function getDefaultSite() {
        $retVal = array();
        $sites = (array)self::getSites();
        foreach($sites as $site) {
            if($site->Default) {
                $retVal = $site;
                break;
            }
        }
        return $retVal;
    }

    public function getSite($prefix) {
        $retVal = array();
        $lang = $prefix;
        foreach((array)self::getSites() as $site) {
            $site = (object)$site;
            if($site->Prefix == $lang) {
                $retVal = $site;
                break;
            }
        }
        return $retVal;
    }

    public function getRequestUrl() {
        $url = $_SERVER['REQUEST_URI'];
        $domainPath = parse_url(DOMAIN);
        $requestUrl = rtrim($url, "/");
        $url = str_replace($domainPath, "", $requestUrl);
        return $url;
    }

    public function getRouteUrl($url = "") {
        $domainPath = parse_url(DOMAIN);
        $requestUrl = rtrim($url, "/");
        $url = str_replace($domainPath, "", $requestUrl);
        return $url;
    }

    public function getUrl() {
        return "/".implode("/", self::splittedUrl()->params);
    }

    public function splittedUrl() {
        $url = self::getRequestUrl();
        $explodedPars = array_values(array_filter(explode("/", $url)));
        $par = array(
            "lang" => null,
            "params" => array()
        );
        if(!empty($explodedPars[0])) {
            $hasLang = self::getLanguageIndex($explodedPars[0]);
            if($hasLang > -1) {
                $par["lang"] = $explodedPars[0];
                array_shift($explodedPars);
                $par["params"] = $explodedPars;
            }else {
                $par["params"] = $explodedPars;
            }
        }

        return (object)$par;
    }

    private function getLanguageIndex($lang = "") {
        $hasLang = -1;
        foreach((array)self::getSites() as $key => $site) {
            $site = (object)$site;
            if($site->Prefix == $lang) {
                $hasLang = $key;
                break;
            }
        }
        return is_int($hasLang) ? $hasLang : -1;
    }
}