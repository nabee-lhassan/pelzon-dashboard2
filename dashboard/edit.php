<?php
include '../conection.php';

include 'sidebar.php';


$id = $_GET['id'];

if (empty($id)){
  header('Location:category.php');
}





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

          <div class="mb-3" style="background-color: #e9e9e9; width: 50%; padding: 20px; box-shadow: 0px 0px 6px 0px gray;">

          <?php 
          
          // getting id which is coming from the details page
          
          




          $select = "SELECT * FROM category WHERE cat_id ='$id'";
          $query = mysqli_query($conn,$select);
          $row = mysqli_fetch_array($query);

          $catName =  $row["cat_name"];


          if(isset($_POST['edit'])){

            $cate = mysqli_real_escape_string($conn, $_POST['cate']) ;
            
            $edit = "UPDATE category SET cat_name='$cate' WHERE cat_id=$id";
          $query = mysqli_query($conn, $edit);


          if ($query){
           
           $msg = '<div class="alert alert-success" role="alert">
           Category Updated Successfully
         </div>';

           $_SESSION ["msg"] = $msg;
           header("Location:category.php");
          }else{

            $msg = '<div class="alert alert-warning" role="alert">
            Oops! Some error occurred
          </div>';
 
            $_SESSION ["msg"] = $msg;
            header("Location:category.php");
            
          }
          }
          ?>

            <form action="" method="POST">


              <label for="formGroupExampleInput" class="form-label"></label>
              <input type="text" class="form-control" value="<?= $catName ?>" name="cate" id="formGroupExampleInput"
                placeholder="Enter Category">
              <button name="edit" class="btn btn-primary m-2">Update</button>
              <a href="./category.php" class="btn btn-secondary m-2">Go back</a>
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