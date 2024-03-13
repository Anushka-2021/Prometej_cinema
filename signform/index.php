<?php
session_start();
if(isset($_GET['exit'])){
  session_unset();
  session_destroy();
  ob_start();
  header("refresh: 1, url=http://kr8/");
  ob_end_clean();
}

else if(isset($_GET['signinlogin'])){
  ob_start();
  $signin_login = $_GET['signinlogin'];
  $signin_password = $_GET['signinpassword'];
  try {
    mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge");
  } catch (Exception $e) {
    session_unset();
    session_destroy();
    echo "Not today..";
    header("refresh: 0, url=http://kr8/");
  }
 
  $link = mysqli_connect("localhost", $signin_login, $signin_password, "kr_apge") or die("not now");
    
  if($link == FALSE){
     //   echo mysqli_connect_error();  
        die("Something's wrong with your access :(");
    }    
    else {
      //  session_start();
        $_SESSION['signin_login'] = $signin_login;
        $_SESSION['signin_password'] = $signin_password;
        $_SESSION['stat'] = 'director'; //дописать нормальное
        $query = 'SELECT * FROM `sessions`';
        $result = mysqli_query($link, $query);
        echo $_SESSION['signin_login'];
    }
    
  header("refresh: 1, url=http://kr8/index.php");
  ob_end_clean();
 
}
else if(!isset($_SESSION['signin_login'])){
  echo '<!doctype html>
    <html lang="en">
      <head>

        <meta charset="utf-8">
        <meta name="description" content="">
        <title>Авторизация</title>
        <link href="css/style.css" media="screen" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"rel="stylesheet" type="text/css">

      </head>
      <body>
 
    <div class="container mregister">
      <form action="#">
        <h1>Авторизация</h1>

        
        <p><label for="floatingInput">Логин<br>
        <input type="input" class="input" id="floatingInput" placeholder="user1234" name="signinlogin">
        </label>
        </p>
          <p><label for="floatingPassword">Пароль<br>
          <input type="password" class="input" id="floatingPassword" placeholder="password" name="signinpassword">
          </label></p>
          

        <button class="button" type="submit">Войти</button>
      </form>
    </div>

        </body>
    </html>';
}
else {
  echo '
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Page</title>
            </head>
            <body>
                <body>
                    <br>You are already in as '.$_SESSION['signin_login'].' , status: '.$_SESSION['stat'].'<br>
                    <br><a href="http://kr8/">Menu</a>
                    <br><a href="http://kr8/movies">Movies</a>
                    <br><a href="?exit=true">Exit</a>
                </body>
                
            </body>
        </html>
    ';
}
?>