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
    <?php var_dump($_SESSION['account']); ?>
    <?php if($hasPlacedAnOrder): ?>
        <div class="profile__recent-order recent-order">
            <h2>Laatste bestelling</h2>
            <div class="recent-order__order">
                <div class="recent-order__img">
                    <img src="" alt="">
                </div>
                <div class="recent-order__desc">
                    <h4 class="recent-order__title">[Product naam hier]</h4>
                    <div class="recent-order__price">
                        €23,45
                        <span>Inclusief BTW.</span>
                    </div>
                    <div class="recent-order__delivery btn btn--order btn--delivery">Is bezorgd</div>
                </div>


            </div>
        </div>
    <?php else: ?>
        //U heeft nog geen bestellingen geplaatst
    <?php endif; ?>
</div>