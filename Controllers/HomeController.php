<?php
use App\Controllers\BaseController;

class HomeController extends BaseController {

    public function Index() {
        $data = array("aa" => "controller data");
        $this->View($data);
    }

    public function Closed() {
        $this->RedirectToAction("Index", "Home");
    }

    public function Cont() {
        $this->Content(json_encode(array("aa"=>"dfsdkjf")), "application/json");
    }

    public function DbTest() {
        $db = $this->connect();
        $sql = $db->prepare("SELECT * FROM users");
        $sql->execute();

        $datas = $sql->fetchAll(PDO::FETCH_ASSOC);

        $this->Content(json_encode($datas), "application/json");
    }
}