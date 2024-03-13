
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
    <a class='button' href='https://kr8/movies/' id='t3'>Выбрать фильм</a>
    <a class='button' href='https://kr8/show_tickets/' id='t3'>Посмотреть проданные билеты</a>
    <a class='button' href='https://kr8/add_movie/' id='t3'>Добавить фильм</a>
    <a class='button' href='?exit=true'>Выйти</a>
</div>
<div class="container mregister">
    <div id="login">
        <h1>Регистрация</h1>
        <form action="index.php" id="registerform" method="post" name="registerform">
            <p><label for="user_login">Полное имя<br>
                    <input class="input" id="full_name" name="full_name"size="32"  type="text" value=""></label></p>
            <p><label for="user_pass">Должность<br>
                    <input class="input" id="post" name="post" size="32"type="post" value=""></label></p>
            <p><label for="user_pass">Имя пользователя<br>
                    <input class="input" id="username" name="username"size="20" type="text" value=""></label></p>
            <p><label for="user_pass">Пароль<br>
                    <input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
            <p class="submit"><input class="button" id="register" name= "register" type="submit" value="Зарегистрировать"></p>
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
require_once("includes/connection.php");
$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, "kr_apge") or die(mysqli_error());
if(isset($_POST["register"])){

    if(!empty($_POST['full_name']) && !empty($_POST['post']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $full_name= htmlspecialchars($_POST['full_name']);
        $post=htmlspecialchars($_POST['post']);
        $username=htmlspecialchars($_POST['username']);
        $password=htmlspecialchars($_POST['password']);
        $query=mysqli_query($con,"SELECT * FROM usertbl WHERE username='".$username."'");
        $numrows=mysqli_num_rows($query);
        if($numrows==0)
        {
            $sql_usr_table="INSERT INTO usertbl (full_name, username, password)
	                        VALUES('$full_name', '$username', '$password')";
            $result=mysqli_query($con, $sql_usr_table);
            if($result){
                $message = "Account Successfully Created";
                $sql_cash_cashiers = "INSERT INTO cashiers (name, post, username)
	                                    VALUES('$full_name', '$post', '$username')";
                $result_cash=mysqli_query($con, $sql_cash_cashiers);
                $sql_create_user_db = "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'";
                $result_create_user = mysqli_query($con, $sql_create_user_db);
                $sql_privileges1 = "GRANT SELECT, INSERT, UPDATE ON kr_apge.clients TO '".$username."'@'localhost';";
                $sql_privileges2 = "GRANT SELECT ON kr_apge.movies TO '".$username."'@'localhost';";
                $sql_privileges3 = "GRANT SELECT ON kr_apge.sessions TO '".$username."'@'localhost';";
                $sql_privileges4 = "GRANT SELECT, INSERT ON kr_apge.tickets TO '".$username."'@'localhost';";
                $sql_privileges5 = "GRANT SELECT ON kr_apge.halls TO '".$username."'@'localhost';";
                $sql_privileges6 = "GRANT SELECT ON kr_apge.cashiers TO '".$username."'@'localhost';";
                $sql_privileges7 = "GRANT SELECT ON kr_apge.seats TO '".$username."'@'localhost';";
                $sql_privileges8 = "GRANT SELECT, INSERT ON kr_apge.reserved_seats TO '".$username."'@'localhost';";
                $sql_privileges9 = "FLUSH PRIVILEGES;";
                mysqli_query($con, $sql_privileges1);
                mysqli_query($con, $sql_privileges5);
                mysqli_query($con, $sql_privileges2);
                mysqli_query($con, $sql_privileges5);
                mysqli_query($con, $sql_privileges3);
                mysqli_query($con, $sql_privileges5);
                mysqli_query($con, $sql_privileges4);
                mysqli_query($con, $sql_privileges5);
                mysqli_query($con, $sql_privileges6);
                mysqli_query($con, $sql_privileges7);
                mysqli_query($con, $sql_privileges8);
                mysqli_query($con, $sql_privileges9);
                #header( "Location: {$_SERVER['https://kr8/registration/register.php']}", true, 303 );
                #exit();
            } else {
                $message = "Failed to insert data information!";
            }
        } else {
            $message = "That username already exists! Please try another one!";
        }
    } else {
        $message = "All fields are required!";
    }
}
$_POST['full_name'] = null;
$_POST['post'] = null;
$_POST['username'] = null;
$_POST['password'] = null;
$_POST["register"] = null;
$sql_usr_table = null;
$sql_cash_cashiers = null;
?>

<?php if (!empty($message)) {echo "<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>