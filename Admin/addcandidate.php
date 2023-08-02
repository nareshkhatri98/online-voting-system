<?php
session_start();
@include 'inc/connection.php';

function isValidEmail($email)
{
   // Use filter_var to validate the email format
   return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function isValidFullName($candidate_name)
{
   // Use regex to match only characters and spaces
   return preg_match('/^[A-Za-z ]+$/', $candidate_name);
}
function isValidAddress($candidate_address)
{
   return preg_match('/^[A-Za-z0-9\s@+\-_$.]+$/', $candidate_address);
}

if (isset($_POST['add_candidate'])) {
   $election_id = $_POST['election_id'];
   $candidate_name = $_POST['candidate_name'];
   $candidate_address = $_POST['candidate_address'];
   $candidate_email = $_POST['candidate_email'];
   $candidate_photo = $_FILES['candidate_photo']['name'];
   $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
   $candidate_image_folder = 'upload_image/' . $candidate_photo;
   $candidate_bio = $_POST['candidate_bio'];
   $inserted_by = $_SESSION['admin'];
   $inserted_on = date("Y-m-d");

   // Perform validation
   if (empty($candidate_name) || empty($candidate_address) || empty($candidate_email) || empty($candidate_photo) || empty($candidate_bio) || empty($election_id) || $election_id == '0') {
      $_SESSION['success_message'] = "Please fill all the fields.";
      header('location:addcandidate.php');
      exit;
   } elseif (!isValidEmail($candidate_email)) {
      $_SESSION['success_message'] = "Invalid email address.";
      header('location:addcandidate.php');
      exit;
   } elseif (!isValidFullName($candidate_name)) {
      $_SESSION['success_message'] = "Invalid name format. Only characters and spaces are allowed.";
      header('location:addcandidate.php');
      exit;
   } elseif (!isValidAddress($candidate_address)) {
      $_SESSION['success_message'] = "Invalid address format. Only characters, spaces, and numbers are allowed.";
      header('location:addcandidate.php');
      exit;
   } else {
      // Check if the image file is uploaded successfully
      if (!isset($_FILES['candidate_photo']['error']) || $_FILES['candidate_photo']['error'] !== UPLOAD_ERR_OK) {
         $_SESSION['success_message'] = "Failed to upload candidate photo.";
         header('location:addcandidate.php');
         exit;
      }

      // Check file type and size
      $allowed_extensions = array('jpg', 'jpeg', 'png');
      $file_extension = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
      if (!in_array($file_extension, $allowed_extensions)) {
         $_SESSION['success_message']  = "Invalid file format. Only JPG, JPEG, and PNG files are allowed.";
         header('location:addcandidate.php');
         exit;
      }
      $max_file_size = 1 * 1024 * 1024; // 1 MB in bytes
      if ($_FILES['candidate_photo']['size'] > $max_file_size) {
         $_SESSION['success_message']   = "The image size should not larger tha 1 MB.";
         header('location:addcandidate.php');
         exit;
      }

      // Check if the image file exists in the destination folder with the same name
      $full_candidate_image_path = $candidate_image_folder;
      if (file_exists($full_candidate_image_path)) {
         $_SESSION['success_message'] = "The image is already exists. Please upload a different image.";
         header('location:addcandidate.php');
         exit;
      }
      // Check if the email already exists in the database
      $existing_email_query = "SELECT * FROM candidate_details WHERE email = '$candidate_email'";
      $existing_email_result = mysqli_query($conn, $existing_email_query);
      if (mysqli_num_rows($existing_email_result) > 0) {
         $_SESSION['success_message'] = "The email already exists. Please use a different email address.";
         header('location:addcandidate.php');
         exit;
      }

      // Perform the insertion
      $insert = "INSERT INTO candidate_details (election_id, candidate_name, address, email, candidate_photo, Bio, inserted_by, inserted_on) VALUES ('$election_id', '$candidate_name', '$candidate_address', '$candidate_email', '$candidate_photo', '$candidate_bio', '$inserted_by', '$inserted_on')";
      $upload = mysqli_query($conn, $insert);

      if ($upload) {
         // Move the uploaded image to the destination folder
         if (move_uploaded_file($candidate_photo_tmp_name, $full_candidate_image_path)) {
            $_SESSION['success_message'] = "Candidate added successfully!";
            header('location:addcandidate.php');
            exit;
         } else {
            $_SESSION['success_message'] = "Failed to upload candidate photo.";
            header('location:addcandidate.php');
            exit;
         }
      } else {
         $_SESSION['success_message'] = "Failed to add candidate.";
         header('location:addcandidate.php');
         exit;
      }

   }
}
?>
<?php
if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM candidate_details WHERE id = $id");
   $_SESSION['success_message'] = "Candidates deleted successfully!";
   header('location:addcandidate.php');
   exit; // Always exit after redirect
}
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
  <link href=" https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
   <link rel="stylesheet" href="../cssfolder/election.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
      integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <style>
      /* Style for the success message */
      .success-message {
         color: green;
         background-color: #e2f1dd;
         padding: 10px;
         border-radius: 5px;
         margin-bottom: 20px;
         text-align: center;
      }

      .error-message {
         color: green;
         background-color: #e2f1dd;
         padding: 10px;
         border-radius: 5px;
         margin-bottom: 20px;
         text-align: center;
      }
   </style>
