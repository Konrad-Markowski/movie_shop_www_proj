<?php
include '../php/admin_products.php'; // Upewnij się, że ścieżka jest poprawna
session_start();
?>
<h2>Lista filmów</h2>
<?php
include_once 'cfg.php';

$result = $mysqli->query("SELECT * FROM products");

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse;'>";
    echo "<tr>
            <th style='width: 50px;'>ID</th>
            <th style='width: 200px;'>Tytuł</th>
            <th style='width: 300px;'>Opis</th>
            <th style='width: 100px;'>ID kategorii</th>
            <th style='width: 120px;'>Cena netto</th>
            <th style='width: 80px;'>VAT</th>
            <th style='width: 120px;'>Cena brutto</th>
            <th style='width: 80px;'>Stan</th>
            <th style='width: 150px;'>Zdjęcie</th>
            <th style='width: 180px;'>Akcja</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $gross_price = $row['price_net'] + ($row['price_net'] * $row['vat_tax'] / 100);

        echo "<tr>";
        echo "<td align='center'>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td align='center'>" . $row['category_id'] . "</td>";
        echo "<td align='center' style='white-space: nowrap;'>" . number_format($row['price_net'], 2) . " zł</td>";
        echo "<td align='center' style='white-space: nowrap;'>" . $row['vat_tax'] . "%</td>";
        echo "<td align='center' style='white-space: nowrap;'>" . number_format($gross_price, 2) . " zł</td>";
        echo "<td align='center'>" . $row['stock_quantity'] . "</td>";

        // Wyświetlenie zdjęcia
        echo "<td align='center'>";
        if (!empty($row['image_path'])) {
            echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['title']) . "' width='120'>";
        } else {
            echo "<em>Brak zdjęcia</em>";
        }
        echo "</td>";

        // Formularz dodawania do koszyka
        echo "<td align='center'>";
        echo "<form method='POST' action='../php/admin_cart.php'>";
        echo "<input type='hidden' name='action' value='add'>";
        echo "<input type='hidden' name='productId' value='" . $row['id'] . "'>";
        echo "<input type='hidden' name='name' value='" . htmlspecialchars($row['title']) . "'>";
        echo "<input type='hidden' name='netPrice' value='" . $row['price_net'] . "'>";
        echo "<input type='hidden' name='vat' value='" . $row['vat_tax'] . "'>";
        echo "<input type='number' name='quantity' value='1' min='1' max='" . $row['stock_quantity'] . "' style='width: 50px;'>";
        echo "<br><button type='submit'>Dodaj</button>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Brak filmów.</p>";
}

?>
