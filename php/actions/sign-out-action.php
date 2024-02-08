<?php
session_start();
require_once "../classes/Out.php";

if (isset($_SESSION["login"])) {
    $out = new Out();
    $out->signOut();
} else {
    header("Location: ../../index.php");
}
