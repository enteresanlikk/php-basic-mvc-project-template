<?php

namespace App\Services;

use App\Controllers\BaseController;

class Redirection {
    private $configService;
    private $redirections;
    private $config;

    public function __construct() {
        $this->configService = new Config();
        $this->redirections = $this->configService->getRedirections();
        $this->config = $this->configService->getConfig();
    }

    public function start() {
        $reqUrl = $this->configService->getRequestUrl();
        if(!Tools::isLocalhost() && $this->config->Live) {
            $currentUrl = DOMAIN.$reqUrl;
            $redirectUrl = $this->GetSslAndWwwRedirection();

            if($currentUrl != $redirectUrl) {
                Tools::redirect($redirectUrl);
            }
        }

        foreach ($this->redirections as $redirection) {
            if($reqUrl == $redirection->from) {
                if(Tools::urlValid($redirection->to)) {
                    Tools::redirect($redirection->to, 301);
                } else {
                    $url = DOMAIN."/".trim($redirection->to, "/");
                    Tools::redirect($url, 301);
                }
            }
        }
    }

    public function GetSslAndWwwRedirection() {
        $parsedDomain = parse_url(DOMAIN);

        if($this->config->WWWRedirection && !Tools::startsWith($parsedDomain["host"], "www")) {
            $parsedDomain["host"] = "www.".$parsedDomain["host"];
        }

        if($this->config->SSLRedirection && $parsedDomain["scheme"] != "https") {
            $parsedDomain["scheme"] = "https";
        }
        $domain = $this->unparse_url($parsedDomain);
        return $domain;
    }

    private function unparse_url($parsed_url) {
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}