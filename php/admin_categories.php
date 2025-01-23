<?php
$mysqli = new mysqli("localhost", "root", "", "shop");

if ($mysqli->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
}

// Funkcje do zarządzania kategoriami
function DodajKategorie($category_name, $parent_id) {
    global $mysqli;

    // Jeśli parent_id jest 0, ustawiamy NULL, ponieważ matka nie może być zerowa w tabeli
    if ($parent_id == 0) {
        $parent_id = NULL;
    }

    // Przygotowanie zapytania SQL
    $stmt = $mysqli->prepare("INSERT INTO kategorie (nazwa, matka) VALUES (?, ?)");
    $stmt->bind_param("si", $category_name, $parent_id);

    // Wykonanie zapytania
    if ($stmt->execute() === false) {
        echo "Błąd: " . $stmt->error;
    }
    $stmt->close();
}

function UsunKategorie($category_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM kategorie WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    if ($stmt->execute() === false) {
        echo "Błąd: " . $stmt->error;
    }
    $stmt->close();
}

function EdytujKategorie($category_id, $category_name, $parent_id) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE kategorie SET nazwa = ?, matka = ? WHERE id = ?");
    $stmt->bind_param("sii", $category_name, $parent_id, $category_id);
    if ($stmt->execute() === false) {
        echo "Błąd: " . $stmt->error;
    }
    $stmt->close();
}

function WyswietlKategorie($parent_id = null, $poziom = 0) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, nazwa FROM kategorie WHERE matka " . ($parent_id === null ? "IS NULL" : "= ?") . " ORDER BY nazwa ASC");
    
    if ($parent_id !== null) {
        $stmt->bind_param("i", $parent_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['nazwa']);
            // Rekurencyjnie wywołaj dla dzieci
            WyswietlKategorie($row['id'], $poziom + 1);
            echo "</li>";
        }
        echo "</ul>";
    }

    $stmt->close();
}

// Obsługa żądań POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'DodajKategorie':
            DodajKategorie($_POST['categoryName'], $_POST['parentCategory']);
            echo "Kategoria została dodana.";
            break;
        case 'UsunKategorie':
            UsunKategorie($_POST['categoryId']);
            echo "Kategoria została usunięta.";
            break;
        case 'EdytujKategorie':
            EdytujKategorie($_POST['categoryId'], $_POST['categoryName'], $_POST['parentCategory']);
            echo "Kategoria została zaktualizowana.";
            break;
    }
}

// // Obsługa żądań GET
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     $action = $_GET['action'];
//     switch ($action) {
//         case 'PokazKategorie':
//             WyswietlKategorie();
//             break;
//     }
// }
// ?>
