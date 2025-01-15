<?php
require_once('cfg.php');

// Pobranie danych produktu
$product_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Produkt nie istnieje!");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="product-page">
        <h1><?php echo $product['name']; ?></h1>
        <p>Kategoria: <?php echo $product['category_name']; ?></p>
        <p>Cena netto: <?php echo $product['price_net']; ?> zł</p>
        <p>VAT: <?php echo $product['vat']; ?>%</p>
        <p>Cena brutto: <?php echo $product['price_net'] * (1 + $product['vat'] / 100); ?> zł</p>
        <p>Stan magazynowy: <?php echo $product['stock']; ?></p>
        <p>Dostępność: <?php echo $product['availability'] ? 'Dostępny' : 'Niedostępny'; ?></p>
        <p>Opis: <?php echo $product['description']; ?></p>
        <a href="shop.php">Powrót do sklepu</a>
    </div>
</body>
</html>
