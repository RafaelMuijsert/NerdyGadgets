<?php

//function loadUserData($username, $conn) {
//    $_SESSION['account'] = [];
//    $Query = "SELECT * FROM webshop_user WHERE email = ?";
//    $statement = mysqli_prepare($conn, $Query);
//    mysqli_stmt_bind_param($statement, 's', $username);
//    mysqli_stmt_execute($statement);
//    $result = mysqli_stmt_get_result($statement);
//    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
//    $_SESSION['account'] = $data[0];
//
//    if($_SESSION['account']['role'] == 'Admin') {
//        $isAdmin = true;
//    }
//}


//function editmail($mailinglist, $conn) {
//
//    $username = '';
//    if(isset($_SESSION['account']['email'])) {
//        $username = $_SESSION['account']['email'];
//    }
//
//    $_SESSION['account'] = [];
//        $Query = "UPDATE $mailinglist SET Mailinglist = '1' WHERE ?";
//        $statement = mysqli_prepare($conn, $Query);
//    mysqli_stmt_bind_param($statement, 's', $username);
//        mysqli_stmt_execute($statement);
//        $result = mysqli_stmt_get_result($statement);
//        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
//        $_SESSION['account'] = $data[0];
//
//        if($_SESSION['account']['role'] == 'Admin') {
//            $isAdmin = true;
//        }
//    }
?>