<?php
include 'connect.php';
// var_dump($_POST);

$id = 0;
for ($i = 1; $i <= 2; $i++) {
    $n = floor(rand(1, 500) * 20 + 10);
    $id = $id + $n;
}

session_start();
$_SESSION['varname'] = $id;

if (isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["location"]) and isset($_POST['Signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $location = $_POST['location'];
    if (!empty($_POST['type'])) {
        $radio = $_POST['type'];
    }
    $conn = OpenCon();
    switch ($radio) {
        case producer:
            $sql = "INSERT INTO producer (companyID, companyName, companyPW, location,totalProduced) VALUES ('$id', '$username','$password','$location','0')";
            break;
        case player:
            $sql = "INSERT INTO player (playerID, username, playerPW, location) VALUES ('$id', '$username', '$password', '$location');";
            $sql .= "INSERT INTO RegularMember (playerID) VALUES ('$id');";
            break;
    }
    if ($conn->multi_query($sql) === TRUE) {
        header('location:Popup.php');
    } else {
        echo "Error : " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/Center.css"/>
    <link rel="stylesheet" href="CSS/SignUp.css"/>
    <title>SignUp</title>
</head>

<body>

<div id="Centered">

    <div class="MainBox">

        <h1>New User Sign up</h1>
        <form action="SignUp.php" method="POST"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            <div class="inputBox">
                <div class="inputText">
                    User Name: <input type="text" name="username"> <br/><br/>
                    Password: <input type="password" name="password"> <br/><br/>
                    Confirm Password: <input type="password" name="password"> <br/><br/>
                </div>
                Location:
                <select name="location">
                    <optgroup label="location">
                        <option value=Asia>Asia</option>
                        <option value=Africa>Africa</option>
                        <option value=NorthAmerica>North America</option>
                        <option value=SouthAmerica>South America</option>
                        <option value=Antarctica>Antarctica</option>
                        <option value=Europe>Europe</option>
                        <option value=Australia>Australia</option>
                    </optgroup>
                </select> <br/><br/>
            </div>

            <div class="checkBox">
                Select a account type:<br/><br/>
                <input type="radio" id="player" name="type" value="player">
                <label for="regularmember">Player</label> * <br/><br/>
                <input type="radio" id="producer" name="type" value="producer">
                <label for="producer">Producer</label>
            </div>
            <input class="SignUpButton" type="submit" value="Sign up" name="Signup">

        </form>
    </div>
</div>
</body>
</html>
