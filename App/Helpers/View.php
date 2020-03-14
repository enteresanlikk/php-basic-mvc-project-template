<?php
namespace App\Helpers;

use App\Services\Config;
use App\Services\Tools;

class View {
    protected $view_file;
    protected $Model;

    private $configService;
    private $currentSite;

    public function __construct($view_file, $model) {
        $this->view_file = $view_file;
        $this->Model = Tools::arrayToObject($model);

        $this->configService = new Config();
        $this->currentSite = $this->configService->getCurrentSite();
    }

    private function page($path, $params) {
        extract((array)$params);
        ob_start();
        include $path;
        $content = ob_get_clean();

        $retVal = array(
            "Layout" => isset($Layout) ? (empty($Layout) ? "" : $Layout) : VIEWS."_ViewStart.php",
            "Title" => isset($title) && !empty($title) ? $title : "",
            "Content" => $content
        );
        return (object)$retVal;
    }

    public function render(){
        $prefix = !empty($this->currentSite->Prefix) ? "-".$this->currentSite->Prefix : "";
        $viewPath = VIEWS.$this->view_file.$prefix.".php";
        if(!file_exists($viewPath)) {
            $viewPath = VIEWS.$this->view_file.".php";
        }
        if(file_exists($viewPath)) {
            $page = $this->page($viewPath, $this->Model);

            ob_start();
            ob_get_clean();

            return $page;
        }
    }
}