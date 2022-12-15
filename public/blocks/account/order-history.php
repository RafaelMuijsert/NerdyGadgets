<div class="order-history">
    <h1 class="order-history__title">Mijn bestellingen</h1>
    <p>Zie hieronder uw eerder bestelde producten.</p>
    <div class="order-history__wrapper">
        <?php
        $orders = getOrderHistory($_SESSION['account']['id'], $databaseConnection);
        if(isset($orders) && !empty($orders)):?>
            <?php foreach($orders as $key => $order):
                $totalPrice = ($order['TaxRate'] / 100) * $order['RecommendedRetailPrice'] + $order['RecommendedRetailPrice'];
                $date = str_split($order['datum'], 11);
                ?>
                <div class="order-history__order">
                    <?php var_dump($order); ?>
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
                            <div class="btn btn--order"><?= $order['orderStatus'] ?></div>
                            <p>Besteld op: <?= $date[0] ?></p>
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
<script>
    // Zoek alle blokken met de class "order-history__order"
    var blocks = document.querySelectorAll('.order-history__order');
    var button = document.querySelector('button.load-more');

    if(blocks.length <= 10) {
        button.style.display = 'none';
    }

    // Geef de eerste 10 blokken de display "block" en de overige blokken de display "none"
    for (var i = 0; i < blocks.length; i++) {
        if (i < 10) {
            blocks[i].style.display = 'block';
        } else {
            blocks[i].style.display = 'none';
        }
    }

    button.addEventListener('click', function() {
        for (var i = 0; i < blocks.length; i++) {
            blocks[i].style.display = 'block';
        }

        button.style.display = 'none';
    });
</script>