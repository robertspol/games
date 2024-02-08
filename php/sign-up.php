<?php
session_start()
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry - rejestracja</title>
    <link rel="stylesheet" href="../css/index.min.css">
</head>

<body>
    <div class="wallpaper"></div>

    <section class="wrapper">
        <form action="actions/sign-up-action.php" method="POST">
            <div class="login-wrapper input-wrapper">
                <label for="login">Nazwa użytkownika:</label>
                <input type="text" name="login" id="login" placeholder="Nazwa użytkownika" value="<?php
                                                                                                    if (isset($_SESSION["entered_login"])) {
                                                                                                        echo $_SESSION["entered_login"];
                                                                                                        unset($_SESSION["entered_login"]);
                                                                                                    }
                                                                                                    ?>">
            </div>

            <div class="error-sign-up-wrapper">
                <?php
                if (isset($_SESSION["err_login"])) {
                    echo "<p>" . $_SESSION["err_login"] . "</p>";
                    unset($_SESSION["err_login"]);
                }
                ?>
            </div>

            <div class="pass-wrapper pass-wrapper1">
                <label for="password1">Hasło:</label>
                <input type="password" name="password1" id="password1" placeholder="Hasło" value="<?php
                                                                                                    if (isset($_SESSION["entered_password1"])) {
                                                                                                        echo $_SESSION["entered_password1"];
                                                                                                        unset($_SESSION["entered_password1"]);
                                                                                                    }
                                                                                                    ?>">
            </div>

            <div class="error-sign-up-wrapper">
                <?php
                if (isset($_SESSION["err_password"])) {
                    echo "<p>" . $_SESSION["err_password"] . "</p>";
                    unset($_SESSION["err_password"]);
                }
                ?>
            </div>

            <div class="pass-wrapper pass-wrapper2">
                <label for="password2">Powtórz hasło:</label>
                <input type="password" name="password2" id="password2" placeholder="Hasło" value="<?php
                                                                                                    if (isset($_SESSION["entered_password2"])) {
                                                                                                        echo $_SESSION["entered_password2"];
                                                                                                        unset($_SESSION["entered_password2"]);
                                                                                                    }
                                                                                                    ?>">
            </div>

            <div class="regulations-wrapper input-wrapper">
                <label for="regulations">Akceptuję regulamin</label>
                <input type="checkbox" name="regulations" id="regulations" <?php
                                                                            if (isset($_SESSION["entered_regulations"])) {
                                                                                echo "checked";
                                                                                unset($_SESSION["entered_regulations"]);
                                                                            }
                                                                            ?>>
            </div>

            <div class="error-sign-up-wrapper">
                <?php
                if (isset($_SESSION["err_regulations"])) {
                    echo "<p>" . $_SESSION["err_regulations"] . "</p>";
                    unset($_SESSION["err_regulations"]);
                }
                ?>
            </div>

            <input class="sign-up-submit" type="submit" value="Zarejestruj się">
        </form>

        <div class="buttons-wrapper">
            <div class="link-start-wrapper a">
                <a href="../index.php">Logowanie</a>
            </div>

            <div class="link-regulations-wrapper">
                <a href="regulations.php">Regulamin</a>
            </div>
        </div>
    </section>
</body>

</html>