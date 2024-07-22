<?php
include "partials/_registration_header.php";
$showAlert = false;
$showError = false;

if (isset($_POST["login"])) {

    $user_name = $_POST["Username"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $mobile = $_POST['mobile_no'];
    $type = $_POST['Type'];


    $connection = mysqli_connect('localhost', 'root', '', 'recruitmentpage');

    if (!$connection) {
        echo "Something went wrong";

        // if(!$result){
        //     die('User already exists');
        // }
    } else {
        if ($password == $c_password) {
            $query = "INSERT INTO `users`(`Username`, `Email`, `Password`, `Phone`, `Type`)";
            $query .= "VALUES ('$user_name','$email','$password','$mobile','$type')";

            $result = mysqli_query($connection, $query);
            if ($result) {
                $showAlert = true;
            } else {
                if (substr($connection->error, 0, 10) == 'Duplicate ') {
                    echo "<div style='text-align: center; margin-bottom: 0.5%;'>";
                    echo "<h1>User already exist</h1>";
                } else {
                    echo $connection->error;
                }
            }
        } else {
            echo "<div style='text-align: center; margin-bottom: 0.5%;'>";
            echo "<h1>Password not matched</h1>";
            $showError = true;
        }
    }
    // $query="INSERT INTO user_credentials('First name',Last name,Email,Password,Phone_No,Organisation) ";
    // $query .="VALUES('$first_name','$last_name','$email','$password','$mobile','$organization')";


}
?>



<div class="container">
    <?php
    if ($showAlert) {
        echo "<h1>your account is created successfully</h1>";
        echo "<a href='/PHP/recruiters_page/index.php'>Login Here</a>";
    }
    ?>
    <div id="user-login-box" class="login-box">

        <!-- <div class="login-icon">
            </div> -->
        <img src="images\computer-1331579_640.webp" width="100" height="100">
        <h2>USER REGISTRATION</h2>
        <form method="post">
            <input type="text" name="Username" id="Username" maxlength="30" placeholder="Enter Your Name"
                required>
            <!-- <input type="text" name="last_name" id="last_name" maxlength="30" placeholder="Enter Your Last Name"
                required> -->
            <input type="email" name="email" id="email" maxlength="50" placeholder="Enter Email Id" required>
            <input type="phone" name="mobile_no" placeholder="Mobile No.:" maxlength="13" required>
            <input type="hidden" id="Type" name="Type" value="User">
            <input type="text" name="password" id="password" minlength="6" maxlength="10" placeholder="Enter Password"
                required>
            <input type="password" name="c_password" id="c_password" minlength="6" maxlength="10"
                placeholder="Confirm Password" required>
            <p id="error-message" style="color: red;"></p>
            <button type="submit" name="login" class="login-btn">REGISTER NOW</button>
            <!-- <button type="reset" name="login" class="login-btn">RESET</button> -->
            <button type="reset" class="login-btn">RESET</button>


        </form>
        <script>
            var password = document.getElementById("password");
            var confirmPassword = document.getElementById("c_password");


            function checkPasswordMatch() {
                // console.log(confirmPassword.value);

                var errorMessage = document.getElementById("error-message");

                if (password.value !== confirmPassword.value) {
                    errorMessage.textContent = "Passwords do not match!";
                    return false; // Prevent form submission
                }

                errorMessage.textContent = ""; // Clear any previous error message
                return true; // Allow form submission
            }

            confirmPassword.addEventListener('input', checkPasswordMatch);


        </script>
    </div>
</div>

<?php
include "partials/_footer.php"
?>