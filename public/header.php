<?php
    setlocale(LC_TIME, 'nl_NL');

    include "../src/database.php";
    $databaseConnection = connectToDatabase(false);
    $databaseConnectionWriteAccess = connectToDatabase(true);
    $submitted = false;
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $cartUpdate = updateShoppingCart($databaseConnectionWriteAccess);
    $itemsInCart = count($_SESSION['cart']);
    $itemsInCart = ($itemsInCart == 0) ? '' : "+$itemsInCart";
?>
<header class="header">
    <div class="container">
        <?php if(cartUpdateRequested()): ?>
            <div>
                <?php if($cartUpdate): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        Product is succesvol toegevoegd aan het winkelmandje.
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php if (intval($_POST['itemQuantity']) == 0): ?>
                        Voer een geldig getal in
                        <?php else: ?>
                        Er zijn helaas geen <?=$_POST['itemQuantity']?> producten meer op voorraad. Probeer het later nog eens
                        <?php endif; ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>
        <div class="row">
            <div class="col-12">
                <div class="header__inner">

                    <a href="./" class="header__logo" id="LogoA">
                        NG
                    </a>

                    <div class="header__navigation">
                        <ul class="header__menu">
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

                        <div class="header__icons">
                            <a href="/browse.php" class="search-icon btn btn--primary">
                                <img class="icon" src="./img/icons/search.svg" alt="">
                            </a>

                            <?php
                                if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
                                    $url = './account.php';
                                else:
                                    $url = './login.php';
                                endif;
                            ?>
                            <a href="<?= $url ?>" class="profile-icon btn btn--primary">
                                <img class="icon" src="./img/icons/profile.svg" alt="">
                            </a>

                            <a href="cart.php" class="cart-icon btn btn--primary">
                                <?php if($itemsInCart > 0): ?>
                                <div class="mr-2 cart-icon--count" id="cart-icon--count"><?=$itemsInCart?></div>
                                <?php endif?>
                                <img class="icon" src="./img/icons/cart.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>