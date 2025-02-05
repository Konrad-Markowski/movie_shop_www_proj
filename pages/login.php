<?php
session_start();
include_once 'cfg.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Zapytanie uwzględniające sprawdzenie uprawnień administratora
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND admin_privilages = 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $user['username']; // Zapisanie nazwy użytkownika w sesji, jeśli potrzeba
        header("Location: index.php?idp=admin_panel");
        exit();
    } else {
        $error = "Nieprawidłowa nazwa użytkownika, hasło lub brak uprawnień administratora.";
    }
}
?>

<h2>Logowanie do panelu administratora</h2>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<form method="POST">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Zaloguj</button>
</form>
