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

function findCustomer($databaseConnection){
    $Query = "
            SELECT max(klantID)
            FROM webshop_klant";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $klantID = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return ($klantID[0]['max(klantID)']);
}

function findOrder($databaseConnection){
    $Query = "
            SELECT max(OrderID)
            FROM webshop_order";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $orderID = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return ($orderID[0]['max(OrderID)']);
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

function createUser($email, $password, $firstname, $prefixName, $surname, $birthDate, $phone, $street, $housenumber, $postcode, $city, $databaseConnection, $lgn, $pwd, $newsletter) {

    try {
        $Query = "
                    INSERT INTO webshop_user (id, email, password, voornaam, tussenvoegsel, achternaam, geboortedatum, telefoonnummer, stad, straat, huisnummer, postcode, mailinglist)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param(
            $Statement,
            "sssssssssssss",
            $userID,
            $email, $password, $firstname, $prefixName, $surname, $birthDate, $phone, $city, $street, $housenumber, $postcode, $newsletter
        );
        mysqli_stmt_execute($Statement);

        loginUser($lgn, $pwd, $databaseConnection);
    } catch (mysqli_sql_exception $e) {
        error_log($e->getMessage());
//        print $e;
        print ("Er is iets fout gegaan! Check alle gegevens opnieuw!");
    }

}


/*
 *  Remove SQL vulnerability
 * */
function sqlInjection($value) {
    if (str_contains($value, "'") || str_contains($value, '"')) {
        return true;
    }

    return false;
}

/*
    Check input fields for correct data
*/
function inputcheck($sessionArray, $formName) {

    if($formName == 'register') {
        if (sqlInjection($_SESSION[$sessionArray]['password']) || isset($_SESSION[$sessionArray]['password']) && strlen($_SESSION[$sessionArray]['password']) < 8) {
            print("Wachtwoord mag niet leeg zijn en moet langer dan 8 karakters lang zijn!");
            return false;
        }
    } elseif ($formName == 'order') {
        if (isset($_SESSION[$sessionArray]['comment']) && strpos($_SESSION[$sessionArray]['comment'], "<") !== false) {
            print("Opmerking is niet correct ingevuld!");
            return false;
        }
    } elseif ($formName == 'order' | $formName =='register') {
        if (sqlInjection($_SESSION[$sessionArray]['email']) || isset($_SESSION[$sessionArray]['email']) && !filter_var($_SESSION[$sessionArray]['email'], FILTER_VALIDATE_EMAIL)) {
            print("Emailadres is niet correct ingevuld!");
            return false;
        }
    }

    $postcode = filterPostalZip($_SESSION[$sessionArray]['postcode']);

    if (sqlInjection($_SESSION[$sessionArray]['firstname']) || preg_match('/[0-9\/\\<>]/', $_SESSION[$sessionArray]['firstname'])) {
        print("Voornaam is niet correct ingevuld!");
        return false;
    } elseif (sqlInjection($_SESSION[$sessionArray]['prefixName']) || preg_match('/[0-9\/\\<>]/', $_SESSION[$sessionArray]['prefixName'])) {
        print("Tussenvoegsel is niet correct ingevuld!");
        return false;
    } elseif (sqlInjection($_SESSION[$sessionArray]['surname']) || preg_match('/[0-9\/\\<>]/', $_SESSION[$sessionArray]['surname'])) {
        print("Achternaam is niet correct ingevuld!");
        return false;
    } elseif (validate_phone_number($_SESSION[$sessionArray]['phone'])) {
        print("Telefoonnummer is niet correct ingevuld!");
        return false;
    } elseif (sqlInjection($_SESSION[$sessionArray]['street']) || preg_match('/[0-9\/\\<>]/', $_SESSION[$sessionArray]['street'])) {
        print("Straatnaam is niet correct ingevuld!");
        return false;
    } elseif (sqlInjection($_SESSION[$sessionArray]['housenumber']) || !preg_match('/^[0-9]{1,3}[a-zA-Z]?$/', $_SESSION[$sessionArray]['housenumber'])) {
        print("Huisnummer is niet correct ingevuld!");
        return false;
    }
    elseif(sqlInjection($postcode) || !preg_match("/^[1-9][0-9]{3} (?!SA|SD|SS)[a-zA-Z]{2}$/", $postcode)) {
        print("Postcode is niet correct ingevuld!");
        return false;
    }
    elseif (sqlInjection($_SESSION[$sessionArray]['city']) || preg_match('/[0-9\/\\<>]/', $_SESSION[$sessionArray]['city'])) {
        print("Stad is niet correct ingevuld!");
        return false;
    }

    if(empty($_SESSION[$sessionArray]['birthDate'])) {
        $_SESSION[$sessionArray]['birthDate'] = NULL;
    }

    if(empty($_SESSION[$sessionArray]['phone'])) {
        $_SESSION[$sessionArray]['phone'] = NULL;
    }

    if(!isset($_SESSION[$sessionArray]['mailinglist']) || empty($_SESSION[$sessionArray]['mailinglist'])) {
        $_SESSION[$sessionArray]['mailinglist'] = 0;
    }

//    var_dump($_SESSION[$sessionArray]);

    return true;
}

function maillistaccount($email, $firstname, $prefixName, $surname, $databaseConnection){
    try {
        $Query = "
                    INSERT INTO webshop_mailinglist (id, email, voornaam, tussenvoegsel, achternaam)
                    VALUES (?, ?, ?, ?, ?)";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param(
            $Statement,
            "sssss",
            $userID,
            $email, $firstname, $prefixName, $surname
        );
        mysqli_stmt_execute($Statement);
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
    return mysqli_stmt_execute($Statement);
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
/*
    Get all orders from one account
*/
function getOrderHistory($userID, $conn) {
    $Query = "
                SELECT * 
                FROM webshop_order AS O 
                JOIN webshop_orderregel AS R ON O.OrderID=R.OrderID 
                JOIN stockitems AS A ON A.StockItemID=R.ArtikelID
                LEFT JOIN stockitemimages AS I ON I.StockItemID=A.StockItemID
                WHERE userID = '$userID'
                GROUP BY O.OrderID, ArtikelID
                ORDER BY datum DESC";
    $smt = mysqli_prepare($conn, $Query);
    mysqli_stmt_execute($smt);
    $result = mysqli_stmt_get_result($smt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}

/*
    Get the date difference between today dnd the
    date wen the order was placed
*/
function getOrderStatus($date) {
    $today = new DateTime();
    $orderDate = new DateTime($date);

    $diff = $today->diff($orderDate);
    $diffFormatted = $diff->format("%a");

    if ($diffFormatted >= 2):
        return "Bezorgd";
    else:
        return "Bestelling wordt verwerkt";
    endif;
}

/*
    Load user data in advance
*/
function loadUserData($username, $conn) {
    $_SESSION['account'] = [];
    $Query = "SELECT * FROM webshop_user WHERE email = '$username'";
    $statement = mysqli_prepare($conn, $Query);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['account'] = $data[0];

    if($_SESSION['account']['role'] == 'Admin') {
        $isAdmin = true;
    }
}

/*
    Login user and redirect to profile page
*/
function loginUser($username, $password, $conn) {

    // SQL injection proof
    $usernameCheck = str_contains($username, '"') || str_contains($username, "'");
    $pwdCheck = str_contains($password, '"') || str_contains($password, "'");

    if (!$usernameCheck && !$pwdCheck) {

        // Setup Query
        $Query = "SELECT password FROM webshop_user WHERE email = '$username'";
        $statement = mysqli_prepare($conn, $Query);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(password_verify($password, $data[0]['password'])) {
            loadUserData($username, $conn);
            $_SESSION['isLoggedIn'] = true;
            unset($_SESSION['login']);
            unset($_SESSION['registration']);
            echo "<script>window.location.replace('./account.php')</script>";
            return 1;
        } else {
            echo "<a style='color: red'><p>Gebruikersnaam of wachtwoord is incorrect, probeer het nog een keer.</p></p></a>";
            return 0;
        }
    }

    echo "<a style='color: red'><p>Gebruikersnaam of wachtwoord is incorrect, probeer het nog een keer.</p></p></a>";
    return 0;
}

function editUser($firstname, $prefixName, $surname, $birthDate, $phone, $street, $housenumber, $postcode, $city, $userID, $mailinglist, $conn) {
    try {
        $stmt = $conn->prepare("UPDATE webshop_user SET voornaam = ?, tussenvoegsel = ?, achternaam = ?, geboortedatum = ?, telefoonnummer = ?, stad = ?, straat = ?, huisnummer = ?, postcode = ?, mailinglist = ? WHERE id = ?");
        $stmt->bind_param("sssssssssss", $firstname, $prefixName, $surname, $birthDate, $phone, $city, $street, $housenumber, $postcode, $mailinglist, $userID);
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        echo "<a style='color: red'><p>De aangepaste gegevens voldoen niet aan de gewenste eisen. Vul de velden opnieuw in.</p></p></a>";
                        print("<p>$e</p>");
    }
}

function getUser($userID, $databaseConnection) {
    $query = "SELECT * FROM webshop_user WHERE id = '$userID'";
    $stmt = mysqli_prepare($databaseConnection, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllUsers($databaseConnection) {
    $query = "SELECT * FROM webshop_user";
    $stmt = mysqli_prepare($databaseConnection, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function deleteUser($userID, $databaseConnection) {
    $query = "DELETE FROM webshop_user WHERE id = '$userID'";
    $stmt = mysqli_prepare($databaseConnection, $query);
    mysqli_stmt_execute($stmt);
}


function addCustomer($databaseConnection){
    $Query = "
            INSERT INTO webshop_klant (voornaam, tussenvoegsel, achternaam, geboortedatum, email, telefoonnummer)
            VALUES (?, ?, ?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssss",
        $_SESSION['userinfo']['firstname'],
        $_SESSION['userinfo']['prefixName'],
        $_SESSION['userinfo']['surname'],
        $_SESSION['userinfo']['birthDate'],
        $_SESSION['userinfo']['email'],
        $_SESSION['userinfo']['phone']);
    return mysqli_stmt_execute($Statement);
}

function addOrder ($customerID, $userID, $databaseConnection){
    var_dump($_SESSION['userinfo']['postcode']);
    $Query = "
            INSERT INTO webshop_order (klantID, straat, postcode, stad, land, huisnummer, opmerkingen, userID)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssssss",
        $customerID,
        $_SESSION['userinfo']['street'],
        $_SESSION['userinfo']['postcode'],
        $_SESSION['userinfo']['city'],
        $_SESSION['userinfo']['country'],
        $_SESSION['userinfo']['housenumber'],
        $_SESSION['userinfo']['comment'],
        $userID);
    return mysqli_stmt_execute($Statement);
}

function addOrderLine($orderID, $databaseConnection) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $total = 0;
        $factor = 1;
        $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
        $price = round($stockItem['SellPrice'], 2);
        if (isset($_SESSION['korting'][0]['procent'])) {
            $factor = (1 - ($_SESSION['korting'][0]['procent'] * 0.01));
            $procent = $_SESSION['korting'][0]['procent'];
        } else $procent = NULL;
        $total += round(($price * $factor), 2) * $quantity;
        $Query = "
                INSERT INTO webshop_orderregel (orderID, artikelID, aantal, bedrag, procentKorting)
                VALUES (?, ?, ?, ?, ?)";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param($Statement, "ssidd", $orderID, $id, $quantity, $total, $procent);
        return mysqli_stmt_execute($Statement);
    }
}

function itemStockUpdate ($databaseConnection){
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $Query = "
                UPDATE stockitemholdings
                SET QuantityOnHand = (QuantityOnHand - ?)
                WHERE StockItemID = ?";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param($Statement, "ii", $quantity, $id);
        return mysqli_stmt_execute($Statement);
    }
}

function processOrder ($userID ,$databaseConnection){
    //------------------- Indien gedoe, uncomment hier onder en onderaan de functie voor testen -------------------
//    $Query = "SET foreign_key_checks = 0";
//    $stmt = mysqli_prepare($databaseConnection, $Query);
//    mysqli_stmt_execute($stmt);

    mysqli_begin_transaction($databaseConnection);

    // Hier onder wordt eerst de klant aangemaakt
    if (!addCustomer($databaseConnection)){
        mysqli_rollback($databaseConnection);
        return;
    }

    $customerID = findCustomer($databaseConnection);

    // Hier wordt vervolgens de Order aangemaakt
    if (!addOrder($customerID, $userID, $databaseConnection)) {
        mysqli_rollback($databaseConnection);
        return;
    }

    $orderID = findOrder($databaseConnection);
    // Hier worden de orderregels aangemaakt
    if (!addOrderLine($orderID, $databaseConnection)) {
        mysqli_rollback($databaseConnection);
        return;
    }

    // Hier worden de opslag aangepast
    if (!itemStockUpdate($databaseConnection)) {
        mysqli_rollback($databaseConnection);
        return;
    }

    // Hier wordt de kortingscode behandeld
    if (isset($_SESSION['korting'][0]['uses']) && $_SESSION['korting'][0]['uses'] > 0){
        if (!reduceUses($_SESSION['korting']['naam'], $databaseConnection)){
            mysqli_rollback($databaseConnection);
            return;
        }
    }
    unset($_SESSION['korting']);

    mysqli_commit($databaseConnection);

    // ------------------- Enable voor testen -------------------
//    $Query = "SET foreign_key_checks = 1";
//    $stmt = mysqli_prepare($databaseConnection, $Query);
//    mysqli_stmt_execute($stmt);
}
