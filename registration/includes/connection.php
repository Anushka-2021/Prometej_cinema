<?php
require("constants.php");

$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, "kr_apge") or die(mysqli_error());
#mysqli_select_db(DB_NAME) or die("Cannot select DB");
?>