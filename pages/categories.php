<h2>Dostępne kategorie filmów na naszym sklepie internetowym</h2>
<?php
$mysqli = new mysqli("localhost", "root", "", "shop");

if ($mysqli->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
}

include '../php/admin_categories.php';
WyswietlKategorie();
?>
