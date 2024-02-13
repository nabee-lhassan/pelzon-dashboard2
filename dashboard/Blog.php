<?php 

include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

include 'sidebar.php';

// $image ; 


?>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <?php 
  
  

  $select = "SELECT * FROM blog
  LEFT JOIN category ON blog.category = category.cat_id
  LEFT JOIN login ON blog.Author_id = login.id
  WHERE blog.Author_id = $user_id ORDER BY blog.Publish_data DESC";

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
<div class="row">
  <div class="col-lg-12">
    <a href="./add-blog.php" class="btn btn-primary m-3">Add New</a>
  </div>
</div>




<form action="" method="POST">
  <div class="row">
    <div class="col-lg-12">
    <table class="table">
 
    <thead>
    <tr>
      <th scope="col" style="width:10px;">SR.NO</th>
      
      <th scope="col">Title</th>
      <th scope="col">Body</th>
      <th scope="col">image</th>
      <th scope="col">Category</th>
      <th scope="col">Publish Date</th>
      
      
      <th scope="col" style="width:10px;">Action</th>
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


      $image_name = $row['Blog_image']

?>


  <tbody>

<tr>
  <td ><?php echo ++$SR; ?></td>
  <td><?php echo $row['Blog_title'] ?></td>

<?php 
$maxContentLength = 40; // Set your desired content limit

$content = $row['Blog_body']; // Replace this with your actual content

$body_content =  strlen($content) > $maxContentLength ? substr($content, 0, $maxContentLength) : $content;


?>

  <td><?php echo $body_content ?></td>
  <td> <img width="50px" src="image/<?php echo $image_name ?>" alt=""> </td>
  <td><?php echo $row['cat_name'] ?></td>

  <td><?php echo $formattedDate  ?></td>
  <td><a class="btn btn-success" href="edit-blog.php?id=<?= $row ['Blog_id'] ?>">Edit</a>  </td>
  <!-- <td>   <button class="btn btn-success" name="single_del" >Delete</button>  </td> -->
  
  <td style="width:10px;"><input type="checkbox" name="cat_id[]" value="<?= $row['Blog_id'] ?>" class="single_check"></td>
  
      
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
    $delete = "DELETE FROM blog WHERE Blog_id IN( $extract_id)";

    $query = mysqli_query($conn,$delete);
   
unlink("image/" .$image_name);


  
  
  if($query){
  
    header("Location:Blog.php");
  }else{
    echo '<script>
  
    alert("Something went wrong")
    </script>';
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




