<?php
session_start();
require_once('cfg.php');

// Create categories table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id INT(6) UNSIGNED DEFAULT 0
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Fetch categories from the database
function fetchCategories($parent_id = 0, $conn) {
    $sql = "SELECT * FROM categories WHERE parent_id = $parent_id";
    $result = $conn->query($sql);
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $row['subcategories'] = fetchCategories($row['id'], $conn);
        $categories[] = $row;
    }
    return $categories;
}

$categories = fetchCategories(0, $conn);

// Handle adding a new category
if (isset($_POST['add_category'])) {
    $new_category = $_POST['new_category'];
    $parent_id = $_POST['parent_id'];
    if (!empty($new_category)) {
        $stmt = $conn->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $stmt->bind_param("si", $new_category, $parent_id);
        $stmt->execute();
        $stmt->close();
        header("Location: shop.php");
        exit;
    }
}

// Sample data for movies
$movies = [
    ['id' => 1, 'title' => 'Avengers', 'category' => 'Action', 'subcategory' => 'Superhero', 'price' => 10],
    ['id' => 2, 'title' => 'Titanic', 'category' => 'Drama', 'subcategory' => 'Historical', 'price' => 15],
    ['id' => 3, 'title' => 'The Mask', 'category' => 'Comedy', 'subcategory' => 'Slapstick', 'price' => 8]
];

// Initialize cart if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    $movie_id = $_POST['movie_id'];
    if (!isset($_SESSION['cart'][$movie_id])) {
        $_SESSION['cart'][$movie_id] = 1;
    } else {
        $_SESSION['cart'][$movie_id]++;
    }
}

// Handle removing from cart
if (isset($_POST['remove_from_cart'])) {
    $movie_id = $_POST['movie_id'];
    if (isset($_SESSION['cart'][$movie_id])) {
        unset($_SESSION['cart'][$movie_id]);
    }
}

// Handle updating quantity in cart
if (isset($_POST['update_quantity'])) {
    $movie_id = $_POST['movie_id'];
    $quantity = $_POST['quantity'];
    if ($quantity > 0) {
        $_SESSION['cart'][$movie_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$movie_id]);
    }
}

// Calculate total amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $movie_id => $quantity) {
    $movie = array_filter($movies, function($m) use ($movie_id) {
        return $m['id'] == $movie_id;
    });
    $movie = array_values($movie)[0];
    $total_amount += $movie['price'] * $quantity;
}

// Return total amount if update_quantity is set
if (isset($_POST['update_quantity'])) {
    echo $total_amount;
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Shop</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function updateQuantity(movieId) {
            const quantity = document.getElementById('quantity-' + movieId).value;
            const formData = new FormData();
            formData.append('movie_id', movieId);
            formData.append('quantity', quantity);
            formData.append('update_quantity', true);

            fetch('shop.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('total-amount').innerText = '$' + data;
            });
        }
    </script>
</head>
<body>

    <button class="sidebar-button" id="sidebarToggle">☰</button>

    <div class="sidebar" id="sidebar">
        <br><br>
        <h2>Ustawienia koloru</h2>
        <div class="color-picker">
            <label for="buttonColor">Kolor:</label><br>
            <input type="color" id="buttonColor" name="buttonColor" value="#0000ff"><br><br>
        </div>
        <button id="resetColor">Przywróć oryginalny kolor</button>
    </div>

    <div class="header">
        <h1>Movie Shop</h1>
    </div>

    <div class="main-content">
        <h2>Categories</h2>
        <ul>
            <?php
            function displayCategories($categories) {
                echo '<ul>';
                foreach ($categories as $category) {
                    echo '<li>' . $category['name'];
                    if (!empty($category['subcategories'])) {
                        displayCategories($category['subcategories']);
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }
            displayCategories($categories);
            ?>
        </ul>

        <form method="post" class="form-container">
            <input type="text" name="new_category" placeholder="New Category">
            <select name="parent_id">
                <option value="0">Main Category</option>
                <?php
                function categoryOptions($categories, $prefix = '') {
                    foreach ($categories as $category) {
                        echo '<option value="' . $category['id'] . '">' . $prefix . $category['name'] . '</option>';
                        if (!empty($category['subcategories'])) {
                            categoryOptions($category['subcategories'], $prefix . '--');
                        }
                    }
                }
                categoryOptions($categories);
                ?>
            </select>
            <button type="submit" name="add_category">Add Category</button>
        </form>

        <h2>Movies</h2>
        <ul>
            <?php foreach ($movies as $movie): ?>
                <li>
                    <?php echo $movie['title']; ?> - $<?php echo $movie['price']; ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Cart</h2>
        <ul id="cart-items">
            <?php if (empty($_SESSION['cart'])): ?>
            <li id="empty-cart-message">The cart is empty</li>
            <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $movie_id => $quantity): ?>
                <?php
                $movie = array_filter($movies, function($m) use ($movie_id) {
                return $m['id'] == $movie_id;
                });
                $movie = array_values($movie)[0];
                ?>
                <li>
                <?php echo $movie['title']; ?> - Quantity: 
                <input type="number" id="quantity-<?php echo $movie_id; ?>" value="<?php echo $quantity; ?>" min="1" onchange="updateQuantity(<?php echo $movie_id; ?>)">
                <form method="post" style="display:inline;">
                    <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
                    <button type="submit" name="remove_from_cart">Remove</button>
                </form>
                </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <script>
            document.querySelectorAll('form[method="post"]').forEach(form => {
            form.addEventListener('submit', function() {
                document.getElementById('empty-cart-message')?.remove();
            });
            });
        </script>

        <h2>Total Amount</h2>
        <p id="total-amount">$<?php echo $total_amount; ?></p>
    </div>

    <div class="footer">
        <p>&copy; 2025 Movie Shop. All rights reserved.</p>
    </div>

    <script src="clock.js"></script>
    <script>
        $(document).ready(function() {
            $('.gallery img').hover(function() {
                $(this).css('transform', 'scale(1.2)');
            }, function() {
                $(this).css('transform', 'scale(1)');
            });

            let scale = 1;
            $('.gallery img').click(function() {
                scale += 0.1;
                $(this).css('transform', 'scale(' + scale + ')');
            });
        });
    </script>
</body>
</html>