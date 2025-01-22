<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "shop");

// Funkcje do zarządzania koszykiem
function addToCart($productId, $name, $netPrice, $vat, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $grossPrice = $netPrice * (1 + $vat / 100);
        $_SESSION['cart'][$productId] = [
            'name' => $name,
            'net_price' => $netPrice,
            'vat' => $vat,
            'gross_price' => $grossPrice,
            'quantity' => $quantity,
        ];
    }
}

// Usuń produkt z koszyka
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Zaktualizuj ilość produktu w koszyku
function updateCart($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    }
}

// Wyczyść koszyk
function clearCart() {
    unset($_SESSION['cart']);
}

// Pobierz szczegóły koszyka
function getCartDetails() {
    return $_SESSION['cart'] ?? [];
}

// Oblicz całkowitą wartość koszyka
function getTotalCartValue() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total += $product['gross_price'] * $product['quantity'];
        }
    }
    return $total;
}

// Obsługa żądań POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add':
            addToCart($_POST['productId'], $_POST['name'], $_POST['netPrice'], $_POST['vat'], $_POST['quantity']);
            break;
        case 'remove':
            removeFromCart($_POST['productId']);
            break;
        case 'update':
            updateCart($_POST['productId'], $_POST['quantity']);
            break;
        case 'clear':
            clearCart();
            break;
    }

    header("Location: ../pages/index.php?idp=cart");
    exit();
}
?>
