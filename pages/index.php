<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sklep Internetowy</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="header">
    <h1>Sklep Internetowy</h1>
    <nav>
        <a href="index.php?idp=home">Home</a>
        <a href="index.php?idp=movies">Filmy</a>
        <a href="index.php?idp=categories">Kategorie</a>
        <a href="index.php?idp=admin_panel">Admin Panel</a>
        <a href="index.php?idp=login">Logowanie</a>
        <a href="index.php?idp=register">Rejestracja</a>
        <a href="index.php?idp=cart">Koszyk</a>
    </nav>
</div>

<div class="main-content">
    <?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    $pages_dir = './';
    $page = $_GET['idp'];

    if (!$page) {
        $page = 'home';
    }

    $page_path = "{$pages_dir}/{$page}.php";

    if (file_exists($page_path)) {
        include $page_path;
    } else {
        echo "Strona nie została znaleziona.";
    }
    ?>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> Sklep Internetowy. Wszelkie prawa zastrzeżone.</p>
</div>

</body>
</html>
