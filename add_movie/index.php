
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Регистрация сотрудника</title>
    <link href="css/style.css" media="screen" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'rel='stylesheet' type='text/css'>
</head>
<body>
<div class="top-menu">
    <a class='button' href='https://kr8/'>Меню</a>
    <a class='button' href='https://kr8/movies/'>Выбрать фильм</a>
    <a class='button' href='https://kr8/show_tickets/'>Посмотреть проданные билеты</a>
    <a class='button' href='https://kr8/registration/'>Добавить сотрудника</a>
    <a class='button' href='https://kr8/show_movies/'>Посмотреть фильмы</a>
    <a class='button' href='?exit=true'>Выйти</a>
</div>
<div class="container mregister">
    <div id="login">
        <h1>Добавить фильм</h1>
        <form action="index.php" id="registerform" method="post" name="registerform">
            <p><label for="user_login">Название<br>
                    <input class="input" name="name" size="32" value=""></label></p>
            <p><label >Жанры<br>
                    <input class="input" name="genre" size="32" value=""></label></p>
            <p class="button-center">
                <input class="button" name= "add_movie" type="submit" value="Добавить фильм">
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
            if(isset($_POST["add_movie"])){
                if(!empty($_POST['name'])) {
                    $name= htmlspecialchars($_POST['name']);
                    $genre=htmlspecialchars($_POST['genre']);
                    $request = "INSERT INTO movies (`name`, genre)
                                VALUES('$name', '$genre')";
                    $result = mysqli_query($link, $request);
                    if($result){
                        $message = "Movie Successfully Added";
                    } else {
                        $message = "Failed to insert data information!";
                    }
                }
            }

        }
        $_POST['name'] = null;
        $_POST['post'] = null;
        $_POST["add_movie"] = null;
        $sql_usr_table = null;
        $sql_cash_cashiers = null;
    ?>

    <?php 
        if (!empty($message)) {
            echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";
        }
    } 
?>