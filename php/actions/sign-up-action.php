<?php
require_once "../classes/SignUpBackend.php";
require_once "../classes/CreateDbTables.php";

if (isset($_POST["login"])) {
    $createAccountTable = new CreateDbTables();
    $createAccountTable->createAccountTable();

    $createACDTable = new CreateDbTables();
    $createACDTable->createACDTable();

    $createKRTable = new CreateDbTables();
    $createKRTable->createKRTable();

    $signUp = new SignUpBackend();
    $signUp->signUp($_POST);
} else {
    header("Location: ../../index.php");
}
