<?php
require_once "../classes/ConnectDb.php";
session_start();
ini_set("display_errors", 0);

class SignInBackend extends ConnectDb
{
    public function signIn($formData)
    {
        try {
            $login = $formData["login"];
            $password = $formData["password"];

            $stmt = $this->pdo->prepare("SELECT * FROM account WHERE login = :login");
            $stmt->bindParam(":login", $login);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $row["password"])) {
                    $_SESSION["login"] = $row["login"];

                    header("Location: ../games.php");
                    exit();
                } else {
                    $_SESSION["error"] = "<p>Nieprawidłowe hasło</p>";
                }
            } else {
                $_SESSION["error"] = "<p>Nieprawidłowy login</p>";
            }
        } catch (PDOException $e) {
            echo "Kod błędu: " . $e->getMessage();
        }

        header("Location: ../../index.php");
    }
}
