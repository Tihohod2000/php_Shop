<?php global $conDB;
require_once("config.php");
ob_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Корзина</title>
    <script src='buy.js'></script>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/face.php';
    ?>
</head>
<body class="cartBody">
<?php
session_start();
if ($_SESSION['login'] == '') {
    header("Location: index.php");
    exit();
}
//print_r($_SESSION);
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/top.php';
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/face.php';
?>

<div class="cart_main">
    <div class="cart_keep">
        <table>
            <tr>
                <td>Инфа</td>
                <td>Цена</td>
                <td>Количество</td>
                <td>
                    <form method="get" action="cart.php">
                        <button type="submit" name="delete_all" style="color: black; font-size: 10px">
                            Delete all
                        </button>
                    </form>
                </td>
            </tr>

            <?php
            if (isset($_SESSION['login'])) {
                if (boolval($_SESSION['login'])) {
                    $id = $_SESSION['login'];
                    $bd_info = mysqli_query($conDB, "SELECT `device`.`text`, `device`.`price`, `cart_$_SESSION[login]`.`count`, `cart_$_SESSION[login]`.`id` 
                                FROM `device` 
                                JOIN `cart_$_SESSION[login]` ON `cart_$_SESSION[login]`.`id_device` = `device`.`id`");
                        static $summ = 0;
//                    print_r($bd_info.count());
                    if (mysqli_num_rows($bd_info) > 0) {
                        while ($row = mysqli_fetch_assoc($bd_info)) {
//                            print_r($row);
                            echo "<tr>";
                            echo "<td style='border-top: black solid 1px'>";
                            echo "$row[text]";
                            echo "</td>";
                            echo "<td style='border-top: black solid 1px'>";
                            echo "$row[price]р.";
                            echo "</td>";
                            echo "<td style='border-top: black solid 1px'>";
                            echo "$row[count] шт.";
                            echo "</td>";
                            echo "<td style='border-top: black solid 1px'>";
                            echo "<form action='cart.php' method='get'>";
                            echo "<button type='submit' style='color: black' value=$row[id] name='delete'>";
                            echo "X";
                            echo "</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                            $summ += $row["price"] * $row["count"];
                        }
                    } else {
                        echo "<tr>";
                        echo "<td class='nothing' colspan=4 style='border-top: black solid 1px'>";
                        echo "У вас нет ничего в корзине";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            }
            ?>
        </table>
    </div>
    <div class="cart_info">
        <div class="infoClient">
            <div style="text-align: center">Основная информация</div>
            <input type="text" name="phone" pattern="[0-9()-+]*" placeholder="Введите номер телефона">
            <input type="text" name="link" placeholder="Введите адресс доставки">
        </div>
        <div>
            <div style="text-align: center">выберете тип оплаты</div>
            <div>
                <input type="radio" name="type_of_money" value="Картой" checked onclick="toggleCart(this)">
                Картой
                <input type="radio" name="type_of_money" onload="true" value="Наличными" onclick="toggleCart(this)">
                Наличными
            </div>
        </div>
        <div class="cartBuy" id="cartBuy" style=" display: flex; flex-direction: column; align-items: center;">
            <input class="numberOfCart" type="text" oninput="checkLength2(this)" pattern="[0-9]*" maxlength="19">
            <div class="numberOfCart2" >
                <input class="dataOfCart" type="text" oninput="checkLength(this, 4)" pattern="[0-9]*">
                <input class="CVC" type="password" maxlength="3">
            </div>
        </div>
        <div style="margin-top: 30px">
            <label style="font-size: 30px;">Сумма заказа:
                <?php
                echo "$summ"."р.";
                ?>
            </label>
        </div>
        <button class="button_buy">
            Заказать
        </button>
    </div>
</div>

<?php
if (isset($_GET['delete'])) {
    mysqli_query($conDB, "UPDATE `cart_$_SESSION[login]` SET `count` = `count` - 1  WHERE `id` = $_GET[delete];");
    mysqli_query($conDB, "DELETE FROM `cart_$_SESSION[login]` WHERE `count` = 0;");
    header("Location: cart.php");
    exit();
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conDB, "DELETE FROM `cart_$_SESSION[login]` WHERE `id` LIKE '%';");
    header("Location: cart.php");
    exit();
}
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bottom.php';
?>


</body>
</html>