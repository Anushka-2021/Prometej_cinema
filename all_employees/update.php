<?php
$conn = new mysqli("localhost", "root", "", "kr_apge");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Обновление</title>
    <link rel="shortcut icon" href="../../signform/images/logo.jpg" type="image/jpg">
    <meta charset="utf-8" />
    <link href="../../add_movie/css/style.css" media="screen" rel="stylesheet">
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
<div class="container mregister">
    <div id="login">
<?php
// если запрос GET
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["cashier_id"]))
{
    $userid = $conn->real_escape_string($_GET["cashier_id"]);
    $sql = "SELECT * FROM cashiers WHERE cashier_id = '$userid'";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $name = $row["name"];
                $post = $row["post"];
                $status = $row["status"];
            }
            echo "
                    <h1>Обновление пользователя</h1>
                    <form method='post'>
                    <input class='input' type='hidden' name='cashier_id' value='$userid' />
                    <p><label>Имя:
                    <input class='input' type='text' name='name' value='$name' /></label></p>
                    <p><label>Должность:
                    <input class='input' type='text' name='post' value='$post' /></label></p>
                    <p><label>Статус:
                    <input class='input' type='number' name='status' value='$status' /></label></p>
                    <input class='button' type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Пользователь не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $conn->error;
    }
}
elseif (isset($_POST["cashier_id"]) && isset($_POST["name"]) && isset($_POST["post"]) && isset($_POST["status"])) {

    $userid = $conn->real_escape_string($_POST["cashier_id"]);
    $name = $conn->real_escape_string($_POST["name"]);
    $post = $conn->real_escape_string($_POST["post"]);
    $status = $conn->real_escape_string($_POST["status"]);
    $sql = "UPDATE cashiers SET name = '$name', post = '$post', status = '$status' WHERE cashier_id = '$userid'";
    if($result = $conn->query($sql)){
        header("Location: index.php");
    } else{
        echo "Ошибка: " . $conn->error;
    }
}
else{
    echo "Некорректные данные";
}
$conn->close();
?>
</div>
</div>
</body>
</html>