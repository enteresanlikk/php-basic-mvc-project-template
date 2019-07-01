<?php
    require "App/Variables.php";

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    use App\Core\Application;
    use App\Services\Config;
    use App\Services\Redirection;

    function __autoload($classname) {
        $file = $classname.".php";
        if(file_exists($file)) {
            include $file;
        }
    }

    $conf = new Config();
    $conf->setup();

    $redir = new Redirection();
    $redir->start();

    $app = new Application();