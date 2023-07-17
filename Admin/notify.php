<?php
include "inc/connection.php";
session_start();
if (!isset($_SESSION['admin'])) {
  header('location:../hompage/login_page.php');
}
?>
<!-- # for data collection -->
<?php
if (isset($_POST['submit'])) {
  $title = $_POST['Title'];
  $content = $_POST['content'];
  $admin = $_SESSION['admin'];

  if (empty($title) || empty($content)) {
    echo '<div class="danger" id="danger">Fields cannot be empty!</div>';
  } else {
    $sql = "INSERT INTO notice (Title, content, inserted_by) VALUES ('$title', '$content', '$admin')";
    $result = $conn->query($sql);
    if ($result) {
      header('location: notify.php');
    }
  }
}
?>
    <?php
    //delte Query
    if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM notice WHERE Notice_id  = $id");
   header('location:notify.php');
}

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
            <input type="text" name="Title" class="box">
            <label for="">Content</label>
            <textarea name="content" id="" cols="30" rows="10"></textarea>
            <button type="submit" class="submit-box" name="submit" value="submit"> Submit</button>
          </form>

          <div class="product-display">
            <table class="product-display-table">
              <thead>
                <tr>
                  <th>S.N</th>
                  <th>Title</th>
                  <th>Content</th>
                  <th>Action</th>
                </tr>
              </thead>

          </div>

        </div>
    </main>
    <!-- end main -->
    <?php
    $noticeQuery = mysqli_query($conn, "SELECT * FROM notice") or die(mysqli_error($conn));
    $sn = 1;
    while ($noticeData = mysqli_fetch_assoc($noticeQuery)) {
      ?>
      <tr>
        <td>
          <?php echo $sn++; ?>
        </td>
        <td>
          <?php echo $noticeData['Title']; ?>
        </td>
        <td>
          <?php echo $noticeData['content']; ?>
        </td>

        <td>
          <a href="updatenotice.php?edit=<?php echo $noticeData['Notice_id']; ?>" class="box-btn">edit </a>
          <a href="notify.php?delete=<?php echo $noticeData['Notice_id']; ?>" class="box-btn"> delete </a>
        </td>
        </td>
      </tr>
      <?php
    }
    ?>
    </tbody>
    </table>
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