<?php
use App\Controllers\BaseController;

class PageNotFoundController extends BaseController {
    public function Index() {
        http_response_code(404);
        $this->View();
    }
}