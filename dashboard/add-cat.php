<?php
include '../conection.php';

include 'sidebar.php';


if (isset($_POST['add'])){

  $cate = mysqli_real_escape_string($conn,$_POST['cate']);

  // $select = "SELECT * FROM category WHERE cat_name = '$cate'";
  $select = "SELECT * FROM category WHERE cat_name = '$cate' AND author_id = '$user_id';";

  $query = mysqli_query($conn, $select);

  $row = mysqli_num_rows($query);

  if ($row){


  //   echo '<script>
  //   alert("this category is already added")
  // </script>';


  
  $msg = '<div class="alert alert-info" role="alert">
  This category is already added
</div>';

  $_SESSION ["msg"] = $msg;

  header("location: add-cat.php");

  }else{

    $insert = "INSERT INTO category (cat_name, Author_id)  VALUES ('$cate', '$user_id') ";
    $insert_query = mysqli_query($conn, $insert);

    if($insert_query){
    //   echo '<script>
    //   alert("Category is added successfully")
    // </script>';
    header("location:category.php");

$msg = '<div class="alert alert-success" role="alert">
Category is added successfully

</div>

<a class="btn btn-primary mx-3" href="category.php">View Category </a>
';



$_SESSION ["msg"] = $msg;

header("location: add-cat.php");
    }
    else{
  //     echo '<script>
  //   alert("Something went wrong")
  // </script>';



  $msg = '<div class="alert alert-warning" role="alert">
  Something went wrong
  </div>';

  $_SESSION ["msg"] = $msg;

  header("location: add-cat.php");

    }

    
  }




  
}






// // echo $_SESSION['admin'];
// if (isset($_SESSION['admin'])){

//   if(isset($_POST['logout'])){
//     session_destroy();
//     header("Location:../login.php");
//   }
// }else{

// echo 'You have log out';
// header("Location:../login.php");
// }


?>

  <div class="wrapper">





    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->



      <!-- content body  -->

      <div class="container">
        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">

            <div class="mb-3 " style="background-color: #e9e9e9; width: 50%; padding: 20px; box-shadow: 0px 0px 6px 0px gray;">
              
            <form action="" method="POST">

            <label for="formGroupExampleInput" class="form-label"></label>
              <input type="text" class="form-control" name="cate" id="formGroupExampleInput"
                placeholder="Enter Category">
<button name="add" class="btn btn-primary m-2">Add</button>
            </form>

            
            </div>


          </div>

      
        </div>




      </div>


    </div>
    <!-- /.content-wrapper -->

    <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2023 Pelzon</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer> -->

  </div>
  <!-- ./wrapper -->

  <?php
  include 'footer.php';
  ?>
