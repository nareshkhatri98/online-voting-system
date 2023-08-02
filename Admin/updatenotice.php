// PHP code for updating the notice
<?php
include "inc/connection.php";
session_start();
$id = $_GET['edit'];
if (!isset($_SESSION['admin'])) {
  header('location:../hompage/login_page.php');
}




function isValidTitle($title) {
  // Regular expression to check if the title contains only characters (A-Z, a-z) and spaces
  return preg_match('/^[A-Za-z ]+$/', $title);
}

if (isset($_POST['update_notice'])) {
  $title = $_POST['Title'];
  $content = $_POST['content'];
  $admin = $_SESSION['admin'];

  if (empty($title) || empty($content)) {
    $_SESSION['error-message'] = "Fields cannot be empty!";
  } elseif (!isValidTitle($title)) {
    $_SESSION['error-message'] = "Title should only contain characters (A-Z, a-z) and spaces.";
  } else {
    // Use prepared statement
    // update cQuery..
    $update_query = "UPDATE notice SET Title = ?, content = ?, inserted_by = ? WHERE Notice_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $title, $content, $admin, $id);
    
    if ($stmt->execute()) {
      $_SESSION['success-message'] = "Notice is updated successfully.";
      header('location: notify.php');
      exit();
    } else {
      $_SESSION['error-message'] = "Something went wrong while updating the notice.";
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
<style>
  .success-message {
      color: green;
      background-color: #E8FFCE;
      padding: 10px;
      border-radius: 10px;
      border-bottom: 20px;
      text-align: center;
    }
    .error-message{
      color: green;
      background-color: #E8FFCE;
      padding: 10px;
      border-radius: 10px;
      border-bottom: 20px;
      text-align: center;
    }
</style>
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
          
        <?php
          if (isset($_SESSION['success-message'])) {
            echo '<div class="success-message">' . $_SESSION['success-message'] . '</div>';
            unset($_SESSION['success-message']);
          }
          if (isset($_SESSION['error-message'])) {
            echo '<div class="error-message">' . $_SESSION['error-message'] . '</div>';
            unset($_SESSION['error-message']);
          }
          ?>          <form method="post" enctype="multipart/form-data">

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