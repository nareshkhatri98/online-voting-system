<?php
@include 'inc/connection.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){

  $election_topic = mysqli_real_escape_string($conn, $_POST['election_topic']);
  $number_of_candidates = mysqli_real_escape_string($conn, $_POST['number_of_candidates']);
  $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
  $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);

   if(empty($election_topic ) || empty($number_of_candidates) || empty($starting_date) || empty($ending_date)){
      $message[] = 'please fill out all!';    
   }else{

      $update_data = "UPDATE products SET election_topic='$election_topic', no_of_candidates='$number_of_candidates', starting_date='$starting_date', ending_date='$ending_date'  WHERE election_id = '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         header('location:addelection.php');
      }else{
         $$message[] = 'please fill out all!'; 
      }

   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../cssfolder/election.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM elections WHERE election_id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">update the product</h3>
      <label for="">Election_Topic</label>
          <input type="text" placeholder="enter election topic" name="election_topic" class="box">
          <label for="">Number of Candidate</label>
            <input type="number" placeholder="Number of candidates" name="number_of_candidates" class="box">
            <label for="">Starting_Date</label>
            <input type="date" placeholder="starting date" name="starting_date" class="box">
           <input type="date" placeholder="ending date" name="ending_date" class="box">
           <label for="">Ending_Date</label>
      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="addelection.php" class="btn">go back!</a>
   </form>
   


   <?php }; ?>

   

</div>

</div>

</body>
</html>