<?php
    use App\Helpers\R;
    use App\Helpers\Url;
?>

<div class="container">
    <h1><?= R::t("About") ?></h1>
    <a href="<?= Url::Action("test", "Home") ?>">no controller and action</a>
</div>