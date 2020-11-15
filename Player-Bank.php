<?php
include 'connect.php';
session_start();
$id = $_SESSION['currentID'];

if ((isset($_POST["iAccountID"]) and isset($_POST["iExpiryDate"])) || (isset($_POST["uAccountID"]) and isset($_POST["toBeDeleted"]))) {
    $conn = OpenCon();
    if (isset($_POST['bankName']) and isset($_POST['insert'])) {
        $bankName = $_POST['bankName'];
        $iAccountID = $_POST['iAccountID'];
        $iExpiryDate = $_POST['iExpiryDate'];
        $sql = "INSERT INTO BankAccount (accountID, bankName, expiryDate) VALUES ('$iAccountID','$bankName','$iExpiryDate');";
        $sql .= "INSERT INTO HasBankAccount_Player (accountID, playerID) VALUES ('$iAccountID','$id')";
    } else if (isset($_POST['update'])) {
        $uAccountID = $_POST['uAccountID'];
        $uExpiryDate = $_POST['uExpiryDate'];
        $sql = "UPDATE BankAccount SET expiryDate='$uExpiryDate' WHERE accountID= '$uAccountID';";
    } else if (isset($_POST['delete'])) {
        $dAccountID = $_POST['toBeDeleted'];
        $sql = "DELETE FROM HasBankAccount_Player WHERE accountID = '$dAccountID';";
        $sql .= "DELETE FROM BankAccount WHERE accountID = '$dAccountID'";
    }
    if ($conn->multi_query($sql) === TRUE) {
        header('location:Player-Bank.php');
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
    <title>Bank</title>
</head>

<body>
<div id="Centered">

    <div class="Header">
        <img src="ProjectIMG/Header.jpg"/>
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
                    <a href="GameInfo-StardewValley.php">
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
            <form method="POST" action="Player-Bank.php"> <!--refresh page when submitted-->

                <h3>Bank Account</h3>
                <?php
                $conn = OpenCon();
                $query = "SELECT B.bankName, B.accountID, B.expiryDate FROM BankAccount B, HasBankAccount_Player H WHERE H.playerID = '$id' AND B.accountID = H.accountID";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    echo "<table border=1>";
                    echo "<tr><th>Bank Name</th><th>Account ID</th><th>Expiry Date</th></tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr> <td>" . $row["bankName"] . "</td> <td>" . $row["accountID"] . "</td> <td>" . $row["expiryDate"] . "</td> </tr>"; //or just use "echo $row[0]"
                    }
                    echo "</table>";
                } else {
                    echo "No account";
                }
                ?>

                <h3>Add New Payment Method</h3>
                Bank Name: <input type="text" name="bankName"> <br/><br/>
                Account ID: <input type="text" name="iAccountID" placeholder="xxxx-xxxx-xxxx-xxxx"> <br/><br/>
                Expiry Date: <input type="text" name="iExpiryDate" placeholder="YYYY-MM-DD">
                <input class="Button" type="submit" value="Add" name="insert"/> <br/><br/>

                <h3>Update Expire Date</h3>
                Account ID:
                <?php
                $conn = OpenCon();
                $query = "SELECT accountID FROM HasBankAccount_Player H WHERE H.playerID = '$id'";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    echo "<select name=uAccountID>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['accountID'] . "'>" . $row['accountID'] . "</option>";
                    }
                    echo "</select>";
                } else {
                    echo "No account";
                }
                ?><br/><br/>
                Expiry Date: <input type="text" name="uExpiryDate" placeholder="YYYY-MM-DD">
                <input class="Button" type="submit" value="Update" name="update"/> <br/><br/>

                <h3>Delete Account</h3>
                Account ID:
                <?php
                $conn = OpenCon();
                $query = "SELECT accountID FROM HasBankAccount_Player H WHERE H.playerID = '$id'";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    echo "<select name=toBeDeleted>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['accountID'] . "'>" . $row['accountID'] . "</option>";
                    }
                    echo "</select>";
                } else {
                    echo "No account";
                }
                ?>
                <input class="Button" type="submit" value="Delete" name="delete"/> <br/><br/>
            </form>
        </div>
    </div>
</div>
</body>
</html>