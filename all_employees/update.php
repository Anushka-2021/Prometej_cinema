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
    <meta charset="utf-8" />
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
<div class="containerupd mupdate">
    <div class="login">
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
                    <p>Имя:
                    <input class='input' type='text' name='name' value='$name' /></p>
                    <p>Должность:
                    <input class='input' type='text' name='post' value='$post' /></p>
                    <p>Статус:
                    <input class='input' type='number' name='status' value='$status' /></p>
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