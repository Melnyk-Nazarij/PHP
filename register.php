<?php
// Сторінка реєстрації нового користувача

// з'єднати з БД
$link=mysqli_connect("localhost", "root", "root", "phpsecondlesson");

if(isset($_POST['submit']))
{
    $err = [];

    // перевіряємо логін
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логін може складатися тільки з букв англійського алфавіту і цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логін повинен бути не менше 3-х символів і не більше 30";
    }

    // перевіряємо, чи не існує користувача з таким ім'ям
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Користувач з таким іменем вже існує в базі даних";
    }

    // Якщо немає помилок, то додаємо в БД нового користувача
    if(count($err) == 0)
    {
        $login = $_POST['login'];

        // Прибираємо зайві прогалини і робимо подвійне хешування
        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        header("Location: login.php"); exit();
    }
    else
    {
        print "<b>При реєстрації відбулися наступні помилки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>

<form method="POST">
Логін <input name="login" type="text" required><br>
Пароль <input name="password" type="password" required><br>
<input name="submit" type="submit" value="Зареєструватися">
</form>