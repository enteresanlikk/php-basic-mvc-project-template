<?php
    use App\Services\Seo;
    use App\Services\Config;
    use App\Services\Route;
    use App\Helpers\Html;

    $model = self::$Model;

    $seoService = new Seo();
    $configService = new Config();
    $routeService = new Route();

    $requestUrl = DOMAIN.$configService->getRequestUrl();
    $currentSite = Config::getCurrentSite();
    $config = $configService->getConfig();
    $seo = $seoService->getPageSeo();

    $defaultTitle = "Test Project";
    $title = isset($seo->Title) ? $seo->Title : $defaultTitle;
    if(isset($model->title) && !empty($model->title)) {
        $title = $model->title;
    }

    $keywords = isset($seo->Keywords) ? $seo->Keywords : "";
    $description = isset($seo->Description) ? $seo->Description : "";
    $canonical = isset($seo->CanonicalUrl) ? $seo->CanonicalUrl : "";
    $customEntry = isset($seo->CustomEntry) ? $seo->CustomEntry : "";
?>

    <title><?= $title ?></title>

<?php if (!empty($keywords)): ?>
    <meta name="keywords" content="<?= $keywords ?>" />
<?php endif; ?>

<?php if (!empty($description)): ?>
    <meta name="description" content="<?= $description ?>" />
<?php endif; ?>

<?php
    foreach($configService->getSites() as $key => $site) {
        ?>
        <link rel="alternate" href="<?= $routeService->getAlternateUrl($site->Prefix, true) ?>" hreflang="<?= $site->Culture ?>" />
        <?php
    }
?>

<?php if (!empty($canonical)): ?>
    <meta name="canonical" content="<?= $canonical ?>" />
<?php else: ?>
    <meta name="canonical" content="<?= $requestUrl ?>" />
<?php endif; ?>

<?php if (!empty($customEntry)):
     echo $customEntry;
endif; ?>

<?php
    Html::section("meta");
    if(!$currentSite->Live || !$config->Live) {
?>
        <meta name="robots" content="nofollow, noindex" />
<?php
    }
?>