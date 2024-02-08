<?php
session_start();
require_once "ConnectDb.php";
ini_set("display_errors", 0);

class KolorowaRuletka extends ConnectDb
{
    private $login;

    public function __construct()
    {
        parent::__construct();
        $this->login = $_SESSION["login"];
    }

    public function getData()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT attempts, money FROM kolorowa_ruletka WHERE login = :login");
            $stmt->bindParam("login", $this->login);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $krData = json_encode(array(
                    "attemptsAmount" => $row["attempts"],
                    "moneyAmount" => $row["money"]
                ));

                echo $krData;
            }
        } catch (PDOException $e) {
            echo "Kod błędu: " . $e->getMessage();
        }
    }

    public function saveData()
    {
        try {
            $jsonData = file_get_contents("php://input");
            $data = json_decode($jsonData);

            if ($data)
                $stmt = $this->pdo->prepare("UPDATE kolorowa_ruletka SET attempts = :attempts, money = :money WHERE login = :login");

            $stmt->bindParam(":attempts", $data->attemptsAmount);
            $stmt->bindParam(":money", $data->moneyAmount);
            $stmt->bindParam(":login", $this->login);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }
}
