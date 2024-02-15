<?php
include '../conection.php';



$select = "SELECT * FROM category ORDER BY cat_id DESC";

$response = array();

$query = mysqli_query($conn, $select);

if ($query){

  header("Content-Type: application/json"); // Fix the header content type

$output = mysqli_fetch_all($query, MYSQLI_ASSOC);

 

echo json_encode($output);


  // while ($row = mysqli_fetch_assoc($query)){

  //   $category = array(
  //     'Blog_id' => $row['Blog_id'],
  //     'Blog_title' => $row['Blog_title'],
  //     'Blog_body' => $row['Blog_body'],
  //     'Blog_image' => $row['Blog_image'],
  //     'Blog_Category' => $row['category'],
  //   );

  //   $response[] = $category;
  // }

  
}



?>