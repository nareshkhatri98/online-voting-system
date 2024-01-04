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
    .accordion-container {
      margin: 40px auto;
      width: 600px;
    }
    
  .notice-section{
    margin-top: -150px;
  }
    .accordion-container li {
      list-style: none;
      width: 100%;
      margin: 20px;
      padding: 10px;
      border-radius: 8px;
      background: #e3edf7;
      box-shadow: 6px 6px 10px -1px rgba(0, 0, 0, 0.15),
      -6px -6px 10px -1px rgba(225, 225, 225, 0.7);
    }

    .accordion-container li label {
      display: flex;
      align-items: center;
      padding: 10px;
     
      font-size: 20px;
      font-weight: 500;
      cursor: pointer;
    }

    label::before {
      content: '+';
      margin-right: 10px;
      font-size: 25px;
      font-weight: 600;
    }

    input[type="radio"] {
      display: none;
    }

    .accordion-container .content {
      color: #555;
      padding: 0 10px;
      line-height: 26px;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s, padding 0.5s;
    }
    
    .accordion-container input[type="radio"]:checked+label+.content {
      max-height: 400px;
      padding: 10px 10px 20px;
    }

    .accordion-container input[type="radio"]:checked+label::before {
      content: '-';
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
          $totalNotices = mysqli_num_rows($details);

          if ($totalNotices > 0) {
          ?>
            <p style="text-align:center">Available Notices:</p>
            <ul class="accordion-container">
              <?php
              while ($row = mysqli_fetch_assoc($details)) {
              ?>
                <li>
                  <input type="radio" name="accordion" id="notice_<?php echo $row['id']; ?>" checked>
                  <label for="notice_<?php echo $row['id']; ?>"><?php echo $row['Title'] ?></label>
                  <div class="content">
                    <p>
                      <?php echo $row['content'] ?>
                    </p>
                  </div>
                </li>
              <?php
              }
              ?>
            </ul>
          <?php
          } else {
          ?>
            <p>No notices available.</p>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
    <div class="custom-shape-divider-bottom-1688894802">
      <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
      </svg>
    </div>
  </header>
</body>

</html>
