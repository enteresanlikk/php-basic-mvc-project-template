<?php
    use App\Helpers\R;
    use App\Helpers\Url;
use App\Services\Tools;

?>

<div class="container">
    <h1><?= R::t("Home") ?></h1>
    <small><?= $this->Model->aa ?></small>
</div>

<?php function scripts() {
    Tools::getJavascript(Url::Content("Content/js/pages/home.js"));
 } ?>