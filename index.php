<?php
session_start();
if(isset($_GET['exit'])){
  session_unset();
  session_destroy();
  ob_start();
  header("refresh: 3, url=http://kr8/");
  ob_end_clean();
}
else if(isset($_SESSION['signin_login'])){
    if($_SESSION['stat'] == 'Стажер' or $_SESSION['stat'] == 'Кассир'){
        echo "<!DOCTYPE html>
            <html lang='ru'>

            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                <title>Добро пожаловать!</title>
            </head>
            <body>
                <h1 id='t1'>Добро пожаловать в наш кинотеатр!</h1>
                <a href='http://kr8/registration'>Add new worker</a>
                <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
                <a href='?exit=true'>Выйти</a>
            </body>

            </html>";
    }
    else {
        echo "<!DOCTYPE html>
        <html lang='ru'>

        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
            <title>Добро пожаловать!</title>
        </head>
        <body>
            <h1 id='t1'>Добро пожаловать в наш кинотеатр!</h1>
            <a href='http://kr8/registration'>Добавить сотрудника</a>
            <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
            <a href='https://kr8/add_movie/' id='t3'>Добавить фильм</a>
            <a href='?exit=true'>Выйти</a>
        </body>

        </html>";
    }
}
else {

echo "<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Добро пожаловать!</title>
</head>
<body>
	<h1 id='t1'>Добро пожаловать в наш кинотеатр!</h1>
    <a href='https://kr8/signform1/' id='t3'>Войти</a>
</body>

</html>";}
?>