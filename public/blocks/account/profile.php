<?php
    $hasPlacedAnOrder = true;
?>
<div class="profile">
    <div class="profile__header">
        <h1 class="profile__title">Gebruikersprofiel</h1>
        <hr>
        <table class="profile__table">
            <thead>
            <tr>
                <th>
                    <?php
                        $firstname = $_SESSION['account']['voornaam'];
                        $prefixName = $_SESSION['account']['tussenvoegsel'];
                        $surname = $_SESSION['account']['achternaam'];
                    ?>
                    <h2 class="profile__name"><?= "$firstname" . " $prefixName" . " $surname" ?></h2>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Geboortedatum:</td>
                <td><?= $_SESSION['account']['geboortedatum'] ?></td>
            </tr>
            <tr>
                <td>Emailadres:</td>
                <td><?= $_SESSION['account']['email'] ?></td>
            </tr>
            <tr>
                <td>Telefoonnummer:</td>
                <td><?= $_SESSION['account']['telefoonnummer'] ?></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td>Land:</td>
                <td>Nederland</td>
            </tr>
            <tr>
                <td>Postcode:</td>
                <td><?= $_SESSION['account']['postcode'] . ", ". $_SESSION['account']['stad'] ?></td>
            </tr>
            <tr>
                <td>Adres:</td>
                <td><?= $_SESSION['account']['straat'] . ' ' . $_SESSION['account']['huisnummer'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <?php
    $results = getOrderHistory($_SESSION['account']['id'], $databaseConnection);
    if(count($results) >= 1):
        $latestOrder = $results[0];
        $totalPrice = ($latestOrder['TaxRate'] / 100) * $latestOrder['RecommendedRetailPrice'] + $latestOrder['RecommendedRetailPrice']; ?>
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

                <?php
                    $buttonColor = 'btn--order';
                    $orderStatus = getOrderStatus($latestOrder['datum']);
                    $date = str_split($latestOrder['datum'], 11);
                    if($orderStatus == 'Bestelling wordt verwerkt'):
                        $buttonColor = 'btn--red';
                    endif;
                ?>
                <div class="order-history__order-description">
                    <h4><?= $latestOrder['StockItemName'] ?></h4>
                    <div class="order-history__price">€   <?= number_format(round($totalPrice, 2), 2); ?> <span>excl. btw</span></div>
                    <div class="btn <?= $buttonColor ?>"><?= $orderStatus; ?></div>
                </div>
                <div class="order-history__order-delivery">
                    <p>Besteld op: <?= $date[0] ?></p>
                    <p>Aantal: <?= $latestOrder['aantal'] ?></p>
                    <p>Artikelnummer: <?= $latestOrder['ArtikelID'] ?></p>
                </div>
            </div>
        </div>
    <?php elseif(isset($_SESSION['account']) && $_SESSION['account']['role'] !== 'Admin'): ?>
        //U heeft nog geen bestellingen geplaatst
    <?php endif; ?>
</div>