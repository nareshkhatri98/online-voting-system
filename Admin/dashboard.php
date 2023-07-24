<?php
include "inc/connection.php";
session_start();
if (!isset($_SESSION['admin'])) {
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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
  <div class="grid-container">

    <!-- header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>
      <div class="class-left">
        <h3>Welcome- <smaLL>
            <?php echo $_SESSION['admin'] ?>
          </smaLL></h3>

      </div>
      <div class="class-right">
        <span class="material-icons-outlined"><a href="logout.php" onclick="logout(event`)">account_circle </a></span>

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
          <span class="material-icons-outlined">dashboard</span> Dashboard
        </li>

        <li class="sidebar-list-item">
          <span class="material-icons-outlined"> <a href="addelection.php">event_available</span>
          Elections</a>
        </li>

        <li class="sidebar-list-item"><span class="material-icons-outlined"> <a href="addcandidate.php">groups</span>
          Candidates</li></a>
        <li class="sidebar-list-item"><span class="material-icons-outlined"> <a href="votersdetails.php">groups</span>
          Voterlist</li></a>
        <li class="sidebar-list-item"> <a href="viewresult.php">
            <span class="material-icons-outlined">visibility</span> View Result</a></li>

        <li class="sidebar-list-item"><a href="notify.php"> <span class="material-icons-outlined">settings </span>
            Notify</a></li>
      </ul>
    </aside>
    <!-- Endsidebar -->

    <!-- main -->
    <?php
    $sql = "SELECT COUNT(*) AS total_users FROM users  WHERE user_role='User'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $totalUsers = $row["total_users"];
    } else {
      $totalUsers = 0;
    }
    ?>
    <main class="main-container">
      <div class="main-title">
        <p class="font-weight-bold" style="margin-left: 155px;">DASHBOARD</p>
      </div>

      <div class="main-cards" style="margin-left: 130px;">

        <div class="card">
          <div class="card-inner">
            <p class="text-primary font-weight-bold">Total users</p>
            <span class="material-icons-outlined text-blue">groups</span>
          </div>
          <span class="text-primary font-weight-bold">
            <?php echo $totalUsers; ?>
          </span>
        </div>

      </div>

    </main>

    <!-- end main -->
  </div>
  </div>












  <!-- custom js -->
  <script src="../assets/js/dashobrd.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
  <script>

    function logout(ev) {
      ev.preventDefault();

      var urlToRedirect = ev.currentTarget.getAttribute('href');
      swal({
        title: "Are you sure to logout?",
        text: "You won't be able to revert this delete",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willCancel) => {
        if (willCancel) {
          window.location.href = urlToRedirect;
        }
      });
    }
  </script>

</body>
</body>

</html>



<!-- <div class="userlist"> -->