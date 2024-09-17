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
    <title>product</title>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/face.php';
    ?>
    <?php
    session_start();
    if ($_SESSION['login'] == '') {
        header("Location: index.php");
        exit();
    }


    ?>
</head>
<body>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/top.php';
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/face.php';
?>


<?php
if (isset($_SESSION['goToProduct'])) {
    if (intval($_SESSION['goToProduct']) != 0) {
        $id = $_SESSION['goToProduct'];
        $bd_info = mysqli_query($conDB, "SELECT `device`.* 
                                FROM `device` 
                                JOIN `device_type` ON `device_type`.`id` = `device`.`id_type` 
                                WHERE `device`.`id` LIKE '$id';");

        if ($bd_info) {
            while ($row = mysqli_fetch_assoc($bd_info)) {
//                print_r($_SESSION);
                echo "<br>";
//                print_r($row);
                echo "<br>";
//                print_r($_POST);
//                unset($_POST);
                echo "<form method='post' action='product.php'>";
                echo "<div class='product'>";
                echo "<img class='photo_in_product' src='$row[image]' alt='photo'>";
                echo "<div class='info'>";
                echo "Характеристики";
                echo "<br>";
                echo "$row[text]";
                echo "<div class='buy'>";
                echo "<div class='price'>";
                echo "$row[price]р.";
                echo "</div>";
                echo "<button name='add_to_cart' value=$id class='button_product' type='submit'>";
                echo "Добавить в корзину";
                echo "</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
//                echo "cart_$_SESSION[login]";
            }
        }

    }
}

?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bottom.php';
?>
<?php
if (isset($_POST['add_to_cart'])) {
    // Проверяем существует ли запись для данного id_device
    $result = mysqli_query($conDB, "SELECT * FROM `cart_$_SESSION[login]` WHERE `id_device` = '$_POST[add_to_cart]'");
    if (mysqli_num_rows($result) > 0) {
        // Если запись существует, обновляем ячейку count
        mysqli_query($conDB, "UPDATE `cart_$_SESSION[login]` SET `count` = `count` + 1 WHERE `id_device` = '$_POST[add_to_cart]'");
    } else {
        // Если записи не существует, вставляем новую запись
        mysqli_query($conDB, "INSERT INTO `cart_$_SESSION[login]` (`id_device`, `count`) VALUES ('$_POST[add_to_cart]','1')");
    }
    header("Location: product.php");
    exit();
}
?>
</body>
</html>