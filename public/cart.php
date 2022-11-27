<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Winkelwagen - NerdyGadgets</title>

        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/resizer.js"></script>

        <!-- Style sheets-->
        <link rel="stylesheet" href="css/main.css" type="text/css">
    </head>
    <body>

        <?php include "header.php"; ?>

        <?php
        $total = 0;

        foreach($_POST as $key => $value) {
            $value = abs($value);
            $stock = getItemStock($key, $databaseConnection)['QuantityOnHand'];
            $value = ($value <= $stock) ? $value : $stock;
            $_SESSION['cart'][$key] = abs($value);
        }

        if(array_key_exists('remove', $_GET)) {
            unset($_SESSION['cart'][$_GET['remove']]);
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        } ?>

        <section class="shopping-cart">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="shopping-cart__cart">
                            <h1>Winkelmandje</h1>

                            <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                                <?php //Haal item op
                                $stockItem = getStockItem($key, $databaseConnection);

                                if (!$stockItem) {
                                    continue;
                                } ?>
                                <div class="card">
                                    <div class="card__img">
                                        <?php if($stockItemImage = getStockItemImage($key, $databaseConnection)): ?>
                                            <div class=''>
                                                <img class='img-fluid' src="<?= 'img/stock-item/' . $stockItemImage[0]['ImagePath'] ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class=''>
                                                <img class='img-fluid' src="<?= 'img/stock-item/' . $stockItem['BackupImagePath'] ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card__description">
                                        <h2><?= $stockItem['StockItemName'] ?></h2>
                                        <div class="card__price">&euro; <?= number_format($stockItem['SellPrice'], 2, '.') ?> <span>Inclusief btw</span></div>
                                        <span class="card__stock">Artikelnummer: <?= $stockItem['StockItemID'] ?></span>
                                    </div>

                                    <div class="card__description">
                                        <form method='post'>
                                            <?php
                                            $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
                                            $stock = getItemStock($stockItem['StockItemID'], $databaseConnection)['QuantityOnHand'];
                                            $price = round($stockItem['SellPrice'], 2);
                                            $total += $price * $quantity; ?>

                                            <input name="<?= $stockItem['StockItemID'] ?>" min="1" type="number" value="<?= $quantity ?>" max="<?= $stock ?>">

                                        </form>

                                        <div class="close">
                                            <a href="<?= 'cart.php?remove=' . $key ?>" class="text-danger">&#10005; </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="shopping-cart__checkout">

                            <?php if (empty($_SESSION['cart'])) {
                                print("<h2>Uw winkelmandje is leeg.</h2>");
                            } else { ?>
                                <h5>
                                    <b>Overzicht</b>
                                </h5>
                                <hr>
                                <div class="">
                                    <div class="">Totaal</div>
                                    <div class=" text-right">&euro; <?php print(number_format($total, 2, '.')) ?></div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <a href="https://www.ideal.nl/demo/qr/?app=ideal" class="btn btn--primary">Bestelling plaatsen</a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include "footer.php"; ?>

        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }

            // Verwijder URL GET-query om dubbele uitvoering te voorkomen op ververs.
            // window.history.pushState("object or string", "Title", "/" + window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
        </script>

    </body>
</html>
