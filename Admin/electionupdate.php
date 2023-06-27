<?php
@include 'inc/connection.php';

$id = $_GET['edit'];
$message = array();

if (isset($_POST['update_product'])) {
  $election_topic = mysqli_real_escape_string($conn, $_POST['election_topic']);
  $number_of_candidates = mysqli_real_escape_string($conn, $_POST['number_of_candidates']);
  $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
  $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);
  $date1 = date_create($starting_date);
  $date2 = date_create($ending_date);
  $diff = date_diff($date1, $date2);
  
  // Compare the starting date with the current date
  $current_date = date("Y-m-d");
  if ($starting_date !== $current_date) {
      $status = "Inactive";
  } elseif ((int)$diff->format("%R%a") <= 0) {
      $status = "Inactive";
  } else {
      $status = "active";
  }

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
   <link rel="stylesheet" href="../cssfolder/election.css">
</head>
<body>

<?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '<span class="message">' . $message . '</span>';
      }
   }
?>

<div class="container">
  <div class="admin-product-form-container centered">
    <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">Update the product</h3>
      <label for="">Election Topic</label>
      <input type="text" placeholder="Enter election topic" name="election_topic" class="box" value="<?php echo $row['election_topic']; ?>">
      
      <label for="">Number of Candidates</label>
      <input type="number" placeholder="Number of candidates" name="number_of_candidates" class="box" value="<?php echo $row['no_of_candidates']; ?>">
      
      <label for="">Starting Date</label>
      <input type="date" placeholder="Starting date" name="starting_date" class="box" value="<?php echo $row['starting_date']; ?>">
      
      <label for="">Ending Date</label>
      <input type="date" placeholder="Ending date" name="ending_date" class="box" value="<?php echo $row['ending_date']; ?>">
      
      <label for="">Status</label>
      <input type="text" placeholder="Status" name="status" class="box" value="<?php echo $row['status']; ?>">
      
      <input type="submit" value="Update Product" name="update_product" class="btn">
      <a href="addelection.php" class="btn">Go back!</a>
    </form>
  </div>
</div>

</body>
</html>
