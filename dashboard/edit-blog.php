<?php
session_start();
include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

include 'sidebar.php';

$BlogId = $_GET['id'];

if (empty($iBlogId)) {
  header('Location:Blog.php');
}




if (isset($_SESSION['admin'])) {



} else {

  ?>
  <script>
    alert('not getting user data')
  </script>
  <?php

}






$select2 = " SELECT * FROM blog
  LEFT JOIN category ON blog.category = category.cat_id
  LEFT JOIN login ON blog.Author_id = login.id
  WHERE Blog_id = $BlogId ";

$query2 = mysqli_query($conn, $select2);

$result = mysqli_fetch_array($query2);


?>

<div class="wrapper">


  <!-- <?= $user ?> -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard
              <?= $BlogId ?>
            </h1>
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

          <?php
          $select = "SELECT * FROM category  WHERE Author_id = $user_id ";
          $query = mysqli_query($conn, $select);

          ?>

          <div class="mb-3"
            style="background-color: #e9e9e9; width: 50%; padding: 20px; box-shadow: 0px 0px 6px 0px gray;">


            <form action="" method="POST" enctype="multipart/form-data">


              <label for="formGroupExampleInput" class="form-label"></label>
              <input type="text" class="form-control" value="<?= $result['Blog_title'] ?>" name="blog_title"
                id="formGroupExampleInput" placeholder="Blog Title">

              <textarea name="blog_body" id="" class="form-control mt-3" cols="30"
                rows="7"> <?= $result['Blog_body'] ?> </textarea>
              <input type="file" name="image" class="form-control mt-3" id="">
              <img width="70px" src="image/<?= $result['Blog_image'] ?>" alt="">

               <!-- <?= $big_file ?>
              <?= $file_type ?>  -->

              <select name="blog_cat" class="form-control mt-3" id="">



                <?php
                while ($row = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?= $row['cat_id'] ?>" <?= ($result['category'] == $row['cat_id']) ? 'selected' : '';
                    ?>>
                    <?= $row['cat_name'] ?>
                  </option>
                  <?php

                }

                ?>

              </select>

              <button name="update_blog" class="btn btn-primary m-2">Update</button>
              <a href="./admin.php" class="btn btn-secondary m-2">Go back</a>
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


if (isset($_POST['update_blog'])) {

  $title = mysqli_real_escape_string($conn, $_POST['blog_title']);
  $body = mysqli_real_escape_string($conn, $_POST['blog_body']);
  $cat = mysqli_real_escape_string($conn, $_POST['blog_cat']);

  $fileName = $_FILES['image']['name'];
  $fileTemp = $_FILES['image']['tmp_name'];
  $fileSize = $_FILES['image']['size'];

  $image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


  $allowed_types = ['png', 'jpg', 'jpeg'];

  $destination = "image/" . $fileName;

  if (!empty($fileName)){

    if (in_array($image_ext, $allowed_types)) {



      if ($fileSize <= 2000000) {
        unlink('image/' . $result['Blog_image']);
        move_uploaded_file($fileTemp, $destination);
  
        $update = "UPDATE blog 
           SET Blog_title = '$title', 
               Blog_body = '$body', 
               Blog_image = '$fileName', 
               category = '$cat', 
               Author_id = '$user_id' 
           WHERE blog_id = '$BlogId'";

            
  
  $query = mysqli_query($conn, $update);
  
        if ($query) {
          
          $msg = '<div class="alert alert-success" role="alert">
          Blog updated successfully
          </div>';
        
          $_SESSION ["msg"] = $msg;
           header('Location:Blog.php');
        }
        else{
          ?>
          <script>
            alert('Oops! Something went wrong')
          </script>
          <?php
        }
  
      } else {
  
        $big_file = ' <p style="color:red;">File Limit 200mb </p>';
      }
  
  
    } else {
  
      $file_type = '<p style="color:red;"> Only allowed jpeg, png, jpg </p>';
  
    }
  }else{
    $update = "UPDATE blog 
    SET Blog_title = '$title', 
        Blog_body = '$body',
        category = '$cat', 
        Author_id = '$user_id' 
    WHERE blog_id = '$BlogId'";

     

$query = mysqli_query($conn, $update);

 if ($query) {
   

  $msg = '<div class="alert alert-success" role="alert">
  Blog updated successfully
  </div>';

  $_SESSION ["msg"] = $msg;
   header('Location:Blog.php');
 }
 else{
   ?>
   <script>
     alert('Oops! Something went wrong')
   </script>
   <?php
 }
  }






}


?>