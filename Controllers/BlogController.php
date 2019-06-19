<?php
use App\Controllers\BaseController;

class BlogController extends BaseController {

    public $data = array(
        array(
            "id" => 1,
            "url" => "yazi-1",
            "title" => "title 1",
            "content" => "content 1"
        ),
        array(
            "id" => 2,
            "url" => "yazi-2",
            "title" => "title 2",
            "content" => "content 2"
        ),
        array(
            "id" => 3,
            "url" => "yazi-3",
            "title" => "title 3",
            "content" => "content 3"
        ),
        array(
            "id" => 4,
            "url" => "yazi-4",
            "title" => "title 4",
            "content" => "content 4"
        )
    );

    public function Index() {
        $this->View($this->data);
    }

    public function Detail($url) {
        $data = array();

        foreach ($this->data as $item) {
            if($url == $item["url"]) {
                $data = $item;
                break;
            }
        }

        if(count($data) == 0) {
            $this->RedirectToAction("Index", "PageNotFound");
            /*
             * OR
             *
             * $this->RedirectToAction("Index"); This controller to Index action.
             */
        }
        $this->View($data);
    }
}