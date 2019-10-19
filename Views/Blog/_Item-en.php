<?php
    use App\Helpers\Url;
?>

<div class="col-lg-4 col-sm-4 p-3 text-center">
    <a href="<?= Url::Action("Detail", "Blog", array("url" => self::$Model->url)) ?>">
        <h3><?= self::$Model->title ?></h3>
        <h3><?= self::$Model->content ?></h3>
        <small>en view</small>
    </a>
</div>