<?php
session_start();
if(isset($_GET['exit'])){
  session_unset();
  session_destroy();
  ob_start();
  header("refresh: 3, url=http://kr8/");
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
    
  header("refresh: 5, url=http://kr8/page/index.php");
  ob_end_clean();
 
}
else if(!isset($_SESSION['signin_login'])){
  echo '<!doctype html>
    <html lang="en">
      <head>

        <meta charset="utf-8">
        <meta name="description" content="">
        <title>Signin Template · Bootstrap v5.3</title>
        
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
          .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
          }

          @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
          }

          .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
          }

          .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
          }

          .bi {
            vertical-align: -.125em;
            fill: currentColor;
          }

          .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
          }

          .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
          }

          .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
          }


        </style>

        <link href="sign-in.css" rel="stylesheet">
      </head>
      <body class="d-flex align-items-center py-4 bg-body-tertiary">
 
    <main class="form-signin w-100 m-auto">
      <form action="#">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
          <input type="input" class="form-control" id="floatingInput" placeholder="name@example.com" name="signinlogin">
          <label for="floatingInput">Login</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="signinpassword">
          <label for="floatingPassword">Password</label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
      </form>
    </main>

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