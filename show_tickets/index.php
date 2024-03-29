<?php
session_start();
if(isset($_GET['exit'])){
    session_unset();
    session_destroy();
    ob_start();
    header("refresh: 0, url=http://kr8/");
    die();
    ob_end_clean();
}?>
<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Кинотеатр Прометей</title>
    <link rel="shortcut icon" href="../../signform/images/logo.jpg" type="image/jpg">
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
<header>
    <div class='wrap-logo'>
        <img class='round' src='../signform/images/logo.JPG' width = 60px>
        <a href='http://kr8/' class='logo'>Кинотеатр Prometheus</a>
    </div>
    <nav>
        <a href='http://kr8/'>Главная</a>
        <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
        <a class='active' href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
        <a href='https://kr8/add_client/' id='t3'>Добавить клиента</a>
        <a href='?exit=true'>Выйти</a>
    </nav>
</header>
    <div class="container mupdate">
	<h1>Купленные билеты</h1>


<?php
    session_start();
    $signin_login = $_SESSION['signin_login'];
    $signin_password = $_SESSION['signin_password'];
    $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die();
    
    if($link == FALSE){
        echo mysqli_connect_error();  
    }    
    else {
        $request = "SELECT *, tickets.ticket_id, tickets.session_id, tickets.seat_id, tickets.purchase_timedate, 
        tickets.cost, tickets.paybon, seats.seat_num, seats.row_num, `sessions`.session_datetime, 
        halls.name as hname, movies.name as mname, clients.name as cname, cashiers.name as wname
        FROM tickets 
        LEFT JOIN seats ON tickets.seat_id=seats.seat_id
        LEFT JOIN `sessions` ON `sessions`.session_id=tickets.session_id
        LEFT JOIN halls ON `sessions`.hall_id = halls.hall_id
        LEFT JOIN movies ON `sessions`.movie_id=movies.movie_id
        LEFT JOIN clients ON clients.client_id = tickets.client_id
        LEFT JOIN cashiers ON cashiers.cashier_id = tickets.cashier_id";
        $result = mysqli_query($link, $request);
        echo "
            <table><tr><th>Номер покупки</th><th>Кассир</th><th>Клиент</th><th>Время показа</th><th>Фильм</th><th>Зал</th><th>Место</th><th>Ряд</th><th>Время продажи</th><th>Цена билета</th><th>Оплачен бонусами</th></tr>
        ";
        foreach($result as $row){
            echo "<tr>";
            echo "<td>".$row["ticket_id"]."</td>";
            echo "<td>".$row["wname"]."</td>";
            echo "<td>".$row["cname"]."</td>";
            echo "<td>".$row["session_datetime"]."</td>";
            echo "<td>".$row["mname"]."</td>";
            echo "<td>".$row["hname"]."</td>";
            echo "<td>".$row["seat_num"]."</td>";
            echo "<td>".$row["row_num"]."</td>";
            echo "<td>".$row["purchase_timedate"]."</td>";
            echo "<td>".$row["cost"]."</td>";
            echo "<td>".$row["paybon"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
?>
</div>
</body>
</html>