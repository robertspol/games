<?php
session_start();

if (isset($_POST['login'])) {
    $all_correct = true;

    $login = $_POST['login'];

    if (!ctype_alnum($login)) {
        $all_correct = false;
        $_SESSION['err_login'] = 'Nazwa użytkownika może zawierać tylko litery i cyfry';
    }

    if (strlen($login) < 3 || strlen($login) > 20) {
        $all_correct = false;
        $_SESSION['err_login'] = 'Nazwa użytkownika musi posiadać od 3 do 20 znaków';
    }

    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if (strlen($password1) < 8 || strlen($password1) > 20) {
        $all_correct = false;
        $_SESSION['err_password'] = 'Hasło musi posiadać od 8 do 20 znaków';
    }

    if ($password1 != $password2) {
        $all_correct = false;
        $_SESSION['err_password'] = 'Podane hasła muszą być takie same';
    }

    $pass_hash = password_hash($password1, PASSWORD_DEFAULT);

    if (!isset($_POST['regulations'])) {
        $all_correct = false;
        $_SESSION['err_regulations'] = 'Musisz zaakceptować regulamin';
    }

    $_SESSION['entered_login'] = $login;
    $_SESSION['entered_password1'] = $password1;
    $_SESSION['entered_password2'] = $password2;

    if (isset($_POST['regulations'])) {
        $_SESSION['entered_regulations'] = true;
    }

    mysqli_report(MYSQLI_REPORT_STRICT);

    require_once 'connect.php';

    try {
        $mysqli = new mysqli($host, $db_user, $db_password, $db_name);

        if ($mysqli->connect_errno > 0) {
            throw new Exception();
        } else {
            $sql = "SELECT login FROM account WHERE login='$login'";

            $result = $mysqli->query($sql);

            if (!$result) throw new Exception();

            $users_amount = $result->num_rows;

            if ($users_amount > 0) {
                $all_correct = false;
                $_SESSION['err_login'] = 'Użytkownik z taką nazwą już istnieje';
            }

            $result->close();
        }
    } catch (Exception) {
        echo 'Nie połączono z bazą danych.';
    }

    if ($all_correct) {
        $mysqli->query("INSERT INTO account VALUES('$login', '$pass_hash')");
        $mysqli->query("INSERT INTO aniol_czy_diabel VALUES('$login', 0, 0, 0, 0)");
        $mysqli->query("INSERT INTO kolorowa_ruletka VALUES('$login', 0, 10)");

        $_SESSION['success'] = true;

        header('Location: welcome.php');
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry - rejestracja</title>
    <link rel="stylesheet" href="./css/index.min.css">
</head>

<body>
    <div class="wallpaper"></div>

    <section class="wrapper">
        <form method="post">
            <div class="login-wrapper input-wrapper">
                <label for="login">Nazwa użytkownika:</label>
                <input type="text" name="login" id="login" placeholder="Nazwa użytkownika" value="<?php
                                                                                                    if (isset($_SESSION['entered_login'])) {
                                                                                                        echo $_SESSION['entered_login'];
                                                                                                        unset($_SESSION['entered_login']);
                                                                                                    }
                                                                                                    ?>">
            </div>

            <div class="error-registration-wrapper">
                <?php
                if (isset($_SESSION['err_login'])) {
                    echo '<p>' . $_SESSION['err_login'] . '</p>';
                    unset($_SESSION['err_login']);
                }
                ?>
            </div>

            <div class="pass-wrapper pass-wrapper1">
                <label for="password1">Hasło:</label>
                <input type="password" name="password1" id="password1" placeholder="Hasło" value="<?php
                                                                                                    if (isset($_SESSION['entered_password1'])) {
                                                                                                        echo $_SESSION['entered_password1'];
                                                                                                        unset($_SESSION['entered_password1']);
                                                                                                    }
                                                                                                    ?>">
            </div>

            <div class="error-registration-wrapper">
                <?php
                if (isset($_SESSION['err_password'])) {
                    echo '<p>' . $_SESSION['err_password'] . '</p>';
                    unset($_SESSION['err_password']);
                }
                ?>
            </div>

            <div class="pass-wrapper pass-wrapper2">
                <label for="password2">Powtórz hasło:</label>
                <input type="password" name="password2" id="password2" placeholder="Hasło" value="<?php
                                                                                                    if (isset($_SESSION['entered_password2'])) {
                                                                                                        echo $_SESSION['entered_password2'];
                                                                                                        unset($_SESSION['entered_password2']);
                                                                                                    }
                                                                                                    ?>">
            </div>

            <div class="regulations-wrapper input-wrapper">
                <label for="regulations">Akceptuję regulamin</label>
                <input type="checkbox" name="regulations" id="regulations" <?php
                                                                            if (isset($_SESSION['entered_regulations'])) {
                                                                                echo "checked";
                                                                                unset($_SESSION['entered_regulations']);
                                                                            }
                                                                            ?>>
            </div>

            <div class="error-registration-wrapper">
                <?php
                if (isset($_SESSION['err_regulations'])) {
                    echo '<p>' . $_SESSION['err_regulations'] . '</p>';
                    unset($_SESSION['err_regulations']);
                }
                ?>
            </div>

            <input class="submit-registration" type="submit" value="Zarejestruj się">
        </form>

        <div class="buttons-wrapper">
            <div class="link-start-wrapper a">
                <a href="./index.php">Logowanie</a>
            </div>

            <div class="link-regulations-wrapper">
                <a href="./regulations.php">Regulamin</a>
            </div>
        </div>
    </section>
</body>

</html>