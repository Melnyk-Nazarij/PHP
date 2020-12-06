<?php
// Скрипт перевірки

// з'єднати з БД
$link=mysqli_connect("localhost", "root", "root", "phpsecondlesson");

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
	$query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
	$userdata = mysqli_fetch_assoc($query);
	//print_r($userdata);
	if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
	{
		setcookie("id", "", time() - 3600*24*30*12, "/");
		setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
		print "Хм, щось пішло не так";
	}
	else
	{
		print "Привіт, ".$userdata['user_login'].". Все працює!";
	}
}
else
{
	print "Включити куки";
}
?>