<?php

include '../conection.php';

// error_reporting(E_ERROR | E_PARSE);

include 'sidebar.php';



if (isset($_SESSION['admin'])) {



} else {

  ?>
  <script>
    alert('not getting user data')
  </script>
  <?php

}


if (isset($_POST['add_blog'])) {

  $title = mysqli_real_escape_string($conn, $_POST['Blog_title']);
  $body = mysqli_real_escape_string($conn, $_POST['Blog_body']);
  $cat = mysqli_real_escape_string($conn, $_POST['Blog_cat']);

  $fileName = $_FILES['image']['name'];
  $fileTemp = $_FILES['image']['tmp_name'];
  $fileSize = $_FILES['image']['size'];

  $image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


  $allowed_types = ['png', 'jpg', 'jpeg'];

  $destination = "image/" . $fileName;


  if (in_array($image_ext, $allowed_types)) {



    if ($fileSize <= 2000000) {
      move_uploaded_file($fileTemp, $destination);



      $insert = "INSERT INTO blog (Blog_title, Blog_body, Blog_image, category, Author_id) 
           VALUES ('$title', '$body', '$fileName', '$cat', '$user_id')";

      $insert_query = mysqli_query($conn, $insert);


      if ($insert_query) {
        $msg = '<div class="alert alert-success" role="alert">
        Blog Added Successfully
      </div>';

        $_SESSION["msg"] = $msg;
        header("Location:Blog.php");
      } else {

        $msg = '<div class="alert alert-danger" role="alert">
        Oops! Something went wrong
      </div>';

        $_SESSION["msg"] = $msg;
        header("Location:add-blog.php");
      }

    } else {

      $big_file = '<p style="color:red;">File Limit 200mb </p>';

      $_SESSION["alert"] = $big_file;

    }


  } else {

    $big_file = '<p style="color:red;"> Only allowed jpeg, png, jpg </p>';

    $_SESSION["alert"] = $big_file;
  }



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
            <h1 class="m-0">Dashboard </h1>
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
              <input type="text" class="form-control" value="" name="Blog_title" id="formGroupExampleInput"
                placeholder="Blog Title">

              <textarea name="Blog_body" id="" class="form-control mt-3" cols="30" rows="7"></textarea>
              <input type="file" name="image" class="form-control mt-3" id="">

              <?php

              if (isset($_SESSION['alert'])) {
                $message = $_SESSION['alert'];
                echo $message;

                unset($_SESSION['alert']);
                // header("Location:add-cat.php");
              }

              ?>


              <select name="Blog_cat" class="form-control mt-3" id="">

                <option value=""> Select Category</option>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?= $row['cat_id'] ?>">
                    <?= $row['cat_name'] ?>
                  </option>
                  <?php

                }

                ?>

              </select>

              <button name="add_blog" class="btn btn-primary m-2">Add</button>
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



?>