</head>

<body>
   <div class="grid-container">

      <!-- header -->
      <header class="header">
         <div class="menu-icon" onclick="openSidebar()">
            <span class="material-icons-outlined">menu</span>
         </div>

      </header>
      <!-- end header -->

      <!-- slidebar -->
      <aside id="sidebar">
         <div class="sidebar-title">
            <div class="sidebar-brand">
               <a href="dashboard.php"> <span class="material-icons-outlined" style="color:#b0b2bd;">how_to_vote</span>
               </a> Go Vote
            </div>
            <span class="material-icons-outlined" onclick="closeSidebar()">close </span>
         </div>

         <ul class="sidebar-list">
            <li class="sidebar-list-item">
               <a href="dashboard.php">
                  <span class="material-icons-outlined">dashboard</span> Dashboard
            </li></a>

            <li class="sidebar-list-item">
               <a href="addelection.php"><span class="material-icons-outlined">event_available</span> Elections
            </li></a>

            <li class="sidebar-list-item"> <a href="dashboard.php"><span class="material-icons-outlined">groups</span>
                  Candidates</li></a>
            <li class="sidebar-list-item"><a href="votersdetails.php"><span class="material-icons-outlined">
                     groups</span>
                  Voterlist</a></li>
            <li class="sidebar-list-item"><a href="viewresult.php"><span
                     class="material-icons-outlined">visibility</span> View Result </a></li>

            <li class="sidebar-list-item"> <a href="notify.php"> <span class="material-icons-outlined">settings </span>
                  Notify</a></li>

         </ul>
      </aside>
      <!-- Endsidebar -->
      <main class="main-container">

         <div class="form-container">
            <div class="admin-product-form-container">
               <?php
               if (isset($_SESSION['success_message'])) {
                  echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
                  // Clear the success message after displaying it
                  unset($_SESSION['success_message']);
               }
               ?>

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
                           $fetchingCandidate = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '" . $election_id . "'") or die(mysqli_error($conn));
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
                  <input type="text" name="candidate_name" class="box">
                  <label for="">Address</label>
                  <input type="text" name="candidate_address" class="box">
                  <label for="">Email</label>
                  <input type="text" name="candidate_email" class="box">
                  <label for="">Photo</label>
                  <input type="file" accept="image/jpg, image/png, image/jpeg" placeholder="Upload the image"
                     name="candidate_photo" class="box" required>
                  <label for="">Bio</label>
                  <textarea name="candidate_bio" class="box" cols="0" rows="0"></textarea>
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
                        <td>
                           <?php echo $sno++; ?>
                        </td>
                        <td><img src="upload_image/<?php echo $row['candidate_photo']; ?>" height="100"
                              style="border-radius: 20px;"></td>
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
                           <?php echo $row['election_topic']; ?>
                        </td>
                        <td>
                           <a href="updatecandidate.php?edit=<?php echo $row['id']; ?>" class="box-btn"> Edit</a>
                           <a href="addcandidate.php?delete=<?php echo $row['id']; ?>" class="box-btn" id="delete"
                              onclick="conformation(event)"> Delete</a>
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

      </main>
   </div>



   <?php
   // Check if the success message is set
   if (isset($_SESSION['success_message'])) {
      echo '<div class="success-msg">' . $_SESSION['success_message'] . '</div>';
      // Clear the success message after displaying it
      unset($_SESSION['success_message']);
   }
   ?>

   <!-- custom js -->
   <script src="../assets/js/dashobrd.js"></script>
   <script src="../assets/js/first.js"></script>
   <script src="../assets/js/drop_down.js"></script>




   <script>
      function conformation(ev) {
         ev.preventDefault();

         var urlToRedirect = ev.currentTarget.getAttribute('href');
         swal({
            title: "Are you sure to delete this?",
            text: "You won't be able to revert this delete",
            icon: "warning",
            buttons: true,
            dangerMode: true,
         }).then((willCancel) => {
            if (willCancel) {
               window.location.href = urlToRedirect;
            }
         });
      }
   </script>
</body>

</html>