<?php
session_start();
require_once "ConnectDb.php";
ini_set("display_errors", 0);

class Out extends ConnectDb
{
    public function signOut()
    {
        session_unset();
        session_destroy();

        header("Location: ../../index.php");
    }

    public function unregister()
    {
        try {
            $login = $_SESSION['login'];

            $stmt1 = $this->pdo->prepare("DELETE FROM account WHERE login = :login");
            $stmt1->bindParam(":login", $login);
            $stmt1->execute();

            $stmt2 = $this->pdo->prepare("DELETE FROM aniol_czy_diabel WHERE login = :login");
            $stmt2->bindParam(":login", $login);
            $stmt2->execute();

            $stmt3 = $this->pdo->prepare("DELETE FROM kolorowa_ruletka WHERE login = :login");
            $stmt3->bindParam(":login", $login);
            $stmt3->execute();

            header("Location: ../account-deleted.php");
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }
}
