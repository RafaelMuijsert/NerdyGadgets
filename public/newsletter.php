<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Nieuwsbrief</title>
    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!--        <script src="js/resizer.js"></script>-->

    <!-- Style sheets-->
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>
<?php
include "header.php";
include "../src/functions.php";
?>
<div>
    <h1>Nieuwsbrief</h1>
</div>

<form name="registration" method="post" action="" class="order__form">

    <span class="order__form-row order__form-error">
        <?php
        if(isset($_POST) && isset($_POST['submitRegistration'])):

            $_SESSION['registration'] = $_POST;
            $username = $_SESSION['registration']['email'];


                maillistaccount(
                    $_SESSION['registration']['email'],
                    $_SESSION['registration']['firstname'],
                    $_SESSION['registration']['prefixName'],
                    $_SESSION['registration']['surname'],
                    $databaseConnection,

                );
                if($exeption == false):

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
        <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
        <input class="btn btn--order" type="submit" name="submitRegistration" value="Bevestig gegevens">
    </div>
</form>


</body>
</html>

