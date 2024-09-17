<?php require_once("config.php");
ob_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CompShop</title>
<!--    <link rel="stylesheet" href="style.css">-->
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/face.php';
    ?>
</head>
<body style="min-width: 0px">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/registration.php';
?>
</body>
</html>