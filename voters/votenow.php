<?php
include "../Admin/inc/connection.php";
session_start();
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

      
      <div class="class-right">

        <h1>Welcome- <smaLL>
     
          </smaLL></h1>

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
        </li></a>
        <li class="sidebar-list-item">
          <a href="dashboard.php" > <span class="material-icons-outlined">event</span> election Avaliable
        </li></a>
       
        <li class="sidebar-list-item">
          <a href="../hompage/home_page.html">
            <span class="material-icons-outlined">account_circle</span>
          </a>
          Logout
        </li>
      </ul>
    </aside>
   
<?php

  ?>
   
   
    <section class="voting">
      <div class="candidate_list">
      <h1>Candidates list</h1>
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
                            <td><img src="../Admin/upload_image/<?php echo $row['candidate_photo']; ?>" height="100" style="border-radius: 20px;"></td>
                            <td><?php echo $row['candidate_name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['Bio']; ?></td>
                            <td><?php echo $election_topic; ?></td>
                            <td><?php echo isset($totalVotes) ? $totalVotes : 0; ?></td>
                            <td>
                              <?php
                                  $checkIfVoteCasted = mysqli_query($conn, "SELECT * FROM votings WHERE voters_id = '". $_SESSION['id'] ."' AND election_id = '". $election_id ."'") or die(mysqli_error($conn));    
                                  $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);
                                

                                  if($isVoteCasted > 0)
                                  {
                                      $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                               
                                      $voteCastedToCandidate = $voteCastedData['candidate_id'];

                                      if($voteCastedToCandidate == $candidate_id)
                                      {
                          ?>

                                          <img src="../assets/image/vote.png" width="100px;">
                          <?php
                                      }
                                  }else {
                          ?><button onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['id']; ?>)"> Vote </button>
                          <?php
                                  }

                                  
                          ?>

                      
                            
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



  
          </tbody>
        </table>
      </div>

    </section>

  </div>



<script>
  const CastVote = (election_id, candidate_id, voters_id) => {
  $.ajax({
    type: "POST",
    url: "inc/ajaxcall.php",
    data: "e_id=" + election_id + "&c_id=" + candidate_id + "&v_id=" + voters_id,
    success: function(response) {
      if(response == "Success")
                {
                    location.assign("votenow.php?voteCasted=1");
                }else {
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
  <script src="../assets/js/jquery.min.js"></script>
  
  
  </div>
</body>

</html>