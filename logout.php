<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

// unset($_SESSION['logged']);
// unset($_SESSION['login']);

// unset($_SESSION['games']);
// unset($_SESSION['wins']);
// unset($_SESSION['failures']);
// unset($_SESSION['draws']);

// unset($_SESSION['attempts']);
// unset($_SESSION['money']);

// unset($_SESSION['error']);

session_unset();
session_destroy();

header('Location: index.php');
