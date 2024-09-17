<?php
if ($_SESSION['login'] == '') {
    session_destroy();
    header("Location: index.php");
    exit();
}
