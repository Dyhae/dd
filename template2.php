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
 
    $reg =false;
    $change=false;
    if ($_GET != null)
    {
        $verify=filter_input(INPUT_GET,'reg',FILTER_SANITIZE_SPECIAL_CHARS);
        if ($verify==true) {
            $reg =true;
        }
        else {
            $reg=false;
        }

        
        $getchangePassword= filter_input(INPUT_GET,'changePassword',FILTER_SANITIZE_SPECIAL_CHARS);
        if ($getchangePassword==true) 
        {
            $change=true;
        }

        $verify = filter_input(INPUT_GET,'logoff',FILTER_SANITIZE_SPECIAL_CHARS);
        // $ver= filter_input(INPUT_GET,'log',FILTER_SANITIZE_SPECIAL_CHARS);

        // $Mainverify = filter_input(INPUT_GET,'logoffMain',FILTER_SANITIZE_SPECIAL_CHARS);
        if ($verify==true ) {
            session_destroy();
            header('location: login.php');
        }
       
       
    
    
    }
    if ($_POST != null) 
    {
        if ($_POST['search']=="search") {
            $input = filter_input(INPUT_POST,'search',FILTER_SANITIZE_SPECIAL_CHARS);
            $query = "SELECT * FROM websitetable WHERE websiteName ='{$input}'";
            $items= $db->prepare($query);
            $items->execute();
            $Info = $items->fetch();
            $name = $Info['websiteName'];
            header("LOCATION:$name.php");
        }
       

       
    }

    function message($stringMessage,$username)
    {
        ECHO $stringMessage.$username;
        
    }

    // $update = "INSERT INTO  websitetable (websiteName) values ('login.php')";
    //                 $state = $db->prepare($update);
    //                 $state->execute();
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
                    <li><a class="link" href="http://localhost:31337/webfinalproject/comment.php">FeedBack</a></li>
                    <?php if(!isset($_SESSION['userName'])):?>
                        <li><a class="link" href="http://localhost:31337/webfinalproject/login.php">Log in</a></li>
                    <?php else :?>
                        <li><a class="link" href="http://localhost:31337/webfinalproject/login.php?logoff=true"><?=$_SESSION['userName']?>/Log OUT</a></li>
                    <?php endif ?>
                    
                </ul>
       </div>
       <div class="container">
       <form action="template.php"
                     method ="post"
                     class="form-horizontal"
                     id="templateForm">
                    <label for="search">Search for a specific page</label>
                        <input class="form-control"type="text" name="search" id ="search">
                        <button type ="submit" id ="search" name="search" value="search" >Search</button>
                    </form>         
       </div>
       
</body>
</html>