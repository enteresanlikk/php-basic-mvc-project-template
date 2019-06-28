<?php
use App\Controllers\BaseController;
use App\Models\SitemapItem;
use App\Helpers\Url;

class XMLController extends BaseController {
    public $sitemapItem;
    public function Sitemap() {
        $this->sitemapItem = new SitemapItem();

        $this->sitemapItem->add(Url::Action("Index", "Home"), 1, "Daily");
        $this->sitemapItem->add(Url::Action("Index", "About"), 0.95, "Daily");
        $this->sitemapItem->add(Url::Action("Index", "Blog"), 0.95, "Daily");

        $this->RenderSitemap($this->sitemapItem->getSitemaps());
    }

    public function RenderSitemap($list)
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>';
        $sitemap .= '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">';
            
        foreach($list as $val) {
            $sitemap .= "<url>
                            <loc>".$val->url."</loc>
                            <lastmod>".$val->lastmod."</lastmod>
                            <changefreq>".$val->changefreq."</changefreq>
                            <priority>".$val->priority."</priority>
                        </url>";
        }

        $sitemap .= '</urlset>';

        $this->Content($sitemap, "text/xml");
    }
}