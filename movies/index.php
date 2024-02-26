<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Кинотеатр Прометей</title>
    <a href='https://kr8/' id='t3'>Меню</a>
</head>
<body>
	<h1 id='t1'>Фильмы</h1>
	<div class='movies'>
		
	</div>
</body>
</html>

<style>
    .movie{
        border: 2px solid black;
        width: 100%;
        display: flex;
        flex-direction: row;
    }
    .movies{
        max-width: 100%;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
    }
    .movie-header {
        font-size: 1.5rem;
    }
    .movie-body{
        display: flex;
        flex-direction: column;
        max-height: 80%;
        flex-wrap: wrap;
        align-content: space-between;
    }
    .movie-body-poster{
        max-width: 35%;
        max-height: 300px;
    }
    .movie-body-info{
        
    }
    .movie-dates{
        border: 1px solid green;
        display: inline-block;
    }
    .movie-days-in-month{
        border: 1px solid red;
        padding: 5px;
    }
</style>


<?php
    $months_array = [
        "1" => "январь",
        "2" => "февраль",
        "3" => "март",
        "4" => "апрель",
        "5" => "май",
        "6" => "июнь",
        "7" => "июль",
        "8" => "август",
        "9" => "сентябрь",
        "10" => "октябрь",
        "11" => "ноябрь",
        "12" => "декабрь",
    ];
    $link = mysqli_connect("localhost", "root", "", "kr_apge") or die();
    if($link == FALSE){
        echo mysqli_connect_error();  
    }    
    else {
        $query = 'SELECT * FROM movies';
        $result = mysqli_query($link, $query);
    }
    echo '<div class="movies">';
    while ($row = mysqli_fetch_array($result)){
        $movie_name = $row['name'];
        $movie_id = $row['movie_id'];
        $res_sessions = mysqli_query($link, "SELECT *, MONTH(DATE(session_datetime)) AS sess_month, DAY(DATE(session_datetime)) AS sess_day, TIME(session_datetime) AS sess_time, halls.name AS hall_name FROM `sessions` LEFT JOIN halls ON halls.hall_id=sessions.hall_id WHERE movie_id='{$movie_id}'");
        $rs1 = $res_sessions;
        echo '
            <div class = movie>
                <div class="movie-body-poster">
                    <img src="http://kr8/movies/posters/'.$movie_id.'.jpg" height="100%">
                </div>
                <div class="movie-body">
                    <div class="movie-header">
                        '.$row['name'].'
                    </div>
                    <div class="movie-body-info">
                        '.$row['genre'].'
                        <div class="movie-kalender">
                            <p>Выберите дату</p>
                            <div class="movie-dates">';
                                
                                $i = 1;
                                $our_months = [];
                                $rs = [];
                                while ($sess = mysqli_fetch_array($rs1)){
                                    $sess_month = $sess["sess_month"];
                                    $rs[] = $sess;
                                    while ($i<=12){
                                        if ($i == $sess_month and !(in_array($i, $our_months))){
                                            $our_months[$i] = $months_array[$i];
                                        }
                                        $i = $i+1;   
                                    }
                                }

                                foreach($our_months as $key => $val){
                                    echo $val;
                                    $printed_days = [];

                                    echo '<div class="movie-days-in-month">';
                                    foreach ($rs as $sess){
                                        $sess_month = $sess["sess_month"];
                                        $sess_day = $sess["sess_day"];
                                        $sess_time = $sess["sess_time"];
                                        $sess_hall = $sess["hall_name"];


                                        if ($key == $sess_month){
                                            if(!(in_array($sess_day, $printed_days))){
                                                echo $sess_day;
                                                $printed_days[] = $sess_day;
                                            }
                                            echo '<br>';
                                            echo ' ';
                                            echo $sess_time;
                                            echo ' ';
                                            echo $sess_hall;
                                        }
                                    }
                                    echo '</div>';
                                }
   
                            echo '</div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    echo '</div>';
?>