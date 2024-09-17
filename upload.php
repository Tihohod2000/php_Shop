<?php
global $conDB;
if (isset($_POST['upload'])) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // Полный путь к файлу


    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//    echo "<img src=$target_file style='height: 150px'>";
    if ($check == false) {
        echo "Файл не является изображением.";
        exit();
    }

    // Проверка, существует ли уже такой файл
    if (file_exists($target_file)) {
        echo "Извините, файл с таким названием уже существует. Переименуйте файл.";
        exit();
    }

// Проверка размера файла (не более 10MB)
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
        echo "Извините, ваш файл слишком большой.";
        exit();
    }

    if ($_POST['info'] == "") {
        echo "Ошибка, вы не указали описание";
        exit();
    }

    $price = $_POST['price'];
    $type_of_device = $_POST['type_of_device'];
//    echo "$type_of_device";
    $info = $_POST['info'];
    $info = mysqli_real_escape_string($conDB, $info);
    $image = $target_dir . $_FILES["fileToUpload"]["name"];

    if($price == "" || $type_of_device == "" || $info == ""){
        echo "Ошибка данных";
        exit();
    }

// Перемещение файла из временной директории в указанную
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Файл " . basename($_FILES["fileToUpload"]["name"]) . " успешно загружен.";
    } else {
        echo "Произошла ошибка при загрузке файла.";
    }

    mysqli_query($conDB, "INSERT INTO `device`
			                            SET `text`='$info',`price`='$price', `id_type` = '$type_of_device', `image` = '$image'");
//    echo "<lable style='text-align: center'>Успешная регистрация</lable>";
    header("Location: admin.php");
//    echo "<script>alert(Уведомление после нажатия кнопки!)</script>";
    exit();
//    unset($_FILES);
//    unset($_POST);
}
?>