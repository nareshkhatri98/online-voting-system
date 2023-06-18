<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Home</title>
  <link rel="stylesheet" href="../cssfolder/first.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
  <link rel="stylesheet" href="../cssfolder/style.css">
</head>
<body>
  <section id="header">
    <a href="../hompage/home_page.html"><h1 class="logo">Go Vote</h1></a>
    <div>
      <ul id="navbar">
        <li><a href="../hompage/home_page.html">Home</a></li>
        <li><a href="about.html">About us</a></li>
        <li><a href="" id="user-icon"><i class="fas fa-user"></i></a> </li>
      </ul>
   </div>
   </section>
   <div class="form-container">

   <form action="login_page.php" method="post" class="form-only">
      <h3>login</h3>
     
      <input type="text" name="phone" pattern="[0-9]{10}$" required placeholder="enter your phone">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="Register-page.php">register here</a></p>
   </form>
   </div>
   
</body>
   </html>
   <?php
   include "../Admin/inc/connection.php";
session_start();

if (isset($_POST['submit'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = md5($_POST['password']);


    // Select Query  
    $select = "SELECT * FROM users WHERE phone = '$phone' && password = '$password' ";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_role'] == 'admin') {
            $_SESSION['admin'] = $row['fullname'];
            $_SESSION['id'] = $row['id']; 
            echo '
            <script>
                alert("login sucessfull");
                window.location ="../Admin/dashboard.php";
            </script>
            ';
            
        } elseif ($row['user_role'] == 'User') {
            $_SESSION['User'] = $row['fullname'];
            $_SESSION['id'] = $row['id']; 
            echo '
            <script>
                alert("login sucessfull");
                window.location ="../voters/dashboard.php";
            </script>
            ';
            
        }
    } else {
      echo '
      <script>
          alert("Invalide username and password");
          window.location = "login_page.php";
      </script>
      ';
    }
}
?>
