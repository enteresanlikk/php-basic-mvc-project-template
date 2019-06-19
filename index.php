<?php
    require "App/Variables.php";

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