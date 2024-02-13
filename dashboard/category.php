<?php 

include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

include 'sidebar.php';




?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <?php 
  
  $select = "SELECT * FROM category WHERE Author_id = $user_id";

  $query = mysqli_query($conn,$select);

// Delete All Categories Functionality start

if (isset($_POST['delete_data'])){
  
  $allId = $_POST['cat_id'];
  



  if(empty($allId)){
  
?>

<script>
    alert("Oops! No Data to Delete")
      window.location.href="category.php";
    </script>
<?php

  }else{

    $extract_id = implode(',',$allId);
    $delete = "DELETE FROM category WHERE cat_id IN( $extract_id)";

    $query = mysqli_query($conn,$delete);
  
  if($query){
  
    header("Location:category.php");
  }else{
    echo '<script>
  
    alert("Something went wrong")
    </script>';
  }
  }



}

// Delete All Categories Functionality end

// Delete one item Categories Functionality start

// if (isset($_POST['single_del'])){
  
//   $id = $_GET['id'];
  
//     $delete = "DELETE FROM category WHERE id = $id ";

//     $query = mysqli_query($conn,$delete);
  
//   if($query){
  
//     header("Location:category.php");
//   }else{
//     echo '<script>
  
//     alert("Something went wrong")
//     </script>';
//   }
//   }






// Delete one item Categories Functionality end

  
  ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

<div class="container">
<div class="row">
  <div class="col-lg-12">
    <a href="./add-cat.php" class="btn btn-primary m-3">Add New</a>
  </div>
</div>




<form action="" method="POST">
  <div class="row">
    <div class="col-lg-12">
    <table class="table">
 
    <thead>
    <tr>
      <th scope="col" style="width:10px;">SR.NO</th>
      
      <th scope="col">Category</th>
      
      
      <th scope="col" style="width:10px;">Action</th>
      <!-- <th scope="col" style="width:10px;"></th> -->
      <th scope="col"><button class="btn btn-danger delete-all-btn" onclick=" return confirm('Are Your sure you Want To Delete')" name="delete_data" >Delete</button></th>
    </tr>
  </thead>

 
  <?php   
  
// SR NO counter 
  $SR = 0;
  
  
  if(mysqli_num_rows($query) > 0){
      while ($row = mysqli_fetch_array($query)){
      // $id = $_GET ['id'];
      

?>


  <tbody>

<tr>
  <td ><?php echo ++$SR; ?></td>
  <td><?php echo $row['cat_name'] ?></td>
  <td><a class="btn btn-success" href="edit.php?id=<?= $row ['cat_id'] ?>">Edit</a>  </td>
  <!-- <td>   <button class="btn btn-success" name="single_del" >Delete</button>  </td> -->
  
  <td style="width:10px;"><input type="checkbox" name="cat_id[]" value="<?= $row['cat_id'] ?>" class="single_check"></td>
  
      
    </tr>

   

<?php
}
    }
    else {

      
?>

<p style="text-align:center;background-color: #ad390663;padding: 7px 0px; font-size: 19px;font-weight: 600;"><?php echo "No data Found" ?></p>

<?php

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




