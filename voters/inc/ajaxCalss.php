<?php
include ("../Admin/inc/connection.php");

if(isset($_POST['e_id'])AND isset($_POST['c_id'])AND isset($_POST['v_id']))
{
    $vote_date = date("y-m-d");
    $vote_time = date("h:i:s a");

    mysqli_query($conn, "INSERT INTO votings(election_id, voters_id, candidate_id, vote_date, vote_time) VALUES('". $_POST['e_id'] ."', '". $_POST['v_id'] ."','". $_POST['c_id'] ."','". $vote_date ."','". $vote_time ."')") or die(mysqli_error($conn));

    echo "Sucess";
}
?>