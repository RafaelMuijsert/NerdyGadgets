<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>The place for your gadgets - NerdyGadgets</title>

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
            include "header.php";
            $StockItem = getStockItem($_GET['id'], $databaseConnection);
            $StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
        ?>

        <section class="product">
            <div class="container">
                <div class="row">

                    <?php if ($StockItem != null): ?>

                        <div class="col-12">
                            <div class="article-header product__header bg-white" id="ArticleHeader">

                                <div class="product__header-left">
                                    <div class="product__header-img">
                                        <?php if (isset($StockItemImage)): ?>

                                            <?php if(count($StockItemImage) == 0): ?>
                                                <div class="product__img" id="ImageFrame" style="background-image: url('img/stock-group/<?= $StockItem['BackupImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                                            <?php elseif (count($StockItemImage) == 1): ?>
                                                <div class="product__img" id="ImageFrame" style="background-image: url('img/stock-item/<?= $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                                            <?php elseif (count($StockItemImage) >= 2): ?>
                                                <div class="product__carousel" id="ImageFrame">
                                                    <div id="ImageCarousel" class="carousel slide" data-interval="false">
                                                        <ul class="carousel-indicators">
                                                            <?php for ($i = 0; $i < count($StockItemImage); $i++): ?>
                                                                <li data-target="#ImageCarousel" data-slide-to="<?= $i ?>" <?= (($i == 0) ? 'class="active"' : ''); ?>></li>
                                                            <?php endfor; ?>
                                                        </ul>

                                                        <div class="carousel-inner">
                                                            <?php for ($i = 0; $i < count($StockItemImage); $i++): ?>
                                                                <div class="carousel-item <?= ($i == 0) ? 'active' : ''; ?>">
                                                                    <img src="img/stock-item/<?= $StockItemImage[$i]['ImagePath'] ?>">
                                                                </div>
                                                            <?php endfor; ?>
                                                        </div>

                                                        <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                                            <span class="carousel-control-prev-icon"></span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                                            <span class="carousel-control-next-icon"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        <?php else:; ?>
                                            <div id="ImageFrame product__img" class="product__img" style="background-image: url('img/stock-group/<?= $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product__header-center">
                                    <div>
                                        <h1 class="product__header-title">
                                            <?= $StockItem['StockItemName']; ?>
                                        </h1>
                                        <h3 class="product__header-price">
                                            <b><?= sprintf("€%.2f", $StockItem['SellPrice']); ?> </b>
                                            <span>Inclusief btw</span>
                                        </h3>
                                    </div>

                                    <p class="product__header-number">Artikelnummer: <?= $StockItem["StockItemID"]; ?></p>

                                </div>

                                <div class="product__header-right">
                                    <form class="product__header-form" method="post">
                                        <input class="product__header-count" type="number" name="stockItemID" value="<?= ($_GET['id']); ?>">
                                        <input class="btn btn--primary" type="submit" name="submit" value="Toevoegen">
                                        <?php if (isset($_POST["submit"])):
                                            updateShoppingCart($_GET['id'], $databaseConnection);
                                        endif; ?>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2>
                    <?php endif; ?>

                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="bg-white">
                            <div class="stock-item-descr" id="StockItemDescription">
                                <h3>Artikel beschrijving</h3>
                                <p><?= $StockItem['SearchDetails']; ?></p>
                            </div>

                            <div class="product__spec stock-item-spec" id="StockItemSpecifications">
                                <h3>Artikel specificaties</h3>
                                <?php
                                $CustomFields = json_decode($StockItem['CustomFields'], true);

                                if (is_array($CustomFields)): ?>
                                    <table>
                                        <thead>
                                        <th>Naam</th>
                                        <th class="text-right">Data</th>
                                        </thead>
                                        <?php foreach ($CustomFields as $SpecName => $SpecText): ?>
                                            <tr>
                                                <td>
                                                    <?= $SpecName; ?>
                                                </td>
                                                <td class="text-right ml-2">
                                                    <?php if (is_array($SpecText)):
                                                        foreach ($SpecText as $SubText):
                                                            print $SubText . " ";
                                                        endforeach;
                                                    else:
                                                        print $SpecText;
                                                    endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php else: ?>
                                    <p><?= $StockItem['CustomFields']; ?>.</p>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                    <?php if (isset($StockItem['Video'])): ?>
                        <div class="col-6">
                            <div class="bg-white">
                                <h3>Video</h3>
                                <div class="product__video" id="VideoFrame">
                                    <?= $StockItem['Video']; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php include "footer.php"; ?>

        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
