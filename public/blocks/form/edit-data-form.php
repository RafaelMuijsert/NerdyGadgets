<form name="registration" method="post" action="" class="edit-data form__form">
    <span class="form__form-row form__form-error">
        <?php if(isset($_POST) && isset($_POST['submitEditData'])):
            $_SESSION['editAccount'] = $_POST;
            $_SESSION['editAccount']['postcode'] = filterPostalzip($_SESSION['editAccount']['postcode']);
            if(inputcheck('editAccount')):
                //Edit User in the database
                editUser(
                    $_SESSION['editAccount']['firstname'],
                    $_SESSION['editAccount']['prefixName'],
                    $_SESSION['editAccount']['surname'],
                    $_SESSION['editAccount']['birthDate'],
                    $_SESSION['editAccount']['phone'],
                    $_SESSION['editAccount']['street'],
                    $_SESSION['editAccount']['housenumber'],
                    $_SESSION['editAccount']['postcode'],
                    $_SESSION['editAccount']['city'],
                    $_SESSION['account']['id'],
                    $databaseConnection
                );
            endif;
        endif; ?>
    </span>

    <?php
        /*
         *  Setup all pre-load form data
         */
        $firstname = (isset($_POST['firstname']) ? $_POST['firstname'] : $_SESSION['account']['voornaam']);
        $prefixName = (isset($_POST['prefixName']) ? $_POST['prefixName'] : $_SESSION['account']['tussenvoegsel']);
        $surname = (isset($_POST['surname']) ? $_POST['surname'] : $_SESSION['account']['achternaam']);
        $birthDate = (isset($_POST['birthDate']) ? $_POST['birthDate'] : $_SESSION['account']['geboortedatum']);
        $phone = (isset($_POST['phone']) ? $_POST['phone'] : $_SESSION['account']['telefoonnummer']);
        $street = (isset($_POST['street']) ? $_POST['street'] : $_SESSION['account']['straat']);
        $housenumber = (isset($_POST['housenumber']) ? $_POST['housenumber'] : $_SESSION['account']['huisnummer']);
        $postalZip = (isset($_POST['postcode']) ? $_POST['postcode'] : $_SESSION['account']['postcode']);
        $city = (isset($_POST['city']) ? $_POST['city'] : $_SESSION['account']['stad']);
    ?>

    <div class="form__form-row form__form-row--40">
        <label for="firstname">Voornaam:*</label>
        <input class="input" value="<?= $firstname ?>" type="text" id="firstname" name="firstname" required>
    </div>

    <div class="form__form-row form__form-row--20">
        <label for="prefixName">Tussenvoegsel:</label>
        <input class="input" placeholder="Tussenvoegsel" value="<?= $prefixName ?>" type="text" id="prefixName" name="prefixName">
    </div>

    <div class="form__form-row form__form-row--40">
        <label for="surname">Achternaam:*</label>
        <input class="input" placeholder="Achternaam" value="<?= $surname ?>" type="text" id="surname" name="surname" required>
    </div>

    <div class="form__form-row">
        <label for="birthDate">Geboortedatum:*</label>
        <input class="input" placeholder="Geboortedatum" value="<?= $birthDate ?>" type="date" id="birthDate" name="birthDate" required>
    </div>

    <div class="form__form-row form__form-row--50">
        <label for="number">Telefoonnummer:</label>
        <input class="input" placeholder="Telefoonnummer" value="<?= $phone ?>" type="tel" id="phone" name="phone" required>
    </div>

    <div class="form__form-row form__form-row--40">
        <label for="street">Straat:*</label>
        <input class="input" type="text" id="street" name="street" placeholder="Vul hier in..." value="<?= $street ?>" required>
    </div>

    <div class="form__form-row form__form-row--10">
        <label for="housenumber">Huisnr:*</label>
        <input class="input" type="text" id="housenumber" name="housenumber" placeholder="..." value="<?= $housenumber ?>" required>
    </div>

    <div class="form__form-row form__form-row--50">
        <label for="postcode">Postcode:*</label>
        <input class="input" placeholder="Vul hier in..." value="<?= $postalZip ?>" type="text" id="postcode" name="postcode" required>
    </div>

    <div class="form__form-row form__form-row--50">
        <label for="city">Stad:*</label>
        <input class="input" placeholder="Stad" value="<?= $city ?>" type="text" id="city" name="city" required>
    </div>

    <div class="form__form-row">
        <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
        <input class="btn btn--order" type="submit" name="submitEditData" value="Gegevens opslaan">
    </div>
</form>
