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

    $json_data = file_get_contents('php://input');

    $data = json_decode($json_data);

    if (!$data) {
        echo 'Błąd - nie można zapisać gry.';
    } else {
        $login = $_SESSION['login'];

        $mysqli->query("UPDATE aniol_czy_diabel SET games=$data->games, wins=$data->wins, failures=$data->failures, draws=$data->draws WHERE login='$login'");
    }

    $mysqli->close();
} catch (Exception $e) {
    echo 'Kod błędu: ' . $e->getCode();
}
