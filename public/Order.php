<?php
include "header.php";
?>
<!DOCTYPE Html>
<html lang="en">
<div class="col-12">
        <h1>Gegevens invullen</h1>
    <hr>
</div>
<body>

<FORM METHOD="post" action="summary.php">

    <label for="fname">Voornaam:</label>
    <input type="text" id="fname" name="fname" style="width: 400px;" required><br><br>

    <label for="lname">Achternaam:</label>
    <input type="text" id="lname" name="lname" style="width: 400px;" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" style="width: 400px;" required><br><br>

    <label for="phonenumber">Telefoonnummer:</label>
    <input type="string" id="Number" name="Number" style="width: 400px;"><br><br>

    <label for="country">Land:</label>
    <select name="country" id="country">
        <option value="Nederland">Nederland</option>
        <option value="België">België</option>
        <option value="Duitsland">Duitsland</option>
        <option value="Luxemburg">Luxemburg</option>
    </select>

    <label for="street">Straat:</label>
    <input type="text" id="street" name="street" style="width: 400px;" required><br><br>

    <label for="postcode">Postcode:</label>
    <input type="text" id="postcode" name="postcode" style="width: 400px;" required><br><br>

    <label for="city">Stad:</label>
    <input type="text" id="city" name="city" style="width:400px" required><br><br>

    <INPUT TYPE="hidden" NAME="required_fields" VALUE="name, from">

<!--    <a href="summary.php" class="btn btn-primary">Doorgaan</a>-->
    <input type="submit">
</FORM>

</body>
</html>