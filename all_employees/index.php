<!DOCTYPE html>
<html>
<head>
    <title>Список сотрудников</title>
    <link rel="shortcut icon" href="../../signform/images/logo.jpg" type="image/jpg">
    <meta charset="utf-8" />
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
<header>
    <div class='wrap-logo'>
        <img class='round' src='../signform/images/logo.JPG' width = 60px>
        <a href='' class='logo'>Кинотеатр Prometheus</a>
    </div>
    <nav>
        <a href='http://kr8/'>Главная</a>
        <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
        <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
        <a href='https://kr8/add_client/' id='t3'>Добавить клиента</a>
        <div class='dropdown'>
            <button class='dropbtn'>Управление</button>
            <div class='dropdown-content'>
                <a href='https://kr8/add_movie/' id='t3'>Добавить фильм</a>
                <a href="http://kr8/add_session/" id="t3">Добавить сеанс</a>
                <a href='https://kr8/registration'>Добавить сотрудника</a>
                <a href='https://kr8/all_employees'>Список сотрудников</a>
            </div>
        </div>
        <a href='?exit=true'>Выйти</a>

    </nav>
</header>
<div class="container mupdate">
<h1>Список сотрудников</h1>

<?php
$conn = new mysqli("localhost", "root", "", "kr_apge");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
$sql = "SELECT * FROM cashiers";
if($result = $conn->query($sql)){
    echo "<table><tr><th>ID</th><th>Имя</th><th>Должность</th><th>Статус</th><th></th></tr>";
    foreach($result as $row){
        echo "<tr>";
        echo "<td>" . $row["cashier_id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["post"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td><a href='update.php?cashier_id=" . $row["cashier_id"] . "'> <img src='images/update.png' width = 25px> </a></td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
$conn->close();
?>
</div>
</body>
</html>