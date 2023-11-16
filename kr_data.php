<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

require_once 'connect.php';

$mysqli = new mysqli($host, $db_user, $db_password, $db_name);

if ($mysqli->connect_errno > 0) throw new Exception();

try {
    $login = $_SESSION['login'];

    $result = $mysqli->query("SELECT attempts, money FROM kolorowa_ruletka WHERE login='$login'");

    if ($result) {
        $users_amount = $result->num_rows;

        if ($users_amount > 0) {
            $row = $result->fetch_assoc();

            $_SESSION['attempts'] = $row['attempts'];
            $_SESSION['money'] = $row['money'];
        }

        $result->close();
    }

    $mysqli->close();
} catch (Exception $e) {
    echo 'Kod błędu: ' . $e->getCode();
}

$kr_data = json_encode(array(
    'attemptsAmount' => $_SESSION['attempts'],
    'moneyAmount' => $_SESSION['money'],
));

echo $kr_data;
