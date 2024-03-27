<?php
    session_start();
    if (isset($_GET['exit'])) {
      session_unset();
      session_destroy();
      ob_start();
      header("refresh: 3, url=http://kr8/");
      ob_end_clean();
    } else if (isset($_SESSION['signin_login'])) {
        if ($_SESSION['stat'] == 'Стажер' or $_SESSION['stat'] == 'Кассир') {
            echo "<!DOCTYPE html>
                <html lang='ru'>
                    <head>
                        <meta charset='utf-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                        <title>Добро пожаловать!</title>
                        <link rel='shortcut icon' href='../signform/images/logo.jpg' type='image/jpg'>
                        <link href='css/style.css' media='screen' rel='stylesheet'>
                        <link href = 'https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel = 'stylesheet' type = 'text/css' >
                    </head>
                    <body>
                        <header>
                        <div class='wrap-logo'>
                            <img class='round' src='../signform/images/logo.JPG' width = 60px>
                            <a href='href=http://kr8/' class='logo'>Кинотеатр Prometheus</a>
                        </div>
                        <nav>
                            <a class='active' href='http://kr8/'>Главная</a>
                            <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
                            <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
                            <a href='https://kr8/add_employee/' id='t3'>Добавить клиента</a>
                            <a href='?exit=true'>Выйти</a>
                        </nav>
                        </header>
                        <img class='bcgrnd' src='../signform/images/prometheus.jpeg'>
                    </body>
                </html>";
        } else {
            echo "<!DOCTYPE html>
            <html lang='ru'>
    
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                <title>Добро пожаловать!</title>
                <link rel='shortcut icon' href='../signform/images/logo.jpg' type='image/jpg'>
                <link href='css/style.css' media='screen' rel='stylesheet'>
                <link href = 'https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel = 'stylesheet' type = 'text/css' >
            </head>
            <body>
                <header>
                    <div class='wrap-logo'>
                        <img class='round' src='../signform/images/logo.JPG' width = 60px>
                        <a href='' class='logo'>Кинотеатр Prometheus</a>
                    </div>
                    <nav>
                        <a class='active' href='http://kr8/'>Главная</a>
                        <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
                        <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>                        
                        <a href='https://kr8/add_employee/' id='t3'>Добавить клиента</a>
                        <div class='dropdown'>
                          <button class='dropbtn'>Управление</button>
                          <div class='dropdown-content'>
                              <a href='https://kr8/add_movie/' id='t3'>Добавить фильм</a>
                              <a href='http://kr8/add_session/' id='t3'>Добавить сеанс</a>
                              <a href='https://kr8/registration'>Добавить сотрудника</a>
                              <a href='https://kr8/all_employees'>Список сотрудников</a>
                          </div>
                        </div>    
                        <a href='?exit=true'>Выйти</a>           
                    </nav>
                </header>
                <img class='bcgrnd' src='../signform/images/prometheus.jpeg'>
            </body>
            </html>";
        }
    } else {
        echo "<!DOCTYPE html>
        <html lang='ru'>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                <title>Добро пожаловать!</title>
                <link rel='shortcut icon' href='../signform/images/logo.jpg' type='image/jpg'>
                <link href='css/style.css' media='screen' rel='stylesheet'><link href = 'https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel = 'stylesheet' type = 'text/css' >
            </head>
            <body>
                <header>
                    <div class='wrap-logo'>
                        <img class='round' src='../signform/images/logo.JPG' width = 60px>
                        <a href='http://kr8/' class='logo'>Кинотеатр Prometheus</a>  
                    </div>
                    <nav>
                        <a class='active' href='http://kr8/'>Главная</a>
                        <a href='https://kr8/signform/' id='t3'>Войти</a>
                    </nav>
                </header>
            </body>
            <img class='bcgrnd' src='../signform/images/prometheus.jpeg'>
        </html>";
    }
?>
