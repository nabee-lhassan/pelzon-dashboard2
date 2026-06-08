<?php
include '../conection.php';

header("Content-Type: application/json");

$select = "
    SELECT 
        cat_id,
        cat_name
    FROM category 
    ORDER BY cat_id DESC
";

$query = mysqli_query($conn, $select);

if ($query) {
    $output = mysqli_fetch_all($query, MYSQLI_ASSOC);
    echo json_encode($output);
} else {
    echo json_encode([]);
}
?>