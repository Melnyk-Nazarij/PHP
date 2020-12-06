<?php
// Сторінка авторизації

// Функція для генерації випадкового рядка
function generateCode($length=6) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
	$code = "";
	$clen = strlen($chars) - 1;
	while (strlen($code) < $length) {
			$code .= $chars[mt_rand(0,$clen)];
	}
	return $code;
}

// Підключення до БД
$link=mysqli_connect("localhost", "root", "root", "phpsecondlesson");

if(isset($_POST['submit']))
{
	// Витягуємо з БД запис, у якій логін дорівнює введеному
	$query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
	$data = mysqli_fetch_assoc($query);
	
	// Порівнюємо паролі
	if($data['user_password'] === md5(md5($_POST['password'])))
	{
		// Генеруємо випадкове число і шифруємо його
		$hash = md5(generateCode(10));

		if(!empty($_POST['not_attach_ip']))
			{
			// Якщо користувача вибрав прив'язку до IP
			// Переводимо IP в рядок
			$insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
		}
			
		// Записуємо в БД новий хеш авторизації і IP
		mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
			
		// Ставимо куки
		setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
		setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!
		// Записуємо в БД новий хеш авторізації и IP
		header("Location: check.php"); exit();
	}
	else
	{
		print "Ви ввели неправильний логін/пароль";
	}
}
?>
<form method="POST">
Логін <input name="login" type="text" required><br>
Пароль <input name="password" type="password" required><br>
Не прикріпляти до IP(не безпечно) <input type="checkbox" name="not_attach_ip"><br>
<input name="submit" type="submit" value="Увійти">
</form>