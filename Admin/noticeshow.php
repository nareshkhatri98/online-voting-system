<?php
include_once('inc/connection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Home</title>
  <link rel="stylesheet" href="../cssfolder/first.css">
  <link rel="stylesheet" href="../cssfolder/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  <link rel="stylesheet" href="../cssfolder/candidateshow.css">
  <style>
  .main{
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .main >p{
    font-size: 18px;
    color: black;
  }
  </style>
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
        <li><a href="#">Notice</a></li>
        <li><a href="../hompage/login_page.php" id="user-icon">Account</a></li>
      </ul>
    </div>
  </section>
  <div class="main">
  <?php
  $sql = "SELECT * FROM notice";
  $details = $conn->query($sql);
  if(mysqli_num_rows($details) > 0) {
    while ($row = mysqli_fetch_assoc($details)) {
      ?>
    
      <p >
        
        <?php echo $row['content'] ; }?>
        </p>
        </div>
  
    <?php
}?>
  </div>

</body>

</html>
