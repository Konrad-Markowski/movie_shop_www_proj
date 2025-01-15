<?php
include '../cfg.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $status = intval($_POST['status']);
    
    $sql = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$title', '$content', $status)";
    if ($conn->query($sql)) {
        echo "Page added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Page</title>
</head>
<body>
    <form method="POST">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Content: <textarea name="content" required></textarea></label><br>
        <label>Status: <input type="checkbox" name="status" value="1" checked></label><br>
        <button type="submit">Add Page</button>
    </form>
</body>
</html>
