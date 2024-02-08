<?php
require_once "ConnectDb.php";

class CreateDbTables extends ConnectDb
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createAccountTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS account (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(255),
            password VARCHAR(255)
            ) CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->pdo->exec($sql);
    }

    public function createACDTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS aniol_czy_diabel (
            login VARCHAR(255),
            games INT,
            wins INT,
            failures INT,
            draws INT
            ) CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->pdo->exec($sql);
    }

    public function createKRTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS kolorowa_ruletka (
            login VARCHAR(255),
            attempts INT,
            money INT
            ) CHARACTER SET utf8 COLLATE utf8_general_ci";

        $this->pdo->exec($sql);
    }
}
