<?php
@include 'inc/connection.php';
session_start();

if(isset($_POST['add_election'])){

  
        $election_topic = mysqli_real_escape_string($conn, $_POST['election_topic']);
        $number_of_candidates = mysqli_real_escape_string($conn, $_POST['number_of_candidates']);
        $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
        $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);
        $inserted_by = $_SESSION['fullname'];
        $inserted_on = date("Y-m-d");
        $current_date = date("Y-m-d"); // Get the current date

        $date1 = date_create($starting_date);
        $date2 = date_create($ending_date);
        $diff = date_diff($date1, $date2);
        
        // Compare the starting date with the current date
        if ($starting_date !== $current_date) {
            $status = "Invalid: Starting date should be the current date";
        } elseif ((int)$diff->format("%R%a") <= 0) {
            $status = "Invalid: Ending date should be a future date";
        } else {
            $status = "active";
        }
        
        if(empty($election_topic) || empty($number_of_candidates) || empty($starting_date) || empty($ending_date)){
         
          echo'   <script>
            alert("please fill out all");
            window.location = "addelection.php";
        </script>
        ';
        
        }
        // inserting into db
       else{ 
         $insert= "INSERT INTO elections(election_topic, no_of_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES('". $election_topic ."', '". $number_of_candidates ."', ' 
       ". $starting_date ."', '". $ending_date ."', '". $status ."', '". $inserted_by ."', '". $inserted_on ."')" ;
         $upload= mysqli_query($conn, $insert);
         if($upload){
          echo'   <script>
          alert("New Election added successfully.");
          window.location = "addelection.php";
      </script>
      ';
    
         }else{
            $message[] = 'could not add the election';
          }
          }
 }
   


if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM elections WHERE election_id = $id");
   header('location:addelection.php');
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
        <a href="dashboard.php"><span class="material-icons-outlined">dashboard</span> Dashboard</li></a>

      <li class="sidebar-list-item">
       <a href="dashboard.php"><span class="material-icons-outlined">event_available</span> Elections</li></a>
      
     <li class="sidebar-list-item">
     <a href="addcandidates.php"><span class="material-icons-outlined">groups</span> Candidates</li></a>
     <li class="sidebar-list-item"><a href="viewresult.php"><span class="material-icons-outlined">visibility</span> View Result </a></li>
   
    <li class="sidebar-list-item"> <span class="material-icons-outlined">settings </span> Notify</li></a>

   </ul>
  </aside>
  <!-- Endsidebar -->
  <main class="main-container">
    

<div class="form-container">

   <div class="admin-product-form-container">

   <form action="addelection.php" method="post" enctype="multipart/form-data">

            <h3>add a new election</h3>
           <label for="">ElectioN topic</label>
            <input type="text" name="election_topic" class="box">
            <label for="">No Of Candiadtes</label>
            <input type="number" placeholder="Number of candidates" name="number_of_candidates" class="box">
            <label for="">starting-date</label>

            <input type="date" placeholder="starting date" name="starting_date" class="box">
            <label for="">Ending-date</label>
           <input type="date" placeholder="ending date" name="ending_date" class="box">
         
            <input type="submit" class="btn" name="add_election" value="add_election">
         </form>

<?php

      $select = mysqli_query($conn, "SELECT * FROM elections");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>S.N</th>
            <th>Election name</th>
            <th>Candidates</th>
            <th>Starting date</th>
            <th>Ending date</th>
            <th>Status</th>
            <th>action</th>
         </tr>
         </thead>
         <?php 
                    $fetchingData = mysqli_query($conn, "SELECT * FROM elections") or die(mysqli_error($conn)); 
                    $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                    if($isAnyElectionAdded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData))
                        {
                            $election_id = $row['election_id'];
                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $row['election_topic']; ?></td>
                                <td><?php echo $row['no_of_candidates']; ?></td>
                                <td><?php echo $row['starting_date']; ?></td>
                                <td><?php echo $row['ending_date']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td> 
                                <a href="electionupdate.php?edit=<?php echo $row['election_id']; ?>" class="box-btn"> <i class="fas fa-edit"></i> edit </a>
                                <a href="addelection.php?delete=<?php echo $row['election_id']; ?>" class="box-btn"> <i class="fas fa-trash"></i> delete </a>
                                </td>
                            </tr>
                <?php
                        }
                    }else {
            ?>
                        <tr> 
                            <td colspan="7"> No any election is added yet. </td>
                        </tr>
            <?php
                    }
                ?>
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