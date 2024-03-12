<?php 
session_start();
if($_SESSION['stat'] == 'director'){
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
                    <br><a href="http://kr8/">Menu</a>
                    <br><a href="http://kr8/movies">Movies</a>
                    <br><a href="http://kr8/registration">Add new worker</a>
                    <br><a href="?exit=true">Exit</a>
                </body>
            </body>
        </html>
    ';
}
/*

$link = mysqli_connect("localhost", "root", "", "my_base") or die();
if($link == FALSE){
    echo mysqli_connect_error();  
}

if(isset($_GET['adding'])){
    if(isset($_POST["title"])){
        $_POST = NULL;
        
        $opts = [];

        $url_put = 'https://dummyjson.com/products/add';

        $context = stream_context_create($opts);
        $resp = file_get_contents($url_put, false, $context);
        print_r($resp);

        echo 'Done!'; 
 
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
                        <br><a href="buffer.php">Menu</a>
                    </body>
                </body>
            </html>
            '; 
    }    
    $_GET['adding'] = NULL;
}
elseif(isset($_GET['getting'])){
    if(isset($_GET['type'])){
        $url_getting = 'https://dummyjson.com/'.$_GET['type'].'/';
        if($_GET['type'] == "products"){
            $url_products = $url_getting.'search?q=iPhone';
            $json = file_get_contents($url_products);
            $obj = json_decode($json, true)["products"];
            //print_r($json);
            foreach($obj as $product){
                $query1 = 'SELECT id FROM products WHERE id='.$product["id"];
                $a = mysqli_query($link, $query1)->fetch_all(MYSQLI_ASSOC);

                $p_id = $product["id"];
                $p_title = $product["title"];
                $p_description = $product["description"];
                $p_price = $product["price"];
                $p_discountPercentage = $product["discountPercentage"];
                $p_rating = $product["rating"];
                $p_stock = $product["stock"];
                $p_brand = $product["brand"];
                $p_category = $product["category"];
                $p_thumbnail = $product["thumbnail"];

                if(empty($a)){
                    $query2 = 'INSERT INTO products(id, title, `description`, price, discountPercentage, rating, stock, brand, category, thumbnail) 
                    VALUES
                    ('.$p_id.', 
                    "'.$p_title.'", 
                    "'.$p_description.'", 
                    '.$p_price.', 
                    '.$p_discountPercentage.', 
                    '.$p_rating.', 
                    '.$p_stock.', 
                    "'.$p_brand.'", 
                    "'.$p_category.'", 
                    "'.$p_thumbnail.'");';
                    $result = mysqli_query($link, $query2);
                }
                else{
                    $query2 = "UPDATE products SET title='".$p_title."',
                    description='".$p_description."',
                    price=".$p_price.", 
                    discountPercentage=".$p_discountPercentage.", 
                    rating=".$p_rating.", 
                    stock=".$p_stock.", 
                    brand='".$p_brand."', 
                    category='".$p_category."', 
                    thumbnail='".$p_thumbnail."';";
                    $result = mysqli_query($link, $query2);
                }
            }    
            echo 'Done!';       
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
                        <br><a href="buffer.php">Menu</a>
                    </body>
                </body>
            </html>
            '; 
        }
        else{
            $json = file_get_contents($url_getting);
            echo $url_getting;
            print_r($json);
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
                        <br>
                        <a href="buffer.php">Menu</a>
                    </body>
                </body>
            </html>
            '; 
        }
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
                        <a href="buffer.php?getting=true&type=products">Products</a>
                        <a href="buffer.php?getting=true&type=recipes">Recipes</a>
                        <a href="buffer.php?getting=true&type=posts">Posts</a>
                        <a href="buffer.php?getting=true&type=users">Users</a>
                    </body>
                </body>
            </html>
        ';
    }
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
                <a href="buffer.php?adding=true">Добавление</a>
                <a href="buffer.php?getting=true">Получение</a>
            </body>
        </body>
        </html>
    ';
}*/
?>