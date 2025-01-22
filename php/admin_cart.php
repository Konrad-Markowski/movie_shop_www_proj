<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "shop");

// Funkcja do sprawdzania stanu magazynowego produktu
function getStockQuantity($productId) {
    global $mysqli;
    $query = $mysqli->prepare("SELECT stock_quantity FROM products WHERE id = ?");
    $query->bind_param("i", $productId);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    return $row['stock_quantity'] ?? 0;
}

// Funkcja do zarządzania koszykiem: Dodawanie produktu
function addToCart($productId, $name, $netPrice, $vat, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $stockQuantity = getStockQuantity($productId);
    $currentQuantity = $_SESSION['cart'][$productId]['quantity'] ?? 0;
    $newQuantity = $currentQuantity + $quantity;

    if ($newQuantity > $stockQuantity) {
        $newQuantity = $stockQuantity; // Ogranicz ilość do dostępnego stanu magazynowego
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
    } else {
        $grossPrice = $netPrice * (1 + $vat / 100);
        $_SESSION['cart'][$productId] = [
            'name' => $name,
            'net_price' => $netPrice,
            'vat' => $vat,
            'gross_price' => $grossPrice,
            'quantity' => $newQuantity,
        ];
    }
}

// Funkcja do usuwania produktu z koszyka
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Funkcja do aktualizacji ilości w koszyku
function updateCart($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        $stockQuantity = getStockQuantity($productId);
        if ($quantity > $stockQuantity) {
            $quantity = $stockQuantity; // Ogranicz ilość do dostępnego stanu magazynowego
        }
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    }
}

// Funkcja do czyszczenia koszyka
function clearCart() {
    unset($_SESSION['cart']);
}

// Funkcja do pobrania szczegółów koszyka
function getCartDetails() {
    return $_SESSION['cart'] ?? [];
}

// Funkcja do obliczenia całkowitej wartości koszyka
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
            addToCart(
                $_POST['productId'],
                $_POST['name'],
                $_POST['netPrice'],
                $_POST['vat'],
                $_POST['quantity']
            );
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
