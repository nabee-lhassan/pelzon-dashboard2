<?php
include '../conection.php';

include 'sidebar.php';

// $select = "SELECT * FROM blog LEFT JOIN category ON blog.category=category.id 
// LEFT JOIN login ON blog.Author_id=login.id WHERE Author_id = $user_id";

$select = "SELECT * FROM blog
           LEFT JOIN category ON blog.category = category.cat_id
           LEFT JOIN login ON blog.Author_id = login.id
           WHERE blog.Author_id = '$user_id' ORDER BY blog.Publish_data DESC";

$query = mysqli_query($conn,$select);

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
<?php 

while ($row = mysqli_fetch_array($query)) {
if ($row){


  $maxContentLength = 100; // Set your desired content limit

  $content = $row['Blog_body']; // Replace this with your actual content
  
  $body_content =  strlen($content) > $maxContentLength ? substr($content, 0, $maxContentLength) : $content;
  


  ?>

<div class="col-lg-4">
<div class="card" style="width: 18rem;">
  <img width="300px" src="image/<?= $row['Blog_image'] ?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title" style="font-weight: 700;font-size:12px;"> Category:<?= $row['cat_name'] ?></h5> <br>
    <h5 class="card-title" style="font-weight: 700;font-size:18px;">Title: <?= $row['Blog_title'] ?></h5>
    <p class="card-text"><?= $body_content . '...' ?></p>
    
  </div>
</div>
          </div>
<?php 
}


}


?>

          
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
