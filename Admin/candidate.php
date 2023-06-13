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
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
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
  <main>
  <?php
while ($row = mysqli_fetch_assoc($all_product)) {

?>
  <div class="container">
      <div class="cart">
      
      <img src="upload_image/<?php echo $row['candidate_photo']; ?>" alt=""> 
        <div class="containt">
       <p> <?php echo"election topic  : " .$row['election_topic'] ?></p>

         <p><?php echo $row['candidate_name'] ?></p>
         <p><?php echo $row['Bio'] ?>.</p>
         
         <a href="../hompage/login_page.php"> <button class="btn">vote now</button></a>
        </div>
      </div>
      
      </div>
    </div>
  <?php
} 
  ?>
  </main>
</body>
</html>