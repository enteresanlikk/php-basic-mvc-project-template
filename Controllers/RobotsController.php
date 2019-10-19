<?php
use App\Controllers\BaseController;
use App\Services\Config;
use App\Helpers\Url;

class RobotsController extends BaseController {
    private $robotsTxt = [];
    public function Index() {
        $configService = new Config();
        $sites = $configService->getSites();

        array_push($this->robotsTxt, "User-agent: *");
        array_push($this->robotsTxt, "");
        if(count((array)$sites) > 1) {
            foreach($sites as $site) {
                array_push($this->robotsTxt, "Sitemap: ".Url::Action("Sitemap", "XML", ["lang" => $site->Prefix]));
            }
        }

        $this->Content(implode("\n", $this->robotsTxt), "text/plain");
    }
}