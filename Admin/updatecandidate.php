<?php
session_start();
@include 'inc/connection.php';

// Check if the 'id' parameter is set
$id = $_GET['edit'];

if (isset($_POST['add_candidate'])) {
  $candidate_name = $_POST['candidate_name'];
  $candidate_address = $_POST['candidate_address'];
  $candidate_email = $_POST['candidate_email'];
  $candidate_photo = $_FILES['candidate_photo']['name'];
  $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
  $candidate_image_folder = 'upload_image/' . $candidate_photo;
  $candidate_bio = $_POST['candidate_bio'];
  $inserted_by = $_SESSION['admin'];
  $inserted_on = date("Y-m-d");

  // Update the candidate details
  $update_query = "UPDATE candidate_details SET candidate_name = '$candidate_name', address = '$candidate_address', email = '$candidate_email', candidate_photo = '$candidate_photo', Bio = '$candidate_bio', inserted_by = '$inserted_by', inserted_on = '$inserted_on' WHERE id = '$id'";

  if (mysqli_query($conn, $update_query)) {
    // Candidate details updated successfully
    header('location:addcandidate.php');
    echo "Candidate details updated successfully.";
  } else {
    // Error updating candidate details
    echo "Error updating candidate details: " . mysqli_error($conn);
  }
}

// Display the details of the candidate
$display = mysqli_query($conn, "SELECT * FROM candidate_details WHERE id='$id'");
$Data = mysqli_fetch_array($display);
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
      <div class="form-container">
        <div class="admin-product-form-container">
          <form action="Updatecandidate.php?edit=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <h3>Update Candidate</h3>
            <label for="">Choose Election Topic</label>
            <select class="box" name="election_id" required>
              <option value="">Select Election Topic</option>
              <?php
              $selectElection = mysqli_query($conn, "SELECT * FROM elections");
              $isAnyElectionAdded = mysqli_num_rows($selectElection);
              if ($isAnyElectionAdded > 0) {
                while ($row = mysqli_fetch_assoc($selectElection)) {
                  $election_id = $row['election_id'];
                  $election_name = $row['election_topic'];
                  ?>
                  <option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>
                  <?php
                }
              } else {
                ?>
              <option value="">Please add an election first</option>
              <?php
              }
              ?>
            </select>
            <label for="">Fullname</label>
            <input type="text" name="candidate_name" class="box" value="<?php echo $Data['candidate_name']; ?>">
            <label for="">Address</label>
            <input type="text" name="candidate_address" class="box" value="<?php echo $Data['address']; ?>">
            <Label>Email</Label>
            <input type="email" name="candidate_email" class="box" value="<?php echo $Data['email']; ?>">

            <label for="">Upload Image</label>
            <input type="file" accept="image/jpg, image/png, image/jpeg" placeholder="Upload the image"
              name="candidate_photo" class="box">
            <input type="hidden" name="old_image" value="<?php echo $Data['candidate_photo']; ?>">

            <label>Short BIO</label>
            <textarea name="candidate_bio" class="box" cols="0" rows="0"><?php echo $Data['Bio']; ?></textarea>
            <input type="submit" class="btn" name="add_candidate" value="Update Candidate">
          </form>
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