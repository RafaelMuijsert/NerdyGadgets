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
<div class="d-flex align-items-center justify-content-center">
    <div class="p-3 rounded border bg-light" style="width: 60%;">
        <h2 class=text-center>Gegevens</h2><hr>
        <FORM METHOD="post" action="summary.php">
            <div class="row">
                <div class="col-2">
                    <label for="fname">Voornaam:</label>
                </div>
                <div class="col-8">
                    <input type="text" id="fname" name="fname" style="width: 80%;" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                  <label for="lname">Achternaam:</label>
                </div>
                <div class="col-8">
                    <input type="text" id="lname" name="lname" style="width: 80%;" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="email">Email:</label>
                </div>
                <div class="col-8">
                    <input type="email" id="email" name="email" style="width: 80%;" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="phonenumber">Telefoonnummer:</label>
                </div>
                <div class="col-8">
                    <input type="string" id="Number" name="Number" style="width: 80%;"><br><br>
                </div>
            </div><hr>
            <div class="row">
                <div class="col-2">
                    <label for="country">Land:</label>
                </div>
                <div class="col-8">
                    <select name="country" id="country" style="width: 80%;">
                        <?php
                        $countries = getCountry($databaseConnection);
                        print_r($countries[1]['CountryName']);
                        foreach ($countries as $index => $country){
                            $countryName = $country['CountryName'];
                            $countryID = $country['CountryID'];
                            print ('<option value="' . $countryName . '" ');
                            if ($countryID == 153){
                                print ("selected");
                            }
                            print(">$countryName</option>");
                        }
                        ?>

                    </select><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="street">Straat:</label>
                </div>
                <div class="col-8">
                    <input type="text" id="street" name="street" style="width: 80%;" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="postcode">Postcode:</label>
                </div>
                <div class="col-8">
                    <input type="text" id="postcode" name="postcode" style="width: 80%;" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label for="city">Stad:</label>
                </div>
                <div class="col-8">
                    <input type="text" id="city" name="city" style="width: 80%" required><br><br>
                </div>
            </div>
            <INPUT TYPE="hidden" NAME="required_fields" VALUE="name, from">

        <!--    <a href="summary.php" class="btn btn-primary">Doorgaan</a>-->
            <input type="submit" value="Verwerken">
        </FORM>
    </div>
</div>
<?php
include "footer.php";
?>