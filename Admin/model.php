<?php
class Model {
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $dbname = "onlinevoting";
  private $conn;

//connection..
  function __construct() {
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    if ($this->conn->connect_error) {
      echo "Connection fail";
    } else {
   #   echo "Connected successfully";
    }
  }

  #fetch the data for edit..

  function displayRecodrById($editid) {
    $sql = "SELECT * FROM products WHERE product_id = '$editid'";
    $result = $this->conn->query($sql);
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      return $row;
    }
    
  }
  #update query
  function updateproduct($id) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $admin = $_SESSION['admin'];
  
    $update_data = "UPDATE notice SET Title='$title', content='$content' WHERE id = '$id'";
    $result = $this->conn->query($update_data);
    if ($result) {
     
      header('location: notice.php');
    } else {
      echo "Error updating product";
    }
  }
# Delete Query
  function DeleteProduct($deleteid){
    $sql ="DELETE FROM notice WHERE id = '$deleteid'";
    $result = $this->conn->query($sql);
    if($result){
      header('location:abcd.php');
    }

  }
}

$obj = new Model(); 
#check for update form..
if (isset($_POST['update_notice'])) {
  $editid = $_GET['edit'];
  $obj->updateproduct($editid);
}
#checjk for the delter botton..
if(isset($_POST['delete']))
{
  $deleteid = $_GET['delete'];
  $obj -> DeleteProduct($deleteid);
}
?>
