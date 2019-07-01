<?php
    use App\Services\Config;
    use App\Services\Route;
    use App\Helpers\Html;
    use App\Helpers\R;

    $configService = new Config();
    $routeService = new Route();
    $sites = Config::getSites();
    $currentSite = Config::getCurrentSite();
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php Html::menuItem(R::t("Home"),"Index", "Home" ,array(), "nav-link", false) ?>
                </li>
                <li class="nav-item">
                    <?php Html::menuItem(R::t("About"),"Index", "About" ,array(), "nav-link") ?>
                </li>
                <li class="nav-item">
                    <?php Html::menuItem(R::t("Blog"),"Index", "Blog", array(), "nav-link test-class") ?>
                </li>
            </ul>

            <?php
            if(count((array)$sites) > 1) {
                echo "<ul  class=\"navbar-nav  ml-auto\">";
                foreach($sites as $site) {
                    if($site->Prefix == $currentSite->Prefix) continue;
                    ?>
                    <li class="nav-item">
                        <a href="<?= $routeService->getAlternateUrl($site->Prefix, true) ?>" class="nav-link"><?= $site->Prefix ? strtoupper($site->Prefix) : "TR" ?></a>
                    </li>
                    <?php
                }
                echo "</ul>";
            }
            ?>
        </div>
    </nav>
</header>