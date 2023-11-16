<?php
session_start();

if (!isset($_SESSION['success'])) {
    header('Location: index.php');
    exit();
} else {
    unset($_SESSION['success']);
}

if (isset($_SESSION['entered_login'])) unset($_SESSION['entered_login']);
if (isset($_SESSION['entered_password1'])) unset($_SESSION['entered_password1']);
if (isset($_SESSION['entered_password2'])) unset($_SESSION['entered_password2']);
if (isset($_SESSION['entered_regulations'])) unset($_SESSION['entered_regulations']);

if (isset($_SESSION['err_login'])) unset($_SESSION['err_login']);
if (isset($_SESSION['err_password'])) unset($_SESSION['err_password']);
if (isset($_SESSION['err_regulations'])) unset($_SESSION['err_regulations']);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry - witam!</title>
    <link rel="stylesheet" href="./css/index.min.css">
</head>

<body>
    <div class="welcome-wrapper">
        <h1>Dziękuję za rejestrację. Możesz już zalogować się na swoje konto i bić rekordy!</h1>

        <a href="./index.php">Zaloguj się</a>
    </div>
</body>

</html>