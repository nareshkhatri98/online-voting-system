
<?php
session_start();
@include 'inc/connection.php';

if (isset($_POST['add_candidate'])) {
    $election_id = $_POST['election_id'];
    $candidate_name = $_POST['candidate_name'];
    $candidate_address = $_POST['candidate_address'];
    $candidate_email = $_POST['candidate_email'];
    $candidate_photo = $_FILES['candidate_photo']['name'];
    $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
    $candidate_image_folder = 'upload_image/'.$candidate_photo;
    $candidate_bio = $_POST['candidate_bio'];
    $inserted_by = $_SESSION['fullname'];
    $inserted_on = date("Y-m-d");

    if (empty($candidate_name) || empty($candidate_address) || empty($candidate_email) || empty($candidate_photo) || empty($candidate_bio) || empty($election_id) || $election_id == '0') {
      echo'   <script>
      alert("Please fill out all fields and provide a valid election ID.");
      window.location = "addcandidate.php";
  </script>
  ';
      
      ;
    } else {
        $insert = "INSERT INTO candidate_details (election_id, candidate_name, address, email, candidate_photo, Bio, inserted_by, inserted_on) VALUES ('$election_id', '$candidate_name', '$candidate_address', '$candidate_email', '$candidate_photo', '$candidate_bio', '$inserted_by', '$inserted_on')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($candidate_photo_tmp_name, $candidate_image_folder);
         echo'   <script>
            alert("new candidate added successfull.");
            window.location = "addcandidate.php";
        </script>
        ';
          
        } else {
         echo'   <script>
            alert("Could not add");
            window.location = "addcandidate.php";
        </script>
        ';
          
        }
    }
}



   

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM candidate_details WHERE id = $id");
   header('location:addcandidate.php');
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title>dashboard</title> -->
  <!-- custome css -->
  <link rel="stylesheet" href="../dashboard/dashboard.css"">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
  rel="stylesheet">
  <link rel="stylesheet" href="../cssfolder/election.css">

<body>
<div class="grid-container">

  <!-- header -->
  <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
      <span class="material-icons-outlined">menu</span>
    </div>
    <div class="class-left">
      <span class="material-icons-outlined"> search </span> 
    </div>
    <div class="class-right">
      <span class="material-icons-outlined" >account_circle </a></span>
      
    </div>
  </header>
  <!-- end header -->

  <!-- slidebar -->
   <aside id="sidebar">
   <div class="sidebar-title">
    <div class="sidebar-brand">
   <a href="dashboard.php"> <span class="material-icons-outlined" style="color:#b0b2bd;">how_to_vote</span> </a> Go Vote
    </div>
    <span class="material-icons-outlined" onclick="closeSidebar()">close </span>
   </div>

   <ul class="sidebar-list">
        <li class="sidebar-list-item">
        <a href="dashboard.php">
        <span class="material-icons-outlined">dashboard</span> Dashboard</li></a>

      <li class="sidebar-list-item">
       <a href="dashboard.php"><span class="material-icons-outlined">event_available</span> Elections</li></a>
      
       <li class="sidebar-list-item"> <a href="dashboard.php"><span class="material-icons-outlined">groups</span> Candidates</li></a>
     <li class="sidebar-list-item"><a href="viewresult.php"><span class="material-icons-outlined">visibility</span> View Result </a></li>
   
    <li class="sidebar-list-item"> <span class="material-icons-outlined">settings </span> Notify</li>

   </ul>
  </aside>
  <!-- Endsidebar -->
  <main class="main-container">
   
   <div class="form-container">
   <div class="admin-product-form-container">
      <form action="addcandidate.php" method="post" enctype="multipart/form-data">
         <h3>Add Candidates</h3>
         <select class="box" name="election_id" required>
            <option value="">Select Election Topic</option>
            <?php 
               $fetchingElections = mysqli_query($conn, "SELECT * FROM elections") or die(mysqli_error($conn));
               $isAnyElectionAdded = mysqli_num_rows($fetchingElections);
               if ($isAnyElectionAdded > 0) {
                  while ($row = mysqli_fetch_assoc($fetchingElections)) {
                     $election_id = $row['election_id'];
                     $election_name = $row['election_topic'];
                     $allowed_candidates = $row['no_of_candidates'];

                     // Now checking how many candidates are added in this election 
                     $fetchingCandidate = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '". $election_id ."'") or die(mysqli_error($conn));
                     $added_candidates = mysqli_num_rows($fetchingCandidate);

                     if ($added_candidates < $allowed_candidates) {
            ?>
            <option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>
            <?php
                     }
                  }
               } else {
            ?>
            <option value="">Please add an election first</option>
            <?php
               }
            ?>
         </select>
         <label for="">Fullname</label>
         <input type="text" placeholder="Enter candidate full name" name="candidate_name" class="box">
         <label for="">Address</label>
         <input type="text" placeholder="Enter candidate address" name="candidate_address" class="box">
         <label for="">Email</label>
         <input type="email" placeholder="Enter email" name="candidate_email" class="box">
         <label for="">Photo</label>
         <input type="file" accept="image/jpg, image/png, image/jpeg" placeholder="Upload the image" name="candidate_photo" class="box" required>
         <label for="">Bio</label>
         <textarea name="candidate_bio" placeholder="Short Bio" class="box" cols="0" rows="0"></textarea>
         <input type="submit" class="btn" name="add_candidate" value="add_candidate">
      </form>
   </div>
</div>


<?php
$select = mysqli_query($conn, "SELECT * FROM candidate_details");
?>
<div class="product-display">
   <table class="product-display-table">
      <thead>
         <tr>
            <th>Sn</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Bio</th>
            <th>Election topic</th>
            <th>Action</th>
         </tr>
      </thead>
      <?php
     $fetchingData = mysqli_query($conn, "SELECT candidate_details.id, candidate_details.candidate_photo, candidate_details.candidate_name, candidate_details.address, candidate_details.email, candidate_details.Bio, elections.election_topic FROM candidate_details JOIN elections ON candidate_details.election_id = elections.election_id") or die(mysqli_error($conn));

     $isAnyCandidateAdded = mysqli_num_rows($fetchingData);
     
     if ($isAnyCandidateAdded > 0) {
         $sno = 1;
         while ($row = mysqli_fetch_assoc($fetchingData)) {
             if (isset($row['candidate_id'])) {
                 $candidate_id = $row['candidate_id'];
             } else {
                 $candidate_id = "N/A";
             }
             ?>
             <tr>
                 <td><?php echo $sno++; ?></td>
                 <td><img src="upload_image/<?php echo $row['candidate_photo']; ?>" height="100" style="border-radius: 20px;"></td>
                 <td><?php echo $row['candidate_name']; ?></td>
                 <td><?php echo $row['address']; ?></td>
                 <td><?php echo $row['email']; ?></td>
                 <td><?php echo $row['Bio']; ?></td>
                 <td><?php echo $row['election_topic']; ?></td>
                 <td>
                     <a href="update.php?edit=<?php echo $row['id']; ?>" class="box-btn"><i class="fas fa-edit"></i> Edit</a>
                     <a href="addcandidate.php?delete=<?php echo $row['id']; ?>" class="box-btn"><i class="fas fa-trash"></i> Delete</a>
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
   </table>
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
</body>
</html>