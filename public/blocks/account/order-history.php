<div class="order-history">
    <h1 class="order-history__title">Mijn bestellingen</h1>
    <p>Zie hieronder uw eerder bestelde producten.</p>
    <?php function getOrderHistory($userID, $conn) {
        $Query = "
                SELECT * 
                FROM webshop_order AS O 
                JOIN webshop_orderregel AS R ON O.OrderID=R.OrderID 
                JOIN stockitems_archive AS A ON A.StockItemID=R.ArtikelID   
                JOIN stockitemimages AS I ON I.StockItemID=A.StockItemID
                WHERE klantID = '$userID'";
        $smt = mysqli_prepare($conn, $Query);
        mysqli_stmt_execute($smt);
        $result = mysqli_stmt_get_result($smt);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $data;
    } ?>

    <div class="order-history__wrapper">
        <?php
        $orders = getOrderHistory($_SESSION['account']['id'], $databaseConnection);
        if(isset($orders) && !empty($orders)): ?>
            <?php foreach($orders as $key => $order):
//                var_dump($order);
                $totalPrice = ($order['TaxRate'] / 100) * $order['RecommendedRetailPrice'] + $order['RecommendedRetailPrice'];
                $date = str_split($order['datum'], 11);
                ?>
                <div class="order-history__order">
                    <div class="accordion order-history__order-header ">
                        <div class="order-history__order-img">
                            <?php if (isset($order['ImagePath'])): ?>
                                <div class="ImgFram"
                                     style="background-image: url('<?= "/img/stock-item/" . $order['ImagePath']; ?>');"></div>
                            <?php elseif (isset($order['BackupImagePath'])): ?>
                                <div class="ImgFrame"
                                     style="background-image: url('<?= "/img/stock-group/" . $order['BackupImagePath'] ?>'); background-size: cover;"></div>
                            <?php endif; ?>
                        </div>
                        <div class="order-history__order-description">
                            <h4><?= $order['StockItemName'] ?></h4>
                            <p>€   <?= round($totalPrice, 2); ?> excl. btw</p>
                            <p>Aantal: <?= $order['aantal'] ?></p>
                            <p>Artikelnummer: <?= $order['ArtikelID'] ?></p>
                        </div>
                        <div class="order-history__delivery">
                            <div class="btn btn--order">Bezorgd</div>
                            <p>Besteld op: <?= $date[0] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Helaas, u heeft nog geen producten besteld. <a style="color: #007bff" href="../../browse.php">Bestel nu uw eerste product hier.</a></p>
        <?php endif; ?>
    </div>
</div>