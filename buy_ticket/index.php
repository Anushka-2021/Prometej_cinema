<?php
session_start();
session_start();
if(isset($_GET['exit'])){
  session_unset();
  session_destroy();
  ob_start();
  header("refresh: 3, url=http://kr8/");
  ob_end_clean();
}
else if(isset($_SESSION['signin_login'])){
    $link = mysqli_connect("localhost", "root", "", "kr_apge") or die();
    if($link == FALSE){
        echo mysqli_connect_error();  
    }    
    else {
        $query = 'SELECT * FROM movies';
        $result = mysqli_query($link, $query);
    }
    echo "<!DOCTYPE html>
    <html lang='ru'>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <title>Добро пожаловать!</title>
    </head>
    <body>
        <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
        <br><a href='http://kr8/'>Menu</a>
        <a href='?exit=true'>Выйти</a>

        <form action='#'>
            <h1 class='h3 mb-3 fw-normal'>Please sign in</h1>

            <div class='form-floating'>
                <p>
                <label for='movie_name'>Movie name</label><br>
                <select name='movie_name' id=''>
                    <option value=''>--Please chose an option--</option>
                    ";
                    while ($row = mysqli_fetch_array($result)){
                        $movie_name = $row['name'];
                        $movie_id = $row['movie_id'];
                        $res_sessions = mysqli_query($link, "SELECT *, MONTH(DATE(session_datetime)) AS sess_month, DAY(DATE(session_datetime)) AS sess_day, TIME(session_datetime) AS sess_time, halls.name AS hall_name FROM `sessions` LEFT JOIN halls ON halls.hall_id=sessions.hall_id WHERE movie_id='{$movie_id}'");
                        $rs1 = $res_sessions;
                        
                        echo "<option value='".$movie_name."'>".$movie_name."</option>
                        ";
                    }
                    echo "
                </select>
                </p>
            </div>
            <div class='form-floating'>
            <input type='input' id='floatingPassword' name='signinpassword'>
            </div>

            <button type='submit'>Submit</button>
            </form>

        </body>

    </html>";
    }
?>