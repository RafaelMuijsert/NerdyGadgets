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

        <?php
            session_start();
            include "header.php";
        ?>

        <?php
        $total = 0;

        foreach($_POST as $key => $value):
            $value = abs($value);
            $stock = getItemStock($key, $databaseConnection);
            $value = ($value <= $stock) ? $value : $stock;
            $_SESSION['cart'][$key] = abs($value);
        endforeach;

        function updateSession($arrayName) {

            if($arrayName == 'cart' || $arrayName == 'registration') {

                foreach($_POST as $key => $value):
                    $value = abs($value);
                    $stock = getItemStock($key, $databaseConnection);
                    $value = ($value <= $stock) ? $value : $stock;
                    $_SESSION[$arrayName][$key] = abs($value);
                endforeach;

            } else {
                return "Function is not capable of handling this request";
            }

            foreach($_POST as $key => $value):
                $value = abs($value);
                $stock = getItemStock($key, $databaseConnection);
                $value = ($value <= $stock) ? $value : $stock;
                $_SESSION[$arrayName][$key] = abs($value);
            endforeach;

        }


        if (!isset($_SESSION['cart'])):
            $_SESSION['cart'] = [];
        endif; ?>

        <section class="shopping-cart">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="shopping-cart__cart bg-white bg-white--large">
                            <h1 class="shopping-cart__title">Winkelmandje</h1>

                            <?php if(count($_SESSION['cart']) !== 0): ?>

                                <?php foreach ($_SESSION['cart'] as $key => $item):
                                    $stockItem = getStockItem($key, $databaseConnection);
                                    if (!$stockItem):
                                        continue;
                                    endif; ?>
                                    <div class="card">
                                        <a href="view.php?id=<?= $key ?>" class="card__img">
                                            <?php if($stockItemImage = getStockItemImage($key, $databaseConnection)): ?>
                                                <img class='img-fluid' src="<?= 'img/stock-item/' . $stockItemImage[0]['ImagePath'] ?>">
                                            <?php else: ?>
                                                <img class='img-fluid' src="<?= 'img/stock-item/' . $stockItem['BackupImagePath'] ?>">
                                            <?php endif; ?>
                                        </a>

                                        <div class="card__description">
                                            <div>
                                                <h2><?= $stockItem['StockItemName'] ?></h2>
                                                <div class="card__price">&euro; <?= number_format($stockItem['SellPrice'], 2, '.', ',') ?> <span>Inclusief btw</span></div>
                                            </div>
                                            <span class="card__stock">
                                                Artikelnummer: <?= $stockItem['StockItemID'] ?>
                                            </span>
                                        </div>

                                        <div class="card__count">
                                            <form method='post'>
                                                <?php
                                                $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
                                                $stock = getItemStock($stockItem['StockItemID'], $databaseConnection);
                                                $price = round($stockItem['SellPrice'], 2);
                                                $total += $price * $quantity; ?>

                                                <input class="btn" name="<?= $stockItem['StockItemID'] ?>" onchange="this.form.submit()" min="1" type="number" value="<?= $quantity ?>" max="<?= $stock ?>">

                                            </form>

                                            <div class="close">
                                                <a href="<?= 'cart.php?remove=' . $key ?>" class="text-danger">&#10005; </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <h2>Uw winkelmandje is leeg.</h2>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="shopping-cart__checkout bg-white">
                            <?php if (empty($_SESSION['cart'])):
                                print("<h2>Uw winkelmandje is leeg.</h2>");
                            else: ?>
                                <h5>
                                    <b>Overzicht</b>
                                </h5>
                                <hr>
                                <div class="shopping-cart__total">
                                    <div class="">Totaal</div>
                                    <div class=" text-right">&euro; <?= (number_format($total, 2, '.', ',')) ?></div>
                                </div>
                                <hr>
                                <div class="text-right">
                                    <a href="./order.php" class="btn btn--order">Bestelling plaatsen</a>
                                </div>
                            <?php endif; ?>
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
