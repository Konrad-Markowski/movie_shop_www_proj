<?php
$mysqli = new mysqli("localhost", "root", "", "shop");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->close();

    echo "Rejestracja zakończona sukcesem! Możesz się teraz zalogować.";
}
?>

<h2>Rejestracja użytkownika</h2>
<form method="POST">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Zarejestruj</button>
</form>
