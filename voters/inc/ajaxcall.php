<?php
session_start();
include('../../Admin/inc/connection.php');

if (isset($_POST['e_id']) && isset($_POST['c_id']) && isset($_POST['v_id']) && isset($_POST['vote_date']) && isset($_POST['vote_time'])) {
  $vote_date = $_POST['vote_date'];
  $vote_time = $_POST['vote_time'];

  mysqli_query($conn, "INSERT INTO votings(election_id, voters_id, candidate_id, vote_date, vote_time) VALUES('". $_POST['e_id'] ."', '". $_POST['v_id'] ."', '". $_POST['c_id'] ."', '". $vote_date ."', '". $vote_time ."')");
  $_SESSION['success-message'] ="Your vote is  casted successfully..";
  // Update vote count for the candidate
  $updateVoteCount = mysqli_query($conn, "UPDATE candidates SET vote_count = vote_count + 1 WHERE id = '". $_POST['c_id'] ."'");
  if ($updateVoteCount) {
    echo"success";
  } else {
    echo"Error";
  }
}
?>
