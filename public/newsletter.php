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
include "send_mail.php";
?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="order__wrapper bg-white bg-white--large">
                <div>
                    <h1>Nieuwsbrief</h1>
                </div>

                <form name="registration" method="post" action="" class="order__form">

                    <span class="order__form-row order__form-error">
                        <?php
                        if(isset($_POST) && isset($_POST['submit-email-Registration'])):

                            $_SESSION['email-registration'] = $_POST;
                        $username = $_SESSION['email-registration']['email'];

                        maillistaccount(
                                $_SESSION['email-registration']['email'],
                                $_SESSION['email-registration']['firstname'],
                                $_SESSION['email-registration']['prefixName'],
                                $_SESSION['email-registration']['surname'],
                                $databaseConnection,
                        );
                        endif;
                        ?>
                    </span>

                    <div class= class="order__form-row">
                        <?php
                        $mail = '';
                        if (isset($_SESSION['email-registration']['email'])):
                            $mail = $_SESSION['email-registration']['email'];
                        endif; ?>
                        <label for="email">Email:*</label>
                        <input class="input" placeholder="Emailadres" value="<?= $mail ?>" type="email" id="email" name="email" required>
                    </div>

                    <div class="order__form-row order__form-row--40">
                        <?php
                        $firstname = '';
                        if (isset($_SESSION['email-registration']['firstname'])):
                            $firstname = $_SESSION['email-registration']['firstname'];
                        endif; ?>
                        <label for="firstname">Voornaam:*</label>
                        <input class="input" value="<?= $firstname ?>" type="text" id="firstname" name="firstname" required>
                    </div>

                    <div class="order__form-row order__form-row--20">
                        <?php
                        $prefixName = '';
                        if (isset($_SESSION['email-registration']['prefixName'])):
                            $prefixName = $_SESSION['email-registration']['prefixName'];
                        endif; ?>
                        <label for="prefixName">Tussenvoegsel:</label>
                        <input class="input" placeholder="Tussenvoegsel" value="<?= $prefixName ?>" type="text" id="prefixName" name="prefixName">
                    </div>

                    <div class="order__form-row order__form-row--40">
                        <?php
                        $surname = '';
                        if (isset($_SESSION['email-registration']['surname'])):
                            $surname = $_SESSION['email-registration']['surname'];
                        endif; ?>
                        <label for="surname">Achternaam:*</label>
                        <input class="input" placeholder="Achternaam" value="<?= $surname ?>" type="text" id="surname" name="surname" required>
                    </div>

                    <div class="order__form-row">
                        <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
                        <a href="send_mail.php" class="btn btn--order"> Bevestigen</a>'
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>

