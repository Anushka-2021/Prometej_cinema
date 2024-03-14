<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Кинотеатр Прометей</title>
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="top-menu">
        <a class="button" href='https://kr8/'>Меню</a>
        <a class='button' href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
        <a class='button' href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
        <a class='button' href='?exit=true'>Выйти</a>
    </div>
    <div class="container mupdate">
	<h1>Фильмы</h1>


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
        $signin_login = $_SESSION['signin_login'];
        $signin_password = $_SESSION['signin_password'];
        $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die();
        
        if($link == FALSE){
            echo mysqli_connect_error();  
        }    
        else {
            $request = "SELECT movies.name as mname, movies.genre as mgenre
            FROM movies";
            $result = mysqli_query($link, $request);
            echo "
                <table><tr><th>Фильм</th><th>Жанры</th></tr>
            ";
            foreach($result as $row){
                echo "<tr>";
                echo "<td>".$row["mname"]."</td>";
                echo "<td>".$row["mgenre"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
?>
</div>
</body>
</html>