<?php
include "partials/_registration_header.php";
include "database/dbconnect.php";
if (isset($_POST["verify"])) {
    
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password=$_POST["password"];

    $sql="SELECT `Phone` from `Users` where `Email`='$email'";
    // echo $sql;
    $result= mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    // var_dump($row);
    if ($result){
        if ($phone == $row['Phone']){
            $query="UPDATE `Users` SET `Password`= '$password' WHERE `Email`='$email'";
            $result= mysqli_query($conn, $query);
            if($result){
                // echo"<link rel='stylesheet' href='resetstyle.css'>
                // <h6 class='popup'>Password updated successfully.
                // <br>

                echo "<div style='text-align: center; margin-bottom: 0.5%;'>";
                echo "<h1>PASSWORD UPDATED</h1>";
                echo "</div>";


                // echo"<link rel='stylesheet' href='resetstyle.css'>
                // <h6 class='popup'>Password updated successfully.
                // <br>
                // <a href='index.php'>Login Here</a></h6>";
            }
            
        }
        else{
             echo"<link rel='stylesheet' href='resetstyle.css'>
                <h6 class='popup1'>Wrong Credential.</h6>";
        }
    
    }


    
}
?>

<div class="container">
        
        <div id="user-login-box" class="login-box">
            <!-- <div class="login-icon"></div> -->
            <img src="images\agent logo.png" width="100" height="100">
            <h2>RESET PASSWORD</h2>
            <form method="post">
                
                <input type="text" name="email" placeholder="Email ID:" required>
                <input type="phone" name="phone" placeholder="Phone No.:" required>
                <input type="text" name="password" id="password" minlength="6" maxlength="10" placeholder="Enter New Password">
                <!-- <label for="agree">USER</label>
                <input type="checkbox" id='agree' name='agree' value="true"> -->
                <!-- <div class='radio-container'>
                <input type="radio"  name="agree" value="true">
                <label for="agree_yes">User</label>
                <input type="radio"  name="agree" value="false">
                <label for="agree_no">Agent</label>
                </div> -->
               

            


                <button type="submit" name="verify" class="login-btn">VERIFY</button>


                <!-- <a href="#" class="forgot-password">Forgot password?</a>
                <button type="button" class="register-btn">REGISTER</button> -->
               
            </form>
            
        </div>
      
        
</div>

<?php
include "partials/_footer.php"
?>