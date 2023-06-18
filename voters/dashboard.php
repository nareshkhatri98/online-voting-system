<?php
include"../Admin/inc/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Custom CSS -->

  <link rel="stylesheet" href="../cssfolder/dashboard.css">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body>
  <div class="grid-container">
    <!-- Header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>

      <?php
      $sel = " SELECT * FROM users WHERE  user_role = 'User'";
      $query = mysqli_query($conn, $sel);
      $result= mysqli_fetch_assoc($query);

       ?>
      <div class="class-right">
        
          <h1>Welcome- <smaLL> <?php echo $result['fullname']; ?></smaLL></h1>
      
      </div>
    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <span class="material-icons-outlined"><a href="dashboard.html">how_to_vote</a></span> Go Vote
        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <span class="material-icons-outlined">home</span> Home
        </li>
        <li class="sidebar-list-item">
         <a href="votenow.php" > <span class="material-icons-outlined">event</span> election Avaliable
        </a>
        </li>
        
        <li class="sidebar-list-item">
          <a href="logut.php">
            <span class="material-icons-outlined">account_circle</span>
          </a>
          Logout
        </li>
      </ul>
    </aside>
    <!-- End Sidebar -->

 <div>
    
 </div>

    <!-- End Main -->

    <!-- Custom JS -->
    <script src="../assets/js/dashobrd.js"></script>
    <script src="../assets/js/first.js"></script>
    <script src="../assets/js/drop_down.js"></script>
    <script src = "abcd.js"></script>
  </div>
</body>
</html>
