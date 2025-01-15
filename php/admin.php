<?php
session_start();
require_once('cfg.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Obsługa wylogowania
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Dodawanie produktu
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $stock);

    if ($stmt->execute()) {
        $success = "Produkt został dodany!";
    } else {
        $error = "Wystąpił błąd podczas dodawania produktu.";
    }

    $stmt->close();
}

// Usuwanie produktu
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $success = "Produkt został usunięty!";
    } else {
        $error = "Wystąpił błąd podczas usuwania produktu: " . $stmt->error;
    }

    $stmt->close();
}

// Modyfikacja produktu
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, stock = ? WHERE id = ?");
    $stmt->bind_param("ssdsii", $name, $description, $price, $image, $stock, $product_id);

    if ($stmt->execute()) {
        $success = "Produkt został zaktualizowany!";
    } else {
        $error = "Wystąpił błąd podczas aktualizacji produktu.";
    }

    $stmt->close();
}

// Pobieranie listy produktów
$products = [];
$stmt = $conn->prepare("SELECT id, name, price, stock, description, image FROM products");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Konrad Markowski">
    <title>Panel Administratora</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="header">
    <h1>Panel Administratora</h1>
    <p>Zalogowany jako: <?php echo $username; ?></p>
    <form method="post" action="admin.php">
        <button type="submit" name="logout">Wyloguj</button>
    </form>
</header>
<div class="main-content">
    <h1>Dodawanie produktu</h1>
    <form method="post" action="admin.php">
        <label for="name">Nazwa:</label>
        <input type="text" name="name" id="name" required>
        <label for="price">Cena:</label>
        <input type="text" name="price" id="price" required>
        <label for="stock">Ilość:</label>
        <input type="text" name="stock" id="stock" required>
        <label for="description">Opis:</label>
        <textarea name="description" id="description" required></textarea>
        <label for="image">Obraz:</label>
        <input type="text" name="image" id="image" required>
        <button type="submit" name="add_product">Dodaj produkt</button>
    </form>
    
    <?php if (isset($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <h1>Lista produktów</h1>
    <?php if (!empty($products)): ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Opis</th>
                <th>Obraz</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['image']; ?></td>
                    <td>
                        <form method="post" action="admin.php" style="display: inline-block;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="delete_product">Usuń</button>
                        </form>
                        <form method="post" action="admin.php" style="display: inline-block;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="update_product">Edytuj</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
