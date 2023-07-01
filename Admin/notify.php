<?php
  include"inc/connection.php";
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('location:../hompage/login_page.php');
  }
  


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>dashboard</title>
  <!-- custome css -->
  <link rel="stylesheet" href="../cssfolder/dashboard.css">
   <link rel="stylesheet" href="../cssfolder/notice.css">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
  rel="stylesheet">

<body>
<div class="grid-container">

  <!-- header -->
  <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
      <span class="material-icons-outlined">menu</span>
    </div>
    <div class="class-left">
    <h3>Welcome- <smaLL> <?php echo $_SESSION['admin']; ?></smaLL></h3>
      
    </div>
    <div class="class-right">
    <a href="logout.php"><span class="material-icons-outlined" >account_circle </a></span>
      
    </div>
  </header>
  <!-- end header -->

  <!-- slidebar -->
   <aside id="sidebar">
   <div class="sidebar-title">
    <div class="sidebar-brand">
    <a href="dashboard.php">
      <span class="material-icons-outlined">how_to_vote</span></a> Go Vote
    </div>
    <span class="material-icons-outlined" onclick="closeSidebar()">close </span>
   </div>

   <ul class="sidebar-list">
        <li class="sidebar-list-item">
        <span class="material-icons-outlined">dashboard</span> Dashboard</li>

      <li class="sidebar-list-item">
      <a href="addelection.php"> <span class="material-icons-outlined">event_available</span>
        Elections</a>
      </li>
      
     <li class="sidebar-list-item"><a href="addcandidate.php"><span class="material-icons-outlined"> groups</span> Candidates</li></a>
     <li class="sidebar-list-item"> <a href="viewresult.php">
      <span class="material-icons-outlined">visibility</span> View Result</a></li>
    <li class="sidebar-list-item"><a href="notify.php"> <span class="material-icons-outlined">settings </span> Notify</a></li>
   </ul>
  </aside>
  <!-- Endsidebar --> 
  <div class="container">
    <form action="" method="POST">
        <div class="box">
            <h3>Notice Form</h3>
            <div class="name">
               <label for="">Title</label>
                <input type="text" name="title" placeholder="Name" id="name">
            </div>
          
            <div class="message-box">
            <label for="">Content</label>
                <textarea id="msg" name="content" cols="30" rows="10" placeholder="Message"></textarea>
            </div>
            <div class="button">
                <button id="send" onclick="message()" value="submit" name="submit">Submit</button>
            </div>
            <div class="message">
                <div class="success" id="success">Your notice Successfully insert!</div>
                <div class="danger" id="danger">Feilds Can't be Empty!</div>
            </div>
        </div>
    </div>
    </form>


  <!-- end main -->
</div>

<!-- # for data collection -->
<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $admin = $_SESSION['admin'];

  if(empty($title)||empty($contetnt)){
   echo ' <div class="danger" id="danger">Feilds Can not be Empty!</div>';
  }
  else{
  $sql = "INSERT INTO notice (Title, content, inserted_by) VALUES ('$title', '$content', '$admin')";
  $result = $conn->query($sql);
  if ($result) {
    header('location:notify.php');
  }
}
}
?>






<script>
  function message(){
    var Name = document.getElementById('name');
   
    var msg = document.getElementById('msg');
    const success = document.getElementById('success');
    const danger = document.getElementById('danger');

    if(Name.value === '' || email.value === '' || msg.value === ''){
        danger.style.display = 'block';
    }
    else{
        setTimeout(() => {
            Name.value = '';
            email.value = '';
            msg.value = '';
        }, 2000);

        success.style.display = 'block';
    }


    setTimeout(() => {
        danger.style.display = 'none';
        success.style.display = 'none';
    }, 4000);

}
</script>






<!-- custom js -->
  <script src="../assets/js/dashobrd.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
</body>
</body>
</html>