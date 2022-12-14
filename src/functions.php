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

function addKlant($firstname, $prefixName, $surname, $birthdate, $email, $phonenumber, $databaseConnection){
    $Query = "
            INSERT INTO webshop_klant (voornaam, tussenvoegsel, achternaam, geboortedatum, email, telefoonnummer)
            VALUES (?, ?, ?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssss", $firstname, $prefixName, $surname, $birthdate, $email, $phonenumber);
    mysqli_stmt_execute($Statement);
}

function addOrder($klantID, $land, $street, $housenumber, $postcode, $stad, $comment, $databaseConnection){
    $Query = "
            INSERT INTO webshop_order (klantID, straat, postcode, stad, land, huisnummer, opmerkingen)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "sssssss", $klantID, $street, $postcode, $stad, $land, $housenumber, $comment);
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

function getTotalPrice() {
    foreach ($_SESSION['cart'] as $id => $quantity):
        $total = 0;
        $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
        $price = round($stockItem['SellPrice'], 2);
        $total += $price * $quantity;
    endforeach;
    return $total;
}
function getKortingcode($kortingscode, $databaseConnection){
    $Querry =  "
            SELECT procent, stockgroup, geldigtot
            FROM kortingcodes
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, "s", $kortingscode);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $korting =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $korting;
}
function checkDatum($kortingscode, $databaseConnection){
    $Querry = "
            SELECT geldigtot
            FROM kortingcodes
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement,'s', $kortingscode);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $geldigTot = mysqli_fetch_all($result, MYSQLI_ASSOC)[0]['geldigtot'];
    if ($geldigTot == NULL){
        return true;
    }
    else {
        $datum = date("Y-m-d");
        return (strtotime($geldigTot) > strtotime($datum));
    }
}