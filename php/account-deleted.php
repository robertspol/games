<?php
session_start();

if (!isset($_SESSION["login"])) {
    session_unset();
    session_destroy();

    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry</title>
    <link rel="stylesheet" href="../css/index.min.css">
</head>

<body>
    <div class="delete-wrapper">
        <h1>Konto zostało usunięte. Kliknij przycisk poniżej, aby powrócić do strony głównej.</h1>
        <a href="../index.php">Strona główna</a>
    </div>
</body>

</html>