<?php
include "inc/connection.php";
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
  <title>dashboard</title>
  <!-- custome css -->
  <link rel="stylesheet" href="../cssfolder/dashboard.css">
  <!-- For icons -->
  <link rel="stylesheet" href="../cssfolder/voter.css">
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
            <?php echo $result['fullname']; ?>
          </small></h3>
      </div>
      <div class="class-right">
        <span class="material-icons-outlined"><a href="logout.php">account_circle</a></span>
      </div>
    </header>
    <!-- end header -->

    <!-- sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <a href="dashboard.php">
            <span class="material-icons-outlined">how_to_vote</span>  </a >Go Vote
      
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
          <span class="material-icons-outlined"><a href="addelection.php">event_available</a></span>
          Elections
        </li>
        <li class="sidebar-list-item">
          <span class="material-icons-outlined"><a href="addcandidate.php">groups</a></span>
          Candidates
        </li>
        <li class="sidebar-list-item">
          <span class="material-icons-outlined">visibility</span> View Result
        </li>
        <li class="sidebar-list-item">
          <span class="material-icons-outlined">settings</span> Notify
        </li>
      </ul>
    </aside>
    <!-- end sidebar -->

    <section class="voting">
      <div class="candidate_list">
        <h3>Election Results</h3>

        <?php 
        $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections") or die(mysqli_error($conn));
        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

        if ($totalActiveElections > 0) {
            while ($row = mysqli_fetch_assoc($fetchingActiveElections)) {
                $election_id = $row['election_id'];
                $election_topic = $row['election_topic'];
        ?>

        <table class="table">
          <thead>
            <tr>
              <th>Photo</th>
              <th>Name of candidate</th>
              <th>Details</th>
              <th>Election topic</th>
              <th># of Votes</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '". $election_id ."'") or die(mysqli_error($conn));

            while ($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                $candidate_id = $candidateData['id'];
                $candidate_photo = $candidateData['candidate_photo'];

                // Fetching Candidate Votes 
                $fetchingVotes = mysqli_query($conn, "SELECT * FROM votings WHERE candidate_id = '". $candidate_id . "'") or die(mysqli_error($conn));
                $totalVotes = mysqli_num_rows($fetchingVotes);
            ?>
                   <tr>
                           <td><img src="upload_image/<?php echo $candidate_photo; ?>" height="100" style="border-radius: 20px;"></td>
                           <td><?php echo $candidateData['candidate_name']; ?></td>
                            <td><?php echo $candidateData['Bio']; ?></td>
                           <td><?php echo $election_topic; ?></td>
                           <td><?php echo $totalVotes; ?></td>
                 </tr>

            <?php
            }
            ?>
          </tbody>
        </table>
        <?php
            }
        } else {
            
        }
        ?>
      </div>
    </section>

    <!-- rest of your HTML code -->

    <!-- custom js -->
    <script src="../assets/js/dashobrd.js"></script>
    <script src="../assets/js/first.js"></script>
    <script src="../assets/js/drop_down.js"></script>
  </div>
</body>

</html>
