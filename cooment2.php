<?php
    require('template.php');
    // session_start();
    include 'bootstrap.php';
    
    if ($_POST != null ) 

    {
        $captcha = filter_input(INPUT_POST,'captcha',FILTER_SANITIZE_SPECIAL_CHARS);

        if ($captcha==$_SESSION['captcha']) 
        {
            $id = $_SESSION['id'];
            $content = filter_input(INPUT_POST,'comment',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $query = "INSERT INTO commenttable (clientId,comments) VALUES ('{$id}','{$content}')";
            $statement = $db->prepare($query);
            $statement->execute();
        }
       
    }

    
            $query = "SELECT * FROM commenttable ";
            $statement = $db->prepare($query);
            $statement->execute();
            $info = $statement->fetchALL();
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" media="screen" href="stylepage.css">
    <title>Document</title>
</head>

<body id ="commentBody">
    <form action="comment.php"
    method = "post"
    class="form-horizontal">
        <label class="control-label" for="comment">Enter comment</label>
        <p><img src="capcha.php" />Captcha<input class="form-control" type="text" name="captcha" /></p>
        <textArea class="form-control" type="text" name="comment" id= "comment"></textArea>
        <button type="submit" name = "commentb" class="btn btn-primary">Comment</button>
    </form>
    <?php foreach ($info as $key) :?>
        <p Style="color: rgba(158, 77, 10);;"><?=$key['comments']?></p>
    <?php endforeach ?>
</body>
</html>