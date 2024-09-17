<div class="head">
    <form id="myForm" method="post">
        <button type="submit" name="shop">CompShop</button>
<!--        <button>Тех.поддержка</button>-->
        <button type="submit" name="cart">Корзина</button>
        <?php
        if ($_SESSION['admin'] == true) {
            echo "<button type='submit' name='admin'>";
            echo "admin";
            echo "</button>";
        }
        ?>
        <button type="submit" name="exit">Выход</button>
    </form>
    <?php
    if (isset($_POST['exit'])){
        session_destroy();
        header("Location: index.php");
        exit();
    }
    if (isset($_POST['shop'])){
        header("Location: shop.php");
        exit();
    }
    if (isset($_POST['admin'])){
        header("Location: admin.php");
        exit();
    }
    if (isset($_POST['cart'])){
        header("Location: cart.php");
        exit();
    }
    ?>
</div>
