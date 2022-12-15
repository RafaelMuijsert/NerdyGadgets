<div class="order-history">
    <h1 class="order-history__title">Mijn bestellingen</h1>
    <div class="order-history__wrapper">
        <?php
        $orders = getOrderHistory($_SESSION['account']['id'], $databaseConnection);
        if(isset($orders) && !empty($orders)):?>
            <p>Zie hieronder uw eerder bestelde producten.</p>
            <?php foreach($orders as $key => $order):
                $date = str_split($order['datum'], 11);

                $styling = '';
                if (count($orders) == ($key +1)):
                    $styling = "style='margin-bottom: 0 !important;'";
                endif;

                $buttonColor = 'btn--order';
                $orderStatus = getOrderStatus($order['datum']);

                if($orderStatus == 'Bestelling wordt verwerkt'):
                    $buttonColor = 'btn--red';
                endif; ?>
                <div class="order-history__order" <?= $styling ?>>
                    <div class="accordion order-history__order-header ">
                        <a href="view.php?id=<?= $order['ArtikelID'] ?>" class="order-history__order-img">
                            <?php if (isset($order['ImagePath'])): ?>
                                <div class="ImgFram"
                                     style="background-image: url('<?= "/img/stock-item/" . $order['ImagePath']; ?>');"></div>
                            <?php elseif (isset($order['BackupImagePath'])): ?>
                                <div class="ImgFrame"
                                     style="background-image: url('<?= "/img/stock-group/" . $order['BackupImagePath'] ?>'); background-size: cover;"></div>
                            <?php endif; ?>
                        </a>
                        <div class="order-history__order-description">
                            <h4><?= $order['StockItemName'] ?></h4>
                            <div class="order-history__price">€   <?= $order['bedrag']; ?> <span>excl. btw</span></div>
                            <div class="btn  <?= $buttonColor ?>"><?= $orderStatus; ?></div>
                        </div>
                        <div class="order-history__order-delivery">
                            <p>Besteld op: <?= $date[0] ?></p>
                            <p>Aantal: <?= $order['aantal'] ?></p>
                            <p>Artikelnummer: <?= $order['ArtikelID'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Helaas, u heeft nog geen producten besteld. <a style="color: #007bff" href="../../browse.php">Bestel nu uw eerste product hier.</a></p>
        <?php endif; ?>
        <div class="order-history__load-more">
            <button class="load-more btn btn--order">Laad meer bestellinge zien</button>
        </div>
    </div>
</div>
<script src="../../js/order-history.js"></script>