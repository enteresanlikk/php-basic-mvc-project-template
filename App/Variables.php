<?php

function getDomain() {
    $domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $domain .= dirname($_SERVER['PHP_SELF']);
    $domain = rtrim($domain, "/");

    return $domain;
}

define("ROOT", getcwd().DIRECTORY_SEPARATOR);

define("APP", ROOT."App".DIRECTORY_SEPARATOR);
define("CORE", ROOT."App".DIRECTORY_SEPARATOR."Core".DIRECTORY_SEPARATOR);
define("HELPERS", ROOT."App".DIRECTORY_SEPARATOR."Helpers".DIRECTORY_SEPARATOR);
define("SERVICES", ROOT."App".DIRECTORY_SEPARATOR."Services".DIRECTORY_SEPARATOR);
define("APP_CONTROLLERS", ROOT."App".DIRECTORY_SEPARATOR."Controllers".DIRECTORY_SEPARATOR);

define("VIEWS", ROOT."Views".DIRECTORY_SEPARATOR);
define("CONTROLLER", ROOT."Controllers".DIRECTORY_SEPARATOR);

define("RESOURCE", ROOT."Resource".DIRECTORY_SEPARATOR);

define("MODELS", APP."Models".DIRECTORY_SEPARATOR);

define("DOMAIN", getDomain());

$paths = array(
    get_include_path(),
    APP,
    CORE,
    HELPERS,
    SERVICES,
    APP_CONTROLLERS,
    MODELS
);

set_include_path(implode(PATH_SEPARATOR, $paths));