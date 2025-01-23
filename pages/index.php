<?php
include_once './cfg.php';
include_once './showpage.php';

// Get requested page or default to home
$page = $_GET['idp'] ?? 'home';

// Get page content
list($title, $content) = showPage($page);
$pageList = showPageList($mysqli);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($title); ?></title>
  <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
  <header class="header">
   <h1>Sklep Internetowy</h1>
  </header>
  <nav class="menu">
    <div style="display: flex; gap: 10px;"></div>
      <?php
      if (mysqli_num_rows($pageList) > 0) {
          while ($row = mysqli_fetch_array($pageList)) {
              echo '<a href="index.php?idp=' . urlencode($row['page_title']) . '">'
                . htmlspecialchars($row['page_title']) . '</a>';
          }
      } else {
          echo '<span>Brak stron do wyświetlenia</span>';
      }
      ?>
    </div>
  </nav>
  <main class="main-content">
    <?php echo $content; ?>
  </main>
  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Sklep Internetowy. Wszelkie prawa zastrzeżone.</p>
  </footer>
  <script src="./js/clock.js"></script>
  <script src="./js/change-bg.js"></script>
</body>

</html>