<?php
include "../Admin/inc/connection.php";
session_start();
if (!isset($_SESSION['User'])) {
  header('location:../hompage/login_page.php');
}
//user details..
$select = "SELECT fullname, phone FROM users WHERE id = " . $_SESSION['id']; // 'id' is the column name in users table
$result = mysqli_query($conn, $select);
if ($result) {
  $row = mysqli_fetch_assoc($result);
  $fullname = $row['fullname'];
  $phone = $row['phone'];
}
?>


<?php
// election avaliable....
$election = "SELECT COUNT(*) AS total_election From elections WHERE status ='active'";
$counteElection = mysqli_query($conn, $election);
if ($counteElection) {
  $Data = mysqli_fetch_assoc($counteElection);
  $Totalelection = $Data['total_election'];
} else {
  echo "No election avaliable.";
}
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
  <div class="grid-container">
    <!-- Header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>


      <div class="class-right">

        <h1>Welcome- <smaLL>
            <?php echo $_SESSION['User'] ?>
          </smaLL></h1>

      </div>
      <div class="class-left">

    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <span class="material-icons-outlined"><a href="dashboard.php">how_to_vote</a></span> Go Vote
        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined">home</span> Home
        </li></a>
        <li class="sidebar-list-item">
          <a href="votenow.php"> <span class="material-icons-outlined">event</span> election Avaliable
          </a>
        </li>

        <li class="sidebar-list-item">
          <a href="logut.php" onclick="logout(event)">
            <span class="material-icons-outlined">account_circle</span>
            Logout
          </a>
        </li>
      </ul>
    </aside>
    <!-- End Sidebar -->
    <main class="main-container">


      <div class="main-cards" style="margin-left: 130px;">

        <div class="card">
          <div class="card-inner">
            <h2 class="text-primary font-weight-bold">Your details</h2>
            <span class="material-icons-outlined text-blue">groups</span>
          </div>
          <span class="text-primary font-weight-bold">
            Fullanme:
            <?php echo $fullname; ?>
          </span>
          <span class="text-primary font-weight-bold" style="margin-top: 12px;">phone:
            <?php echo $phone; ?>
          </span>
        </div>

        <div class="card">
          <div class="card-inner">
            <h2 class="text-primary font-weight-bold">Elections</h2>
            <span class="material-icons-outlined text-blue">event</span>
          </div>
          <span class="text-primary font-weight-bold">
            Avaliable election:
            <?php echo $Totalelection; ?>
          </span>

        </div>
      </div>

    </main>



    <!-- End Main -->

    <!-- Custom JS -->
    <script src="../assets/js/dashobrd.js"></script>
    <script src="../assets/js/first.js"></script>
    <script src="../assets/js/drop_down.js"></script>
    <script src="abcd.js"></script>

    <script>

    function logout(ev) {
    ev.preventDefault();

    var urlToRedirect = ev.currentTarget.getAttribute('href');
    swal({
      position: 'top',
      title: "Are you sure to logout?",
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
  </div>
</body>

</html>