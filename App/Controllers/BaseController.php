<?php
namespace App\Controllers;

use App\Helpers\DB;
use App\Helpers\Url;
use App\Helpers\View;
use App\Services\Config;
use App\Services\Tools;

class BaseController extends DB {
    protected $view;
    protected $configService;

    private $currentSite;
    private $noRobots;

    public function __construct() {
        $this->configService = new Config();

        $config = $this->configService->getConfig();
        $this->noRobots = false;
        if(!$config->Live) {
            $this->noRobots = true;
        } else {
            $this->currentSite = $this->configService->getCurrentSite();
            if(!$this->currentSite->Live) {
                $this->noRobots = true;
            }
        }

        if($this->noRobots) {
            header("X-Robots-Tag: noindex, nofollow", true);
        }
    }

    protected function View($model = []) {

        $action = debug_backtrace()[1]["function"];

        $controller = str_replace("Controller", "", get_called_class());
        $name = $controller."/".$action;
        $this->view = new View($name, $model);
        $content = $this->view->render();

        $body = $content->Content;

        $viewLayout = $content->Layout;

        if(!empty($viewLayout)) {
            include $viewLayout;

            if(isset($Layout)) {
                include $Layout;
            }
        } else {
            echo $body;
        }
    }

    protected function Content($par, $type="text/html") {
        header("Content-Type: $type; charset=UTF-8");
        print_r($par);
    }

    protected function RedirectToAction($action, $controller = "", $params = array(), $status = 302) {
        if(empty($controller)) {
            $f = debug_backtrace()[1];
            $controller = str_replace("Controller", "", $f["class"]);
        }
        $url = Url::Action($action, $controller, $params);
        Tools::redirect($url, $status);
    }

    public static function ErrorPage($redirect = true) {
        if(!Tools::isLocalhost()) {
            if($redirect) {
                $url = Url::Action("Index", "PageNotFound");
                Tools::redirect($url);
            }
        }
    }
}