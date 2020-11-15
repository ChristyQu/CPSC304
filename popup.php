<?php
include 'connect.php';
session_start();
$var_value = $_SESSION['varname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/Center.css"/>
    <link rel="stylesheet" href="CSS/PopUp.css"/>
    <title>Successful</title>
</head>
<body>

<div id="Centered">

    <div class="MainBox">

        <h3>Successful!</h3>
        <form method="POST" action="SignIn.php"> <!--refresh page when submitted-->
            Your ID is <h2><?php echo $var_value ?></h2>
            <p> Please be reminded that this ID number will be asked every time you log-in </p>
            <a href="SignIn.php">
                <input class="loginButton" type="button" value="Redirect to Sign-in page"/>
            </a>

        </form>
    </div>
</div>
</body>
</html>
