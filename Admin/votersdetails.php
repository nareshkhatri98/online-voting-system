<?php
include "inc/connection.php";
$election_id = 1;
// Retrieve the admin user data
$sel = "SELECT * FROM users WHERE user_role = 'admin'";
$query = mysqli_query($conn, $sel);
$result = mysqli_fetch_assoc($query);

// Retrieve the active elections
$fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE status = 'active'") or die(mysqli_error($conn));
$totalActiveElections = mysqli_num_rows($fetchingActiveElections);
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
  <link rel="stylesheet" href="../cssfolder/voter.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body>
  <div class="grid-container">
    <!-- Header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>
      <div class="class-left">
        <h3>Welcome- <small>
            <?php echo $result['fullname']; ?>
          </small></h3>
      </div>
      
    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <a href="dashboard.php">
            <span class="material-icons-outlined">how_to_vote</a></span>Go Vote

        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined">dashboard</span> Dashboard
          </a>
        </li>
        <li class="sidebar-list-item">
        <a href="addelection.php">
          <span class="material-icons-outlined">event_available</span>Elections
          </a></li>
        <li class="sidebar-list-item"><a href="addcandidate.php">
          <span class="material-icons-outlined">groups</span> Candidates
        </a></li>
        <li class="sidebar-list-item"><a href="votersdetails.php"><span class="material-icons-outlined"> groups</span>
            Voterlist</a></li>
        <li class="sidebar-list-item">
          <a href="viewresult.php">
          <span class="material-icons-outlined">visibility</span> View Result
          </a></li>
        <li class="sidebar-list-item">
          <a href="notify.php"><span class="material-icons-outlined">settings</span></a> Notify
        </li>
      </ul>
    </aside>
    <!-- End Sidebar -->

    <section class="voting">
      <div class="candidate_list">
        <h3 style="text-align: center;">Voter Details</h3>


        <?php
        $fetchingVoteDetails = mysqli_query($conn, "SELECT * FROM votings WHERE election_id = '" . $election_id . "'");
        $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

        if ($number_of_votes > 0) {
          $sno = 1;
          ?>
          <table class="table">
            <thead>
              <tr>
                <th styke'>S.No</th>
                <th>Voter Name</th>
                <th>Contact No</th>
                <th>Voted To</th>
                <th>Date </th>
                <th>Time</th>
              </tr>
            </thead>
            <?php
            while ($data = mysqli_fetch_assoc($fetchingVoteDetails)) {
              $voters_id = $data['voters_id'];
              $candidate_id = $data['candidate_id'];
              $fetchingUsername = mysqli_query($conn, "SELECT * FROM users WHERE id = '" . $voters_id . "'") or die(mysqli_error($conn));
              $isDataAvailable = mysqli_num_rows($fetchingUsername);
              $userData = mysqli_fetch_assoc($fetchingUsername);
              if ($isDataAvailable > 0) {
                $username = $userData['fullname'];
                $contact_no = $userData['phone'];
              } else {
                $username = "No_Data";
                $contact_no = $userData['contact_no'];
              }


              $fetchingCandidateName = mysqli_query($conn, "SELECT * FROM candidate_details WHERE id = '" . $candidate_id . "'") or die(mysqli_error($conn));
              $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
              $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
              if ($isDataAvailable > 0) {
                $candidate_name = $candidateData['candidate_name'];
              } else {
                $candidate_name = "No_Data";
              }
              ?>
              <tr>
                <td>
                  <?php echo $sno++; ?>
                </td>
                <td>
                  <?php echo $username; ?>
                </td>
                <td>
                  <?php echo $contact_no; ?>
                </td>
                <td>
                  <?php echo $candidate_name; ?>
                </td>
                <td>
                  <?php echo $data['vote_date']; ?>
                </td>
                <td>
                  <?php echo $data['vote_time']; ?>
                </td>
              </tr>
              <?php
            }
            echo "</table>";
        } else {
          echo "No any vote detail is available!";
        }







        ?>
        </table>
      </div>
    </section>

    <!-- Rest of your HTML code -->

    <!-- Custom JS -->
    <script src="../assets/js/dashobrd.js"></script>
    <script src="../assets/js/first.js"></script>
    <script src="../assets/js/drop_down.js"></script>
  </div>
</body>

</html>