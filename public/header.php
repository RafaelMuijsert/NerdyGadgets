<?php
    setlocale(LC_TIME, 'nl_NL');
    session_start();
    include "database.php";
    $databaseConnection = connectToDatabase();
    $submitted = false;
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $cartUpdate = updateShoppingCart($databaseConnection);
    $itemsInCart = count($_SESSION['cart']);
    $itemsInCart = ($itemsInCart == 0) ? '' : "+$itemsInCart";
?>
<header class="header">
    <?php if(cartUpdateRequested()): ?>
        <div>
            <?php if($cartUpdate): ?>
                <div class="alert alert-success" role="alert">
                    Item is toegevoegd aan het winkelmandje
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Er zijn geen producten meer op voorraad. Probeer het later nog eens
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
    <div class="container">
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

<!--                        <form action="browse.php">-->
<!--                            <input class="form-control" type="text" placeholder="Style mij nog even!" name="search_string" id="search_string" value="" class="form-submit">-->
<!--                        </form>-->

                        <div class="header__icons">
                            <a href="/browse.php" class="search-icon btn btn--primary">
                                <img class="icon" src="./img/icons/search.svg" alt="">
                            </a>

                            <a href="./login.php" class="profile-icon btn btn--primary">
                                <img class="icon" src="./img/icons/profile.svg" alt="">
                            </a>

                            <a href="cart.php" class="cart-icon btn btn--primary">
                                    <div class="cart-icon--count" id="cart-icon--count"><?=$itemsInCart?></div>
                                <img class="icon" src="./img/icons/cart.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>




