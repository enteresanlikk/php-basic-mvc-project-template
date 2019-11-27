<?php
use App\Controllers\BaseController;
use App\Models\BlogRepository;

class BlogController extends BaseController {

    public function Index() {
        $this->View(BlogRepository::GetAll());
    }

    public function Detail($url) {
        $entry = BlogRepository::Get($url);

        if(count((array)$entry) == 0) {
            $this->RedirectToAction("Index", "PageNotFound");
            /*
             * OR
             *
             * $this->RedirectToAction("Index"); This controller to Index action.
             */
        }
        $this->View($entry);
    }
}