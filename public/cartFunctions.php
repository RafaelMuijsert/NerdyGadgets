<?php
if (!isset($_SESSION)) {
    session_start();
}

function getCart()
{
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    } else {
        $cart = array();                                //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                                       // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart)
{
    $_SESSION["cart"] = $cart;                          // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addItem($stockItemID)
{
    $cart = getCart();                                  // eerst de huidige cart ophalen
    if (array_key_exists($stockItemID, $cart)) {        //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                       //zo ja: aantal met 1 verhogen
    } else {
        $cart[$stockItemID] = 1;                        //zo nee: key toevoegen en aantal op 1 zetten.
    }
    saveCart($cart);
}

function removeItem($stockItemID, $deleteAll = false)
{
    $cart = getCart();
    if(!array_key_exists($stockItemID, $cart)) {        // Item niet in winkelmand verwidjeren? return niks
        return;
    }
    if ($cart[$stockItemID] <= 1 || $deleteAll) {       // Kijkt of er nog 1 over is of als deleteAll is meegebracht
        unset($cart[$stockItemID]);                     // Verwijder item uit sessie
    } else {
        $cart[$stockItemID]--;                          //  Aantal items -1
    }
    saveCart($cart);
}
