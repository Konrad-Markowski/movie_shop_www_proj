<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php?idp=login");
    exit();
}

include '../php/admin_categories.php';
include '../php/admin_products.php';
?>

<div class="header">
    <h1>Panel Administratora</h1>
    <a href="index.php?idp=logout" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Wyloguj</a>
    <form id="logoutForm" action="logout.php" method="POST" style="display: none;">
        <input type="hidden" name="action" value="logout">
    </form>
</div>

<div class="main-content">
    <div id="categoriesPanel" class="panel">
        <h2>Kategorie</h2>
        <form id="categoryForm" method="POST" action="index.php?idp=admin_panel" onsubmit="return showCategoryAlert()">
            <input type="hidden" id="categoryId" name="categoryId">
            <input type="hidden" name="action" value="DodajKategorie">
            <label for="categoryName">Nazwa kategorii:</label>
            <input type="text" id="categoryName" name="categoryName" required>
            
            <label for="parentCategory">Nadrzędna kategoria:</label>
            <select id="parentCategory" name="parentCategory">
                <option value="0">Brak (nadrzędna kategoria)</option>
                <?php
                $result = $mysqli->query("SELECT id, nazwa FROM kategorie WHERE matka IS NULL");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
                }
                ?>
            </select>
            
            <button type="submit">Zapisz</button>
        </form>
        <ul id="categoryList">
            <?php WyswietlKategorie(); ?>
        </ul>
    </div>

    <div id="productsPanel" class="panel">
        <h2>Filmy</h2>
        <form id="productForm" method="POST" action="index.php?idp=admin_panel" onsubmit="return showProductAlert()">
            <input type="hidden" id="productId" name="productId">
            <input type="hidden" name="action" value="DodajProdukt">
            <label for="productName">Tytuł filmu:</label>
            <input type="text" id="productName" name="productName" required><br>
            <label for="productDescription">Opis:</label>
            <textarea id="productDescription" name="productDescription"></textarea><br>
            <label for="productPrice">Cena netto:</label>
            <input type="number" id="productPrice" name="productPrice" step="0.01" required><br>
            <label for="productVat">VAT:</label>
            <input type="number" id="productVat" name="productVat" step="0.01" required><br>
            <label for="productStock">Ilość w magazynie:</label>
            <input type="number" id="productStock" name="productStock" required><br>
            <label for="productCategory">Kategoria:</label>
            <select id="productCategory" name="productCategory">
                <?php
                $result = $mysqli->query("SELECT id, nazwa FROM kategorie");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
                }
                ?>
            </select><br>
            <button type="submit">Zapisz</button>
        </form>
        
        <ul id="productList">
            <?php
            $result = $mysqli->query("SELECT * FROM products");
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Cena netto: " . number_format($row['price_net'], 2) . " PLN</p>";
                echo "<p>VAT: " . $row['vat_tax'] . "%</p>";
                echo "<p>Cena brutto: " . number_format($row['price_net'] * (1 + $row['vat_tax'] / 100), 2) . " PLN</p>";
                echo "<p>Ilość dostępna: " . $row['stock_quantity'] . "</p>";
                
                // Formularz do edycji produktu
                echo "<form method='POST' action='index.php?idp=admin_panel' style='display: inline;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='hidden' name='action' value='EdytujProdukt'>
                        <input type='text' name='title' value='" . htmlspecialchars($row['title']) . "' required>
                        <textarea name='description'>" . htmlspecialchars($row['description']) . "</textarea>
                        <input type='number' name='price_net' value='" . $row['price_net'] . "' step='0.01' required>
                        <input type='number' name='vat_tax' value='" . $row['vat_tax'] . "' step='0.01' required>
                        <input type='number' name='stock_quantity' value='" . $row['stock_quantity'] . "' required>
                        <button type='submit'>Edytuj</button>
                      </form>";
                
                // Formularz do usuwania produktu
                echo "<form method='POST' action='index.php?idp=admin_panel' style='display: inline;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='hidden' name='action' value='UsunProdukt'>
                        <button type='submit'>Usuń</button>
                      </form>";
                
                echo "</li>";
            }
            ?>
        </ul>
        <div id="productMessage"></div>
    </div>
</div>

<script>
function showCategoryAlert() {
    alert("Kategoria została dodana pomyślnie!");
    return true;
}

function showProductAlert() {
    alert("Produkt został dodany pomyślnie!");
    return true;
}
</script>
