<?php
include 'connect.php';
session_start();
$id = $_SESSION['currentID'];

if (isset($_POST["comment"])) {
    $conn = OpenCon();
    if (isset($_POST['insert'])) {
        $content = $_POST['comment'];
        $sql = "INSERT INTO MakesComments (commentTime, content, playerID, gameID) VALUES ((now()),'$content','$id',1)";
    }
    if ($conn->query($sql) === TRUE) {
        header('location:GameInfo-StardewValley.php');
    } else {
        echo "Error : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/Sidebar.css"/>
    <link rel="stylesheet" href="CSS/iconfont-Sidebar.css"/>
    <title>StardewValley</title>
</head>

<body>

<div id="Centered">

    <div class="Header">
        <img src="ProjectIMG/Game/StardewValley.jpg"/>
    </div>

    <div class="MainBox">

        <div class="SideBar">
            <ul>
                <li>
                    <a href="Player-Info.php">
                        <span class="iconfont icon-user"></span>
                        <span>Account Info</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Membership.php">
                        <span class="iconfont icon-membership"></span>
                        <span>Membership</span>
                    </a>
                </li>
                <li>
                    <a href="Player-MyGames.php">
                        <span class="iconfont icon-game"></span>
                        <span>My Games</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Bank.php">
                        <span class="iconfont icon-bank"></span>
                        <span>Bank Account</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Device.php">
                        <span class="iconfont icon-device"></span>
                        <span>Device</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Gift.php">
                        <span class="iconfont icon-gift"></span>
                        <span>Gift</span>
                    </a>
                </li>
                <li>
                    <a href="Player-Friends.php">
                        <span class="iconfont icon-friends"></span>
                        <span>Friends</span>
                    </a>
                </li>
                <li>
                    <a href="Player-AllGames.php">
                        <span class="iconfont icon-all"></span>
                        <span>All Games</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="Content">
            <h2>Stardew Valley</h2>
            <?php
            $conn = OpenCon();
            $query = "SELECT G.gameType, G.latestVersion, P.companyName FROM Game AS G, PublishUpdateGame AS Publish, Producer AS P WHERE G.gameID = 1 AND Publish.gameID = G.gameID AND Publish.companyID = P.companyID";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "Type: " . $row['gameType'] . " &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Latest Version: " . $row['latestVersion'] . " &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Producer: " . $row['companyName'] . "<br/><br/>";
            }
            $query = "SELECT C.content, P.username, C.commentTime FROM MakesComments AS C, Player AS P WHERE C.gameID = 1 AND C.playerID = P.playerID";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                echo "<table border=1>";
                echo "<tr><th>Comments</th><th>Username</th><th>Comment Time</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr> <td>" . $row["content"] . "</td> <td>" . $row["username"] . "</td> <td>" . $row["commentTime"] . "</td> </tr>";
                }
                echo "</table>";
            } else {
                echo "No comment";
            }
            ?>

            <form method="POST" action="GameInfo-StardewValley.php"> <!--refresh page when submitted-->
                <input type="text" name="comment" placeholder="Comment..."/>
                <input class="Button" type="submit" value="Submit" name="insert"/> <br/><br/>
            </form>

            <?php
            $conn = OpenCon();
            $query = "SELECT timeSpent, rating FROM HasPlayer_Game_Accomplishment WHERE gameID = 1 AND playerID = '$id'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "Game length: " . $row['timeSpent'] . " &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Rating/Rank: " . $row['rating'] . "<br/><br/>";
                }
            } else {
                echo "Haven't played this game yet.";
            }
            echo "My accomplishment:";
            $query = "SELECT H.accomplishmentID, A2.reward, A2.accomplishLevel, H.obtainedDate FROM HasPlayer_Game_Accomplishment AS H, Accomplishment AS A, Accomplishment2 AS A2 WHERE H.gameID = 1 AND playerID = '$id' AND H.accomplishmentID = A.accomplishmentID AND A.accomplishLevel = A2.accomplishLevel";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                echo "<table border=1>";
                echo "<tr><th>AccomplishmentID</th><th>Reward</th><th>Level</th><th>Date</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr> <td>" . $row["accomplishmentID"] . "</td> <td>" . $row["reward"] . "</td> <td>" . $row["accomplishLevel"] . "</td> <td>" . $row["obtainedDate"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No accomplishment";
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>