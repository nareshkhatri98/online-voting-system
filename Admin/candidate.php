<?php
include_once('inc/connection.php');

$sql = "SELECT *FROM candidate_details join elections on candidate_details.election_id = elections.election_id";
$all_product = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Home</title>
  <link rel="stylesheet" href="../cssfolder/first.css">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  <link rel="stylesheet" href="../cssfolder/candidateshow.css">
</head>

<body>
  <section id="header">
    <a href="home_page.html">
      <h1 class="logo">Go Vote</h1>
    </a>
    <div>
      <ul id="navbar">
        <li><a href="../hompage/home_page.html">Home</a></li>
        <li><a href="../Admin/candidate.php">Candidates</a></li>
        <li><a href="../hompage/about.html">About Us</a></li>
        <li> <a href="login_page.php" id="user-icon"><i class="fas fa-user"></i></a></li>
      </ul>
    </div>
  </section>
  <div class="container">

<?php
// Assuming $all_product is the result set obtained from the database query
while ($row = mysqli_fetch_assoc($all_product)) {
?>

<section class="main">
  <div class="main-top">
    <h1 style="margin-left: 900px;">Candidates</h1>
  </div>
  <div class="users">
    <div class="card">
      <img src="upload_image/<?php echo $row['candidate_photo']; ?>" alt="">
      <h3>
        <?php echo "Name: " . $row['candidate_name']; ?>
      </h3>
      <span style="font-weight: 800;">
        <?php echo "Election Topic: " . $row['election_topic']; ?>
      </span>
      <br>
      <p style="font-weight: 800; font-size: 13px;">
        <?php echo $row['Bio']; ?>
      </p>
      <a href="../homepage/login_page.php">
        <button style="font-weight: 800;">Vote Now</button>
      </a>
    </div>
  </div>
</section>

<?php
}

// Check if no candidates were found
if (mysqli_num_rows($all_product) === 0) {
  echo '<h3 style="margin-left:1000px">No candidates  avaliable.</h3>';
}

// Error handling
if (!$all_product) {
  echo "<p>Error fetching candidates: " . mysqli_error($conn) . "</p>";
}
?>

</div>


</body>

</html>