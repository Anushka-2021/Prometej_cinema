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
                <link href='css/style.css' media='screen' rel='stylesheet'>
            </head>
            <body>
                <header>
                <div class='wrap-logo'>
                    <a href='href=http://kr8/' class='logo'>Кинотеатр Prometheus</a>
                    <img class='round' src='../signform/images/logo.JPG' width = 60px>
                </div>
                <nav>
                    <a class='active' href='http://kr8/'>Главная</a>
                    <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
                    <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
                    <a href='?exit=true'>Выйти</a>
                </nav>
                </header>
            <img class='bcgrnd' src='../signform/images/prometheus.jpeg'>
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
            <link href='css/style.css' media='screen' rel='stylesheet'>
            
        </head>
        <body>
        <header>
            <div class='wrap-logo'>
                <a href='href=http://kr8/' class='logo'>Кинотеатр Prometheus</a>
                <img class='round' src='../signform/images/logo.JPG' width = 60px>
            </div>
            <nav>
                    <a class='active' href='http://kr8/'>Главная</a>
                    <a href='http://kr8/registration'>Добавить сотрудника</a>
                    <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
                    <a href='https://kr8/add_movie/' id='t3'>Добавить фильм</a><br><br><br>
                    <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
                    <a href='?exit=true'>Выйти</a>
            </nav>
        </header>
        <img class='bcgrnd' src='../signform/images/prometheus.jpeg'>
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
    <link href='css/style.css' media='screen' rel='stylesheet'>
</head>
<body>
 <header>
    <div class='wrap-logo'>
        <a href='href=http://kr8/' class='logo'>Кинотеатр Prometheus</a>
        <img class='round' src='../signform/images/logo.JPG' width = 60px>  
    </div>
    <nav>
            <a class='active' href='http://kr8/'>Главная</a>
            <a href='https://kr8/signform/' id='t3'>Войти</a>
    </nav>
</header>
</body>
<img class='bcgrnd' src='../signform/images/prometheus.jpeg'>
</html>";}
?>