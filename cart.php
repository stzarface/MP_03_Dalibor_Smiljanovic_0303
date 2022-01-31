<?php 

include_once('./initdb.php');
session_start();

class Korpa {
    function __construct() {
        if(!isset($_SESSION['item_cart'])) { 
            $_SESSION['item_cart'] = [];
            $_SESSION['cart_total'] = 0;
        }
    }

    function dodajUKorpu($id, $naziv, $price, $amount) {
        if(isset($_SESSION['item_cart'][$id])) {
            $_SESSION['item_cart'][$id]['amount'] += $amount;
        } else {
            $_SESSION['item_cart'][$id] = [];
            $_SESSION['item_cart'][$id]['amount'] = $amount;
            $_SESSION['item_cart'][$id]['naziv'] = $naziv;
        }
        if(!isset($_SESSION['cart_total'])){
            $_SESSION['cart_total'] = 0;
        }
        $_SESSION['cart_total'] += $price;
    }

    function listajKorpu() {
        foreach ($_SESSION['item_cart'] as $id => $item) {
            $naziv = $item['naziv'];
            $amount = $item['amount'];
            echo "Stavka $naziv je u korpi $amount puta<br>";
        }

        echo "Ukupna vrednost Vase porudzbine je: " . $_SESSION['cart_total'] . " dinara.";
    }


    function isprazniKorpu() {
        $_SESSION['item_cart'] = [];
        $_SESSION['cart_total'] = 0;
    }
}


$korpa = new Korpa();

?>