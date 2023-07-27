<?php
include "inc/connection.php";

// Retrieve the admin user data
$sel = "SELECT * FROM users WHERE user_role = 'admin'";
$query = mysqli_query($conn, $sel);
$result = mysqli_fetch_assoc($query);

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
          </a>
          </li>
        <li class="sidebar-list-item">
          <a href="addcandidate.php">
            <span class="material-icons-outlined">groups</span>Candidates
          </a>
        </li>
        <li class="sidebar-list-item"><a href="votersdetails.php"><span class="material-icons-outlined"> groups</span>
            Voterlist</a></li>
        <li class="sidebar-list-item">
          <span class="material-icons-outlined">visibility</span> View Result
        </li>
        <li class="sidebar-list-item">
          <a href="notify.php"><span class="material-icons-outlined">settings</span> Notify
          </a></li>
      </ul>
    </aside>
    <!-- End Sidebar -->

    <section class="voting">
      <div class="candidate_list">
        <h3 style="text-align: center;">Election Results</h3>

        <?php
        $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE status = 'active'") or die(mysqli_error($conn));
        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

        if ($totalActiveElections > 0) {
          while ($row = mysqli_fetch_assoc($fetchingActiveElections)) {
            $election_id = $row['election_id'];
            $election_topic = $row['election_topic'];

            // Retrieve the candidate details and votes
            $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '$election_id'") or die(mysqli_error($conn));
            $totalCandidates = mysqli_num_rows($fetchingCandidates);

            if ($totalCandidates > 0) {
              $winner = null; // Variable to store the winner
        
              echo '<table class="table">';
              echo '<thead>';
              echo '<tr>';
              echo '<th>Photo</th>';
              echo '<th>Name of candidate</th>';
              echo '<th>Details</th>';
              echo '<th>Election topic</th>';
              echo '<th>Total Votes</th>';
              echo '</tr>';
              echo '</thead>';
              echo '<tbody>';

              while ($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                $candidate_id = $candidateData['id'];
                $candidate_photo = $candidateData['candidate_photo'];

                // Fetching Candidate Votes 
                $fetchingVotes = mysqli_query($conn, "SELECT * FROM votings WHERE candidate_id = '$candidate_id'") or die(mysqli_error($conn));
                $totalVotes = mysqli_num_rows($fetchingVotes);

                // Check if this candidate has the highest number of votes
                if ($totalVotes > 0) {
                  if (!isset($winner) || $totalVotes > $winner['votes']) {
                    $winner = [
                      'candidate_id' => $candidate_id,
                      'candidate_name' => $candidateData['candidate_name'],
                      'candidate_photo' => $candidate_photo,
                      'votes' => $totalVotes
                    ];
                  }
                }

                echo '<tr>';
                echo '<td><img src="upload_image/' . $candidate_photo . '" height="100" style="border-radius: 20px;"></td>';
                echo '<td>' . $candidateData['candidate_name'] . '</td>';
                echo '<td>' . $candidateData['Bio'] . '</td>';
                echo '<td>' . $election_topic . '</td>';
                echo '<td>' . $totalVotes . '</td>';
                echo '</tr>';
              }

              echo '</tbody>';
              echo '</table>';

              // Declare the winner(s)
              if ($winner) {
                $winners = [$winner]; // Initialize an array to store the winners
                $maxVotes = $winner['votes']; // Store the maximum number of votes

                // Check for ties and add all candidates with equal votes to the winners array
                mysqli_data_seek($fetchingCandidates, 0); // Reset the candidates fetch pointer
                while ($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                  $candidate_id = $candidateData['id'];
                  $candidate_photo = $candidateData['candidate_photo'];

                  // Fetching Candidate Votes 
                  $fetchingVotes = mysqli_query($conn, "SELECT * FROM votings WHERE candidate_id = '$candidate_id'") or die(mysqli_error($conn));
                  $totalVotes = mysqli_num_rows($fetchingVotes);

                  if ($totalVotes === $maxVotes && $candidate_id !== $winner['candidate_id']) {
                    $winners[] = [
                      'candidate_id' => $candidate_id,
                      'candidate_name' => $candidateData['candidate_name'],
                      'candidate_photo' => $candidate_photo,
                      'votes' => $totalVotes
                    ];
                  }
                }

                // Display the winner(s)
                echo '<h4 style="text-align:center">Winner</h4>';
                echo '<div class="winners-container">'; // Flex container for winners

                foreach ($winners as $winner) {
                  echo '<div class="winner">';
                
                  echo '<img src="upload_image/' . $winner['candidate_photo'] . '">';
                  echo '<p>' . $winner['candidate_name'] . '</p>';
                  echo '<p>Total Votes: ' . $winner['votes'] . '</p>';
                  echo '</div>';
                }

                echo '</div>'; // Close flex container
              } else {
                echo '<p style="text-align: center;">No winner declared yet.</p>';
              }
            }
          }
        } else {
          echo '<p style="text-align: center>No active elections found.</p>';
        }
        ?>

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
