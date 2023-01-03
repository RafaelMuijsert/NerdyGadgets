
<form method="post" action="" class="form__form">
    <span class="form__form-row form__form-error">
        <?php
        if(isset($_POST['orderSubmit'])):
            $_SESSION['userinfo'] = $_POST;
            $_SESSION['userinfo']['postcode'] = str_replace(' ', '', $_SESSION['userinfo']['postcode']);
            if(inputcheck('userinfo', 'order')):
                $_SESSION['userinfo']['postcode'] = filterPostalZip($_SESSION['userinfo']['postcode']);
                echo "<script>window.location.replace('./checkout.php')</script>";
            endif;
        endif;
        ?>
    </span>

    <div class="form__form-row form__form-row--40">
        <?php
        $firstname = '';
        if (isset($_SESSION['userinfo']['firstname'])):
            $firstname = $_SESSION['userinfo']['firstname'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $firstname = $_SESSION['account']['voornaam'];
        endif; ?>
        <label for="firstname">Voornaam:*</label>
        <input class="input" placeholder="Voornaam" value="<?= $firstname ?>" type="text" id="firstname" name="firstname" required>
    </div>

    <div class="form__form-row form__form-row--20">
        <?php
        $prefixName = '';
        if (isset($_SESSION['userinfo']['prefixName'])):
            $prefixName = $_SESSION['userinfo']['prefixName'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $prefixName = $_SESSION['account']['tussenvoegsel'];
        endif; ?>
        <label for="prefixName">Tussenvoegsel:</label>
        <input class="input" placeholder="Tussenvoegsel" value="<?= $prefixName ?>" type="text" id="prefixName" name="prefixName">
    </div>

    <div class="form__form-row form__form-row--40">
        <?php
        $surname = '';
        if (isset($_SESSION['userinfo']['surname'])):
            $surname = $_SESSION['userinfo']['surname'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $surname = $_SESSION['account']['achternaam'];
        endif; ?>
        <label for="surname">Achternaam:*</label>
        <input class="input" placeholder="Achternaam" value="<?= $surname ?>" type="text" id="surname" name="surname" required>
    </div>

    <div class="form__form-row">
        <?php
        $birthDate = '';
        if (isset($_SESSION['userinfo']['birthDate'])):
            $birthDate = $_SESSION['userinfo']['birthDate'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $birthDate = $_SESSION['account']['geboortedatum'];
        endif; ?>
        <label for="birthDate">Geboortedatum:</label>
        <input class="input" placeholder="Geboortedatum" value="<?= $birthDate ?>" type="date" id="birthDate" name="birthDate">
    </div>

    <div class="form__form-row">
        <?php
        $mail = '';
        if (isset($_SESSION['userinfo']['email'])):
            $mail = $_SESSION['userinfo']['email'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $mail = $_SESSION['account']['email'];
        endif; ?>
        <label for="email">Email:*</label>
        <input class="input" placeholder="Emailadres" value="<?= $mail ?>" type="email" id="email" name="email" required>
    </div>

    <div class="form__form-row form__form-row--50">
        <?php
        $phone = '';
        if (isset($_SESSION['userinfo']['phone'])):
            $phone = $_SESSION['userinfo']['phone'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $phone = $_SESSION['account']['telefoonnummer'];
        endif; ?>
        <label for="number">Telefoonnummer:</label>
        <input class="input" placeholder="Telefoonnummer" value="<?= $phone ?>" type="tel" id="phone" name="phone">
    </div>

    <div class="form__form-row form__form-row--50">
        <label for="country">Land:</label>
        <select class="select country" name="country" id="country">
            <option value="Netherlands">Nederland</option>
        </select>
    </div>

    <div class="form__form-row form__form-row--40">
        <?php
        $street = '';
        if (isset($_SESSION['userinfo']['street'])):
            $street = $_SESSION['userinfo']['street'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $street = $_SESSION['account']['straat'];
        endif; ?>
        <label for="street">Straat:*</label>
        <input class="input" type="text" id="street" name="street" placeholder="Straat" value="<?= $street ?>" required>
    </div>

    <div class="form__form-row form__form-row--10">
        <?php
        $housenumber = '';
        if (isset($_SESSION['userinfo']['housenumber'])):
            $housenumber = $_SESSION['userinfo']['housenumber'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $housenumber = $_SESSION['account']['huisnummer'];
        endif; ?>
        <label for="housenumber">Huisnr:*</label>
        <input class="input" type="text" id="housenumber" name="housenumber" placeholder="..." value="<?= $housenumber ?>" required>
    </div>

    <div class="form__form-row form__form-row--50">
        <?php
        $postalZip = '';
        if (isset($_SESSION['userinfo']['postcode'])):
            $postalZip = $_SESSION['userinfo']['postcode'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $postalZip = $_SESSION['account']['postcode'];
        endif; ?>
        <label for="postcode">Postcode:*</label>
        <input class="input" placeholder="Postcode" value="<?= $postalZip ?>" type="text" id="postcode" name="postcode" required>
    </div>

    <div class="form__form-row">
        <?php
        $city = '';
        if (isset($_SESSION['userinfo']['city'])):
            $city = $_SESSION['userinfo']['city'];
        elseif(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
            $city = $_SESSION['account']['stad'];
        endif; ?>
        <label for="city">Stad:*</label>
        <input class="input" placeholder="Stad" value="<?= $city ?>" type="text" id="city" name="city" required>
    </div>

    <div class="form__form-row">
        <?php
        $comment = '';
        if (isset($_SESSION['userinfo']['comment'])):
            $comment = $_SESSION['userinfo']['comment'];
        endif; ?>
        <label for="comment">Opmerkingen:</label>
        <textarea class="input" placeholder="Vul hier in... (max 255 karakters)" value="<?= $comment ?>" type="text" id="comment" name="comment"></textarea>
    </div>

    <div class="form__form-row">
        <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
        <input class="btn btn--order" name="orderSubmit" type="submit" value="Bevestig gegevens">
    </div>
</form>