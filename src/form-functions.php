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
    Filter Postal Zip code
*/
function filterPostalZip($postal){
    return strtoupper(trim($postal));
}