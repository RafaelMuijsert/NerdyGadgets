<?php
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
        return true;
    }

    return false;
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
    } else {
        return true;
    }

}

function filterPostalzip($postal) {
    $postalCAP = strtoupper($postal);
    $postalClean = str_replace(' ', '', $postalCAP);
    return $postalClean;
}