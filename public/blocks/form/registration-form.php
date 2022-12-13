<?php
    include "form-functions.php";
?>

<form name="registration" method="post" action="" class="order__form">

    <span class="order__form-row order__form-error">
        <?php
        if(isset($_POST) && isset($_POST['submitRegistration'])):

            $_SESSION['registration'] = $_POST;
            $username = $_SESSION['registration']['email'];
            $pwd = $_SESSION['registration']['password'];
            $hashPassword = password_hash($_SESSION['registration']['password'], PASSWORD_DEFAULT);

            if(inputcheck('registration')):
                //Create User in the database
                createUser(
                    $_SESSION['registration']['email'],
                    $hashPassword,
                    $_SESSION['registration']['firstname'],
                    $_SESSION['registration']['prefixName'],
                    $_SESSION['registration']['surname'],
                    $_SESSION['registration']['birthDate'],
                    $_SESSION['registration']['phone'],
                    $_SESSION['registration']['street'],
                    $_SESSION['registration']['housenumber'],
                    $_SESSION['registration']['postcode'],
                    $_SESSION['registration']['city'],
                    $databaseConnection
                );

                loginUser($username, $pwd, $databaseConnection);
            endif;
        endif;
        ?>
    </span>

    <div class="order__form-row order__form-row--50">
        <?php
        $mail = '';
        if (isset($_SESSION['registration']['email'])):
            $mail = $_SESSION['registration']['email'];
        endif; ?>
        <label for="email">Email:*</label>
        <input class="input" placeholder="Emailadres" value="<?= $mail ?>" type="email" id="email" name="email" required>
    </div>

    <div class="order__form-row order__form-row--50">
        <?php
        $password = '';
        if (isset($_SESSION['registration']['password'])):
            $password = $_SESSION['registration']['password'];
        endif; ?>
        <label for="password">Wachtwoord:*</label>
        <input class="input" placeholder="Wachtwoord" value="<?= $password ?>" type="password" id="password" name="password" required>
    </div>

    <div class="order__form-row order__form-row--40">
        <?php
        $firstname = '';
        if (isset($_SESSION['registration']['firstname'])):
            $firstname = $_SESSION['registration']['firstname'];
        endif; ?>
        <label for="firstname">Voornaam:*</label>
        <input class="input" value="<?= $firstname ?>" type="text" id="firstname" name="firstname" required>
    </div>

    <div class="order__form-row order__form-row--20">
        <?php
        $prefixName = '';
        if (isset($_SESSION['registration']['prefixName'])):
            $prefixName = $_SESSION['registration']['prefixName'];
        endif; ?>
        <label for="prefixName">Tussenvoegsel:</label>
        <input class="input" placeholder="Tussenvoegsel" value="<?= $prefixName ?>" type="text" id="prefixName" name="prefixName">
    </div>

    <div class="order__form-row order__form-row--40">
        <?php
        $surname = '';
        if (isset($_SESSION['registration']['surname'])):
            $surname = $_SESSION['registration']['surname'];
        endif; ?>
        <label for="surname">Achternaam:*</label>
        <input class="input" placeholder="Achternaam" value="<?= $surname ?>" type="text" id="surname" name="surname" required>
    </div>

    <div class="order__form-row">
        <?php
        $birthDate = '';
        if (isset($_SESSION['registration']['birthDate'])):
            $birthDate = $_SESSION['registration']['birthDate'];
        endif; ?>
        <label for="birthDate">Geboortedatum:*</label>
        <input class="input" placeholder="Geboortedatum" value="<?= $birthDate ?>" type="date" id="birthDate" name="birthDate" required>
    </div>



    <div class="order__form-row order__form-row--50">
        <?php
        $phone = '';
        if (isset($_SESSION['registration']['phone'])):
            $phone = $_SESSION['registration']['phone'];
        endif; ?>
        <label for="number">Telefoonnummer:</label>
        <input class="input" placeholder="Telefoonnummer" value="<?= $phone ?>" type="tel" id="phone" name="phone" required>
    </div>

    <div class="order__form-row order__form-row--50">
        <label for="country">Land:</label>
        <select class="select country" name="country" id="country">
            <option value="Netherlands">Nederland</option>
        </select>
    </div>

    <div class="order__form-row order__form-row--40">
        <?php
        $street = '';
        if (isset($_SESSION['registration']['street'])):
            $street = $_SESSION['registration']['street'];
        endif; ?>
        <label for="street">Straat:*</label>
        <input class="input" type="text" id="street" name="street" placeholder="Vul hier in..." value="<?= $street ?>" required>
    </div>

    <div class="order__form-row order__form-row--10">
        <?php
        $housenumber = '';
        if (isset($_SESSION['registration']['housenumber'])):
            $housenumber = $_SESSION['registration']['housenumber'];
        endif; ?>
        <label for="housenumber">Huisnr:*</label>
        <input class="input" type="text" id="housenumber" name="housenumber" placeholder="..." value="<?= $housenumber ?>" required>
    </div>

    <div class="order__form-row order__form-row--50">
        <?php
        $postalZip = '';
        if (isset($_SESSION['registration']['postcode'])):
            $postalZip = $_SESSION['registration']['postcode'];;
        endif; ?>
        <label for="postcode">Postcode:*</label>
        <input class="input" placeholder="Vul hier in..." value="<?= $postalZip ?>" type="text" id="postcode" name="postcode" required>
    </div>

    <div class="order__form-row">
        <?php
        $city = '';
        if (isset($_SESSION['registration']['city'])):
            $city = $_SESSION['registration']['city'];
        endif; ?>
        <label for="city">Stad:*</label>
        <input class="input" placeholder="Stad" value="<?= $city ?>" type="text" id="city" name="city" required>
    </div>

    <div class="order__form-row">
        <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
        <input class="btn btn--order" type="submit" name="submitRegistration" value="Bevestig gegevens">
    </div>
</form>
