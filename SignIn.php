<?php
include 'connect.php';

if (isset($_POST["UserID"]) and isset($_POST["Password"])) {
    $userID = $_POST['UserID'];
    $password = $_POST['Password'];

    session_start();
    $_SESSION['currentID'] = $userID;

    if (!empty($_POST['type'])) {
        $radio = $_POST['type'];
    }
    $conn = OpenCon();
    switch ($radio) {
        case Producer:
            $sql = "SELECT * FROM Producer WHERE companyID = '$userID' and companyPW ='$password'";
            $result = mysqli_query($conn, $sql) or die("Failed to query database " . mysql_error());
            $row = mysqli_fetch_array($result);
            if ($row['companyID'] === $userID && $row['companyPW'] === $password) {
                header('location:Player-Bank.php');
            } else {
                echo "Failed to login!";
            }
            break;
        case Player:
            $sql = "SELECT * FROM Player WHERE playerID = '$userID' and playerPW ='$password'";
            $result = mysqli_query($conn, $sql) or die("Failed to query database " . mysql_error());
            $row = mysqli_fetch_array($result);
            if ($row['playerID'] === $userID && $row['playerPW'] === $password) {
                header('location:Player-Bank.php');
            } else {
                echo "Failed to login!";
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Center.css"/>
    <link rel="stylesheet" href="CSS/iconfont-SignIn.css"/>
    <link rel="stylesheet" href="CSS/SignIn.css"/>
    <title>SignIn</title>
</head>

<body>

<div id="Centered">
    <div class="MainBox">
        <form action="SignIn.php" method="POST"> <!--refresh page when submitted-->
            <h1>SIGN IN</h1>

            <div checkBox>
                <div class="checkBox">
                    <input type="radio" id="Player" name="type" value="Player" checked>
                    <label for="Player">Player</label>
                    <input type="radio" id="Producer" name="type" value="Producer">
                    <label for="Producer">Producer</label>
                </div>
            </div>

            <div class="inputBox">
                <div class="inputText">
                    <span class="iconfont icon-nickname"></span>
                    <input type="text" name="UserID" placeholder="UserID"/> <br/><br/>
                    <span class="iconfont icon-visible"></span>
                    <input type="password" name="Password" placeholder="Password"/>
                </div>
            </div>

            <input class="loginButton" type="submit" value="Login">

            <p>
                Don't have an account? <a href="SignUp.php">Join us!</a>
            </p>
        </form>
    </div>
</div>
</body>

</html>
