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
    <h1 style="color:white;">Panel Administratora</h1>
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

    <div id="deleteCategoryPanel" class="panel">
    <h2>Usuń kategorię</h2>
    <form method="POST" action="index.php?idp=admin_panel" onsubmit="return showCategoryDeleteAlert()">
        <input type="hidden" name="action" value="UsunKategorie">
        <label for="deleteCategoryId">ID kategorii:</label>
        <input type="number" id="deleteCategoryId" name="categoryId" required>
        <button type="submit">Usuń</button>
    </form>
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
        
        <div id="deleteProductPanel" class="panel">
            <h2>Usuń produkt</h2>
            <form method="POST" action="index.php?idp=admin_panel" onsubmit="return showProductDeleteAlert()">
                <input type="hidden" name="action" value="UsunProdukt">
                <label for="deleteProductId">ID produktu:</label>
                <input type="number" id="deleteProductId" name="productId" required>
                <button type="submit">Usuń</button>
            </form>
        </div>

        <div id="editProductPanel" class="panel">
            <h2>Edytuj produkt</h2>
            <form method="POST" action="index.php?idp=admin_panel">
                <input type="hidden" name="action" value="EdytujProdukt">
                <label for="editProductId">ID produktu:</label>
                <input type="number" id="editProductId" name="productId" required>
                <label for="editProductTitle">Tytuł:</label>
                <input type="text" id="editProductTitle" name="title" required>
                <label for="editProductDescription">Opis:</label>
                <textarea id="editProductDescription" name="description"></textarea>
                <label for="editProductPrice">Cena netto:</label>
                <input type="number" id="editProductPrice" name="price_net" step="0.01" required>
                <label for="editProductVat">VAT:</label>
                <input type="number" id="editProductVat" name="vat_tax" step="0.01" required>
                <label for="editProductStock">Ilość w magazynie:</label>
                <input type="number" id="editProductStock" name="stock_quantity" required>
                <label for="editProductCategory">Kategoria:</label>
                <select id="editProductCategory" name="productCategory" required>
                    <?php
                    $result = $mysqli->query("SELECT id, nazwa FROM kategorie");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
                    }
                    ?>
                </select><br>
                <button type="submit">Edytuj</button>
            </form>
        </div>
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
function showProductDeleteAlert() {
    alert("Produkt został usunięty pomyślnie!");
    return true;
}
</script>
