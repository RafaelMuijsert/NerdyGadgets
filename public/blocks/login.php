<section class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="bg-white bg-white--large">
                    <h1 class="login__title">Login page</h1>

                    <?php
                        if(isset($_POST) && isset($_POST['submitLogin'])):
                            $_SESSION['login'] = $_POST;
                            $conn = $databaseConnection;
                            $username = $_SESSION['login']['username'];
                            $pwd = $_SESSION['login']['password'];

                            loginUser($username, $pwd, $conn);
                        endif;
                    ?>

                    <form class="login__form" action="" method="POST">
                        <label for="username">Email:</label>
                        <input class="input" placeholder="Gebruikersnaam" type="text" name="username">

                        <label for="password">Wachtwoord:</label>
                        <input class="input" placeholder="Wachtwoord" type="password" name="password">

                        <a href="./register.php">Registreer nu!</a>

                        <input name="submitLogin" value="Inloggen" class="btn btn--order submit" type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
