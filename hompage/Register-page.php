<?php
include "../Admin/inc/connection.php";

$error = array(); // Initialize the error array
$successMessage = ""; // Initialize the success message

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

  // Check if the password matches
  if ($password == $cpassword) {
    if (empty($error)) {
      // Insert the data into the database
      $insert = "INSERT INTO users(fullname, phone, password, user_role) VALUES('$name','$phone','$password','$user_role')";
      $result = mysqli_query($conn, $insert);
      if ($result) {
        // Registration successful
        $successMessage = "Registration successful";
        // Wait for 2 seconds before redirecting to the login page
        echo '<script>setTimeout(function(){ window.location.href = "login_page.php"; }, 2000);</script>';
      } else {
        $error[] = "Something went wrong with the database query: " . mysqli_error($conn);
        // You may also log or handle the error differently if needed
      }
    }
  } else {
    $error[] = "Passwords do not match";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
  <link rel="stylesheet" href="../cssfolder/style.css">
  <link rel="stylesheet" href="../cssfolder/optinola.css">
</head>

<body>
  <!-- Top banner -->
  <div class="top-banner">
    <div class="container">
      <div class="small-bold-text banner-text">"Cast your vote from anywhere, anytime with our secure and convenient online voting system."</div>
    </div>
  </div>
  <!-- Navbar -->
  <nav>
    <div class="container main-nav flex">
      <a href="optionalhome.html" class="company-logo">
        <h1>Govote</h1>
      </a>
      <div class="nav-links">
        <ul class="flex">
          <li><a href="optionalhome.php" class="hover-links">Home</a></li>
          <li><a href="../Admin/candidate.php" class="hover-links">Candidates</a></li>
          <li><a href="../Admin/noticeshow.php" class="hover-links">Notice</a></li>
          <li><a href="login_page.php" class="hover-links secondary-btn">Login</a></li>
          <li><a href="Register-page.php" class="hover-links primary-btn">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- header section -->
  <header>
    <div class="container header-section flex">
      <div class="header-left">
        <div class="form-container">
          <form action="Register-page.php" method="post" class="form-only" style=" margin-bottom: -10%; " onsubmit="return myfun()">
            <h3>Register</h3>
            <?php
            if (!empty($error)) {
              echo '<span class="error-msg" style="color:white;">' . implode("<br>", $error) . '</span>';
            } else if (!empty($successMessage)) {
              echo '<span class="success-msg" style="color:red;">' . $successMessage . '</span>';
            }
            ?>
            <label for="">Fullname</label>
            <input type="text" name="name" pattern="^[a-zA-Z]+ [a-zA-Z]+$" required placeholder="Enter your name">
            <label for="">Phone</label>
            <input type="text" name="phone" id="phonenumber"> <span id="message" style="color:red;"></span>

            <label for="">Password</label>
            <span id="password-message" style="color:red;"></span>
            <input type="password" name="password" id="password">

            <label for="">Confirm_Password</label>
            <span id="confirm-password-message" style="color:red;"></span>
            <input type="password" name="cpassword" id="passwords">

            <input type="submit" name="submit" value="Register now" class="form-btn">
            <p>Already have an account? <a href="login_page.php">Login here</a></p>
          </form>
        </div>
      </div>
    </div>
    <div class="custom-shape-divider-bottom-1688894802">
  <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
  </svg>
</div>
  </header>

  <script>
    function myfun() {
      var mobile = document.getElementById("phonenumber").value;
      if (mobile == "") {
        document.getElementById("message").innerHTML = "*Please fill in the number";
        return false;
      }
      if (isNaN(mobile)) {
        document.getElementById("message").innerHTML = "**Only numbers are allowed";
        return false;
      }
      if (mobile.length !== 10) {
        document.getElementById("message").innerHTML = "**Mobile number must be 10 digits";
        return false;
      }
      if (mobile.charAt(0) != '9') {
        document.getElementById("message").innerHTML = "**Mobile number must start with 9";
        return false;
      }

      var password = document.getElementById("password").value;
      if (password == "") {
        document.getElementById("password-message").innerHTML = "*Please fill in the password";
        return false;
      }
      if (password.length <= 5) {
        document.getElementById("password-message").innerHTML = "**Password must be at least 5 characters long";
        return false;
      }
      if (password.length > 10) {
        document.getElementById("password-message").innerHTML = "**Password must be less than 10 characters long";
        return false;
      }

      var uppercaseRegex = /[A-Z]/;
      if (!uppercaseRegex.test(password)) {
        document.getElementById("password-message").innerHTML = "**Password must include at least one capital letter";
        return false;
      }

      var lowercaseRegex = /[a-z]/;
      if (!lowercaseRegex.test(password)) {
        document.getElementById("password-message").innerHTML = "**Password must include at least one lowercase letter";
        return false;
      }

      var numberRegex = /[0-9]/;
      if (!numberRegex.test(password)) {
        document.getElementById("password-message").innerHTML = "**Password must include at least one number";
        return false;
      }

      var specialCharRegex = /[!@#$%^&*]/;
      if (!specialCharRegex.test(password)) {
        document.getElementById("password-message").innerHTML = "**Password must include at least one special character (!, @, #, $, %, ^, &, *)";
        return false;
      }

      var cpassword = document.getElementById("passwords").value;
      if (password != cpassword) {
        document.getElementById("confirm-password-message").innerHTML = "**Passwords do not match";
        return false;
      }

      // The form is valid
      return true;
    }
  </script>

</body>

</html>
