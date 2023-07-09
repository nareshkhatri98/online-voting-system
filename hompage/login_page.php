<?php
include "../Admin/inc/connection.php";
$error = array();
session_start();

if (isset($_POST['submit'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = md5($_POST['password']);

    // Select Query  
    $select = "SELECT * FROM users WHERE phone = '$phone' && password = '$password' ";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_role'] == 'admin') {
            $_SESSION['admin'] = $row['fullname'];
            $_SESSION['id'] = $row['id']; 
           
            $error[] = "login successful";
            header("location: ../Admin/dashboard.php");
            exit();
        } elseif ($row['user_role'] == 'User') {
            $_SESSION['User'] = $row['fullname'];
            $_SESSION['id'] = $row['id']; 
           
           
            header("location: ../voters/dashboard.php");
            exit();
        }
    } else {
        $error[] = "Invalid username and password";
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

    <div class="small-bold-text banner-text">Cast your vote from anywhere, anytime with our secure and convenient online voting system."</div>
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
      <li><a href="optionalhome.html" class="hover-links">Home</a></li>
      <li><a href="../Admin/candidate.php" class="hover-links">Candidates</a></li>
      <li><a href="../admin/noticeshow.php" class="hover-links">Notice</a></li>
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
   <form action="login_page.php" method="post" class="form-only" >
      <h3>login</h3>
      <?php
            if (!empty($error)) {
                echo '<span class="error-msg">' . implode("<br>", $error) . '</span>';
            }
      ?>
      <label for="">Phone</label>
      <input type="text" name="phone" pattern="[0-9]{10}$">
      
     <label for="">Password</label>
      <input type="password" name="password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="Register-page.php">register here</a></p>
   </form>
   </div>
  </div>
  
 </div>
</header>



</body>
</html>
