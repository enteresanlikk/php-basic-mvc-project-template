<?php
    use App\Helpers\R;
    use App\Helpers\Url;
?>

<div class="container">
    <h1><?= R::t("Home") ?></h1>
    <small><?= $this->Model->aa ?></small>
</div>

<?php function scripts() { ?>
    <script src="<?= Url::Content("Content/js/pages/home.js") ?>"></script>
<?php } ?>