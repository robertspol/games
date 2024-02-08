<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: php/games.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry - strona startowa</title>
    <link rel="stylesheet" href="css/index.min.css">
</head>

<body>
    <div class="wallpaper"></div>

    <section class="wrapper">
        <form action="php/actions/sign-in-action.php" method="POST">
            <div class="sign-in-wrapper">
                <label for="login">Wpisz nazwę użytkownika:</label>
                <input id="login" type="text" name="login" placeholder="Nazwa użytkownika">
            </div>

            <div class="pass-wrapper">
                <label for="password">Wpisz hasło:</label>
                <input id="password" type="password" name="password" placeholder="Hasło">
            </div>

            <div class="error-sign-in-wrapper">
                <?php
                if (isset($_SESSION["error"])) {
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                }
                ?>
            </div>

            <input class="sign-in-submit" type="submit" value="Zaloguj się">
        </form>

        <div class="link-sign-up-wrapper">
            <a href="php/sign-up.php">Załóż konto</a>
        </div>

        <h1 class="text">Zagraj w gry, w których liczy się szczęście, ale także ryzyko. Jeśli nie posiadasz konta, załóż je już teraz!</h1>

        <div class="info-wrapper">
            <a href="php/info.php">Zasady gier</a>
        </div>
    </section>
</body>

</html>