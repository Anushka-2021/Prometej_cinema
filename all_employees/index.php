<!DOCTYPE html>
<html>
<head>
    <title>Список сотрудников</title>
    <meta charset="utf-8" />
</head>
<body>
<h2>Список сотрудников</h2>
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
        echo "<td><a href='update.php?cashier_id=" . $row["cashier_id"] . "'>Изменить</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
$conn->close();
?>
</body>
</html>