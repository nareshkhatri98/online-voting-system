<?php
include "../Admin/inc/connection.php";

$error = array(); // Initialize the error array

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_role = "User";

    // Check if the phone number already exists
    $userExist = "SELECT * FROM users WHERE phone = '$phone'";
    $result = mysqli_query($conn, $userExist);
    if (mysqli_num_rows($result) > 0) {
        $error[] = "Phone number already exists";
    }

    if ($password == $cpassword) {
        // Proceed with registration if the password matches
        if (empty($error)) {
            $insert = "INSERT INTO users(fullname, phone, password, user_role) VALUES('$name','$phone','$password','$user_role')";
            mysqli_query($conn, $insert);
            if ($insert) {
                $error[] = "Registration successful";
                header("location:login_page.php");
            } else {
                $error[] = "Something went wrong";
                header("location:Register-page.php");
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home</title>
    <link rel="stylesheet" href="../cssfolder/first.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link rel="stylesheet" href="../cssfolder/style.css">
</head>

<body>
    <section id="header">
        <h1 class="logo">Go Vote</h1>
        <div>
            <ul id="navbar">
                <li><a href="../hompage/home_page.html">Home</a></li>
                <li><a href="about.html">About us</a></li>
                <li><a href="" id="user-icon"><i class="fas fa-user"></i></a></li>
            </ul>
        </div>
    </section>

    <div class="form-container">
        <form action="Register-page.php" method="post" class="form-only" style=" margin-bottom: -10%;"
            onsubmit="return myfun()">
            <h3>register</h3>
            <?php
            if (!empty($error)) {
                echo '<span class="error-msg">' . implode("<br>", $error) . '</span>';
            }
            ?>

            <label for="">Fullname</label>
            <input type="text" name="name" pattern="^[a-zA-Z]+ [a-zA-Z]+$" required placeholder="enter your name">
            <label for="">Phone</label>
            <input type="text" name="phone" id="phonenumber"> <span id="message" style="color:red;"></span>

            <label for="">Password</label>
            <span id="messages" style="color:red;"></span>
            <input type="password" name="password" id="password">
            <label for="">Confirm_Password</label>
            <span id="messages" style="color:red;"></span>
            <input type="password" name="cpassword" id="passwords">

            <input type="submit" name="submit" value="register now" class="form-btn">
            <a href="login_page.php"></a>
            <p>already have an account? <a href="login_page.php">login here</a></p>
        </form>
    </div>

    <script>
        function myfun() {
            var mobile = document.getElementById("phonenumber").value;
            if (mobile == "") {
                document.getElementById("message").innerHTML = "*please fill the number";
                return false;
            }
            if (isNaN(mobile)) {
                document.getElementById("message").innerHTML = "** Only Number are allowed";
                return false;

            }
            if (mobile.length < 10) {
                document.getElementById("message").innerHTML = "** mobile Number must be 10 digit allowed";
                return false;
            }
            if (mobile.length > 10) {
                document.getElementById("message").innerHTML = "** mobile Number must be 10 digit allowed";
                return false;
            }
            if (mobile.charAt(0) != '9') {
                document.getElementById("message").innerHTML = "** mobile Number must be start with 9";
                return false;
            }
            var password = document.getElementById("password").value;

            if (password == "") {
                document.getElementById("messages").innerHTML = "* please fill the password";
                return false;
            }

            if (password.length < 5) {
                document.getElementById("messages").innerHTML = "** password must be greater than 5 characters";
                return false;
            }

            if (password.length > 10) {
                document.getElementById("messages").innerHTML = "** password must be less than 10 characters";
                return false;
            }

            var uppercaseRegex = /[A-Z]/;
            if (!uppercaseRegex.test(password)) {
                document.getElementById("messages").innerHTML = "** password must include at least one capital letter";
                return false;
            }

            var lowercaseRegex = /[a-z]/;
            if (!lowercaseRegex.test(password)) {
                document.getElementById("messages").innerHTML = "** password must include at least one lowercase letter";
                return false;
            }

            var numberRegex = /[0-9]/;
            if (!numberRegex.test(password)) {
                document.getElementById("messages").innerHTML = "** password must include at least one number";
                return false;
            }

            var specialCharRegex = /[!@#$%^&*]/;
            if (!specialCharRegex.test(password)) {
                document.getElementById("messages").innerHTML = "** password must include at least one special character (!, @, #, $, %, ^, &, *)";
                return false;
            }

            // The password is valid
            return true;

            var cpassword = document.getElementById("passwords").value;
            if (password != cpassword) {
                document.getElementById("messages").innerHTML = "** passwrod and confirm password not match";
                return false;
            }
        }
    </script>
</body>

</html>