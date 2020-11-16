<?php
include 'connect.php';
session_start();
$id = $_SESSION['currentID'];

if (isset($_POST["username"]) and isset($_POST['Update'])){
    $conn = OpenCon();

    $username = $_POST['username'];
    $sql = "UPDATE player SET username='$username' WHERE playerID='$id'";

    if ($conn->multi_query($sql) === TRUE) {
        header('Player-Info.php');
    } else {
        echo "Error : " . $conn->error;
    }
} else {
    echo "POST array is null";
  }

// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../CSS/Sidebar.css"/>
    <link rel="stylesheet" href="../../CSS/iconfont-Sidebar.css"/>
    <title>User Information</title>
</head>

<body>
<div id="Centered">

    <div class="Header">
        <img src="../../ProjectIMG/Header.jpg"/>
    </div>

    <div class="MainBox">

        <div class="SideBar">
            <ul>
                <li>
                    <a href="Player-Info.html">
                        <span class="iconfont icon-user"></span>
                        <span>Account Info</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Membership.html">
                        <span class="iconfont icon-membership"></span>
                        <span>Membership</span>
                    </a>
                </li>
                <li>
                    <a href="Player-MyGames.html">
                        <span class="iconfont icon-game"></span>
                        <span>My Games</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Bank.html">
                        <span class="iconfont icon-bank"></span>
                        <span>Bank Account</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Device.html">
                        <span class="iconfont icon-device"></span>
                        <span>Device</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Gift.html">
                        <span class="iconfont icon-gift"></span>
                        <span>Gift</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Friends.html">
                        <span class="iconfont icon-friends"></span>
                        <span>Friends</span>
                    </a>
                </li>
                <li>
                    <a href="Player-AllGames.html">
                        <span class="iconfont icon-all"></span>
                        <span>All Games</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="Content">
            <h2>Account Info</h2>
            <img src="../../ProjectIMG/ProfilePic.jpg"/>

            <form method="POST" action="Player-Info.php"> <!--refresh page when submitted-->
                <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">

                <div class="Read">
                  <?php
                  $conn = OpenCon();
                  $query = "SELECT P.username, P.playerID, P.location FROM Player P WHERE P.playerID = '$id'";
                  $result = $conn->query($query);
                  $row = $result->fetch_assoc();

                  echo "User Name: " . $row["username"] . "<br/><br/>";
                  echo "ID :" . $row["playerID"] . "<br/><br/>";
                  echo "Location: " . $row["location"] . "<br/><br/>";

                  $conn->close();
                  ?>

                </div>
                <br/><br/>
                <div class="Write">
                    New name: <input class="read" type="text" name="username">
                    <input class="Button" type="submit" name="Update" value="Update"> <br/><br/>
                </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
