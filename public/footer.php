<?php
include_once("../src/environment.php");
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer__inner">
                    <div class="footer__nav">
                        <span>Pagina's</span>
                        <ul>
                            <?php
                            $HeaderStockGroups = getHeaderStockGroups($databaseConnection);
                            foreach ($HeaderStockGroups as $HeaderStockGroup): ?>
                            <li>
                                <a href="browse.php?category_id=<?= $HeaderStockGroup['StockGroupID']; ?>"
                                   class="HrefDecoration"><?= $HeaderStockGroup['StockGroupName']; ?></a>
                            </li>
                            <?php endforeach; ?>
                            <li>
                                <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer__brand" style="float: top; height: 200px; position: relative;">
                        <a href="./" class="header__logo" id="LogoA">
                            NG
                        </a>
                    </div>
                </div>
                <div class="footer__bottom">
                    <div class="footer__cookies">
                        <ul style="float: bottom; position: relative;">
                            <a href="cookies.php">Cookies </a>
                            <a href="privacy.php"> Privacy policy </a>
                            <a href="tos.php"> Algemene Voorwaarden </a>
                            <a href="newsletter.php"> Nieuwsbrief </a>
                            <a href="contact.php"> Contact</a>
                        </ul>
                        <div><a href="/">©Nerdygadgets 2023 - <?=getEnvironmentVariable("WEB_SERVER_NAME")?> - <?=getDatabaseHostname($databaseConnection) ?></a></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
