<?php
session_start();
include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

include 'sidebar.php';

$BlogId = $_GET['id'];
// echo 'fdsfsfsdf' . $BlogId;


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

      $Update = "UPDATE blog
      SET Blog_title = '$title',
          Blog_body = '$body',
          Blog_image = '$fileName',
          category = '$cat'
      WHERE blog_id = $id ";

      $query = mysqli_query($conn, $Update);

      if ($query) {

        ?>
        <script>
          alert('Blog added Successfully')

        </script>
        <?php
      } else {
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



}








// echo $BlogId ;

?>

<div class="wrapper">




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


          $select = "SELECT * FROM blog
          LEFT JOIN category ON blog.category = category.id
          LEFT JOIN login ON blog.Author_id = login.id
          WHERE blog.Author_id = $user_id AND Blog_id = $BlogId";
          $query = mysqli_query($conn, $select);



          $row = mysqli_fetch_array($query);

          $in_place = $row['Blog_title'];
          $tex_place = $row['Blog_body'];
          $image_place = $row['Blog_image'];



          ?>

          <div class="mb-3"
            style="background-color: #e9e9e9; width: 50%; padding: 20px; box-shadow: 0px 0px 6px 0px gray;">


            <form action="" method="POST" enctype="multipart/form-data">

              <label for="formGroupExampleInput" class="form-label"></label>
              <?php



              // $select = "SELECT * FROM category  WHERE Blog_id = $BlogId";
              $select = "SELECT * FROM blog
              LEFT JOIN category ON blog.category = category.id
              LEFT JOIN login ON blog.Author_id = login.id
              WHERE  blog.Author_id = $user_id";
              $query = mysqli_query($conn, $select);

              $cat_place = $row['cat_name'];


              ?>

              <?php


              ?>
              <input type="text" class="form-control" value="<?= $in_place ?>" name="Blog_title"
                id="formGroupExampleInput" placeholder="Blog Title">
              <textarea name="Blog_body" id="" class="form-control mt-3" cols="30"
                rows="7"> <?= $tex_place ?></textarea>
              <input type="file" name="image" value="<?= $image_place ?>" class="form-control mt-3" id="">
              <img width="50px" src="image/<?= $image_place ?>" alt="">

              <?= $big_file ?>
              <?= $file_type ?>

              <select name="Blog_cat" class="form-control mt-3" id="">

                <?php
                while ($row = mysqli_fetch_array($query)) {
                  ?>
                  <option value="<?= $row['id'] ?>" <?php

                    if ($row['cat_name'] == $row['id']) {
                      echo ' selected="selected"';
                    } else {
                      echo ' ';
                    }

                    ?>>
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