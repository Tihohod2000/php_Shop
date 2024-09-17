<?php global $conDB;
require_once("config.php");
ob_start();
?>
<div class="content_rege">
    <div class="rege">
        <form action="index.php" id="myForm" method="post">
            <div class="text-registration">
                Регистрация
            </div>
            <div class="login">
                <input class="login_info" type="text" name="login" placeholder="Логин от 4 до 16">
                <input class="login_info" type="password" name="password" placeholder="Пароль от 4 до 16">
            </div>
            <div class="buttons">
                <button type="submit" name="logging">
                    Авторизация
                </button>
                <button type="submit" name="reg">
                    Регистрация
                </button>
            </div>
        </form>
        <?php
        if (isset($_POST['reg'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            // Если ничего не введено, то
            if ($login == "" || $password == "") {
                echo "<div class='errors'>вы не ввели логин или пароль</div>";
                // Иначе добавляем запись (INSERT INTO)
            } else {
                $login = mysqli_real_escape_string($conDB, $login);
                $password = mysqli_real_escape_string($conDB, $password);

                $result = mysqli_query($conDB, "SELECT * FROM `users` WHERE `login`='$login';");

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<div class='errors'>Такой пользователь уже существует</div>";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_query($conDB, "INSERT INTO `users`
			                            SET `login`='$login',`password`='$hashed_password', `admin` = 0");
                    mysqli_query($conDB, "CREATE TABLE IF NOT EXISTS `cart_$login` (
                                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                                        `id_device` INT NOT NULL,
                                        `count` INT NOT NULL,
                                        FOREIGN KEY (`id_device`) REFERENCES `device`(`id`) ON DELETE CASCADE
                                        );");
                    header("Location: index.php");
                    exit();
                }
            }
        }

        ?>
        <?php
        session_start();
        if (isset($_POST['logging'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            if ($login == "" or $password == "") {
                echo "<div class='errors'>Некорректные данные</div>";
            } else {
                $login = mysqli_real_escape_string($conDB, $login);
                $password = mysqli_real_escape_string($conDB, $password);
//                $hashed_password = password_hash($password, PASSWORD_DEFAULT);


                $result = mysqli_query($conDB, "SELECT * FROM `users` WHERE `login`='$login';");

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if(password_verify($password, $row['password'])) {
                        // Успешная авторизация
                        $_SESSION['admin'] = $row['admin'];
                        $_SESSION['login'] = $login;

                        // Выполняйте действия после успешной авторизации
                    // Например, перенаправление на другую страницу
                    header("Location: shop.php");
                    exit();
                    }// Важно завершить выполнение скрипта после вызова header
                } else {
                    // Неверный логин или пароль
                    echo "<div class='errors'>Неверный логин или пароль</div>";
                    session_destroy();
                }
            }
        }

        ?>


    </div>
</div>