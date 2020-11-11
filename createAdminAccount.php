<?php
    include("./force_login.php");
    global $user_id;
    include_once("./sqlInit.php");
    global $conn;
    include("./header.php");
?>

<!-- background on the website-->
<div class="bg">
    <!-- border layout-->
    <div class="round2">
        <?php
        // Used on account creation
        if(isset($_POST["uname"]) && 
            isset($_POST["fname"]) && isset($_POST["lname"]) &&
            isset($_POST["phone"]) && isset($_POST["email"]) &&
            isset($_POST["psw"])){
            $query = "CALL `insert_new_admin`('".$_POST["uname"]."', '".$_POST["psw"]."', 
            '".$_POST["email"]."', '".$_POST["phone"]."', 
             '".$_POST["lname"]."', '".$_POST["fname"]."')";
            mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
            $result = mysqli_store_result($conn);
            $login_successful = mysqli_fetch_row($result)[0];
            mysqli_free_result($result);
            header("Location: ./manageAccounts.php");
        }
        ?>
        <p><h3>Create Administrator Account</h3>
        <form action="./createAdminAccount.php" method="post">
            <input type="text" placeholder="Username" id="uname" name="uname" required>
            <br><br>
            <input type="text" placeholder="First Name" id="fname" name="fname" required>
            <input type="text" placeholder="Last Name" id="lname" name="lname" required>
            <br><br>
            <input type="text" placeholder="Phone" id="phone" name="phone" required>
            <input type="text" placeholder="E-mail" id="email" name="email" required>
            <br><br>
            <input type="password" placeholder="Password" id="psw" name="psw" required>
            <input type="password" placeholder="Re-Enter Password" id="psw" name="psw" required>
            <br><br>
            <button type="submit">Register Now</button>
        </form>
        <br><br><br>
        </p>
    </div>
</div>

<?php
    include("./footer.php");
?>
