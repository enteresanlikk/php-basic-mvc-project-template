<?php
namespace App\Services;

use App\Services\Config;
use App\Services\Route;

class Seo {
    private $routeService;
    private $configService;
    public function __construct() {
        $this->routeService = new Route();
        $this->configService = new Config();
    }

    public function getPageSeo() {
        $retVal = array();
        $url = trim($this->configService->getUrl(), "/");
        $seoList = $this->configService->getSeo();
        foreach($seoList as $seo) {
            if($seo->Path == $url) {
                $retVal = $seo;
            }
        }
        return $retVal;
    }
}