<?php
function getVoorraadTekst($actueleVoorraad) {
    if ($actueleVoorraad > 1000) {
        return "Ruime voorraad beschikbaar.";
    } else {
        return "Voorraad: $actueleVoorraad";
    }
}

function berekenVerkoopPrijs($adviesPrijs, $btw) {
    return $btw * $adviesPrijs / 100 + $adviesPrijs;
}

function getCountry($databaseConnection) {
    $Query = "
            SELECT CountryID, CountryName
            FROM Countries 
            ORDER BY CountryName ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    return mysqli_fetch_all($Result, MYSQLI_ASSOC);
}

function addKlant($vNaam, $aNaam, $email, $telefoon, $databaseConnection){
    $Query = "
            INSERT INTO webshop_klant (voornaam, achternaam, email, telefoonnummer)
            VALUES (?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssss", $vNaam, $aNaam, $email, $telefoon);
    mysqli_stmt_execute($Statement);
}

function addOrder($klantID, $land, $adress, $postcode, $stad, $databaseConnection){
    $Query = "
            INSERT INTO webshop_order (klantID, land, straat, postcode, stad)
            VALUES (?, ?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "sssss", $klantID, $land, $adress, $postcode, $stad);
    mysqli_stmt_execute($Statement);
}

function addOrderregel($orderID, $artikelID, $aantal, $bedrag, $databaseConnection){
    $Query = "
            INSERT INTO webshop_orderregel (orderID, artikelID, aantal, bedrag)
            VALUES (?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssid", $orderID, $artikelID, $aantal, $bedrag);
    mysqli_stmt_execute($Statement);
}
function removeStock($stockID, $aantal, $databaseConnection){
    $Query = "
            UPDATE stockitemholdings
            SET QuantityOnHand = (QuantityOnHand - ?)
            WHERE StockItemID = ?";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ii", $aantal, $stockID);
    mysqli_stmt_execute($Statement);
}
function findKlant($databaseConnection){
    $Query = "
            SELECT max(klantID)
            FROM webshop_klant";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $klantID = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $klantID;
}
function findOrder($databaseConnection){
    $Query = "
            SELECT max(OrderID)
            FROM webshop_order";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $orderID = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $orderID;
}