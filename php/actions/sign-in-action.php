<?php
require_once "../classes/SignInBackend.php";

if (isset($_POST["login"])) {
    $signIn = new SignInBackend();
    $signIn->signIn($_POST);
} else {
    header("Location: ../../index.php");
}
