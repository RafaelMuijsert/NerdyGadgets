<?php
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


//function loginUser($username, $password, $conn) {
//    $Query = "SELECT password FROM webshop_user WHERE email = '$username'";
//    $statement = mysqli_prepare($conn, $Query);
//    mysqli_stmt_execute($statement);
//    $result = mysqli_stmt_get_result($statement);
//    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
//
//    if(password_verify($password, $data[0]['password'])) {
//        loadUserData($username, $conn);
//        $_SESSION['isLoggedIn'] = true;
//        unset($_SESSION['login']);
//        unset($_SESSION['registration']);
//        echo "<script>window.location.replace('./account.php')</script>";
//    } else {
//        echo "<a style='color: red'>Gebruikersnaam of wachtwoord is incorrect, probeer het nog een keer.</a>";
//    }
//
//}

function loginUser($username, $password, $conn) {

    // Block SQL Injection
    $username = str_replace("'", "", $username);
    $username = str_replace('"', '', $username);

    $password = str_replace("'", "", $password);
    $password = str_replace('"', '', $password);

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
    } else {
        echo "<a style='color: red'><p>Gebruikersnaam of wachtwoord is incorrect, probeer het nog een keer.</p></p></a>";
    }

}

/*
    Validate User emailadres input
*/
function validate_email($email) {
    // Check if the email address is in a valid format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Split the email address into local and domain parts
    list($local, $domain) = explode("@", $email, 2);

    // Check if the local part and domain part are not empty
    if (empty($local) || empty($domain)) {
        return false;
    }

    // Check if the domain part contains at least one dot (.)
    if (strpos($domain, ".") === false) {
        return false;
    }

    // Check if the domain part contains only letters, digits, and hyphens
    if (!preg_match("/^[A-Za-z0-9-]*$/", $domain)) {
        return false;
    }

    return true;
}

/*
    Validate User mobile phone input
*/
function validate_phone_number($phone) {
    // Remove any non-numeric characters from the phone number
    $phone = preg_replace("/[^0-9]/", "", $phone);

    // Check if the phone number is at least 10 digits long
    if (strlen($phone) < 10) {
        return false;
    }

    // Check if the phone number starts with a valid country code (31)
    if (substr($phone, 0, 2) != "31") {
        return false;
    }

    // Check if the phone number has a valid area code (2-9)
    if (!in_array(substr($phone, 2, 1), array("2", "3", "4", "5", "6", "7", "8", "9"))) {
        return false;
    }

    return true;
}

/*
    Check input fields for correct data
*/
function inputcheck($sessionArray) {

    if (!preg_match('/^[0-9]{1,3}[a-zA-Z]?$/', $_SESSION[$sessionArray]['housenumber'])) {
        print("Huisnummer is niet correct ingevuld!");
        return false;
    } elseif(!preg_match('/^[0-9]{4}[a-zA-Z]{2}$/', $_SESSION[$sessionArray]['postcode'])) {
        print("Postcode is niet correct ingevuld!");
        return false;
    } elseif (!ctype_alpha($_SESSION[$sessionArray]['street'])) {
        print("Straatnaam is niet correct ingevuld!");
        return false;
    } elseif (isset($_SESSION[$sessionArray]['email']) && validate_email($_SESSION[$sessionArray]['email'])) {
        print("Emailadres is niet correct ingevuld!");
        return false;
    } elseif (validate_phone_number($_SESSION[$sessionArray]['phone'])) {
        print("Telefoonnummer is niet correct ingevuld!");
        return false;
    } elseif (isset($_SESSION[$sessionArray]['password']) && strlen($_SESSION[$sessionArray]['password']) < 8) {
        print("Wachtwoord mag niet leeg zijn en moet langer dan 8 karakters lang zijn!");
        return false;
    }

    return true;
}