<?php
function getVoorraadTekst($actueleVoorraad) {
    if ($actueleVoorraad > 1000) {
        return "Ruime voorraad beschikbaar.";
    } else {
        return "Voorraad: $actueleVoorraad";
    }
}

function calculateSellPrice($adviesPrijs, $btw) {
    return $btw * $adviesPrijs / 100 + $adviesPrijs;
}

function addCustomer($firstname, $prefixName, $surname, $birthdate, $email, $phonenumber, $databaseConnection){
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

function addOrderLine($orderID, $artikelID, $aantal, $bedrag, $korting, $databaseConnection){
    $Query = "
            INSERT INTO webshop_orderregel (orderID, artikelID, aantal, bedrag, procentKorting)
            VALUES (?, ?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssidd", $orderID, $artikelID, $aantal, $bedrag, $korting);
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

function findCustomer($databaseConnection){
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
function getDiscountCode($kortingscode, $databaseConnection){
    $Querry =  "
            SELECT procent, geldigtot, uses
            FROM webshop_kortingscodes
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, "s", $kortingscode);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $korting =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $korting;
}

function checkCodeDate($kortingscode, $databaseConnection) {
    $Querry = "
            SELECT geldigtot
            FROM webshop_kortingscodes
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement,'s', $kortingscode);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $geldigTot = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (($geldigTot == NULL) || ($geldigTot[0]['geldigtot'] == '')){
        return true;
    }
    else {
        $datum = date("Y-m-d");
        return (strtotime($geldigTot[0]['geldigtot']) > strtotime($datum));
    }
}

function createUser($email, $password, $firstname, $prefixName, $surname, $birthDate, $phone, $street, $housenumber, $postcode, $city, $databaseConnection, $lgn, $pwd) {

    try {
        $Query = "
                    INSERT INTO webshop_user (id, email, password, voornaam, tussenvoegsel, achternaam, geboortedatum, telefoonnummer, stad, straat, huisnummer, postcode)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param(
            $Statement,
            "ssssssssssss",
            $userID,
            $email, $password, $firstname, $prefixName, $surname, $birthDate, $phone, $city, $street, $housenumber, $postcode
        );
        mysqli_stmt_execute($Statement);

        loginUser($lgn, $pwd, $databaseConnection);
    } catch (mysqli_sql_exception $e) {
        print("Ongeldig e-mailadres");
    }

}
function checkUses($kortingscode, $databaseConnection){
    $Querry = "
            SELECT uses
            FROM webshop_kortingscodes
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement,'s', $kortingscode);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    $uses = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if ($uses == NULL || $uses[0]['uses'] === NULL || ($uses[0]['uses'] > 0 )){
        return TRUE;
    }

    return FALSE;
}

function reduceUses($kortingscode, $databaseConnection){
    $Querry = "
            UPDATE webshop_kortingscodes
            SET uses = uses - 1
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, 's', $kortingscode);
    mysqli_stmt_execute($Statement);
}
function discountCodes($databaseConnection){
    $Querry = "
            SELECT * FROM webshop_kortingscodes";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function removeDiscountCodes($kortingID, $databaseConnection){
    $Querry = "
            DELETE FROM webshop_kortingscodes
            WHERE kortingID = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, "s", $kortingID);
    mysqli_stmt_execute($Statement);
}
function addDiscountCode($naam, $procent, $geldigtot, $uses, $databaseConnection){
    $Querry = "
            INSERT INTO webshop_kortingscodes(codenaam, procent, geldigtot, uses)
            VALUES (?,?,?,?)";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, 'sdsi', $naam, $procent, $geldigtot, $uses);
    mysqli_stmt_execute($Statement);
}
function updateDiscountCode($naam, $procent, $geldigtot, $uses, $databaseConnection){
    $Querry = "
            UPDATE webshop_kortingscodes
            SET procent = ?, geldigtot = ?, uses = ?
            WHERE codenaam = ?";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, 'dsis',  $procent, $geldigtot, $uses, $naam);
    mysqli_stmt_execute($Statement);
}
function getDeliverycosts ($databaseConnection){
    $Querry = "
            SELECT instellingNaam, aantal
            FROM webshop_admininstellingen";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_execute($Statement);
    $result = mysqli_stmt_get_result($Statement);
    return mysqli_fetch_all($result);
}

function updateDeliveryLimit ($deliveryLimit, $databaseConnection){
    $Querry = "
            UPDATE webshop_admininstellingen
            SET aantal = ?
            WHERE instellingNaam = 'verzendKostenGrens'";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, 'd', $deliveryLimit);
    mysqli_stmt_execute($Statement);
}
function updateDeliveryCosts ($deliveryCosts, $databaseConnection){
    $Querry = "
            UPDATE webshop_admininstellingen
            SET aantal = ?
            WHERE instellingNaam = 'verzendKostenAantal'";
    $Statement = mysqli_prepare($databaseConnection, $Querry);
    mysqli_stmt_bind_param($Statement, 'd', $deliveryCosts);
    mysqli_stmt_execute($Statement);
}