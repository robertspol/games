<?php
session_start();
require_once "ConnectDb.php";
ini_set("display_errors", 0);

class SignUpBackend extends ConnectDb
{
    public function signUp($formData)
    {
        $allCorrect = true;
        $login = $formData["login"];

        if (!ctype_alnum($login)) {
            $allCorrect = false;
            $_SESSION["err_login"] = "Nazwa użytkownika może zawierać tylko litery i cyfry";
        }

        if (strlen($login) < 3 || strlen($login) > 20) {
            $allCorrect = false;
            $_SESSION["err_login"] = "Nazwa użytkownika musi posiadać od 3 do 20 znaków";
        }

        $password1 = $formData["password1"];
        $password2 = $formData["password2"];

        if (strlen($password1) < 8 || strlen($password1) > 20) {
            $allCorrect = false;
            $_SESSION["err_password"] = "Hasło musi posiadać od 8 do 20 znaków";
        }

        if ($password1 !== $password2) {
            $allCorrect = false;
            $_SESSION["err_password"] = "Podane hasła muszą być takie same";
        }

        $passwordHashed = password_hash($password1, PASSWORD_DEFAULT);

        if (!isset($formData["regulations"])) {
            $allCorrect = false;
            $_SESSION["err_regulations"] = "Musisz zaakceptować regulamin";
        }

        $_SESSION["entered_login"] = $login;
        $_SESSION["entered_password1"] = $password1;
        $_SESSION["entered_password2"] = $password2;

        if (isset($formData["regulations"])) {
            $_SESSION["entered_regulations"] = true;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT login FROM account WHERE login = :login");
            $stmt->bindParam(":login", $login);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $allCorrect = false;
                $_SESSION["err_login"] = "Użytkownik z taką nazwą już istnieje";
            }
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }

        if ($allCorrect) {
            $stmt1 = $this->pdo->prepare("INSERT INTO account (login, password) VALUES (:login, :password_hashed)");

            $stmt1->bindParam(":login", $login);
            $stmt1->bindParam(":password_hashed", $passwordHashed);

            $stmt1->execute();

            $stmt2 = $this->pdo->prepare("INSERT INTO aniol_czy_diabel (login, games, wins, failures, draws) VALUES (:login, :games, :wins, :failures, :draws)");

            $stmt2->bindParam(":login", $login);
            $stmt2->bindValue(":games", 0);
            $stmt2->bindValue(":wins", 0);
            $stmt2->bindValue(":failures", 0);
            $stmt2->bindValue(":draws", 0);

            $stmt2->execute();

            $stmt3 = $this->pdo->prepare("INSERT INTO kolorowa_ruletka (login, attempts, money) VALUES (:login, :attempts, :money)");

            $stmt3->bindParam(":login", $login);
            $stmt3->bindValue(":attempts", 0);
            $stmt3->bindValue(":money", 10);

            $stmt3->execute();

            $_SESSION["success"] = true;

            header("Location: ../welcome.php");
            exit();
        }

        header("Location: ../sign-up.php");
    }
}
