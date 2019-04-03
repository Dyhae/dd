<?php
    Session_start();
    define('DB_DSN','mysql:host=localhost;dbname=serverside');
    define('DB_USER','serveruser');
    define('DB_PASS','gorgonzola7!');
    
    
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
<div id="navbar">
                <ul>
                    <li><a class="link" href="http://localhost:31337/webfinalproject/Mainpage.php">Home</a></li>
                    <li><a class="link" href="http://localhost:31337/webfinalproject/menu.php">Menu</a></li>
                    <li><a class="link" href="http://localhost:31337/webfinalproject/about.php">About</a></li>
                    <?php if(!isset($_SESSION['userName'])):?>
                        <li><a class="link" href="http://localhost:31337/webfinalproject/login.php">Log in</a></li>
                    <?php else :?>
                        <li><a class="link" href="http://localhost:31337/webfinalproject/login.php?logoff=true"><?=$_SESSION['userName']?>/Log OUT</a></li>
                    <?php endif ?>
                    
                </ul>           
       </div>
</body>
</html>