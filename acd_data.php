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

    $result = $mysqli->query("SELECT games, wins, failures, draws FROM aniol_czy_diabel WHERE login='$login'");

    if ($result) {
        $users_amount = $result->num_rows;

        if ($users_amount > 0) {
            $row = $result->fetch_assoc();

            $_SESSION['games'] = $row['games'];
            $_SESSION['wins'] = $row['wins'];
            $_SESSION['failures'] = $row['failures'];
            $_SESSION['draws'] = $row['draws'];
        }

        $result->close();
    }

    $mysqli->close();
} catch (Exception $e) {
    echo 'Kod błędu: ' . $e->getCode();
}

$acd_data = json_encode(array(
    'games' => $_SESSION['games'],
    'wins' => $_SESSION['wins'],
    'failures' => $_SESSION['failures'],
    'draws' => $_SESSION['draws']
));

echo $acd_data;
