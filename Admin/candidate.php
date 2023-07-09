<?php
include_once('inc/connection.php');

$sql = "SELECT * FROM candidate_details JOIN elections ON candidate_details.election_id = elections.election_id WHERE elections.status = 'Active'";
$details = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
  <link rel="stylesheet" href="../cssfolder/candidateshow.css">
  <link rel="stylesheet" href="../cssfolder/optinola.css">
</head>
<body>
  <!-- Top banner -->
<div class="top-banner">
  <div class="container">

    <div class="small-bold-text banner-text">"Cast your vote from anywhere, anytime with our secure and convenient online voting system."</div>
  </div>  
</div>
<!-- Navbar -->
<nav>
  <div class="container main-nav flex">
    <a href="../hompage/optionalhome.html" class="company-logo">
      <h1 style>Govote</h1>
    </a>
    <div class="nav-links">
     <ul class="flex">
      <li><a href="../hompage/optionalhome.html" class="hover-links">Home</a></li>
      <li><a href="" class="hover-links">Candidates</a></li>
      <li><a href="noticeshow.php" class="hover-links">Notice</a></li>
      <li><a href="../hompage/login_page.php" class="hover-links secondary-btn">Login</a></li>
      <li><a href="../hompage/Register-page.php" class="hover-links primary-btn">Register</a></li>
     </ul>
    </div>
  </div>
</nav>
<!-- header section -->
<header>
 <div class="container header-section flex">
  <div class="header-left">
  <div class="small-container">
  <div class="row">
    <?php
    if(mysqli_num_rows($details) > 0) {
      while ($row = mysqli_fetch_assoc($details)) {
        ?>
        <div class="col-4">
          <img src="upload_image/<?php echo $row['candidate_photo']; ?>" alt="" height="100px">
          <h4>
            <?php echo "Name: " . $row['candidate_name']; ?>
          </h4>
          <div class="rating">
            <p>
              <?php echo "Election Topic: " . $row['election_topic']; ?>
            </p>
          </div>
          <p>
            <?php echo 'Bio: '.$row['Bio']; ?>
          </p>
          <a href="../hompage/login_page.php"><button>Vote Now</button></a>
        </div>
      <?php
      }
    } else {
      ?>
      <h3 style="margin-top:100px;">No candidates available.</h3>
    <?php
    } ?>
  </div>
</div>  
</div>
 </div>
</header>
</body>
</html>
 
  








