<?php
    use App\Helpers\Html;
    use App\Helpers\Url;
    use App\Services\Tools;
    use App\Services\Config;

    $currentSite = Config::getCurrentSite();
?>

<!doctype html>
<html lang="<?= $currentSite->Culture ?>" xml:lang="<?= $currentSite->Culture ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
        Html::partial("_Seo");

        Tools::getCss(Url::Content("Content/css/plugins/bootstrap/bootstrap-reboot.min.css"));
        Tools::getCss(Url::Content("Content/css/plugins/bootstrap/bootstrap-grid.min.css"));
        Tools::getCss(Url::Content("Content/css/plugins/bootstrap/bootstrap.min.css"));

        Tools::getCss(Url::Content("Content/css/style.css"));
    ?>
</head>
<body class="<?= $currentSite->Prefix ?>">

    <?php

        Html::partial("_Header");

        echo $body;

        Html::partial("_Footer");

        Tools::getJavascript(Url::Content("Content/js/plugins/jquery-3.4.1.min.js"));
        Tools::getJavascript(Url::Content("Content/js/plugins/bootstrap.min.js"));
        Tools::getJavascript(Url::Content("Content/js/main.js"));

        Html::section("scripts");
    ?>

</body>
</html>