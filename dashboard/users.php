<?php 

include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

include 'sidebar.php';
 
// $user_id = $_SESSION['admin'][0];

if ($user_id != 1) {
  header('Location:admin.php');
}

// $image ;

$AdminCount = 1;


?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <?php 
  
  

  $select = "SELECT * FROM login  ";

  $query = mysqli_query($conn,$select);

  




  
  ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Blog</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

<div class="container">





<form action="" method="POST">
  <div class="row">
    <div class="col-lg-12">
    <table class="table">
 
    <thead>
    <tr>
      <th scope="col" style="width:10px;">SR.NO</th>
      
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">image</th>
      <th scope="col">Roll</th>
      <th scope="col">Publish Date</th>
      
      
   
      <!-- <th scope="col" style="width:10px;"></th> -->
      <th scope="col"><button class="btn btn-danger delete-all-btn" onclick=" return confirm('Are Your sure you Want To Delete')" name="delete_data" >Delete</button></th>
    </tr>
  </thead>

 
  <?php   
  
// SR NO counter 

  $SR = 0;
  
  while ($row = mysqli_fetch_array($query)){

    if($row > 0){
      // $id = $_GET ['id'];
      $dateFromDatabase = $row['Publish_data'];
      $formattedDate = date("Y-m-d ", strtotime($dateFromDatabase));
      $formattedTime = date("i:s", strtotime($dateFromDatabase));


      // $image_name = $row['user_image'];

      $userRoll = $row['id']

?>


  <tbody>

<tr>
  <td ><?php echo ++$SR; ?></td>
  <td><?php echo $row['username'] ?></td>

<?php 


?>

  <td><?php echo $row['email'] ?></td>
  <td> <img width="50px" src="../image/<?php echo $row['user_image'] ?>" alt=""> </td>
  <td><?= ($userRoll == 1) ? (($userRoll == $user_id) ? 'Admin<br>You Are Logged in' : 'Admin') : (($userRoll == $_SESSION['admin'][0]) ? 'User<br>You Are Logged in' : 'User') ?></td>

  <td><?php echo $formattedDate  ?></td>
 
  <!-- <td>   <button class="btn btn-success" name="single_del" >Delete</button>  </td> -->
  
  <td style="width:10px;"><input type="checkbox" name="id[]" value="<?= $row['id'] ?>" class="single_check"></td>
  
      
    </tr>

<?php
    }else {

      
?>

<p>No Data </p>
   

<?php

    }

     
  }
  
  
  
  ?>
  
  
    
  </tbody>
</table>
    </div>
  </div>
  </form>
</div>

    </div>
    <!-- /.content-header -->

    
  </div>
  <!-- /.content-wrapper -->
  
</div>
<!-- ./wrapper -->
<?php 
// Delete All Categories Functionality start

if (isset($_POST['delete_data'])){
  
  $allId = $_POST['id'];
  



  if(empty($allId)){
  
?>

<script>
    alert("Oops! No Data to Delete")
      window.location.href="category.php";
    </script>
<?php

  }else{

    $extract_id = implode(',',$allId);
    $delete = "DELETE FROM login WHERE id IN( $extract_id)";

    $query = mysqli_query($conn,$delete);
   
unlink("../image/" .$image_name);


  
  
  if($query){
    $msg = '<div class="alert alert-success" role="alert">
    User Deleted successfully
    </div>';
    $_SESSION['msg'] = $msg;
  
    header("Location:users.php");
  }else{
    $msg = '<div class="alert alert-success" role="alert">
    Oops User Not Deleted 
    </div>';
    $_SESSION['msg'] = $msg;
  
    header("Location:users.php");
  }
  }



}





include 'footer.php';
?>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>




