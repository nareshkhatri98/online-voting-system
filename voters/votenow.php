<?php
// connection.php
include "../Admin/inc/connection.php";
session_start();
if (!isset($_SESSION['User'])) {
  header('location:../hompage/login_page.php');
}

// Check and update the status of elections
$fetchingElections = mysqli_query($conn, "SELECT * FROM elections") or die(mysqli_error($conn));
while ($data = mysqli_fetch_assoc($fetchingElections)) {
  $stating_date = $data['starting_date'];
  $ending_date = $data['ending_date'];
  $curr_date = date("Y-m-d");
  $election_id = $data['election_id'];
  $status = $data['status'];

  // Active = Expire = Ending Date
  // InActive = Active = Starting Date

  if ($status == "Active") {
    $date1 = date_create($curr_date);
    $date2 = date_create($ending_date);
    $diff = date_diff($date1, $date2);

    if ((int) $diff->format("%R%a") < 0) {
      // Update!
      mysqli_query($conn, "UPDATE elections SET status = 'Expired' WHERE election_id = '" . $election_id . "'") or die(mysqli_error($conn));
    }
  } else if ($status == "InActive") {
    $date1 = date_create($curr_date);
    $date2 = date_create($stating_date);
    $diff = date_diff($date1, $date2);

    if ((int) $diff->format("%R%a") <= 0) {
      // Update!
      mysqli_query($conn, "UPDATE elections SET status = 'Active' WHERE election_id = '" . $election_id . "'") or die(mysqli_error($conn));
    }
  }
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
  <link rel="stylesheet" href="../cssfolder/voter.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <!-- SweetAlert Library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <style>
    .success-message {
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
    <!-- Header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>

      <div class="class-right">
        <h2>Welcome-
          <?php echo $_SESSION['User']; ?><smaLL></smaLL>
        </h2>
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
          <a href="dashboard.php">
            <span class="material-icons-outlined">home</span> Home
        </li>
        <li class="sidebar-list-item">
          <a href="dashboard.php">
            <span class="material-icons-outlined">event</span> Election Available
        </li>
        <li class="sidebar-list-item">
          <a href="logut.php">
            <span class="material-icons-outlined">account_circle</span>
          </a>
          Logout
        </li>
      </ul>
    </aside>
      <div class="candidate_list">
      <?php
      if (isset($_SESSION['success-message'])) {
        echo '<div class="success-message">' . $_SESSION['success-message'] . '</div>';
        unset($_SESSION['success-message']);
      }
      ?>
        <h3 style="text-align:center;">Candidates list</h3>
        <?php
        $election_id = null; // Declare $election_id variable
        
        $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE status = 'Active'") or die(mysqli_error($conn));
        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

        if ($totalActiveElections > 0) {
          while ($data = mysqli_fetch_assoc($fetchingActiveElections)) {
            $election_id = $data['election_id'];
            $election_topic = $data['election_topic'];
            ?>
            <table class="table">
              <thead>
                <tr>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Email</th>
                  <th>Details</th>
                  <th>Election topic</th>
                  <th># of Votes</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '" . $election_id . "'") or die(mysqli_error($conn));
                $isAnyCandidateAdded = mysqli_num_rows($fetchingCandidates);

                if ($isAnyCandidateAdded > 0) {
                  while ($row = mysqli_fetch_assoc($fetchingCandidates)) {
                    if (isset($row['id'])) {
                      $candidate_id = $row['id'];

                      // Fetching the votes
                      $fetchingVotes = mysqli_query($conn, "SELECT * FROM votings WHERE candidate_id = '" . $candidate_id . "'") or die(mysqli_error($conn));
                      $totalVotes = mysqli_num_rows($fetchingVotes);
                    } else {
                      $candidate_id = "N/A";
                    }
                    ?>
                    <tr>
                      <td><img src="../Admin/upload_image/<?php echo $row['candidate_photo']; ?>" height="100"></td>
                      <td>
                        <?php echo $row['candidate_name']; ?>
                      </td>
                      <td>
                        <?php echo $row['address']; ?>
                      </td>
                      <td>
                        <?php echo $row['email']; ?>
                      </td>
                      <td>
                        <?php echo $row['Bio']; ?>
                      </td>
                      <td>
                        <?php echo $election_topic; ?>
                      </td>
                      <td>
                        <?php echo isset($totalVotes) ? $totalVotes : 0; ?>
                      </td>
                      <td>
                        <?php
                        $checkIfVoteCasted = mysqli_query($conn, "SELECT * FROM votings WHERE voters_id = '" . $_SESSION['id'] . "' AND election_id = '" . $election_id . "'") or die(mysqli_error($conn));
                        $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                        if ($isVoteCasted > 0) {
                          $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                          $voteCastedToCandidate = $voteCastedData['candidate_id'];

                          if ($voteCastedToCandidate == $candidate_id) {
                            echo '<img src="../assets/image/vote.png" width="100px;">';
                          }
                        } else {
                          echo '<button onclick="confirmVote(' . $election_id . ', ' . $candidate_id . ', ' . $_SESSION['id'] . ')">Vote</button>';
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  ?>
                <tr>
                  <td colspan="8">No candidates yet.</td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
            <?php
          }
        }
        ?>
      </div>
    </section>

  </div>

  <script>
    // for confirm
    function confirmVote(election_id, candidate_id, voters_id) {
      // Show SweetAlert confirmation dialog
      Swal.fire({
        title: "Are you sure?",
        text: "Once you vote, your decision cannot be changed.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, vote now",
        cancelButtonText: "No, cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          // User clicked "Yes, vote now" button, proceed to cast the vote
          CastVote(election_id, candidate_id, voters_id);
          
        } else {
          // User clicked "No, cancel" button, do nothing
        }
      });
    }
// ajax

    const CastVote = (election_id, candidate_id, voters_id) => {
      // Get the client's local date and time
      const clientDate = new Date();
      const vote_date = clientDate.toISOString().slice(0, 10);
      const vote_time = clientDate.toLocaleTimeString('en-US');

      $.ajax({
        type: "POST",
        url: "inc/ajaxcall.php",
        data: {
          e_id: election_id,
          c_id: candidate_id,
          v_id: voters_id,
          vote_date: vote_date,
          vote_time: vote_time
        },
        success: function (response) {
          if (response === "Success") {
            
            location.assign("votenow.php?voteCasted=1");
        
          } else {
            location.assign("votenow.php?voteNotCasted=1");
          }
        }
      });
    }
  </script>

  <!-- Custom JS -->
  <script src="../assets/js/dashobrd.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
  <!-- jQuery Library -->
  <script src="../assets/js/jquery.min.js"></script>
</body>

</html>