
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