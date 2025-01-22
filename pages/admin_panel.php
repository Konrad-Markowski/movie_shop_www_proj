<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php?idp=login");
    exit();
}
include_once '../php/admin_subpages.php';
include_once '../php/admin_categories.php';
include_once '../php/admin_products.php';


handlePageSubmissions($mysqli);
?>

<div class="header">
    <h1 style="color:white;">Panel Administratora</h1>
    <a href="index.php?idp=logout" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">Wyloguj</a>
    <form id="logoutForm" action="logout.php" method="POST" style="display: none;">
        <input type="hidden" name="action" value="logout">
    </form>
</div>

<div class="main-content">
    <!-- KATEGORIE -->
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

        <!-- Panel usuwania kategorii -->
        <div id="deleteCategoryPanel" class="panel">
            <h2>Usuń kategorię</h2>
            <form method="POST" action="index.php?idp=admin_panel" onsubmit="return showCategoryDeleteAlert()">
                <input type="hidden" name="action" value="UsunKategorie">
                <label for="deleteCategoryId">ID kategorii:</label>
                <input type="number" id="deleteCategoryId" name="categoryId" required>
                <button type="submit">Usuń</button>
            </form>
        </div>

        <!-- Panel edycji kategorii -->
        <div id="editCategoryPanel" class="panel">
            <h2>Edytuj kategorię</h2>
            <form method="POST" action="index.php?idp=admin_panel">
                <input type="hidden" name="action" value="EdytujKategorie">
                <label for="editCategoryId">ID kategorii:</label>
                <input type="number" id="editCategoryId" name="categoryId" required>
                <label for="editCategoryName">Nazwa kategorii:</label>
                <input type="text" id="editCategoryName" name="categoryName" required>
                <label for="editParentCategory">Nadrzędna kategoria:</label>
                <select id="editParentCategory" name="parentCategory">
                    <option value="0">Brak (nadrzędna kategoria)</option>
                    <?php
                    $result = $mysqli->query("SELECT id, nazwa FROM kategorie WHERE matka IS NULL");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nazwa'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Edytuj</button>
            </form>
        </div>
    </div>

    <!-- PRODUKTY -->
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
            <label for="productImage">Link do obrazu:</label>
            <input type="text" id="productImage" name="productImage"><br>
            <button type="submit">Zapisz</button>
        </form>

        <!-- Panel usuwania produktu -->
        <div id="deleteProductPanel" class="panel">
            <h2>Usuń produkt</h2>
            <form method="POST" action="index.php?idp=admin_panel" onsubmit="return showProductDeleteAlert()">
                <input type="hidden" name="action" value="UsunProdukt">
                <label for="deleteProductId">ID produktu:</label>
                <input type="number" id="deleteProductId" name="productId" required>
                <button type="submit">Usuń</button>
            </form>
        </div>

        <!-- Panel edycji produktu -->
        <div id="editProductPanel" class="panel">
            <h2>Edytuj produkt</h2>
            <form method="POST" action="index.php?idp=admin_panel" enctype="multipart/form-data">
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
                <label for="editProductImage">Link do obrazu:</label>
                <input type="text" id="editProductImage" name="image_path"><br>
                <button type="submit">Edytuj</button>
            </form>
        </div>
        
        <!-- Panel podstron -->
        <div id="subpagesPanel" class="panel">
            <h2>Podstrony</h2>
            <div>
                <a href="index.php?idp=admin_panel&action=add" class="button">Dodaj nową podstronę</a>
                <?php
                if (isset($_GET['action'])) {
                    if ($_GET['action'] === 'edit' && isset($_GET['id'])) {
                        // Funkcja do edycji podstrony
                        echo EdytujPodstrone($mysqli);
                    } elseif ($_GET['action'] === 'add') {
                        echo DodajNowaPodstrone($mysqli);
                    } elseif ($_GET['action'] === 'delete' && isset($_GET['id'])) {
                        // Zmieniamy metodę z GET na POST dla usuwania
                        ?>
                        <form method="POST" action="index.php?idp=admin_panel">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Czy na pewno chcesz usunąć?')">Usuń
                            </button>
                        </form>
                        <?php
                    } else {
                        echo '<div class="alert alert-error">Nieznana akcja!</div>';
                    }
                } else {
                    echo ListaPodstron($mysqli);
                }
                ?>
            </div>
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

function showCategoryDeleteAlert() {
    alert("Kategoria została usunięta pomyślnie!");
    return true;
}
</script>
