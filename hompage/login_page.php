<?php
include "../Admin/inc/connection.php";
$error = array();
session_start();
// ... (existing code)

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
      <li><a href="optionalhome.php" class="hover-links">Home</a></li>
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
      <input type="text" name="phone" pattern="[0-9]{10}$" id="phone">
      
     <label for="">Password</label>
      <input type="password" name="password" id="password">
      <input type="submit" name="submit" value="login now" class="form-btn" id="log-btn">
      <p>don't have an account? <a href="Register-page.php">register here</a></p>
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

</body>
</html>
