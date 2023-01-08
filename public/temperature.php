<?php
require "../src/database.php";

$connection = connectToDatabase(false);
$temperature = getColdroomTemperature($connection);
echo $temperature;