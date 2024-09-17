<?php global $conDB;
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
    <title>admin</title>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/face.php';

    if ($_SESSION['login'] == '' || $_SESSION['admin'] == 0) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
    ?>


</head>
<body>


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/top.php';
?>
<div class="inputInfo">

    <form action="admin.php" class="face_content_in_admin" method="post" enctype="multipart/form-data">
        Выберите фотографию: <input type="file" name="fileToUpload" accept="image/*">
        Введите описание: <textarea name="info"></textarea>
        Укажите цену: <input type="number" name="price">

        <?php
        $bd_info = mysqli_query($conDB, "SELECT `id`,`type` FROM `device_type`");
        if ($bd_info) {
            echo "Выберите тип товара";
            echo "<select name='type_of_device'>";
            while ($row = mysqli_fetch_assoc($bd_info)) {
                echo "<option value='$row[id]'>";
                echo "$row[type]";
                echo "</option>";
            }
            echo "</select>";
        }
        ?>
        <div id="imageUpload" class="imageUpload">
            <img id="previewImage" src="#" alt="Предпросмотр изображения" style="display: none; max-width: 300px;">
        </div>
        <input type="submit" value="Загрузить" name="upload">
    </form>

</div>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/upload.php';
?>


<!--<script type='text/javascript' src='func.js'></script>-->
<script src='func.js'></script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bottom.php';
?>
</body>

</html>