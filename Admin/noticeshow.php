<?php
include_once('inc/connection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
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
    <a href="../hompage/optionalhome.html" class="company-logo">
      <h1>Govote</h1>
    </a>
    <div class="nav-links">
     <ul class="flex">
      <li><a href="../hompage/optionalhome.html" class="hover-links">Home</a></li>
      <li><a href="" class="hover-links">Candidates</a></li>
      <li><a href="noticeshow.php" class="hover-links">Notice</a></li>
      <li><a href="../hompage/login_page.php" class="hover-links secondary-btn">Login</a></li>
      <li><a href="../hompage/Register-page.php" class="hover-links primary-btn">Register</a></li>
     </ul>
    </div>
  </div>
</nav>
<!-- header section -->
<header>
 <div class="container header-section flex">
  <div class="header-left">
    

<div class="main">
  <?php
  $sql = "SELECT * FROM notice";
  $details = $conn->query($sql);
  if(mysqli_num_rows($details) > 0) {
    while ($row = mysqli_fetch_assoc($details)) {
      ?>
    
      <p style="margin-top:100px">
        
        <?php echo $row['content'] ; }?>
        </p>
        </div>
  
    <?php
}?>
</div>
  
 </div>
</header>



</body>
</html>
 
  













