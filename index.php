<?php
    require "App/Variables.php";

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    use App\Core\Application;
    use App\Services\Config;
    use App\Services\Redirection;

    /*

    spl_autoload_register(function($class) {
        $prefix = 'App\\';

        $length = strlen($prefix);

        $base_directory = __DIR__ . '/App/';

        if(strncmp($prefix, $class, $length) !== 0) {
            return;
        }

        $class_end = substr($class, $length);

        $file = $base_directory . str_replace('\\', '/', $class_end) . '.php';

        if(file_exists($file)) {
            include $file;
        }
    });

    */

    function __autoload($classname) {
        $file = $classname.".php";
        if(file_exists($file)) {
            include $file;
        }
    }

    if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip')){
		ob_start("ob_gzhandler");
	}else{
		ob_start();
	}

    $conf = new Config();
    $conf->setup();

    $redir = new Redirection();
    $redir->start();

    $app = new Application();