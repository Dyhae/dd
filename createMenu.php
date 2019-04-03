<?php
    require('template.php');
    $error=false;
    $admin = filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT);


    if (!$admin) 
    {
      header("LOCATION:menu.php");
    }
    if($_POST != null)
    {
        $name = filter_input(INPUT_POST,'namePlate',FILTER_SANITIZE_SPECIAL_CHARS);
        $description= filter_input(INPUT_POST,'description',FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST,'price',FILTER_SANITIZE_NUMBER_FLOAT);
        $type= filter_input(INPUT_POST,'type',FILTER_SANITIZE_SPECIAL_CHARS);
        $array =[$name,$description,$price,$type];

        foreach($array as $variable)
        {
            if (!$variable || empty($variable)) 
            {
                $error = true;
                break;
            }

        }


      
           include "imageUpload.php";
        
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
            $query = "INSERT INTO menuitem (menuitemsName,description,price,type,menuItemImage) values('{$name}','{$description}','{$price}','{$type}','{$_FILES['image']['name']}')";
            $statement = $db->prepare($query);
            $statement->execute();

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
<body id="createMenuBody">
    <form 
    method="post"
    action="createMenu.php"
    enctype='multipart/form-data'>
        <div>
            <label for="namePlate">Plate Name:</label>
            <input type="text" name ="namePlate" id ="namePlate">
            <label for="description">Plate Description:</label>
            <textArea type="textBox" name="description" id="description"></textarea >
            <label for="price">Price:</label>
            <input type="text" name="price" id="price">
            <p id="foodType">
                <input type="radio" name="type" value="meat" id ="meat" >
                <label for="meat">Meat</label>
                <input type="radio" name="type" value="salads" id ="salads" >
                <label for="salads">Salads</label>
                <input type="radio" name="type" value="chicken" id ="chicken" >
                <label for="chicken">Chicken</label>
            </p> 
                <label for="image">Image Filename:</label>
                <input type="file" name="image" id="image">

            <button type="submit" name="submit">Create</button>
        </div>       
    </form>
    <?php if($error):?>
    <h1 class="errorCreate">Fill all the box and the price must be a number</h1>
    <?php else :?>
    <h1 class="errorCreate">The plate was created</h1>
    <?php endif ?>
    <!-- <?php if ($upload_error_detected): ?>

    <p>Error Number: <?= $_FILES['image']['error'] ?></p>

    <?php elseif ($image_upload_detected): ?>

    <p>Client-Side Filename: <?= $_FILES['image']['name'] ?></p>
    <p>Apparent Mime Type:   <?= $_FILES['image']['type'] ?></p>
    <p>Size in Bytes:        <?= $_FILES['image']['size'] ?></p>
    <p>Temporary Path:       <?= $_FILES['image']['tmp_name'] ?></p>

    <?php endif ?> -->
</body>
</html>