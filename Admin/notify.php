<?php
include "inc/connection.php";
session_start();
if (!isset($_SESSION['admin'])) {
  header('location:../hompage/login_page.php');
}

function isValidTitle($title) {
  // Regular expression to check if the title contains only characters (A-Z, a-z) and spaces
  return preg_match('/^[A-Za-z ]+$/', $title);
}

// For data collection
if (isset($_POST['submit'])) {
  $title = $_POST['Title'];
  $content = $_POST['content'];
  $admin = $_SESSION['admin'];

  if (empty($title) || empty($content)) {
    $_SESSION['error-message'] = "Please fill all the fields.";
  } elseif (!isValidTitle($title)) {
    $_SESSION['error-message'] = "Title should only contain characters  and spaces.";
  } else {
    // Use prepared statement to safely insert data
    $sql = "INSERT INTO notice (Title, content, inserted_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $admin);
    if ($stmt->execute()) {
      $_SESSION['success-message'] = "Notice is added successfully.";
    } else {
      $_SESSION['error-message'] = "Something went wrong while adding the notice.";
    }
    header('location: notify.php');
    exit; // Add exit after header to stop executing the rest of the code.
  }
}
?>

<?php
// Delete Query
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM notice WHERE Notice_id = $id");
  $_SESSION['success-message'] = "Notice is deleted successfully.";
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        <li class="sidebar-list-item"><a href="votersdetails.php"><span class="material-icons-outlined">groups</span>
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
      ?>
          <form method="post" enctype="multipart/form-data" onsubmit="return myfun()">
            <h3>Notice Form</h3>
            <label for="" id="title">Title</label>
            <input type="text" name="Title" class="box"><span id="message" style="color:red;"></span>
            <label for="">Content</label>
            <textarea name="content" id="" cols="30" rows="10"></textarea>
            <button type="submit" class="submit-box" name="submit" value="submit">Submit</button>
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
              <tbody>
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
                      <a href="updatenotice.php?edit=<?php echo $noticeData['Notice_id']; ?>" class="box-btn">Edit</a>
                      <a href="notify.php?delete=<?php echo $noticeData['Notice_id']; ?>" class="box-btn"
                        onclick="conformation(event)">Delete</a>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
    <!-- end main -->
  </div>

  <!-- custom js -->
  <script src="../assets/js/dashobrd.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
  <!-- conform delete -->
  <script>
    function conformation(ev) {
      ev.preventDefault();

      var urlToRedirect = ev.currentTarget.getAttribute('href');
      swal({
        title: "Are you sure to delete this?",
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

</html>