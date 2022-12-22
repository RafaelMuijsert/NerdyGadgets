<form action="send_mail.php" method="POST" class="newsletter__form">
    <?php if(!isset($_SESSION['isLoggedIn'])): ?>
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
    <?php
    $mail = '';
    if(isset($_SESSION['account']['email'])):
        $mail = $_SESSION['account']['email'];
    endif;
    ?>
    <div class="order__form-row">
        <label for="email">Email:*</label>
        <input type="email" class="input" value="<?= $mail ?>" placeholder="Email" style="width: 100%">
    </div>
    <br>
    <div class="oder__form-row">
        <input type="submit" name="newsletterSubmit" value="Aanmelden" class="btn btn--order">
    </div>
</form>
