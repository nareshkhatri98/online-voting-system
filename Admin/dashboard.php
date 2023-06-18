<?php
  include"inc/connection.php";
session_start();
if(!isset($_SESSION['admin']))
{
  header('location:../hompage/login_page.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>dashboard</title>
  <!-- custome css -->
  <link rel="stylesheet" href="../cssfolder/dashboard.css">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
  rel="stylesheet">

<body>
<div class="grid-container">

  <!-- header -->
  <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
      <span class="material-icons-outlined">menu</span>
    </div>
    <div class="class-left">
    <h3>Welcome- <smaLL> <?php echo $_SESSION['admin'] ?></smaLL></h3>
      
    </div>
    <div class="class-right">
      <span class="material-icons-outlined" ><a href="logout.php">account_circle </a></span>
      
    </div>
  </header>
  <!-- end header -->

  <!-- slidebar -->
   <aside id="sidebar">
   <div class="sidebar-title">
    <div class="sidebar-brand">
    <a href="dashboard.php">
      <span class="material-icons-outlined">how_to_vote</span></a> Go Vote
    </div>
    <span class="material-icons-outlined" onclick="closeSidebar()">close </span>
   </div>

   <ul class="sidebar-list">
        <li class="sidebar-list-item">
        <span class="material-icons-outlined">dashboard</span> Dashboard</li>

      <li class="sidebar-list-item">
       <span class="material-icons-outlined"> <a href="addelection.php">event_available</span>
        Elections</a>
      </li>
      
     <li class="sidebar-list-item"><span class="material-icons-outlined"> <a href="addcandidate.php">groups</span> Candidates</li></a>
     <li class="sidebar-list-item"> <a href="viewresult.php">
      <span class="material-icons-outlined">visibility</span> View Result</a></li>
    <li class="sidebar-list-item"><a href="notify.php"> <span class="material-icons-outlined">settings </span> Notify</a></li>
   </ul>
  </aside>
  <!-- Endsidebar -->

  <!-- main -->
 
    
  <!-- end main -->
</div>















<!-- custom js -->
  <script src="../assets/js/dashobrd.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
</body>
</body>
</html>