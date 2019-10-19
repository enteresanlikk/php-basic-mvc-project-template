<?php
namespace Models;
use App\Services\Tools;

class SitemapItem {
    public $sitemapList = array();
    public function add($url, $priority, $changeFreq) {
        array_push($this->sitemapList, array("url" => rtrim($url, "/"), "priority" => $priority, "lastmod" => Date("Y-m-d"), "changefreq" => $changeFreq ));
    }

    public function getSitemaps() {
        return Tools::arrayToObject($this->sitemapList);
    }
}