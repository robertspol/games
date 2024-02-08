<?php
session_start();
require_once "ConnectDb.php";
ini_set("display_errors", 0);

class AniolCzyDiabel extends ConnectDb
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
            $stmt = $this->pdo->prepare("SELECT games, wins, failures, draws FROM aniol_czy_diabel WHERE login = :login");
            $stmt->bindParam(":login", $this->login);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $acdData = json_encode(array(
                    "games" => $row["games"],
                    "wins" => $row["wins"],
                    "failures" => $row["failures"],
                    "draws" => $row["draws"]
                ));

                echo $acdData;
            }
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }

    public function saveData()
    {
        try {
            $jsonData = file_get_contents("php://input");
            $data = json_decode($jsonData);

            if ($data) {
                $stmt = $this->pdo->prepare("UPDATE aniol_czy_diabel SET games = :games, wins = :wins, failures = :failures, draws = :draws WHERE login = :login");

                $stmt->bindParam(":games", $data->games);
                $stmt->bindParam(":wins", $data->wins);
                $stmt->bindParam(":failures", $data->failures);
                $stmt->bindParam(":draws", $data->draws);
                $stmt->bindParam(":login", $this->login);

                $stmt->execute();
            }
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }

    public function resetData()
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE aniol_czy_diabel SET games = :games, wins = :wins, failures = :failures, draws = :draws WHERE login = :login");

            $stmt->bindValue(":games", 0);
            $stmt->bindValue(":wins", 0);
            $stmt->bindValue(":failures", 0);
            $stmt->bindValue(":draws", 0);
            $stmt->bindParam(":login", $this->login);

            $stmt->execute();
        } catch (PDOException $e) {
            echo "Błąd: " . $e->getMessage();
        }
    }
}
