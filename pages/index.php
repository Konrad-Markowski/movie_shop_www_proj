<?php

include_once 'cfg.php';
include_once 'showpage.php';

$page = $_GET['page'] ?? 'index';

list($title, $content) = showPage($page);
$pageList = showPageList($mysqli);
?>

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
    <nav style="display: flex; justify-content: center; align-items: center; gap: 20px; flex-wrap: wrap; margin-top: 10px; margin-bottom: 20px;">
    <a href="index.php?idp=home" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Home
    </a>
    <a href="index.php?idp=movies" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Filmy
    </a>
    <a href="index.php?idp=categories" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Kategorie
    </a>
    <a href="index.php?idp=admin_panel" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Admin Panel
    </a>
    <a href="index.php?idp=login" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Logowanie
    </a>
    <a href="index.php?idp=register" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Rejestracja
    </a>
    <a href="index.php?idp=cart" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Koszyk
    </a>
    <a href="index.php?idp=showpage" 
       style="text-decoration: none; color: #fff; font-weight: bold; padding: 12px 20px; background-color: rgba(57, 153, 153, 0.8); border-radius: 5px; transition: all 0.3s ease; font-size: 1rem; letter-spacing: 1px;">
       Lista podstron
    </a>
</nav>
</div>

<div class="main-content" style="width: 80%;">
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
