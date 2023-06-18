<?php
include"../Admin/inc/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Home</title>
  <link rel="stylesheet" href="../cssfolder/first.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link rel="stylesheet" href="../cssfolder/style.css">
</head>
<body>
  <section id="header">
    <h1 class="logo">Go Vote</h1>
    <div>
      <ul id="navbar">
        <li><a href="../hompage/home_page.html">Home</a></li>
        <li><a href="about.html">About us</a></li>
        <li><a href="" id="user-icon"><i class="fas fa-user"></i></a> </li>
      </ul>
   </div>
   </section>

      
<div class="form-container">
<form action="Register-page.php" method="post" class="form-only">
  <h3>register</h3>
 
  <input type="text" name="name" pattern="^[a-zA-Z]+ [a-zA-Z]+$" required placeholder="enter your name">
  <input type="tel" name="phone" pattern="^[0-9]{10}$" required placeholder="enter your phone">
  <input type="password" name="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" required placeholder="enter your password">
  <input type="password" name="cpassword" required placeholder="confirm your password">
     
  <input type="submit" name="submit" onclick="Register();" value="register now" class="form-btn">
<a href="login_page.php"></a>
  <p>already have an account? <a href="login_page.php">login here</a></p>
</form>

   
</div>
</body>
</html>
<?php
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_role = "User";

    if ($password == $cpassword) {
        $insert = "INSERT INTO users(fullname, phone, password, user_role) VALUES('$name','$phone','$password','$user_role')";
        mysqli_query($conn, $insert);
        if ($insert) {
            echo '
            <script>
                alert("Registration successful");
                window.location = "login_page.php";
            </script>
            ';
        } else {
            echo '
            <script>
                alert("Something went wrong");
                window.location = "Register-page.php";
            </script>
            ';
        }
    } else {
        echo '
        <script>
            alert("Password and confirm password do not match");
            window.location = "Register-page.php";
        </script>
        ';
    }
}
?>
