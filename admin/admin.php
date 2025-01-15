<?php
include '../cfg.php';

// Fetch page list
$sql = "SELECT * FROM page_list";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <a href="add_page.php">Add New Page</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['page_title']; ?></td>
                <td><?= $row['status'] ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <a href="edit_page.php?id=<?= $row['id']; ?>">Edit</a> |
                    <a href="delete_page.php?id=<?= $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
