<?php
include_once 'cfg.php';
include_once 'showpage.php';

$page_title = $_GET['title'] ?? '';
list($title, $content) = showPage($page_title);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="main-content">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p><?php echo nl2br($content); ?></p>
    </div>
</body>
</html>