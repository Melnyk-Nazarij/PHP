<?php
// сторінка розавторизації

// Удаляем куки
setcookie("id", "", time() - 3600*24*30*12, "/");
setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!!

// Переадресовуємо браузер на сторінку перевірки нашого скрипта
header("Location: /"); exit;

?>
<form method="POST">
Логін <input name="login" type="text" required><br>
Пароль <input name="password" type="password" required><br>
Не прикріпляти до IP(не безпечно) <input type="checkbox" name="not_attach_ip"><br>
<input name="submit" type="submit" value="Увійти">
</form>