<?php
global $conDB;
require_once("config.php");
ob_start();
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CompShop</title>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/face.php';
    ?>
</head>
<body>

<!--Проверка авторизации через данные сессии-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/protect.php';
?>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/top.php';

?>

<form action="shop.php" class="search" method="post">
    <input class="search_text" type="text" name="search_text" placeholder="Поиск...">
    <button type="submit" class="search_text" name="search">Поиск</button>
</form>


<div class="face_content">
    <?php
    if (isset($_POST['search'])) {
        if (strval($_POST['search_text']) != "") {
            $search = $_POST['search_text'];
            $search = mysqli_real_escape_string($conDB, $search);
            $bd_info = mysqli_query($conDB, "SELECT `device`.* 
                                FROM `device` 
                                JOIN `device_type` ON `device_type`.`id` = `device`.`id_type` 
                                WHERE `device`.`text` LIKE '%$search%' OR `device_type`.`type` LIKE '%$search%' ;");

            if ($bd_info) {
                while ($row = mysqli_fetch_assoc($bd_info)) {
                    show($row);
                }
            }
        } else {
            $bd_info = mysqli_query($conDB, "SELECT * FROM `device`");
            if ($bd_info) {
                while ($row = mysqli_fetch_assoc($bd_info)) {
                    show($row);
                }
            }
        }
    } else {
        $bd_info = mysqli_query($conDB, "SELECT * FROM `device`");
        if ($bd_info) {
            while ($row = mysqli_fetch_assoc($bd_info)) {
                show($row);
            }
        }
    }
    ?>
</div>


<?php

//Функция наполнения главной страницы
function show($row)
{
    global $conDB;
    echo "<form action='shop.php' method='post'>";
    echo "<div class='main_content'>";
    echo "<img src='$row[image]' style='width: 100%;  height: 150px' alt='photo'>";
    echo "<br>";
    echo "$row[text]";
    echo "<br>";
    echo "$row[price]р.";
    echo "<br>";
    echo "<div class='selec'>";
    echo "<button name='goToProduct' value=$row[id] style='color: black; border: 1px solid black; border-radius: 10px;'>";
    echo "Перейти";
    echo "</button>";
    if ($_SESSION['admin'] == true) {
        echo "<button type='submit' name='delet_device' value=$row[image] style='color: white; border-radius: 5px; border:solid 1px white; background-color: red'>";
        echo "X";
        echo "</button>";
    }
    echo "</div>";
    echo "</div>";
    echo "</form>";

//    print_r($_POST);
//    print_r($row);

    if (isset($_POST['goToProduct'])){
        $_SESSION['goToProduct'] = $_POST['goToProduct'];
        header("Location: product.php");
        exit();
    }


    if (isset($_POST['delet_device'])){
//        print_r($_POST);
//        print_r($row);
        $fileToDelete = $_POST['delet_device'];
//        print_r($fileToDelete);
// Проверяем, существует ли файл перед удалением
        if (file_exists($fileToDelete)) {
            // Попытка удалить файл
            if (unlink($fileToDelete)) {
                mysqli_query($conDB, "DELETE FROM `device` WHERE `image` LIKE '$fileToDelete';");
                echo 'Файл успешно удален.';
            } else {
                echo 'Не удалось удалить файл.';
            }
            header("Location: shop.php");
            exit();
        } else {
            echo 'Файл не существует.';
        }


    }


}



?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bottom.php';
?>
</body>

</html>