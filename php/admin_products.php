<?php
include_once 'cfg.php';

// Funkcje do zarządzania produktami
function DodajProdukt($title, $description, $category_id, $price_net, $vat_tax, $stock_quantity, $image_path) {
    global $mysqli;

    // Sprawdzenie, czy kategoria istnieje
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM kategorie WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $stmt->bind_result($category_exists);
    $stmt->fetch();
    $stmt->close();

    if ($category_exists == 0) {
        die("Kategoria o ID '$category_id' nie istnieje.");
    }

    // Ustawienie availability_status
    $availability_status = $stock_quantity > 0 ? 1 : 0;

    // Dodanie produktu
    $stmt = $mysqli->prepare("INSERT INTO products (title, description, category_id, price_net, vat_tax, stock_quantity, availability_status, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdiiis", $title, $description, $category_id, $price_net, $vat_tax, $stock_quantity, $availability_status, $image_path);
    $stmt->execute();
    $stmt->close();
}

function UsunProdukt($product_id) {
    global $mysqli;

    // Zapytanie SQL do usunięcia produktu na podstawie jego id
    $stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
}

function EdytujProdukt($id, $title, $description, $category_id, $price_net, $vat_tax, $stock_quantity, $image_path) {
    global $mysqli;

    // Sprawdzenie, czy kategoria istnieje
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM kategorie WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $stmt->bind_result($category_exists);
    $stmt->fetch();
    $stmt->close();

    if ($category_exists == 0) {
        die("Kategoria o ID '$category_id' nie istnieje.");
    }

    // Pobranie obecnej ilości w magazynie
    $stmt = $mysqli->prepare("SELECT stock_quantity FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($current_stock_quantity);
    $stmt->fetch();
    $stmt->close();

    // Jeśli pole dla ilości jest puste, zachowujemy bieżącą wartość
    if ($stock_quantity === '') {
        $stock_quantity = $current_stock_quantity;
    }

    // Ustawienie availability_status na podstawie nowej ilości
    $availability_status = $stock_quantity > 0 ? 1 : 0;

    // Aktualizacja produktu z uwzględnieniem zmiany kategorii
    $stmt = $mysqli->prepare("UPDATE products SET title = ?, description = ?, category_id = ?, price_net = ?, vat_tax = ?, stock_quantity = ?, availability_status = ?, image_path = ? WHERE id = ?");
    $stmt->bind_param("sssdiiisi", $title, $description, $category_id, $price_net, $vat_tax, $stock_quantity, $availability_status, $image_path, $id);
    $stmt->execute();
    $stmt->close();
}

function PokazProdukty($category_id = null) {
    global $mysqli;

    if ($category_id) {
        $stmt = $mysqli->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->bind_param("i", $category_id);
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM products");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<p>Cena netto: " . number_format($row['price_net'], 2) . " PLN</p>";
        echo "<p>VAT: " . $row['vat_tax'] . "%</p>";
        echo "<p>Cena brutto: " . number_format($row['price_net'] * (1 + $row['vat_tax'] / 100), 2) . " PLN</p>";
        echo "<p>Ilość dostępna: " . $row['stock_quantity'] . "</p>";
        echo "<form method='POST' action='admin_products.php' style='display: inline;'>
                <input type='hidden' name='productId' value='" . $row['id'] . "'>
                <input type='hidden' name='action' value='EdytujProdukt'>
                <input type='text' name='title' value='" . htmlspecialchars($row['title']) . "' required>
                <textarea name='description'>" . htmlspecialchars($row['description']) . "</textarea>
                <input type='number' name='price_net' value='" . $row['price_net'] . "' step='0.01' required>
                <input type='number' name='vat_tax' value='" . $row['vat_tax'] . "' step='0.01' required>
                <input type='number' name='stock_quantity' value='" . $row['stock_quantity'] . "' required>
                <button type='submit'>Edytuj</button>
              </form>";
        echo "<form method='POST' action='admin_products.php' style='display: inline;'>
                <input type='hidden' name='productId' value='" . $row['id'] . "'>
                <input type='hidden' name='action' value='UsunProdukt'>
                <button type='submit'>Usuń</button>
              </form>";
        echo "</li>";
    }

    $stmt->close();
}

// Obsługa żądań POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    switch ($action) {
        case 'DodajProdukt':
            if (isset($_POST['productName'], $_POST['productDescription'], $_POST['productCategory'], $_POST['productPrice'], $_POST['productVat'], $_POST['productStock'])) {
                DodajProdukt($_POST['productName'], $_POST['productDescription'], $_POST['productCategory'], $_POST['productPrice'], $_POST['productVat'], $_POST['productStock'], $_POST['productImage']);
                header("Location: ../pages/index.php?idp=admin_panel");
                exit();
            } else {
                echo "Brakujące dane produktu.";
            }
            break;
        case 'UsunProdukt':
            if (isset($_POST['productId'])) {
                UsunProdukt($_POST['productId']);
                header("Location: ../pages/index.php?idp=admin_panel");
                exit();
            }
            break;
        case 'EdytujProdukt':
            if (isset($_POST['productId'], $_POST['title'], $_POST['description'], $_POST['productCategory'], $_POST['price_net'], $_POST['vat_tax'], $_POST['stock_quantity'])) {
                EdytujProdukt($_POST['productId'], $_POST['title'], $_POST['description'], $_POST['productCategory'], $_POST['price_net'], $_POST['vat_tax'], $_POST['stock_quantity'], $_POST['image_path']);
                header("Location: ../pages/index.php?idp=admin_panel");
                exit();
            }
            break;
    }
}
?>
