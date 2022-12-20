<?php
    $hasPlacedAnOrder = true;
?>
<div class="profile">
    <div class="profile__header">
        <h1 class="profile__title">Gebruikersprofiel</h1>
        <hr>
        <?php include './blocks/form/edit-data-form.php'; ?>
    </div>
    <hr>
    <?php
    $results = getOrderHistory($_SESSION['account']['id'], $databaseConnection);
    if(count($results) >= 1):
        $latestOrder = $results[0];
        $buttonColor = 'btn--order';
        $orderStatus = getOrderStatus($latestOrder['datum']);
        $date = str_split($latestOrder['datum'], 11);
        if($orderStatus == 'Bestelling wordt verwerkt'):
            $buttonColor = 'btn--red';
        endif; ?>
        <div class="profile__recent-order recent-order">
            <h2>Laatste bestelling</h2>
            <div class="recent-order__order order-history__order-header">
                <a href="view.php?id=<?= $latestOrder['ArtikelID'] ?>" class="order-history__order-img">
                    <?php if (isset($latestOrder['ImagePath'])): ?>
                        <div class="ImgFram"
                             style="background-image: url('<?= "/img/stock-item/" . $latestOrder['ImagePath']; ?>');"></div>
                    <?php elseif (isset($latestOrder['BackupImagePath'])): ?>
                        <div class="ImgFrame"
                             style="background-image: url('<?= "/img/stock-group/" . $latestOrder['BackupImagePath'] ?>'); background-size: cover;"></div>
                    <?php endif; ?>
                </a>
                <div class="order-history__order-description">
                    <h4><?= $latestOrder['StockItemName'] ?></h4>
                    <div class="order-history__price">€   <?= $latestOrder['bedrag']; ?> <span>excl. btw</span></div>
                    <div class="btn <?= $buttonColor ?>"><?= $orderStatus; ?></div>
                </div>
                <div class="order-history__order-delivery">
                    <p>Besteld op: <?= $date[0] ?></p>
                    <p>Aantal: <?= $latestOrder['aantal'] ?></p>
                    <p>Artikelnummer: <?= $latestOrder['ArtikelID'] ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>