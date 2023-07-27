<?php
@include 'inc/connection.php';

$id = $_GET['edit'];
$message = array();
function getElectionStatus($starting_date, $ending_date)
{
    $current_date = new DateTime();
    $start_date = new DateTime($starting_date);
    $end_date = new DateTime($ending_date);

    // We need to add 1 day to the end date to include the entire ending date in the comparison
    $end_date->add(new DateInterval('P1D'));

    if ($start_date <= $current_date && $end_date > $current_date) {
        return "Active";
    } elseif ($end_date < $current_date) {
        return "Expired";
    } else {
        return "Inactive";
    }
}

if (isset($_POST['update_product'])) {
  $election_topic = mysqli_real_escape_string($conn, $_POST['election_topic']);
  $number_of_candidates = mysqli_real_escape_string($conn, $_POST['number_of_candidates']);
  $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
  $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);
  $date1 = date_create($starting_date);
  $date2 = date_create($ending_date);
  $diff = date_diff($date1, $date2);

  // Compare the starting date with the current date
  $status = getElectionStatus($starting_date, $ending_date);

  if (empty($election_topic) || empty($number_of_candidates) || empty($starting_date) || empty($ending_date)) {
    $message[] = 'Please fill out all fields.';
  } else {
    $update_data = "UPDATE elections SET election_topic='$election_topic', no_of_candidates='$number_of_candidates', starting_date='$starting_date', ending_date='$ending_date', status='$status' WHERE election_id='$id'";
    $upload = mysqli_query($conn, $update_data);

    if ($upload) {
      header('location:addelection.php');
      exit();
    } else {
      $message[] = 'Error updating data. Please try again.';
    }
  }
}

$select = mysqli_query($conn, "SELECT * FROM elections WHERE election_id='$id'");
$row = mysqli_fetch_assoc($select);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title>dashboard</title> -->
  <!-- custome css -->
  <link rel="stylesheet" href="../dashboard/dashboard.css">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <link rel="stylesheet" href="../cssfolder/election.css">
</head>

<body>
  <div class="grid-container">

    <!-- header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>
      <div class="class-left">
        <span class="material-icons-outlined">search</span>
      </div>
    </header>
    <!-- end header -->

    <!-- slidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <a href="dashboard.php"><span class="material-icons-outlined" style="color:#b0b2bd;">how_to_vote</span></a>
          Go Vote
        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <span class="material-icons-outlined">dashboard</span> Dashboard
        </li>

        <li class="sidebar-list-item">
          <a href="addelection.php"><span class="material-icons-outlined">event_available</span> Election
          </a>
        </li>

        <li class="sidebar-list-item">
          <a href="dashboard.php"><span class="material-icons-outlined">groups</span> Candidates</a>
        </li>
        <li class="sidebar-list-item">
          <a href="votersdetails.php"><span class="material-icons-outlined">groups</span> Voterlist</a>
        </li>
        <li class="sidebar-list-item">
          <span class="material-icons-outlined">visibility</span> View Result
        </li>
        <li class="sidebar-list-item">
          <a href="notify.php"><span class="material-icons-outlined">settings</span> Setting</a>
        </li>
      </ul>
    </aside>
    <!-- Endsidebar -->


    <main class="main-container">
      <div class="form-container" >
        <div class="admin-product-form-container"">

          <div class="container" style="marigin-top:100%;>
            <div class="admin-product-form-container centered">
              <form action="" method="post" enctype="multipart/form-data">
                <h3 class="title">Update election</h3>
                <label for="">Election Topic</label>
                <input type="text" placeholder="Enter election topic" name="election_topic" class="box"
                  value="<?php echo $row['election_topic']; ?>">

                <label for="">Number of Candidates</label>
                <input type="number" placeholder="Number of candidates" name="number_of_candidates" class="box"
                  value="<?php echo $row['no_of_candidates']; ?>">

                <label for="">Starting Date</label>
                <input type="date" placeholder="Starting date" name="starting_date" class="box"
                  value="<?php echo $row['starting_date']; ?>">

                <label for="">Ending Date</label>
                <input type="date" placeholder="Ending date" name="ending_date" class="box"
                  value="<?php echo $row['ending_date']; ?>">

                <label for="">Status</label>
                <input type="text" placeholder="Status" name="status" class="box" value="<?php echo $row['status']; ?>">

                <input type="submit" value="Update election" name="update_product" class="btn">
               
              </form>
            </div>
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
</body>

</html>