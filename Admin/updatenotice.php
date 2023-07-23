<?php
include "inc/connection.php";
session_start();
$id = $_GET['edit'];
if (!isset($_SESSION['admin'])) {
  header('location:../hompage/login_page.php');
}
?>
<!-- # for data collection -->
<?php
if (isset($_POST['update_notice'])) {
  $title = $_POST['Title'];
  $content = $_POST['content'];
  $admin = $_SESSION['admin'];

  if (empty($title) || empty($content)) {
    echo '<div class="danger" id="danger">Fields cannot be empty!</div>';
  } else {
    $update = "UPDATE notice SET Title ='$title', content ='$content', inserted_by ='$admin' where Notice_id = '$id'";
    $result = $conn->query($update);
    if ($result) {
      header('location: notify.php');
    }
  }
}
?>
<?php
//to diapya the content of notice....
 
 $dispay = mysqli_query($conn, "SELECT *FROM notice where Notice_id='$id'");
 $row =mysqli_fetch_assoc($dispay); 
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>dashboard</title>
  <!-- custom css -->
  <link rel="stylesheet" href="../cssfolder/dashboard.css">
  <link rel="stylesheet" href="../cssfolder/notice.css">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body>
  <div class="grid-container">
    <!-- header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>
      <div class="class-left">
        <h3>Welcome- <small>
            <?php echo $_SESSION['admin']; ?>
          </small></h3>
      </div>

    </header>
    <!-- end header -->

    <!-- sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <a href="dashboard.php">
            <span class="material-icons-outlined">how_to_vote</span> </a>Go Vote


        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined">dashboard</span> Dashboard</a>
        </li>
        <li class="sidebar-list-item">
          <a href="addelection.php">
            <span class="material-icons-outlined">event_available</span> Elections
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="addcandidate.php">
            <span class="material-icons-outlined">groups</span> Candidates
          </a>
        </li>
        <li class="sidebar-list-item"><a href="votersdetails.php"><span class="material-icons-outlined"> groups</span>
            Voterlist</a></li>
        <li class="sidebar-list-item">
          <a href="viewresult.php">
            <span class="material-icons-outlined">visibility</span> View Result
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="notify.php">
            <span class="material-icons-outlined">settings</span> Notify
          </a>
        </li>
      </ul>
    </aside>
    <!-- end sidebar -->


    <!-- main -->
    <main class="main-container">


      <div class="form-container">

        <div class="admin-product-form-container">

          <form method="post" enctype="multipart/form-data">

            <h3>Notice Form</h3>
            <label for="">Title</label>
            <input type="text" name="Title" class="box" value="<?php echo $row['Title'];?>">
            <label for="">Content</label>
            <textarea name="content"" id="" cols="30" rows="10" ><?php echo $row['content']; ?></textarea>
            <input type="submit" class="box-btn" style="padding:20px; width:100%; height:50%; font-size:1rem"name="update_notice" value="update notice">
          </form>
          <!-- end main -->
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

</html>