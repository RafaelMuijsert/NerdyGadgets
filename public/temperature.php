<?php
require "../src/database.php";

$connection = connectToDatabase();
$temperature = getColdroomTemperature($connection);
echo $temperature;