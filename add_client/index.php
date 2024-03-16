
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Добавление фильма</title>
    <link rel="shortcut icon" href="../../signform/images/logo.jpg" type="image/jpg">
    <link href="../../add_movie/css/style.css" media="screen" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
<header>
    <div class='wrap-logo'>
        <img class='round' src='../signform/images/logo.JPG' width = 60px>
        <a href='href=http://kr8/' class='logo'>Кинотеатр Prometheus</a>

    </div>
    <nav>
        <a href='http://kr8/'>Главная</a>
        <a href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
        <a href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
        <a href='https://kr8/add_client/' id='t3'>Добавить клиента</a>
        <a href='?exit=true'>Выйти</a>

    </nav>
</header>
<div class="container mregister">
    <div id="login">
        <h1>Добавить клиента</h1>
        <form action="index.php" id="registerform" method="post" name="registerform">
            <p><label for="user_login">Имя<br>
                    <input class="input" name="name" size="32" value=""></label></p>
            <p><label >Email<br>
                    <input class="input" name="email" size="32" value=""></label></p>
            <p class="button-center">
                <input class="button" name= "add_client" type="submit" value="Добавить">
            </p>
        </form>
    </div>
</div>
</body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>
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
    session_start();
    $signin_login = $_SESSION['signin_login'];
    $signin_password = $_SESSION['signin_password'];
    $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die();

    if($link == FALSE){
        echo mysqli_connect_error();
    }
    else {
        if(isset($_POST["add_client"])){
            if(!empty($_POST['name'])) {
                $name= htmlspecialchars($_POST['name']);
                $genre=htmlspecialchars($_POST['email']);
                $request = "INSERT INTO clients (`name`, email)
                                VALUES('$name', '$genre')";
                $result = mysqli_query($link, $request);
                if($result){
                    $message = "Client Successfully Added";
                } else {
                    $message = "Failed to insert data information!";
                }
            }
        }

    }
    $_POST['name'] = null;
    $_POST['email'] = null;
    $_POST["add_client"] = null;
    $sql_usr_table = null;
    $sql_cash_cashiers = null;
    ?>

    <?php
    if (!empty($message)) {
        echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";
    }
}
?>
