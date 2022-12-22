<?php
    function addToMailingList($email, $firstname, $prefix, $surname, $userID, $databaseConnection) {
        try {
            $Query = "
            INSERT INTO webshop_mailinglist (email, Voornaam, Tussenvoegsel, Achternaam, email, userID)
            VALUES (?, ?, ?, ?, ?, ?)";
            $Statement = mysqli_prepare($databaseConnection, $Query);
            mysqli_stmt_bind_param($Statement, "ssssss", $email, $firstname, $prefix, $surname, $email, $userID);
            mysqli_stmt_execute($Statement);
        } catch (Exception $e) {
//            var_dump($e);
        }
    }

    function addAccountToMailing($userID, $conn) {

    }

    function defaultInputCheck($field) {
        if (preg_match('/[\'\"\/0-9\\\\]/', $field)) {
            echo "<a style='color: red'><p>Een van de ingevuld gegevens voldoet niet aan de eisen..</p></p></a>";
            return false;
        }
        return true;
    }

    function newsletterCheck() {
        validate_email($_SESSION['newsletter']['email']);
        defaultInputCheck($_SESSION['newsletter']['firstname']);
        defaultInputCheck($_SESSION['newsletter']['prefixName']);
        defaultInputCheck($_SESSION['newsletter']['surname']);
    }
?>
<form action="" method="POST" class="newsletter__form">
    <span>
        <?php
            $isLoggedIn = (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == false);
            if(isset($_POST['newsletterSubmit'])):

                $_SESSION['newsletter'] = $_POST;

                if(true):
                    $userID = NULL;
                    if($isLoggedIn):
//                        $userID = $_SESSION['account']['id'];
//                        addAccountToMailing($userID, $databaseConnection);
                    endif;


                    addToMailingList(
                            $_SESSION['newsletter']['email'],
                            $_SESSION['newsletter']['firstname'],
                            $_SESSION['newsletter']['prefixName'],
                            $_SESSION['newsletter']['surname'],
                            $userID,
                            $databaseConnection
                    );

                endif;
            endif;
        ?>
    </span>

    <?php if($isLoggedIn): ?>
        <div class="form__form-row form__form-row--40">
            <label for="firstname">Voornaam:*</label>
            <input class="input" placeholder="Voornaam" type="text" id="firstname" name="firstname" required>
        </div>

        <div class="form__form-row form__form-row--20">
            <label for="prefixName">Tussenvoegsel:</label>
            <input class="input" placeholder="Tussenvoegsel" type="text" id="prefixName" name="prefixName">
        </div>

        <div class="form__form-row form__form-row--40">
            <label for="surname">Achternaam:*</label>
            <input class="input" placeholder="Achternaam" type="text" id="surname" name="surname" required>
        </div>
    <?php endif; ?>

    <div class="form__form-row form__form-row--100">
        <?php
            $mail = '';
            if(isset($_SESSION['account']['email'])):
                $mail = $_SESSION['account']['email'];
            endif;
        ?>
        <label for="email">Email:*</label>
        <input type="email" name="email" class="input" value="<?= $mail ?>" placeholder="Email" style="width: 100%" required>
    </div>

    <div class="form__form-row form__form-row--100">
        <input type="submit" name="newsletterSubmit" value="Aanmelden" class="btn btn--order">
    </div>
</form>
