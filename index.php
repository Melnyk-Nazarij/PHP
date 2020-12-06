<!DOCTYPE html>
<html>
    <head>
        <title>Приклад</title>
    </head>
    <body>
        <?php
        if (isset($_GET["a"])) {
       
        $a=(int)$_GET["a"];
        $b=(int)$_GET["b"];
        if($a>0) {
        $s=$a*$b;
        echo "Привіт, а результат $s";
        } else {
            echo "Привіт, а результату немає :-)";
        }
        } else {
			?>
            <form method="get" action="index.php">
            a=<input type="text" name="a"><br>
            b=<input type="text" name="b"><br>
            <input type="submit" value="Порахувати">
            </form>
			<?php
        }
        ?>
	</body>
</html>