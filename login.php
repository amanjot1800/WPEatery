<?php
include "header.php";

    require_once('WebsiteUser.php');
    session_start();
    if(isset($_SESSION['websiteUser'])){
        if($_SESSION['websiteUser']->isAuthenticated()){
            session_write_close();
            header('Location:mailing_list.php');
        }
    }
    $missingFields = false;
    if(isset($_POST['submit'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            if($_POST['username'] == "" || $_POST['password'] == ""){
                $missingFields = true;
            } else {
                //All fields set, fields have a value
                $websiteUser = new WebsiteUser();

                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $websiteUser->authenticate($username, $password);
                    if($websiteUser->isAuthenticated()){
                        $_SESSION['websiteUser'] = $websiteUser;
                        header('Location:mailing_list.php');
                    }
                }
            }

    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Week 12 Lecture</title>
    </head>
    <body>
        <!-- MESSAGES -->
        <?php
            //Missing username/password
            if($missingFields){
                echo '<h3 style="color:red;">Please enter both a username and a password</h3>';
            }
            
            //Authentication failed
            if(isset($websiteUser)){
                if(!$websiteUser->isAuthenticated()){
                    echo '<h3 style="color:red;">Login failed. Please try again.</h3>';
                }
            }
        ?>
        
        <form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <table style="margin:20px auto 20px auto">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" id="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id="password"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" id="submit" value="Login"></td>
                <td><input type="reset" name="reset" id="reset" value="Reset"></td>
            </tr>
        </table>
        </form>
    </body>
</html>

<?php include "footer.php" ?>