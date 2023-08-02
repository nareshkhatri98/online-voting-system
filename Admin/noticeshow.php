<?php
include_once('inc/connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My website</title>
  <link rel="stylesheet" href="../cssfolder/optinola.css">
  <style>
    /* CSS for the notice section */
    .notice-section {
      margin-top: -120px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-evenly ;
      align-items: flex-start;
    }

    .notice {
      background-color: #D8D9DA;
      padding: 10px;
      margin: 10px;
      border-radius: 5px;
      flex: 0 0 calc(33.33% - 30px); /* Adjust the width of each notice box as per your requirement */
    }

    /* Additional styles for notice content */
    .notice p{
      margin-top: 10px;
      font-size: 1.0rem;
      color:#331D2C;
    }

  </style>
</head>

<body>
  <!-- Top banner -->
  <div class="top-banner">
    <div class="container">
      <div class="small-bold-text banner-text">Cast your vote from anywhere, anytime with our secure and convenient
        online voting system."</div>
    </div>
  </div>
  <!-- Navbar -->
  <nav>
    <div class="container main-nav flex">
      <a href="../hompage/optionalhome.html" class="company-logo">
        <h1>Govote</h1>
      </a>
      <div class="nav-links">
        <ul class="flex">
          <li><a href="../hompage/optionalhome.php" class="hover-links">Home</a></li>
          <li><a href="candidate.php" class="hover-links">Candidates</a></li>
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
        <div class="notice-section">
          <?php
          $sql = "SELECT * FROM notice";
          $details = $conn->query($sql);
          if (mysqli_num_rows($details) > 0) {
            while ($row = mysqli_fetch_assoc($details)) {
              ?>
              <div class="notice">
                <p style="text-align:center; ">
                  <?php echo $row['Title'];?>
                </p>
                <p>
                  <?php echo $row['content']; ?>
                </p>
              </div>
              <?php
            }
          } else {
            ?>
            <p>No notice available.</p>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <div class="custom-shape-divider-bottom-1688894802">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path
          d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
          class="shape-fill"></path>
      </svg>
    </div>
  </header>
</body>
</html>
