<!DOCTYPE html>
<html>
<head>
    <title>Список сотрудников</title>
    <meta charset="utf-8" />
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container mlistempl">
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