<?php
require_once('connect.php');

session_start();

if (isset($_SESSION['login'])) {
    header('Location: games.php');
    exit();
}

mysqli_report(MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli($host, $db_user, $db_password, $db_name);

    if ($mysqli->connect_errno > 0) throw new Exception();

    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT login, password FROM account WHERE login=?");

    $stmt->bind_param('s', $login);
    $stmt->execute();

    $result = $stmt->get_result();

    if (!$result) throw new Exception();

    $users = $result->num_rows;

    if ($users > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['logged'] = true;
            $_SESSION['login'] = $row['login'];

            unset($_SESSION['error']);
            header('Location: games.php');
        } else {
            $_SESSION['error'] = '<p>Nieprawidłowy login lub hasło</p>';
            header('Location: index.php');
        }
    } else {
        $_SESSION['error'] = '<p>Nieprawidłowy login lub hasło</p>';
        header('Location: index.php');
    }

    $result->close();
    $mysqli->close();
} catch (Exception $e) {
    echo 'Kod błędu: ' . $e->getCode();
}
