<?php
include '../php/admin_products.php'; // Upewnij się, że ścieżka jest poprawna
session_start();
?>
<h2>Lista filmów</h2>
<?php
$mysqli = new mysqli("localhost", "root", "", "shop");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM products");
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $gross_price = $row['price_net'] + ($row['price_net'] * $row['vat_tax'] / 100);
        echo "<li>";
        echo "ID: " . $row['id'] . "<br>";
        echo "Tytuł: " . $row['title'] . "<br>";
        echo "Opis: " . $row['description'] . "<br>";
        echo "ID kategorii: " . $row['category_id'] . "<br>";
        echo "Cena netto: " . $row['price_net'] . "<br>";
        echo "VAT: " . $row['vat_tax'] . "<br>";
        echo "Cena brutto: " . $gross_price . "<br>";
        echo "Stan: " . $row['stock_quantity'] . "<br>";

        // Dodaj przycisk do dodawania produktu do koszyka
        echo "<form method='POST' action='../php/admin_cart.php'>";
        echo "<input type='hidden' name='action' value='add'>";
        echo "<input type='hidden' name='productId' value='" . $row['id'] . "'>";
        echo "<input type='hidden' name='name' value='" . htmlspecialchars($row['title']) . "'>";
        echo "<input type='hidden' name='netPrice' value='" . $row['price_net'] . "'>";
        echo "<input type='hidden' name='vat' value='" . $row['vat_tax'] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1' max='" . $row['stock_quantity'] . "'>";
        echo "<button type='submit'>Dodaj do koszyka</button>";
        echo "</form>";

        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Brak filmów.";
}

$mysqli->close();
?>
