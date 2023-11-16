<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

require_once 'connect.php';

try {
    $mysqli = new mysqli($host, $db_user, $db_password, $db_name);

    if ($mysqli->connect_errno > 0) throw new Exception();

    $login = $_SESSION['login'];

    $mysqli->query("DELETE FROM account WHERE login='$login'");
    $mysqli->query("DELETE FROM aniol_czy_diabel WHERE login='$login'");
    $mysqli->query("DELETE FROM kolorowa_ruletka WHERE login='$login'");

    $mysqli->close();

    session_unset();
    session_destroy();
} catch (Exception $e) {
    echo 'Kod błędu: ' . $e->getCode();
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
    <div class="delete-wrapper">
        <h1>Konto zostało usunięte. Kliknij przycisk poniżej, aby powrócić do strony głównej.</h1>
        <a href="index.php">Strona główna</a>
    </div>
</body>

</html>