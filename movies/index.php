<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Кинотеатр Прометей</title>
</head>
<body>
    <a href='https://kr8/' id='t3'>Меню</a>
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
    session_start();
    $signin_login = $_SESSION['signin_login'];
    $signin_password = $_SESSION['signin_password'];
    $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die();
    if(isset($_GET['shop_submit'])){
        
        if($link == FALSE){
            echo mysqli_connect_error();  
        }    
        else {
            if(isset($_GET['client_id'])){
                $query1 = '
                SELECT clients.email AS mail FROM clients
                WHERE client_id = '.$_GET['client_id'];
                $result1 = mysqli_query($link, $query1);
                $a = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                $client_id = $_GET['client_id'];
                echo 'sdfgerf';
            }
            else{
                $client_id = Null;
            }
            
            $query2 = '
                SELECT cashier_id AS id FROM cashiers
                WHERE username = "'.$signin_login.'"';

            $query3 = '
                SELECT seat_id 
                FROM seats 
                LEFT JOIN halls ON seats.hall_id = halls.hall_id
                WHERE seat_num = '.$_SESSION['seat'].'
                AND row_num = '.$_SESSION['row'].'
                AND halls.name = "'.$_SESSION['hname'].'"
            ';
        }
        
        $result2 = mysqli_query($link, $query2);
        $result3 = mysqli_query($link, $query3);
        
        $b = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        $c = mysqli_fetch_array($result3, MYSQLI_ASSOC);
        $cashier_id = $b['id'];
        
        $session_id = $_SESSION['session_id'];
        $seat_id = $c['seat_id'];
        $purchase_timedate = date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s");
        $cost = $_GET['price'];
        $paybon = 0; //add later $_GET['paybon']
        $query4 = '
                INSERT INTO `tickets`(`cashier_id`, `client_id`, `session_id`, `seat_id`, `purchase_timedate`, `cost`, `paybon`)
                VALUES('.$cashier_id.','.$client_id.', '.$session_id.','.$seat_id.',"'.$purchase_timedate.'",'.$cost.','.$paybon.')';
        if($paybon){
            $diff = -$cost;
        }
        else{
            $diff = $cost/10;
        }
        $query5 = '
                UPDATE clients
                SET discount_points = discount_points+'.$diff.'
                WHERE client_id = '.$client_id
        ;
        $query6 = '
            INSERT INTO `reserved_seats`(`session_id`, `seat_id`)
            VALUES('.$session_id.','.$seat_id.')';
        ;
        $result4 = mysqli_query($link, $query4);
        $result5 = mysqli_query($link, $query5);
        $result6 = mysqli_query($link, $query6);
      //  $d = mysqli_fetch_array($result4, MYSQLI_ASSOC);
        mail($a['mail'], 'Order', $cashier_id.','.$client_id.','.$session_id.','.$seat_id.',"'.$purchase_timedate.'",'.$cost.','.$paybon);
    }
    else if(isset($_GET['ready'])){
        if($link == FALSE){
            echo mysqli_connect_error();  
        }    
        else {
            $query = '
                SELECT movies.name AS mname, sessions.session_datetime as dat, halls.name as hname, sessions.session_id as session_id
                FROM sessions
                LEFT JOIN movies ON movies.movie_id = sessions.movie_id
                LEFT JOIN halls ON sessions.hall_id = halls.hall_id
                WHERE session_id = '.$_GET['session_id'];
            $result = mysqli_query($link, $query);
        }
        $a = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo 'Название: '.$a['mname'];
        echo '<br>Дата: '.$a['dat'];
        echo '<br>Зал: '.$a['hname'];
        echo '<br>Ряд: '.$_GET['row'];
        echo '<br>Место: '.$_GET['seat'];
        $_SESSION['session_id'] = $a['session_id'];
        $_SESSION['mname'] = $a['mname'];
        $_SESSION['dat'] = $a['dat'];
        $_SESSION['hname'] = $a['hname'];
        $_SESSION['row'] = $_GET['row'];
        $_SESSION['seat'] = $_GET['seat'];
        echo '<br>
        <form action="" method="GET">
            <input type="text" name="client_id" placeholder="clientId"><br>
            <input type="text" name="price" placeholder="Price"><br>
            <input type="checkbox" name="paybon">
            <label for="paybon">Pay by bonuses</label><br>
            <button type = submit name="shop_submit">Submit</button>
        </form>';
        
    }

    else if(isset($_GET['session_id'])){
        if($link == FALSE){
            echo mysqli_connect_error();  
        }    
        else {
            $query = '
                SELECT movies.name AS mname, sessions.session_datetime as dat, halls.name as hname, halls.row_amount as ramount, sessions.session_id as sess_id
                FROM sessions
                LEFT JOIN movies ON movies.movie_id = sessions.movie_id
                LEFT JOIN halls ON sessions.hall_id = halls.hall_id
                WHERE session_id = '.$_GET['session_id'];
            $result = mysqli_query($link, $query);
        }
        $a = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo $a['mname'].' ';
        echo $a['dat'].' ';
        echo $a['hname'].'<br>';
        echo $a['ramount'].'<br>';
        $query = '
                SELECT seats.seat_num as seat_num, seats.row_num as row_num
                FROM seats
                WHERE seats.hall_id = (SELECT hall_id FROM halls WHERE name = "'.$a['hname'].'")
                AND seats.seat_id NOT IN (
                    SELECT seat_id
                    FROM reserved_seats
                    WHERE session_id = '.$a['sess_id'].'
                    )';
            $result = mysqli_query($link, $query);
            $b = $result;
        echo "
        <br>
        <div class = 'chose_row'>";
            foreach($b as $sss){
               /* for(i=1; i<=$a['ramount']; i+=1){
                    
                    if($sss['row_num'] == i){
                        if()
                        echo $sss['row_num'], '<br>';
                        if
                    }
                }*/
                echo '<a href="?session_id='.$a['sess_id'].'&row='.$sss['row_num'].'&seat='.$sss['seat_num'].'&ready=true">';
                echo 'Ряд: '.$sss['row_num'], ' место: ', $sss['seat_num'], '<br>';
                echo '</a>';
              /*  foreach($sss as $ssss){
                    echo $ssss.'<br>';
                }*/
            }
        echo "</div>
        ";

    }
    else {
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
                                            $sess_id = $sess["session_id"];
                                            $sess_month = $sess["sess_month"];
                                            $sess_day = $sess["sess_day"];
                                            $sess_time = $sess["sess_time"];
                                            $sess_hall = $sess["hall_name"];
    
    
                                            if ($key == $sess_month){
                                                if(!(in_array($sess_day, $printed_days))){
                                                    echo $sess_day;
                                                    $printed_days[] = $sess_day;
                                                }
                                             //   echo '<br>';
                                                echo '<div>';
                                                echo '<a href="?session_id='.$sess_id.'">';
                                                echo ' ';
                                                echo $sess_time;
                                                echo ' ';
                                                echo $sess_hall;
                                                echo '</a>';
                                                echo '</div>';
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
    }
?>