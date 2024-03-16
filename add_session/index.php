<?php
    session_start();
    if(isset($_GET['exit'])){
      session_unset();
      session_destroy();
      ob_start();
      header("refresh: 0, url=http://kr8/");
      ob_end_clean();
    }
    
    else{
        session_start();
        $signin_login = 'root';//$_SESSION['signin_login'];
        $signin_password = '';//$_SESSION['signin_password'];
        $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die();

        if($link == FALSE){
            echo mysqli_connect_error();  
        }    
        else {
            $request1 = "SELECT name as mname FROM movies";
            $result1 = mysqli_query($link, $request1);
            if(isset($_POST["add_session"])){
                $mname=$_POST['mname'];
                $sql1 = "SELECT movie_id FROM movies WHERE name='.$mname.'";
                $mid = (int)mysqli_query($link, $sql1);
                $hname= ($_POST['hname']);
                $sql2 = "SELECT hall_id FROM halls WHERE name='.$hname.'";
                $hid = (int)mysqli_query($link, $sql2);
                $sdate= ($_POST['sdate']);
                $request4 = "INSERT INTO sessions(movie_id, session_datetime, hall_id) VALUES('$mid', '$sdate', '$hid')";
                $res = mysqli_query($link, $request4);
                if($res){
                    $message = "Client Successfully Added";
                } else {
                    $message = "Failed to insert data information!";
                }
                ob_start();
                header("refresh: 0, url=http://kr8/movies");
                ob_end_clean();
            }
            else {
                    $request2 = "SELECT name as hname FROM halls";
                    $result2 = mysqli_query($link, $request2);
                //    $request3 = "SELECT movie_id as mid FROM movies WHERE name=$mname";
                  //  $request4 = "SELECT hall_id as hid FROM halls WHERE name=$hname";
                    echo '
                        <!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="utf-8">
                                <title>Добавление сеанса</title>
                                <link rel="shortcut icon" href="../../signform/images/logo.jpg" type="image/jpg">
                                <link href="../../add_movie/css/style.css" media="screen" rel="stylesheet">
                                <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
                            </head>
                            <body>
                            <header>
                                <div class="wrap-logo">
                                    <img class="round" src="../signform/images/logo.JPG" width = 60px>
                                    <a href="href=http://kr8/" class="logo">Кинотеатр Prometheus</a>
                            
                                </div>
                                <nav>
                                    <a href="http://kr8/">Главная</a>
                                    <a href="https://kr8/movies/" id="t3">Выбрать фильм</a>
                                    <a href="https://kr8/show_tickets/" id="t3">Посмотреть проданные билеты</a>
                                    <a href="https://kr8/add_client/" id="t3">Добавить клиента</a>
                                    <div class="dropdown">
                                        <button class="dropbtn">Управление</button>
                                        <div class="dropdown-content">
                                            <a href="https://kr8/add_movie/" id="t3">Добавить фильм</a>
                                            <a href="http://kr8/add_session/" id="t3">Добавить сеанс</a>
                                            <a href="https://kr8/registration">Добавить сотрудника</a>
                                            <a href="https://kr8/all_employees">Список сотрудников</a>
                                        </div>
                                    </div>
                                    <a href="?exit=true">Выйти</a>
                            
                                </nav>
                            </header>
                            <div class="container mregister">
                                <div id="login">
                                    <h1>Добавить сеанс для фильма</h1>
                                    <form method="POST">
                                        ';
                                        echo '
                                        <p><label>Фильм<br>
                                            <select class="input" name="mname">
                                                <option value="">--Выберите фильм--</option>
                                            ';
                                            foreach($result1 as $row){
                                                echo '<option value="'.$row["mname"].'">'.$row["mname"].'</option>';
                                            }
                                            echo '
                                            </select>
                                        </label></p> 
                                        <p><label>Дата<br>
                                            <input class="input" name="sdate" size="32" placeholder="2000-02-22 14:00:00" value="">
                                        </label></p>      
                                        <p><label>Зал<br>
                                            <select class="input" name="hname">
                                        ';
                                        foreach($result2 as $row){
                                            echo '<option value="'.$row["hname"].'">'.$row["hname"].'</option>';
                                        }
                                        echo ' 
                                        </select>   
                                        </label></p>       
                                        <input class="button" name= "add_session" type="submit" value="Добавить сеанс">';
                                        echo '
                                    </form>
                                </div>
                            </div>
                            </body>
                            </html>
                    ';
            }
         /*       else if(!empty($_GET['mname'])) {
                    $mname= ($_GET['mname']);
                    $request2 = "SELECT name as hname FROM halls";
                    $result2 = mysqli_query($link, $request2);
                    echo '
                        <!DOCTYPE html>
                            <html lang="en">
                            <head>
                                <meta charset="utf-8">
                                <title>Добавление сеанса</title>
                                <link href="css/style.css" media="screen" rel="stylesheet">
                                <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
                            </head>
                            <body>
                            <div class="top-menu">
                                <a class="button" href="https://kr8/">Меню</a>
                                <a class="button" href="https://kr8/movies/">Выбрать фильм</a>
                                <a class="button" href="https://kr8/show_tickets/">Посмотреть проданные билеты</a>
                                <a class="button" href="https://kr8/registration/">Добавить сотрудника</a>
                                <a class="button" href="https://kr8/show_movies/">Посмотреть фильмы</a>
                                <a class="button" href="?exit=true">Выйти</a>
                            </div>
                            <div class="container mregister">
                                <div id="login">
                                    <h1>Добавить сеанс для фильма '.$mname.'</h1>
                                    <table>
                                        <tr><th>Зал</th></tr>
                                        ';
                                        foreach($result2 as $row){
                                            echo '<tr><td><a href="'.'?mname='.$mname.'&hname='.$row["hname"].'">'.$row["hname"].'</a></td></tr>';
                                        }
                                        echo '
                                    </table>
                                </div>
                            </div>
                            </body>
                            </html>
                            ';
                }
            }
            else{
                echo '
                <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <title>Добавление сеанса</title>
                        <link href="css/style.css" media="screen" rel="stylesheet">
                        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
                    </head>
                    <body>
                    <div class="top-menu">
                        <a class="button" href="https://kr8/">Меню</a>
                        <a class="button" href="https://kr8/movies/">Выбрать фильм</a>
                        <a class="button" href="https://kr8/show_tickets/">Посмотреть проданные билеты</a>
                        <a class="button" href="https://kr8/registration/">Добавить сотрудника</a>
                        <a class="button" href="https://kr8/show_movies/">Посмотреть фильмы</a>
                        <a class="button" href="?exit=true">Выйти</a>
                    </div>
                    <div class="container mregister">
                        <div id="login">
                            <h1>Добавить сеанс</h1>
                            <table>
                                <tr><th>Фильм</th></tr>
                                ';
                                foreach($result1 as $row){
                                    echo '<tr><td><a href="'."?mname=".$row["mname"].'">'.$row["mname"].'</a></td></tr>';
                                }
                                echo '
                            </table>
                        </div>
                    </div>
                    </body>
                    </html>
                    ';
            }*/
        }
        $_POST['name'] = null;
        $_POST['post'] = null;
        $_POST["add_movie"] = null;
        $sql_usr_table = null;
        $sql_cash_cashiers = null;
    }
?>