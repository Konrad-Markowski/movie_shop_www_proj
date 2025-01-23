-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 23, 2025 at 09:46 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `matka` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `nazwa`, `matka`) VALUES
(1, 'Dramat', NULL),
(2, 'Akcja', NULL),
(3, 'Przygodowe', NULL),
(4, 'Przygodowe', NULL),
(5, 'superbohaterowie', NULL),
(6, 'Marvel', 5),
(8, 'Horror', NULL),
(9, 'Paranormalne', 8),
(10, 'Psychologiczne', 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `page_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'home', '<h2>Witamy w naszym sklepie internetowym!</h2>\n\n<h3>Nasza Galeria Filmowych Okładek:</h3>\n<table class=\"film-gallery\">\n    <tr>\n        <td class=\"film-item\">\n            <img src=\"../img/movies/gladiator.jpg\" alt=\"Gladiator\" />\n            <p>Gladiator</p>\n        </td>\n        <td class=\"film-item\">\n            <img src=\"../img/movies/indiana_jones.jpg\" alt=\"Indiana Jones\" />\n            <p>Indiana Jones</p>\n        </td>\n        <td class=\"film-item\">\n            <img src=\"../img/movies/inglorious_bastards.jpg\" alt=\"Inglorious Bastards\" />\n            <p>Inglorious Bastards</p>\n        </td>\n    </tr>\n    <tr>\n        <td class=\"film-item\">\n            <img src=\"../img/movies/interstellar.jpg\" alt=\"Interstellar\" />\n            <p>Interstellar</p>\n        </td>\n        <td class=\"film-item\">\n            <img src=\"../img/movies/lalaland.jpg\" alt=\"La La Land\" />\n            <p>La La Land</p>\n        </td>\n        <td class=\"film-item\">\n            <img src=\"../img/movies/the_dark_knight.jpg\" alt=\"The Dark Knight\" />\n            <p>The Dark Knight</p>\n        </td>\n    </tr>\n</table>', 1),
(2, 'movies', '<?php\r\ninclude \'../php/admin_products.php\'; // Upewnij się, że ścieżka jest poprawna\r\nsession_start();\r\n?>\r\n<h2>Lista filmów</h2>\r\n<?php\r\ninclude_once \'cfg.php\';\r\n\r\n$result = $mysqli->query(\"SELECT * FROM products\");\r\n\r\nif ($result->num_rows > 0) {\r\n    echo \"<table border=\'1\' cellpadding=\'10\' cellspacing=\'0\' style=\'width: 100%; border-collapse: collapse;\'>\";\r\n    echo \"<tr>\r\n            <th style=\'width: 50px;\'>ID</th>\r\n            <th style=\'width: 200px;\'>Tytuł</th>\r\n            <th style=\'width: 300px;\'>Opis</th>\r\n            <th style=\'width: 100px;\'>ID kategorii</th>\r\n            <th style=\'width: 120px;\'>Cena netto</th>\r\n            <th style=\'width: 80px;\'>VAT</th>\r\n            <th style=\'width: 120px;\'>Cena brutto</th>\r\n            <th style=\'width: 80px;\'>Stan</th>\r\n            <th style=\'width: 150px;\'>Zdjęcie</th>\r\n            <th style=\'width: 180px;\'>Akcja</th>\r\n          </tr>\";\r\n\r\n    while ($row = $result->fetch_assoc()) {\r\n        $gross_price = $row[\'price_net\'] + ($row[\'price_net\'] * $row[\'vat_tax\'] / 100);\r\n\r\n        echo \"<tr>\";\r\n        echo \"<td align=\'center\'>\" . $row[\'id\'] . \"</td>\";\r\n        echo \"<td>\" . htmlspecialchars($row[\'title\']) . \"</td>\";\r\n        echo \"<td>\" . htmlspecialchars($row[\'description\']) . \"</td>\";\r\n        echo \"<td align=\'center\'>\" . $row[\'category_id\'] . \"</td>\";\r\n        echo \"<td align=\'center\' style=\'white-space: nowrap;\'>\" . number_format($row[\'price_net\'], 2) . \" zł</td>\";\r\n        echo \"<td align=\'center\' style=\'white-space: nowrap;\'>\" . $row[\'vat_tax\'] . \"%</td>\";\r\n        echo \"<td align=\'center\' style=\'white-space: nowrap;\'>\" . number_format($gross_price, 2) . \" zł</td>\";\r\n        echo \"<td align=\'center\'>\" . $row[\'stock_quantity\'] . \"</td>\";\r\n\r\n        // Wyświetlenie zdjęcia\r\n        echo \"<td align=\'center\'>\";\r\n        if (!empty($row[\'image_path\'])) {\r\n            echo \"<img src=\'\" . htmlspecialchars($row[\'image_path\']) . \"\' alt=\'\" . htmlspecialchars($row[\'title\']) . \"\' width=\'120\'>\";\r\n        } else {\r\n            echo \"<em>Brak zdjęcia</em>\";\r\n        }\r\n        echo \"</td>\";\r\n\r\n        // Formularz dodawania do koszyka\r\n        echo \"<td align=\'center\'>\";\r\n        echo \"<form method=\'POST\' action=\'../php/admin_cart.php\'>\";\r\n        echo \"<input type=\'hidden\' name=\'action\' value=\'add\'>\";\r\n        echo \"<input type=\'hidden\' name=\'productId\' value=\'\" . $row[\'id\'] . \"\'>\";\r\n        echo \"<input type=\'hidden\' name=\'name\' value=\'\" . htmlspecialchars($row[\'title\']) . \"\'>\";\r\n        echo \"<input type=\'hidden\' name=\'netPrice\' value=\'\" . $row[\'price_net\'] . \"\'>\";\r\n        echo \"<input type=\'hidden\' name=\'vat\' value=\'\" . $row[\'vat_tax\'] . \"\'>\";\r\n        echo \"<input type=\'number\' name=\'quantity\' value=\'1\' min=\'1\' max=\'\" . $row[\'stock_quantity\'] . \"\' style=\'width: 50px;\'>\";\r\n        echo \"<br><button type=\'submit\'>Dodaj</button>\";\r\n        echo \"</form>\";\r\n        echo \"</td>\";\r\n\r\n        echo \"</tr>\";\r\n    }\r\n    echo \"</table>\";\r\n} else {\r\n    echo \"<p>Brak filmów.</p>\";\r\n}\r\n\r\n?>', 1),
(3, 'categories', '<h2>Dostępne kategorie filmów na naszym sklepie internetowym</h2>\r\n<?php\r\ninclude_once \'cfg.php\';\r\ninclude \'../php/admin_categories.php\';\r\nWyswietlKategorie();\r\n?>', 1),
(4, 'admin_panel', '<?php\r\nsession_start();\r\nif (!isset($_SESSION[\'admin_logged_in\'])) {\r\n    header(\"Location: index.php?idp=login\");\r\n    exit();\r\n}\r\ninclude_once \'../php/admin_subpages.php\';\r\ninclude_once \'../php/admin_categories.php\';\r\ninclude_once \'../php/admin_products.php\';\r\n\r\n\r\nhandlePageSubmissions($mysqli);\r\n?>\r\n\r\n<div class=\"header\">\r\n    <h1 style=\"color:white;\">Panel Administratora</h1>\r\n    <a href=\"index.php?idp=logout\" onclick=\"event.preventDefault(); document.getElementById(\'logoutForm\').submit();\">Wyloguj</a>\r\n    <form id=\"logoutForm\" action=\"logout.php\" method=\"POST\" style=\"display: none;\">\r\n        <input type=\"hidden\" name=\"action\" value=\"logout\">\r\n    </form>\r\n</div>\r\n\r\n<div class=\"main-content\">\r\n    <!-- KATEGORIE -->\r\n    <div id=\"categoriesPanel\" class=\"panel\">\r\n        <h2>Kategorie</h2>\r\n        <form id=\"categoryForm\" method=\"POST\" action=\"index.php?idp=admin_panel\" onsubmit=\"return showCategoryAlert()\">\r\n            <input type=\"hidden\" id=\"categoryId\" name=\"categoryId\">\r\n            <input type=\"hidden\" name=\"action\" value=\"DodajKategorie\">\r\n            <label for=\"categoryName\">Nazwa kategorii:</label>\r\n            <input type=\"text\" id=\"categoryName\" name=\"categoryName\" required>\r\n            \r\n            <label for=\"parentCategory\">Nadrzędna kategoria:</label>\r\n            <select id=\"parentCategory\" name=\"parentCategory\">\r\n                <option value=\"0\">Brak (nadrzędna kategoria)</option>\r\n                <?php\r\n                $result = $mysqli->query(\"SELECT id, nazwa FROM kategorie WHERE matka IS NULL\");\r\n                while ($row = $result->fetch_assoc()) {\r\n                    echo \"<option value=\'\" . $row[\'id\'] . \"\'>\" . $row[\'nazwa\'] . \"</option>\";\r\n                }\r\n                ?>\r\n            </select>\r\n            \r\n            <button type=\"submit\">Zapisz</button>\r\n        </form>\r\n\r\n        <ul id=\"categoryList\">\r\n            <?php WyswietlKategorie(); ?>\r\n        </ul>\r\n\r\n        <!-- Panel usuwania kategorii -->\r\n        <div id=\"deleteCategoryPanel\" class=\"panel\">\r\n            <h2>Usuń kategorię</h2>\r\n            <form method=\"POST\" action=\"index.php?idp=admin_panel\" onsubmit=\"return showCategoryDeleteAlert()\">\r\n                <input type=\"hidden\" name=\"action\" value=\"UsunKategorie\">\r\n                <label for=\"deleteCategoryId\">ID kategorii:</label>\r\n                <input type=\"number\" id=\"deleteCategoryId\" name=\"categoryId\" required>\r\n                <button type=\"submit\">Usuń</button>\r\n            </form>\r\n        </div>\r\n\r\n        <!-- Panel edycji kategorii -->\r\n        <div id=\"editCategoryPanel\" class=\"panel\">\r\n            <h2>Edytuj kategorię</h2>\r\n            <form method=\"POST\" action=\"index.php?idp=admin_panel\">\r\n                <input type=\"hidden\" name=\"action\" value=\"EdytujKategorie\">\r\n                <label for=\"editCategoryId\">ID kategorii:</label>\r\n                <input type=\"number\" id=\"editCategoryId\" name=\"categoryId\" required>\r\n                <label for=\"editCategoryName\">Nazwa kategorii:</label>\r\n                <input type=\"text\" id=\"editCategoryName\" name=\"categoryName\" required>\r\n                <label for=\"editParentCategory\">Nadrzędna kategoria:</label>\r\n                <select id=\"editParentCategory\" name=\"parentCategory\">\r\n                    <option value=\"0\">Brak (nadrzędna kategoria)</option>\r\n                    <?php\r\n                    $result = $mysqli->query(\"SELECT id, nazwa FROM kategorie WHERE matka IS NULL\");\r\n                    while ($row = $result->fetch_assoc()) {\r\n                        echo \"<option value=\'\" . $row[\'id\'] . \"\'>\" . $row[\'nazwa\'] . \"</option>\";\r\n                    }\r\n                    ?>\r\n                </select>\r\n                <button type=\"submit\">Edytuj</button>\r\n            </form>\r\n        </div>\r\n    </div>\r\n\r\n    <!-- PRODUKTY -->\r\n    <div id=\"productsPanel\" class=\"panel\">\r\n        <h2>Filmy</h2>\r\n        <form id=\"productForm\" method=\"POST\" action=\"index.php?idp=admin_panel\" onsubmit=\"return showProductAlert()\">\r\n            <input type=\"hidden\" id=\"productId\" name=\"productId\">\r\n            <input type=\"hidden\" name=\"action\" value=\"DodajProdukt\">\r\n            <label for=\"productName\">Tytuł filmu:</label>\r\n            <input type=\"text\" id=\"productName\" name=\"productName\" required><br>\r\n            <label for=\"productDescription\">Opis:</label>\r\n            <textarea id=\"productDescription\" name=\"productDescription\"></textarea><br>\r\n            <label for=\"productPrice\">Cena netto:</label>\r\n            <input type=\"number\" id=\"productPrice\" name=\"productPrice\" step=\"0.01\" required><br>\r\n            <label for=\"productVat\">VAT:</label>\r\n            <input type=\"number\" id=\"productVat\" name=\"productVat\" step=\"0.01\" required><br>\r\n            <label for=\"productStock\">Ilość w magazynie:</label>\r\n            <input type=\"number\" id=\"productStock\" name=\"productStock\" required><br>\r\n            <label for=\"productCategory\">Kategoria:</label>\r\n            <select id=\"productCategory\" name=\"productCategory\">\r\n                <?php\r\n                $result = $mysqli->query(\"SELECT id, nazwa FROM kategorie\");\r\n                while ($row = $result->fetch_assoc()) {\r\n                    echo \"<option value=\'\" . $row[\'id\'] . \"\'>\" . $row[\'nazwa\'] . \"</option>\";\r\n                }\r\n                ?>\r\n            </select><br>\r\n            <label for=\"productImage\">Link do obrazu:</label>\r\n            <input type=\"text\" id=\"productImage\" name=\"productImage\"><br>\r\n            <button type=\"submit\">Zapisz</button>\r\n        </form>\r\n\r\n        <!-- Panel usuwania produktu -->\r\n        <div id=\"deleteProductPanel\" class=\"panel\">\r\n            <h2>Usuń produkt</h2>\r\n            <form method=\"POST\" action=\"index.php?idp=admin_panel\" onsubmit=\"return showProductDeleteAlert()\">\r\n                <input type=\"hidden\" name=\"action\" value=\"UsunProdukt\">\r\n                <label for=\"deleteProductId\">ID produktu:</label>\r\n                <input type=\"number\" id=\"deleteProductId\" name=\"productId\" required>\r\n                <button type=\"submit\">Usuń</button>\r\n            </form>\r\n        </div>\r\n\r\n        <!-- Panel edycji produktu -->\r\n        <div id=\"editProductPanel\" class=\"panel\">\r\n            <h2>Edytuj produkt</h2>\r\n            <form method=\"POST\" action=\"index.php?idp=admin_panel\" enctype=\"multipart/form-data\">\r\n                <input type=\"hidden\" name=\"action\" value=\"EdytujProdukt\">\r\n                <label for=\"editProductId\">ID produktu:</label>\r\n                <input type=\"number\" id=\"editProductId\" name=\"productId\" required>\r\n                <label for=\"editProductTitle\">Tytuł:</label>\r\n                <input type=\"text\" id=\"editProductTitle\" name=\"title\" required>\r\n                <label for=\"editProductDescription\">Opis:</label>\r\n                <textarea id=\"editProductDescription\" name=\"description\"></textarea>\r\n                <label for=\"editProductPrice\">Cena netto:</label>\r\n                <input type=\"number\" id=\"editProductPrice\" name=\"price_net\" step=\"0.01\" required>\r\n                <label for=\"editProductVat\">VAT:</label>\r\n                <input type=\"number\" id=\"editProductVat\" name=\"vat_tax\" step=\"0.01\" required>\r\n                <label for=\"editProductStock\">Ilość w magazynie:</label>\r\n                <input type=\"number\" id=\"editProductStock\" name=\"stock_quantity\" required>\r\n                <label for=\"editProductCategory\">Kategoria:</label>\r\n                <select id=\"editProductCategory\" name=\"productCategory\" required>\r\n                    <?php\r\n                    $result = $mysqli->query(\"SELECT id, nazwa FROM kategorie\");\r\n                    while ($row = $result->fetch_assoc()) {\r\n                        echo \"<option value=\'\" . $row[\'id\'] . \"\'>\" . $row[\'nazwa\'] . \"</option>\";\r\n                    }\r\n                    ?>\r\n                </select><br>\r\n                <label for=\"editProductImage\">Link do obrazu:</label>\r\n                <input type=\"text\" id=\"editProductImage\" name=\"image_path\"><br>\r\n                <button type=\"submit\">Edytuj</button>\r\n            </form>\r\n        </div>\r\n        \r\n        <!-- Panel podstron -->\r\n        <div id=\"subpagesPanel\" class=\"panel\">\r\n            <h2>Podstrony</h2>\r\n            <div>\r\n                <a href=\"index.php?idp=admin_panel&action=add\" class=\"button\">Dodaj nową podstronę</a>\r\n                <?php\r\n                if (isset($_GET[\'action\'])) {\r\n                    if ($_GET[\'action\'] === \'edit\' && isset($_GET[\'id\'])) {\r\n                        // Funkcja do edycji podstrony\r\n                        echo EdytujPodstrone($mysqli);\r\n                    } elseif ($_GET[\'action\'] === \'add\') {\r\n                        echo DodajNowaPodstrone($mysqli);\r\n                    } elseif ($_GET[\'action\'] === \'delete\' && isset($_GET[\'id\'])) {\r\n                        // Zmieniamy metodę z GET na POST dla usuwania\r\n                        ?>\r\n                        <form method=\"POST\" action=\"index.php?idp=admin_panel\">\r\n                            <input type=\"hidden\" name=\"action\" value=\"delete\">\r\n                            <input type=\"hidden\" name=\"id\" value=\"<?php echo $_GET[\'id\']; ?>\">\r\n                            <button type=\"submit\" class=\"btn btn-danger\"\r\n                                    onclick=\"return confirm(\'Czy na pewno chcesz usunąć?\')\">Usuń\r\n                            </button>\r\n                        </form>\r\n                        <?php\r\n                    } else {\r\n                        echo \'<div class=\"alert alert-error\">Nieznana akcja!</div>\';\r\n                    }\r\n                } else {\r\n                    echo ListaPodstron($mysqli);\r\n                }\r\n                ?>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n<script>\r\nfunction showCategoryAlert() {\r\n    alert(\"Kategoria została dodana pomyślnie!\");\r\n    return true;\r\n}\r\n\r\nfunction showProductAlert() {\r\n    alert(\"Produkt został dodany pomyślnie!\");\r\n    return true;\r\n}\r\n\r\nfunction showProductDeleteAlert() {\r\n    alert(\"Produkt został usunięty pomyślnie!\");\r\n    return true;\r\n}\r\n\r\nfunction showCategoryDeleteAlert() {\r\n    alert(\"Kategoria została usunięta pomyślnie!\");\r\n    return true;\r\n}\r\n</script>', 1),
(5, 'login', '<?php\r\nsession_start();\r\ninclude_once \'cfg.php\';\r\n\r\nif ($_SERVER[\'REQUEST_METHOD\'] === \'POST\') {\r\n    $username = $_POST[\'username\'];\r\n    $password = $_POST[\'password\'];\r\n\r\n    // Zapytanie uwzględniające sprawdzenie uprawnień administratora\r\n    $stmt = $mysqli->prepare(\"SELECT * FROM users WHERE username = ? AND admin_privilages = 1\");\r\n    $stmt->bind_param(\"s\", $username);\r\n    $stmt->execute();\r\n    $result = $stmt->get_result();\r\n    $user = $result->fetch_assoc();\r\n\r\n    if ($user && password_verify($password, $user[\'password\'])) {\r\n        $_SESSION[\'admin_logged_in\'] = true;\r\n        $_SESSION[\'username\'] = $user[\'username\']; // Zapisanie nazwy użytkownika w sesji, jeśli potrzeba\r\n        header(\"Location: index.php?idp=admin_panel\");\r\n        exit();\r\n    } else {\r\n        $error = \"Nieprawidłowa nazwa użytkownika, hasło lub brak uprawnień administratora.\";\r\n    }\r\n}\r\n?>\r\n\r\n<h2>Logowanie do panelu administratora</h2>\r\n<?php if (isset($error)) echo \"<p>$error</p>\"; ?>\r\n<form method=\"POST\">\r\n    <label for=\"username\">Nazwa użytkownika:</label>\r\n    <input type=\"text\" id=\"username\" name=\"username\" required><br>\r\n    <label for=\"password\">Hasło:</label>\r\n    <input type=\"password\" id=\"password\" name=\"password\" required><br>\r\n    <button type=\"submit\">Zaloguj</button>\r\n</form>', 1),
(6, 'logout', '<?php\r\nsession_start();\r\nsession_destroy();\r\nheader(\"Location: ./index.php?page=login\"); // Przekierowanie na stronę logowania\r\nexit();', 0),
(7, 'register', '<?php\r\ninclude_once \'cfg.php\';\r\n\r\nif ($_SERVER[\'REQUEST_METHOD\'] === \'POST\') {\r\n    $username = $_POST[\'username\'];\r\n    $password = password_hash($_POST[\'password\'], PASSWORD_DEFAULT);\r\n\r\n    $stmt = $mysqli->prepare(\"INSERT INTO users (username, password) VALUES (?, ?)\");\r\n    $stmt->bind_param(\"ss\", $username, $password);\r\n    $stmt->execute();\r\n    $stmt->close();\r\n\r\n    echo \"Rejestracja zakończona sukcesem! Możesz się teraz zalogować.\";\r\n}\r\n?>\r\n\r\n<h2>Rejestracja użytkownika</h2>\r\n<form method=\"POST\">\r\n    <label for=\"username\">Nazwa użytkownika:</label>\r\n    <input type=\"text\" id=\"username\" name=\"username\" required><br>\r\n    <label for=\"password\">Hasło:</label>\r\n    <input type=\"password\" id=\"password\" name=\"password\" required><br>\r\n    <button type=\"submit\">Zarejestruj</button>\r\n</form>', 1),
(8, 'cart', '<?php\r\ninclude \'../php/admin_cart.php\'; // Upewnij się, że ścieżka jest poprawna\r\n\r\n// Pobranie szczegółów koszyka\r\n$cartDetails = getCartDetails() ?? [];\r\n$totalValue = getTotalCartValue() ?? 0.00;\r\n?>\r\n\r\n<h2>Koszyk</h2>\r\n\r\n<?php if (empty($cartDetails)) : ?>\r\n    <p>Twój koszyk jest pusty.</p>\r\n<?php else : ?>\r\n    <form method=\"POST\" action=\"../php/admin_cart.php\">\r\n        <table border=\"1\" cellpadding=\"10\" cellspacing=\"0\">\r\n            <thead>\r\n                <tr>\r\n                    <th>Produkt</th>\r\n                    <th>Cena netto</th>\r\n                    <th>VAT</th>\r\n                    <th>Cena brutto</th>\r\n                    <th>Ilość</th>\r\n                    <th>Razem</th>\r\n                    <th>Akcje</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                <?php foreach ($cartDetails as $productId => $product) : ?>\r\n                    <?php \r\n                        // Pobierz aktualny stan magazynowy\r\n                        $stockQuantity = getStockQuantity($productId); \r\n                    ?>\r\n                    <tr>\r\n                        <td><?= htmlspecialchars($product[\'name\']) ?></td>\r\n                        <td><?= number_format($product[\'net_price\'], 2) ?> zł</td>\r\n                        <td><?= $product[\'vat\'] ?>%</td>\r\n                        <td><?= number_format($product[\'gross_price\'], 2) ?> zł</td>\r\n                        <td>\r\n                            <input \r\n                                type=\"number\" \r\n                                name=\"quantity[<?= htmlspecialchars($productId) ?>]\" \r\n                                value=\"<?= htmlspecialchars($product[\'quantity\']) ?>\" \r\n                                min=\"1\" \r\n                                max=\"<?= $stockQuantity ?>\" \r\n                                data-stock=\"<?= $stockQuantity ?>\" \r\n                                class=\"quantity-input\"\r\n                            >\r\n                            <p style=\"font-size: 0.8em; color: gray;\">(Max: <?= $stockQuantity ?>)</p>\r\n                        </td>\r\n                        <td class=\"total-price\"><?= number_format($product[\'gross_price\'] * $product[\'quantity\'], 2) ?> zł</td>\r\n                        <td>\r\n                            <form method=\"POST\" action=\"../php/admin_cart.php\" style=\"display: inline;\">\r\n                                <input type=\"hidden\" name=\"productId\" value=\"<?= htmlspecialchars($productId) ?>\">\r\n                                <input type=\"hidden\" name=\"action\" value=\"remove\">\r\n                                <button type=\"submit\">Usuń</button>\r\n                            </form>\r\n                        </td>\r\n                    </tr>\r\n                <?php endforeach; ?>\r\n            </tbody>\r\n            <tfoot>\r\n                <tr>\r\n                    <td colspan=\"5\" style=\"text-align: right;\"><strong>Całkowita wartość:</strong></td>\r\n                    <td colspan=\"2\"><strong id=\"total-cart-value\"><?= number_format($totalValue, 2) ?> zł</strong></td>\r\n                </tr>\r\n            </tfoot>\r\n        </table>\r\n\r\n        <button type=\"submit\" name=\"action\" value=\"clear\">Wyczyść koszyk</button>\r\n    </form>\r\n<?php endif; ?>\r\n\r\n<script>\r\ndocument.addEventListener(\'DOMContentLoaded\', function() {\r\n    const quantityInputs = document.querySelectorAll(\'.quantity-input\');\r\n    const totalCartValueElement = document.getElementById(\'total-cart-value\');\r\n\r\n    quantityInputs.forEach(input => {\r\n        input.addEventListener(\'change\', function() {\r\n            const stockQuantity = parseInt(this.dataset.stock);\r\n            const newQuantity = Math.min(parseInt(this.value), stockQuantity);\r\n            this.value = newQuantity; // Ogranicz wartość do maksymalnej dostępnej\r\n\r\n            const row = this.closest(\'tr\');\r\n            const netPrice = parseFloat(row.querySelector(\'td:nth-child(2)\').innerText);\r\n            const vat = parseFloat(row.querySelector(\'td:nth-child(3)\').innerText) / 100;\r\n            const grossPrice = netPrice * (1 + vat) * newQuantity;\r\n            row.querySelector(\'.total-price\').innerText = grossPrice.toFixed(2) + \' zł\';\r\n\r\n            // Zaktualizuj całkowitą wartość koszyka\r\n            let totalCartValue = 0;\r\n            document.querySelectorAll(\'.total-price\').forEach(element => {\r\n                totalCartValue += parseFloat(element.innerText);\r\n            });\r\n            totalCartValueElement.innerText = totalCartValue.toFixed(2) + \' zł\';\r\n        });\r\n    });\r\n});\r\n</script>', 1),
(11, 'test', 'lorem ipsum', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price_net` decimal(10,2) NOT NULL,
  `vat_tax` decimal(4,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `availability_status` tinyint(1) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price_net`, `vat_tax`, `stock_quantity`, `availability_status`, `image_path`, `category_id`) VALUES
(2, 'La La Land', 'lubie jazz', 50.00, 23.00, 14, 1, 'https://kinopalacowe.pl/media/gallery/md/lalaland_plakat_KI8IJRI.jpg', 8),
(3, 'Avengers', 'bohaterowie', 80.00, 23.00, 17, 0, 'https://fwcdn.pl/fpo/15/15/371515/7611932_1.3.jpg', 6),
(4, 'The Notebook', 'aaaaa', 14.00, 15.00, 3, 0, 'https://m.media-amazon.com/images/M/MV5BZjE0ZjgzMzYtMTAxYi00NGMzLThmZDktNzFlMzA2MWRmYWQ0XkEyXkFqcGc@._V1_.jpg', 1),
(7, 'Spider_Man', 'film o początkach spider-man\'a', 46.00, 23.00, 14, 1, 'https://fwcdn.pl/fpo/96/95/9695/7518091_1.8.webp', 6),
(8, 'Spider-Man 2', 'spider-man2', 15.00, 15.00, 6, 1, 'https://fwcdn.pl/fpo/42/81/34281/7537326_1.3.jpg', 6),
(9, 'Batman', 'czlowiek nietoperz', 79.00, 23.00, 15, 1, 'https://fwcdn.pl/fpo/63/18/626318/7998474_2.8.webp', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_privilages` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `admin_privilages`) VALUES
(1, 'admin', '$2y$10$emPlaXKRwhj1BXBsBxic..UN0fBFBwENMvBEwS/jHqngQuGHc3CPG', 1),
(2, 'user', '$2y$10$Az2PyNaHU49EgojrsYbvHucIMhkPII0huAWSLZ5iH9Mk4OxOtnmuO', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matka` (`matka`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD CONSTRAINT `kategorie_ibfk_1` FOREIGN KEY (`matka`) REFERENCES `kategorie` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `kategorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
