<?php
include '../conection.php';

// $select = "SELECT * FROM category";

// $response = array();

// $query = mysqli_query($conn, $select);

// if ($query){

//   header("Content-Type:application/JSON");

//   while ($row = mysqli_fetch_array($query)){

//     $response['category id'] = $row['cat_id'];
//     $response['category Title'] = $row['cat_name'];
   

//   }
// echo json_encode($response,JSON_PRETTY_PRINT);

// }




$select = "SELECT * FROM blog";

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