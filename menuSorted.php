<?php

// Session_start();
require('template.php');
$admin=false;

if(!$_POST)
{
    if (isset($_SESSION['Description'])) {
        if ($_SESSION['Description'] =='admin') {
            $admin = true;
        }
    }

        $query ="SELECT * FROM menuitem  ORDER BY type ASC";
        $items= $db->prepare($query);
        $items->execute();
        $Info = $items->fetchAll();
}
else
{
    $type= filter_input(INPUT_POST,'search',FILTER_SANITIZE_SPECIAL_CHARS);
        if (isset($_POST["search"])) 
        {
        
            $query ="SELECT * FROM menuitem WHERE type LIKE '%{$type}%' ";
            $items= $db->prepare($query);
            $items->execute();
            $Info = $items->fetchAll();
        }
  
}
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="stylepage.css">
    <script src="main.js"></script>
</head>
<header>
    <form action="menu.php"
            method="post">
    <label for="search">Search For Specific Type of food (Chicken, beef, salad):</label>
        <input type="text" name="search" id="search">
        <button type="submit">Search</button>
    </form>
</header>
<body id="menubody">
    <?php if($admin):?>
        <a id="createlink" href="createMenu.php?user=<?=$admin?>">create</a>
        <div  class="menuitem">    
            <?php foreach ($Info as $key):?> 
                <div class="dispaymenu">
                        <p><?=$key['type']?></p>
                        <p><img class="image"src="uploads/<?=$key['menuItemImage']?>" alt=""></p>
                        <p><?=$key['menuitemsName']?></p>
                        <p class="description"><?=$key['description']?></p>
                        <p><?=$key['price']?></p>
                        <a href="editMenu.php?id=<?=$key['id']?>&admin=admin&menuItemName=<?=$key['menuitemsName']?>">edit</a>
                </div>     
            <?php endforeach?>
        </div>
    <?php else :?>
        <div  class="menuitem">
            <?php foreach ($Info as $key):?>           
                <div class="dispaymenu">
                        <p><?=$key['type']?></p>
                        <p><img class="image" src="uploads/<?=$key['menuItemImage']?>" alt=""></p>
                        <p><?=$key['menuitemsName']?></p>
                        <p class="description"><?=$key['description']?></p>
                        <p><?=$key['price']?></p>
                </div>  
            <?php endforeach?>
        </div>
    <?php endif ?>
    <p>Note: To see the Entire Menu press the menu Button Again!!</p>
</body>
</html>