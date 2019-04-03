<?php
    require('template.php');
    // $admin=$_GET['user'];
    // $admin = filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT);
    // if (!$admin) 
    // {
    //   header("LOCATION:menu.php");
    // }
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $query= "SELECT * FROM menuitem WHERE id = '{$id}'";
    $statement = $db->prepare($query);
    $statement->execute();
    $lines = $statement->fetch();
    $_SESSION['id']=$lines['id'];

    if ($_POST != Null) 
    {
        $itemName=filter_input(INPUT_POST,'itemName',FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST,'description',FILTER_SANITIZE_SPECIAL_CHARS);
        $price=filter_input(INPUT_POST,'price', FILTER_VALIDATE_FLOAT);
        $type=filter_input(INPUT_POST,'type',FILTER_SANITIZE_SPECIAL_CHARS);
        $idPost = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $image=filter_input(INPUT_POST,'image',FILTER_SANITIZE_SPECIAL_CHARS);
        $error= false;

        $inputs=[$itemName,$description,$price,$type];
            foreach($inputs as $variable)
            {
                if (!$variable || empty($variable)) 
                {
                    $error = true;
                    break;
                }
                else
                {
                    $error;
                }
    
            }
            // if (empty($image)) 
            // {
            //     if ($lines['menuItemImage'] != "") 
            //     {
            //         $image=$lines[]
            //     }
            // }
    

               require("imageUpload.php");
            
                $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
                $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);
            
                if ($image_upload_detected) { 
                    $image_filename       = $_FILES['image']['name'];
                    $temporary_image_path = $_FILES['image']['tmp_name'];
                    $new_image_path       = file_upload_path($image_filename);
            
                    if (file_is_an_image($temporary_image_path, $new_image_path)) { 
                        move_uploaded_file($temporary_image_path, $new_image_path);
                    }
                }

            if ($error==false) 
            {
                $update = "UPDATE menuitem SET menuitemsName = :menuitemsName, description = :description, price = :price, type = :type, menuItemImage = '{$_FILES['image']['name']}'WHERE id='{$idPost}'";
                $state = $db->prepare($update);
                $state->bindValue(':menuitemsName', $itemName);        
                $state->bindValue(':description', $description);
                $state->bindValue(':price', $price);
                $state->bindValue(':type', $type);
                $state->execute();
                
                header("LOCATION:editMenu.php?id=<?=$id?>");
            }
    

            
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="stylepage.css">
    <script src="main.js"></script>
</head>
<body id="editMenu">
    <form action="editMenu.php?id=<?=$id?>"
        method="post"
        enctype='multipart/form-data'>
        <label for="itemName">Item Name </label>
        <input type="text" name="itemName" id="itemName" value="<?=$lines['menuitemsName']?>">
        <label for="description">Description </label>
        <textarea name="description" id="description" cols="53" rows="20"><?=$lines['description']?></textarea>
        <label for="type">Type </label>
        <input type="text" name="type" id="type" value="<?=$lines['type']?>">
        <label for="price">Price </label>
        <input type="text" name="price" id="price" value="<?=$lines['price']?>">
        <label for="image">Image Filename:</label>
        <input type="file" name="image" id="image">
        <button type="submit" name="submit" id="submit">Change</button>
    </form>
  <img class="image" src="uploads/<?=$lines['menuItemImage']?>" alt="">
</body>
</html>