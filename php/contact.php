<?php
class Kontakt {
    public function PokazKontakt() {
        echo '
        <!DOCTYPE html>
        <html lang="pl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Kontakt</title>
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <div class="header">
                <h1>Kontakt</h1>
            </div>
            <div class="main-content">
                <h2>Formularz kontaktowy</h2>
                <div class="form-container">
                    <form action="contact.php" method="post">
                        <label for="name">Imię:</label><br>
                        <input type="text" id="name" name="name"><br><br>
                        <label for="email">E-mail:</label><br>
                        <input type="email" id="email" name="email"><br><br>
                        <label for="subject">Temat:</label><br>
                        <input type="text" id="subject" name="subject"><br><br>
                        <label for="message">Wiadomość:</label><br>
                        <textarea id="message" name="message" rows="6" cols="50"></textarea><br><br>
                        <input type="submit" value="Wyślij">
                    </form>
                </div>
            </div>
            <div class="footer">
                <p>&copy; 2024 Filmy Oscarowe. Wszelkie prawa zastrzeżone.</p>
            </div>
        </body>
        </html>';
    }

    public function WyslijMailKontakt() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $to = "k.markowski2002@gmail.com";
            $headers = "From: " . $email;

            if (mail($to, $subject, $message, $headers)) {
                echo "Wiadomość została wysłana.";
            } else {
                echo "Wystąpił błąd podczas wysyłania wiadomości.";
            }
        }
    }

    public function PrzypomnijHaslo() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $subject = "Przypomnienie hasła";
            $message = "Twoje hasło do panelu admina to: [TwojeHaslo]";

            $to = $email;
            $headers = "From: admin@twojastrona.pl";

            if (mail($to, $subject, $message, $headers)) {
                echo "Wiadomość z hasłem została wysłana.";
            } else {
                echo "Wystąpił błąd podczas wysyłania wiadomości.";
            }
        }
    }
}

$kontakt = new Kontakt();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['subject']) && isset($_POST['message'])) {
        $kontakt->WyslijMailKontakt();
    } elseif (isset($_POST['email'])) {
        $kontakt->PrzypomnijHaslo();
    }
} else {
    $kontakt->PokazKontakt();
}
