<?php
error_reporting(E_ALL);

// Ustal domyślną stronę
$strona = './html/glowna.html';

// Lista dostępnych stron
$pages = [
    'glowna' => './html/glowna.html',
    'login' => './php/login.php',
    'register' => './php/register.php',
    'admin' => './php/admin.php'
];

// Sprawdź parametr "idp" w URL
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];

    // Jeśli parametr pasuje do listy dostępnych stron, ustaw odpowiednią ścieżkę
    if (array_key_exists($idp, $pages)) {
        $strona = $pages[$idp];
    } else {
        $strona = './html/404.html'; // Strona błędu
    }
}

// Zabezpieczenie - sprawdź, czy plik istnieje
if (!file_exists($strona)) {
    $strona = './html/404.html'; // Strona błędu, jeśli plik nie istnieje
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja Strona</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <nav class="menu">
            <a href="index.php">Strona główna</a>
            <a href="index.php?idp=login">Zaloguj</a>
            <a href="index.php?idp=register">Zarejestruj</a>
            <a href="index.php?idp=admin">Panel Administratora</a>
        </nav>
    </header>
    <main>
        <?php
        // Załaduj treść podstrony
        if (file_exists($strona)) {
            include($strona);
        } else {
            echo "<p>Błąd: nie znaleziono pliku $strona</p>";
        }
        ?>
    </main>
</body>
</html>
