<?php
namespace App\Core;

use App\Controllers\BaseController;
use App\Helpers\Url;
use App\Services\Config;
use App\Services\Route;
use App\Services\Tools;

class Application {
    protected $controller;
    protected $action;

    protected $parameters = array();

    private $routeService;
    private $configService;

    public function __construct() {
        $currentSite = Config::getCurrentSite();
        $this->configService = new Config();
        $splittedUrl = $this->configService->splittedUrl();

        //Prefix control
        if(empty($splittedUrl->lang) && !empty($currentSite->Prefix)) {
            Tools::redirect($currentSite->Prefix);
        }

        $this->routeService = new Route();

        $r = $this->routeService->getActiveRoute(true);
        if(isset($r) && isset($r->Route) && isset($r->Route->Controller) && isset($r->Route->Action)) {
            $this->controller = $r->Route->Controller."Controller";
            $this->action = $r->Route->Action;
            $this->parameters = $r->Parameters;
        } else {
            $reqUrl = $splittedUrl->params;
            if(count($reqUrl) == 2) {
                $this->controller = $reqUrl[0]."Controller";
                $this->action = $reqUrl[1];
            } else if(count($reqUrl) == 1) {
                $this->controller = $reqUrl[0]."Controller";
                $this->action = "Index";
            } else {
                BaseController::ErrorPage();
            }
        }

        $controllerPath = CONTROLLER.$this->controller.".php";
        if(file_exists($controllerPath)) {
            require_once $controllerPath;
            $this->controller = new $this->controller;
            if(method_exists($this->controller, $this->action)) {
                call_user_func_array([$this->controller, $this->action], $this->parameters);
            } else {
                BaseController::ErrorPage();
                //echo $this->action." action not found!";
            }
        } else {
            BaseController::ErrorPage();
            //echo $this->controller." controller not found!";
        }
    }
}