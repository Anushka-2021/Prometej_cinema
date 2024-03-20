<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Кинотеатр Прометей</title>
    <link rel="shortcut icon" href="../../signform/images/logo.jpg" type="image/jpg">
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href = 'https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel = 'stylesheet' type = 'text/css' >
</head>
<body>
<header>
    <div class='wrap-logo'>
        <img class='round' src='../signform/images/logo.JPG' width = 60px>
        <a href='http://kr8/' class='logo'>Кинотеатр Prometheus</a>
    </div>
    <nav>
        <a href='http://kr8/'>Главная</a>
        <a class='active' href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
        <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
        <a href='https://kr8/add_client/' id='t3'>Добавить клиента</a>
        <a href='?exit=true'>Выйти</a>
    </nav>
</header>
<div class="container mupdate">
    <h1 id='t1'>Фильмы</h1>


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
    $signin_login = $_SESSION['signin_login'];
    $signin_password = $_SESSION['signin_password'];
    $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die();
    if(isset($_GET['shop_submit'])){

        if($link == FALSE){
            echo mysqli_connect_error();
        }
        else {
            ob_start();
            header("refresh: 3, url=http://kr8/movies");
            ob_end_clean();
            if($_GET['client_id'] != null){
                $query1 = '
                            SELECT clients.email AS mail FROM clients
                            WHERE client_id = '.$_GET['client_id'];
                $result1 = mysqli_query($link, $query1);
                $a = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                $client_id = $_GET['client_id'];

            }
            else{
                $client_id = null;
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
        if($_GET['client_id'] != null) {
            $query4 = 'INSERT INTO `tickets`(`cashier_id`, `client_id`, `session_id`, `seat_id`, `purchase_timedate`, `cost`, `paybon`)
                    VALUES(' . $cashier_id . ',' . $client_id . ', ' . $session_id . ',' . $seat_id . ',"' . $purchase_timedate . '",' . $cost . ',' . $paybon . ')';
        }
        else{
            $query4 = 'INSERT INTO `tickets`(`cashier_id`, `session_id`, `seat_id`, `purchase_timedate`, `cost`, `paybon`)
                    VALUES(' . $cashier_id . ', ' . $session_id . ',' . $seat_id . ',"' . $purchase_timedate . '",' . $cost . ',' . $paybon . ')';
        }
        if($paybon){
            $diff = -$cost;
        }
        else{
            $diff = $cost/10;
        }
        if($_GET['client_id'] != null) {
            $query5 = 'UPDATE clients
                   SET discount_points = discount_points+' . $diff . '
                   WHERE client_id = ' . $client_id;
            $result5 = mysqli_query($link, $query5);
        }
        $query6 = 'INSERT INTO `reserved_seats`(`session_id`, `seat_id`)
                   VALUES('.$session_id.','.$seat_id.')';
        ;
        $result4 = mysqli_query($link, $query4);

        $result6 = mysqli_query($link, $query6);
        //  $d = mysqli_fetch_array($result4, MYSQLI_ASSOC);
        if($_GET['client_id'] != null) {
            mail($a['mail'], 'Order', $cashier_id . ',' . $client_id . ',' . $session_id . ',' . $seat_id . ',"' . $purchase_timedate . '",' . $cost . ',' . $paybon);
        }
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
        echo '<div class="mtext">';
        echo 'Название: '.$a['mname'];
        echo '<br>Дата: '.$a['dat'];
        echo '<br>Зал: '.$a['hname'];
        echo '<br>Ряд: '.$_GET['row'];
        echo '<br>Место: '.$_GET['seat'];
        echo '<br></div>';
        $_SESSION['session_id'] = $a['session_id'];
        $_SESSION['mname'] = $a['mname'];
        $_SESSION['dat'] = $a['dat'];
        $_SESSION['hname'] = $a['hname'];
        $_SESSION['row'] = $_GET['row'];
        $_SESSION['seat'] = $_GET['seat'];
        echo '  <div class="confirm_order">
                            <h1>Оформление покупки</h1>
                            <form action="" method="GET">
                                <p ><label> ID клиента <br>
                                    <input class="input" type="text" name="client_id" placeholder="clientId"></label ></p >
                                <p ><label> Стоимость <br>
                                    <input type="text" name="price" placeholder="Price"><br></label ></p >
                                <input type="checkbox" name="paybon">
                                <label for="paybon">Pay by bonuses</label><br>
                                <button class="button" type = submit name="shop_submit">Оформить</button>
                            </form>
                        </div><br><br><br>';

    }

    else if(isset($_GET['session_id'])){
        if($link == FALSE){
            echo mysqli_connect_error();
        }
        else {
            $query = '
                            SELECT movies.name AS mname, sessions.session_datetime as dat, 
                            halls.name as hname, halls.row_amount as ramount, sessions.session_id as sess_id
                            FROM sessions
                            LEFT JOIN movies ON movies.movie_id = sessions.movie_id
                            LEFT JOIN halls ON sessions.hall_id = halls.hall_id
                            WHERE session_id = '.$_GET['session_id'];
            $result = mysqli_query($link, $query);
        }
        $a = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo '<div class="mtext">';
        echo 'Название: '.$a['mname'].' ';
        echo '<br>';
        echo 'Дата и время сеанса: '.$a['dat'].' ';
        echo '<br>';
        echo 'Наименование зала: '.$a['hname'];
        echo '<br></div>';
        //echo $a['ramount'].'<br>';
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
            echo '<div class="marg_rows">';
            echo '<a class="rows_seats" href="?session_id='.$a['sess_id'].'&row='.$sss['row_num'].'&seat='.$sss['seat_num'].'&ready=true">';
            echo 'Ряд: '.$sss['row_num'], ' место: ', $sss['seat_num'], '<br>';
            echo '</a></div>';
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
            $res_sessions = mysqli_query($link,  "SELECT *, MONTH(DATE(session_datetime)) AS sess_month, DAY(DATE(session_datetime)) AS sess_day, 
                                                        SUBSTRING(SEC_TO_TIME(((TIME_TO_SEC(session_datetime)+30) DIV 60) * 60),1,5) AS sess_time, 
                                                        halls.name AS hall_name FROM `sessions` 
                                                        LEFT JOIN halls ON halls.hall_id=sessions.hall_id 
                                                        WHERE movie_id='{$movie_id}'");
            $rs1 = $res_sessions;
            echo '
                            <div class = "movie">
                                <div class="movie-body-poster">
                                    <img class="posters" src="http://kr8/movies/posters/'.$movie_id.'.jpg" height="100%">
                                </div>
                                <div class="movie-body">
                                    <div class="movie-header">
                                        '.$row['name'].'
                                    </div>
                                    <div class="movie-body-info">
                                        '.$row['genre'].'
                                        <div class="movie-kalender">
                                            <p>Выберите дату</p>';
            //  <div class="movie-dates">';

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
                $i=0;
            }


            foreach($our_months as $key => $val){
                echo '<div class="movie-dates" vertical-allign="middle">';
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
                        echo '<div class="session_date">';
                        echo '<a class="href_session" href="?session_id='.$sess_id.'">';
                        echo ' ';
                        echo $sess_time;
                        echo ' ';
                        echo $sess_hall;
                        echo '</a>';
                        echo '</div>';

                    }

                }
                echo '</div>';
                echo '</div>';
            }

            echo
            '</div>
                                    </div>
                                </div>
                            </div>
                            
                        ';
        }
        echo '</div>';
    }}
    ?>
</div>
</body>
</html>