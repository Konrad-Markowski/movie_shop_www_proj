<?php
// Funkcja wyświetlająca stronę
include_once 'cfg.php';

function showPage($alias)
{
    global $mysqli;
    $page_title = htmlspecialchars($alias, ENT_QUOTES, 'UTF-8');
    $query = "SELECT * FROM page_list WHERE page_title = '$page_title' LIMIT 1";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($result);

    if (empty($row['id'])) {
        $content = "Nie znaleziono strony";
        $title = "Nie znaleziono strony";
    } else {
        $content = $row["page_content"];
        $title = $row["page_title"];
        
        // Bezpieczne uruchamianie kodu PHP w page_content
        ob_start();
        eval("?>$content<?php ");
        $content = ob_get_clean();
    }

    return array($title, $content);
}

function showPageList($mysqli)
{
    $query = "SELECT id, page_title FROM page_list WHERE status = 1 ORDER BY id ASC LIMIT 10";
    $result = mysqli_query($mysqli, $query);
    return $result;
}
