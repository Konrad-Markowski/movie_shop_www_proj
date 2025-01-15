<?php
session_start();
require_once('cfg.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Weryfikacja hasła
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $user;
            header("Location: admin.php");
            exit;
        } else {
            $error = "Nieprawidłowe hasło!";
        }
    } else {
        $error = "Nie znaleziono użytkownika!";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Konrad Markowski">
    <title>Logowanie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="header">
    <h1>Witamy w naszym serwisie</h1>
</header>

<div class="main-content">
    <h1>Logowanie</h1>
    <p>Zaloguj się do swojego konta, aby uzyskać dostęp do panelu administratora.</p>
    
    <!-- Formularz logowania -->
    <div class="form-container">
        <form method="POST" action="login.php" autocomplete="off">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Zaloguj">
        </form>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2025 Movie Shop. Wszelkie prawa zastrzeżone.</p>
</footer>

</body>
</html>
