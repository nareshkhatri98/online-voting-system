<?php
  include"inc/connection.php";
 $sel = " SELECT * FROM users WHERE user_role = 'admin'";
 $query = mysqli_query($conn, $sel);
 $result= mysqli_fetch_assoc($query);


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
    <h3>Welcome- <smaLL> <?php echo $result['fullname']; ?></smaLL></h3>
      
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
      <span class="material-icons-outlined"><a href="dashboard.html">how_to_vote</span></a> Go Vote
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
     <li class="sidebar-list-item"><span class="material-icons-outlined">visibility</span> View Result</li>
    <li class="sidebar-list-item"> <span class="material-icons-outlined">settings </span> Setting</li>
   </ul>
  </aside>
  <!-- Endsidebar -->

  <!-- main -->
  <main class="main-container">
    <div class="main-title">
      <p class="font-weight-bold">DASHBOARD</p>
    </div>

    <div class="main-cards">

      <div class="card">
        <div class="card-inner"> 
         <p class="text-primary">Add Election </p>
         <a href="addelection.php"><span class="material-icons-outlined text-blue"> event_available</span></a>
        </div>
        <span class="text-primary font-weight-bold"></span>
      </div>

       <div class="card">
        <div class="card-inner"> 
         <p class="text-primary">candidates</p>
        <a href="addcandidate.php"><span class="material-icons-outlined text-blue"> groups</span></a> 
        </div>  
        <span class="text-primary font-weight-bold"></span>
       </div>
       

      <div class="card">
        <div class="card-inner"> 
         <p class="text-primary">View Result</p>
         <span class="material-icons-outlined text-orange"> visibility</span>
        </div>
        <span class="text-primary font-weight-bold">On going</span>
      </div>
    </div>  
  </main>
  <!-- end main -->
</div>















<!-- custom js -->
  <script src="../assets/js/dashobrd.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
</body>
</body>
</html>