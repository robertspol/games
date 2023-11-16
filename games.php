<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry</title>
    <link rel="stylesheet" href="./css/index.min.css">
</head>

<body>
    <div class="games-wallpaper"></div>

    <div class="games-wrapper">
        <div class="welcome">
            <?php echo "Witaj " . $_SESSION['login'] . '. Wybierz grę i poprawiaj swój wynik!' ?>
        </div>

        <nav class="games-list">
            <ul>
                <li>
                    <a>Anioł czy diabeł</a>
                </li>

                <li>
                    <a>Kolorowa ruletka</a>
                </li>
            </ul>
        </nav>

        <div class="logout-wrapper">
            <a href="logout.php">Wyloguj się</a>
        </div>

        <div class="delete-account-wrapper">
            <a href="account-delete.php">Usuń konto</a>
        </div>
    </div>

    <script src="./games.js"></script>
</body>

</html>