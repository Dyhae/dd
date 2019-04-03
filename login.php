<?php
    
    require("template.php");
    $username = '';

    if ($_POST != null) 
    {   
        $fullname = filter_input(INPUT_POST,'fullName',FILTER_SANITIZE_SPECIAL_CHARS);
        $phonenumber = filter_input(INPUT_POST, 'phoneNumber' ,FILTER_SANITIZE_NUMBER_INT);
        $address = filter_input(INPUT_POST,'address',FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
        $newPassword = filter_input(INPUT_POST,'newpassword',FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword = filter_input(INPUT_POST,'confirmpassword',FILTER_SANITIZE_SPECIAL_CHARS);
        $oldPassword = filter_input(INPUT_POST,'oldPassword',FILTER_SANITIZE_SPECIAL_CHARS);
        
        $select = "SELECT userName,password,description FROM client WHERE userName = '{$username}' ";
        $selectStat = $db->prepare($select);
        $selectStat ->execute();
        $lines = $selectStat->fetch();

        if(isset($_POST["register"]))
        {   
            if (!empty($fullname) && !empty($phonenumber)  && !empty($address)  && !empty($username)  && !empty($password)) 
            {
                // $message="Please log in";
                message("Please log in","/".$username);

                    if($lines['userName'] == $username)
                    {
                        message("The user already exits","/".$username);
                        // $message ="The user already exits";  
                    }
                    else
                    {
                        $query = "INSERT INTO client (clientName,phoneNumber,description,location,userName,password) values 
                        ('{$fullname}','{$phonenumber}','client','{$address}','{$username}','{$password}')";
                        $statment= $db->prepare($query);
                        $statment->execute();
                        
                        $message="The user has been created";

                    }   
            }
            else
            {
                // $message="Please log in";
                message("Please log in","/".$username);
            }
        }


    
        if(isset($_POST["change"]))
        {

            if($lines['userName'] == $username)
            {
                if ($lines['password'] == $oldPassword) 
                {
                    if ($newPassword==$confirmPassword)
                    {
                        $query = "UPDATE client SET password = '{$newPassword}' WHERE userName = '{$username}'";
                        $statement = $db ->prepare($query);
                        $statement->execute();
                        // $message="please login";
                        message("please login","/".$username);
                    }
                    else
                    {
                        // $message="The password doesnt match";
                        message("The password doesnt match","/".$username);
                    }     
                }
                else
                {
                    message("The  old password doesnt match","/".$username);
                }  
            }
            else
            {
                message("Please log in","/".$username);
            }
        }


        if(isset($_POST["submit"]))
        {
            if (!empty($username)  && !empty($password)) 
            {
                if ($lines['userName'] == $username)
                {
                    if ($lines['password'] == $password)
                    {
                        // Session_start();
                        $_SESSION['userName']=$username;
                        $_SESSION['password']=$password;
                        $_SESSION['Description']=$lines['description'];
                        header("location: menu.php");
                    }
                    else
                    {
                        message("The password is wrong","/".$username);
                    }
                }  
                else
                {
                    message("the username is wrong or doesn't exists","");
                }
            }
            else
            {
                message("the username is wrong or doesn't exists","");
            }
        }

        if(isset($_POST["delete"]))
        {
            if (!empty($username)  && !empty($password)) 
            {
                    
                if ($lines['userName'] == $username)
                {
                    if ($lines['password'] == $password)
                    {
                        // Session_start();
                        $query = "DELETE FROM client WHERE userName = '{$username}'";
                        $statement = $db->prepare($query);
                        $statement->execute();
                        
                        message("the user has been deleted","");
                    }
                    else
                    {
                        message("The password is wrong","/".$username);
                    }
                }
            }
            else
            {
                message("the username is wrong or doesn't exists","");
            }
        }

    }
    else
    {
        message("Input Information","");
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
<body id="loginbody">
<br>
<img id="loginImage" src="images/download.jpg" alt="dinner image">
    <?php if ($reg==true) :?>
        <form id="register"
            method="post" 
            action="login.php">
                <label for="fullName">Full Name:</label>
                <input  id="fullName" name="fullName" type="text">
                <label for="phoneNumber">Phone Number:</label>
                <input  id="phoneNumber"  name="phoneNumber" type="text">
                <label for="address">Address:</label>
                <input  id="address"  name="address" type="text">
                <label for="username">UserName:</label>
                <input  id="username" name="username"  type="text">
                <label for="password">Password:</label>
                <input id="password"  name="password" type="text">
                <button name="register" type="submit">register</button>
        </form>
    <?php else :?>
        <?php if ($change ==false):?>
            <form id="menu"
                method="post" 
                action="login.php">
                <label for="username">UserName:</label>
                <input  id="username" name="username" type="text">
                <label for="password">Password:</label>
                <input id="password" name="password" type="text">
                <button name="submit" type="submit">submit</button>
                <button name ="delete" type="submit">Delete User</button>
                <a href="login.php?changePassword=true">change Password</a>
            </form>
            <?php else :?>
            <form 
                method="post"
                action="login.php">
                <label for="changeUsername">UserName:</label>
                <input  id="changeUsername" name="username" type="text">
                <label for="oldPassword">Old Password:</label>
                <input  id="oldPassword" name="oldPassword" type="text">
                <label for="newpassword">New Password:</label>
                <input type="text" name="newpassword" id="newpassword">
                <label for="confirmpassword">Confirm Password</label>
                <input type="text" name="confirmpassword" id="confirmpassword">
                <button type ="submit" name="change">Change</button>
            </form>
        <?php endif ?>
    <?php endif?>
    <a id="registerlink" href="login.php?reg=true">Register</a>
    <a id="loginlink" href="login.php">Login</a>
</body>
</html>