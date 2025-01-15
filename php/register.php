<?php
session_start();
require_once('cfg.php');

// Obsługa formularza rejestracji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $role = 'user'; // Domyślnie user

    // Sprawdzenie zgodności haseł
    if ($pass !== $confirm_pass) {
        $error = "Hasła nie pasują do siebie!";
    } else {
        // Sprawdzenie, czy użytkownik już istnieje
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Użytkownik o podanej nazwie już istnieje!";
        } else {
            // Hashowanie hasła
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

            // Dodanie użytkownika do bazy danych
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user, $hashed_pass, $role);
            if ($stmt->execute()) {
                $success = "Rejestracja zakończona sukcesem! Możesz się teraz zalogować.";
            } else {
                $error = "Wystąpił błąd podczas rejestracji.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Rejestracja użytkownika</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required>
            <label for="confirm_password">Potwierdź hasło:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <button type="submit">Zarejestruj</button>
        </form>
    </div>
</body>
</html>
