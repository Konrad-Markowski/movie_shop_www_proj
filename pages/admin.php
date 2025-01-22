<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Administratora</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="header">
    <h1>Panel Administratora</h1>
    <a href="logout.php" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Wyloguj</a>
    <form id="logoutForm" action="logout.php" method="POST" style="display: none;">
        <input type="hidden" name="action" value="logout">
    </form>
</div>

<div class="main-content">
    <div id="categoriesPanel" class="panel">
        <h2>Kategorie</h2>
        <form id="categoryForm" method="POST" action="../php/admin_categories.php">
            <input type="hidden" id="categoryId" name="categoryId">
            <input type="hidden" name="action" value="DodajKategorie">
            <label for="categoryName">Nazwa kategorii:</label>
            <input type="text" id="categoryName" name="categoryName" required>
            <button type="submit">Zapisz</button>
        </form>
        <ul id="categoryList">
        </ul>
        <div id="categoryMessage"></div>
    </div>

    <div id="productsPanel" class="panel">
        <h2>Filmy</h2>
        <form id="productForm" method="POST" action="../php/admin_products.php">
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
            </select><br>
            <button type="submit">Zapisz</button>
        </form>
        <ul id="productList">
        </ul>
        <div id="productMessage"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Obsługa formularza kategorii
    $('#categoryForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: '../php/admin_categories.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#categoryMessage').html('<p>' + response + '</p>');
                // Odśwież listę kategorii
                loadCategories();
            },
            error: function() {
                $('#categoryMessage').html('<p>Wystąpił błąd podczas dodawania kategorii.</p>');
            }
        });
    });

    // Obsługa formularza produktów
    $('#productForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: '../php/admin_products.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#productMessage').html('<p>' + response + '</p>');
                // Odśwież listę produktów
                loadProducts();
            },
            error: function() {
                $('#productMessage').html('<p>Wystąpił błąd podczas dodawania produktu.</p>');
            }
        });
    });

    // Funkcje do ładowania kategorii i produktów
    function loadCategories() {
        $.ajax({
            url: '../php/admin_categories.php',
            type: 'GET',
            data: { action: 'PokazKategorie' },
            success: function(response) {
                $('#categoryList').html(response);
            }
        });
    }

    function loadProducts() {
        $.ajax({
            url: '../php/admin_products.php',
            type: 'GET',
            data: { action: 'PokazProdukty' },
            success: function(response) {
                $('#productList').html(response);
            }
        });
    }

    // Initial load
    loadCategories();
    loadProducts();
});
</script>

</body>
</html>
