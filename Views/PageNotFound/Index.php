<?php
    use App\Helpers\R;
    use App\Helpers\Url;

    $Layout = "";
?>

<div class="container">
    <h1><?= R::t("PageNotFound") ?></h1>

    <a href="<?= Url::Action("Index","Home") ?>"><?= R::t("Home") ?></a>
</div>