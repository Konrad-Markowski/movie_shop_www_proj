-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 22, 2025 at 01:54 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `matka` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `nazwa`, `matka`) VALUES
(1, 'Dramat', NULL),
(2, 'Akcja', NULL),
(3, 'Przygodowe', NULL),
(4, 'Przygodowe', NULL),
(5, 'superbohaterowie', NULL),
(6, 'Marvel', 5),
(8, 'Horror', NULL),
(9, 'Paranormalne', 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `page_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'glowna', '<table style=\"width: 100%\">\r\n    <tr>\r\n        <th><a href=\"index.php?idp=glowna\">Główna </a></th>\r\n        <th><a href=\"index.php?idp=contact\">Kontakt </a></th>\r\n        <th><a href=\"index.php?idp=movies\">Filmy </a></th>\r\n        <th><a href=\"index.php?idp=categories\">Kategorie</a></th>\r\n     </tr>\r\n</table>\r\n<section>\r\n    <h2>Najdłuższe mosty świata</h2>\r\n    <div class=\"text\">\r\n        <p>Strona omawia najdłuższe mosty świata</p>\r\n    </div>\r\n</section>\r\n<section>\r\n    <h2>Witamy na naszej stronie!</h2>\r\n    <div class=\"text\">\r\n        <p>Witamy na naszej stronie poświęconej najdłuższym mostom świata. Znajdziesz tutaj informacje o najbardziej imponujących konstrukcjach mostowych, które łączą odległe miejsca i ułatwiają podróżowanie. Nasza strona zawiera szczegółowe opisy, zdjęcia oraz ciekawostki na temat tych niesamowitych budowli.</p>\r\n        <p>Zapraszamy do eksploracji i odkrywania fascynujących faktów o mostach, które zmieniają świat.</p>\r\n    </div>\r\n</section></div>', 1),
(2, 'contact', '<header>\r\n    <h1>Kontakt</h1>\r\n</header>\r\n\r\n<table class=\"menu\">\r\n    <tr>\r\n        <th><a href=\"index.php?idp=glowna\">Główna </a></th>\r\n        <th><a href=\"index.php?idp=contact\">Kontakt </a></th>\r\n        <th><a href=\"index.php?idp=movies\">Filmy </a></th>\r\n        <th><a href=\"index.php?idp=categories\">Kategorie</a></th>\r\n     </tr>\r\n</table>\r\n\r\n<section id=\"contact\">\r\n    <h2>Skontaktuj się z nami</h2>\r\n    <form action=\"k.markowski2002@gmail.com\" method=\"post\" enctype=\"text/plain\">\r\n        <label for=\"name\">Imię:</label>\r\n        <input type=\"text\" id=\"name\" name=\"n ame\" required>\r\n        <br>\r\n        <label for=\"email\">Email:</label>\r\n        <input type=\"email\" id=\"email\" name=\"email\" required>\r\n        <br>\r\n        <label for=\"message\">Treść:</label>\r\n        <br>\r\n        <textarea id=\"message\" name=\"message\" rows=\"4\" required></textarea>\r\n        <br>\r\n        <input type=\"submit\" value=\"Wyślij wiadomość\">\r\n    </form>\r\n</section>\r\n<section id=\"contactForm\">\r\n    <h2> Formularz kontaktowy </h2>\r\n        <a href=\"contact.php\">Formularz Kontaktowy</a>\r\n</section>', 1),
(3, 'movies', '<table style=\"width: 100%\">\r\n    <tr>\r\n       <th><a href=\"index.php?idp=glowna\">Główna </a></th>\r\n       <th><a href=\"index.php?idp=contact\">Kontakt </a></th>\r\n       <th><a href=\"index.php?idp=movies\">Filmy </a></th>\r\n       <th><a href=\"index.php?idp=categories\">Kategorie</a></th>\r\n    </tr>\r\n</table>\r\n\r\n<section>\r\n    <h2>Najlepiej Oceniane Filmy</h2>\r\n\r\n    <p>W tej sekcji znajdziesz zwiastuny do najlepiej ocenianych filmów wszechczasów.</p>\r\n    <div class=\"video-container\">\r\n       <iframe width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/EXeTwQWrcwY\" title=\"The Dark Knight Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n       <p>The Dark Knight - Film o Batmanie walczącym z Jokerem, reżyserowany przez Christophera Nolana.</p>\r\n       <iframe width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/6hB3S9bIaco\" title=\"The Shawshank Redemption Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n       <p>The Shawshank Redemption - Historia niesłusznie skazanego więźnia, który planuje ucieczkę z więzienia Shawshank.</p>\r\n       <iframe width=\"640\" height=\"360\" src=\"https://www.youtube.com/embed/YoHD9XEInc0\" title=\"Inception Trailer\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n       <p>Inception - Film science fiction o złodzieju, który wchodzi do snów ludzi, aby ukraść ich sekrety, reżyserowany przez Christophera Nolana.</p>\r\n    </div>\r\n</section>', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price_net` decimal(10,2) NOT NULL,
  `vat_tax` decimal(4,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `availability_status` tinyint(1) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price_net`, `vat_tax`, `stock_quantity`, `availability_status`, `image_path`, `category_id`) VALUES
(2, 'La La Land', 'film o nieszczęśliwej miłości', 26.00, 23.00, 15, 0, NULL, 1),
(3, 'Avengers', 'bohaterowie', 80.00, 23.00, 17, 0, NULL, 6),
(4, 'The Notebook', 'aaaaa', 14.00, 15.00, 3, 0, NULL, 1),
(5, 'Forrest Gump', 'aadsafasf', 124.00, 23.00, 5, 0, NULL, 3),
(6, 'Iron-Man', 'czlowiek zelazko', 14.00, 11.00, 5, 1, NULL, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin_privilages` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `admin_privilages`) VALUES
(0, 'admin', '$2y$10$emPlaXKRwhj1BXBsBxic..UN0fBFBwENMvBEwS/jHqngQuGHc3CPG', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matka` (`matka`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD CONSTRAINT `kategorie_ibfk_1` FOREIGN KEY (`matka`) REFERENCES `kategorie` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `kategorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
