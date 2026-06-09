<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conection.php';

header("Content-Type: application/json");

$debug = [];

// Check connection database
$dbResult = mysqli_query($conn, "SELECT DATABASE() AS db_name");
$debug['connected_database'] = $dbResult ? mysqli_fetch_assoc($dbResult)['db_name'] : mysqli_error($conn);

// Count all blogs
$countAll = mysqli_query($conn, "SELECT COUNT(*) AS total FROM blogs");
$debug['total_blogs'] = $countAll ? mysqli_fetch_assoc($countAll)['total'] : mysqli_error($conn);

// Count published blogs
$countPublished = mysqli_query($conn, "SELECT COUNT(*) AS total FROM blogs WHERE status = 'published'");
$debug['published_blogs'] = $countPublished ? mysqli_fetch_assoc($countPublished)['total'] : mysqli_error($conn);

$select = "
    SELECT 
        blogs.id,
        blogs.category_id,
        blogs.title,
        blogs.slug,
        blogs.short_description,
        blogs.content,
        blogs.featured_image,
        blogs.image_alt,
        blogs.meta_title,
        blogs.meta_description,
        blogs.meta_keywords,
        blogs.canonical_url,
        blogs.status,
        blogs.views,
        blogs.created_at,
        blogs.updated_at,
        category.cat_name AS category_name,
        category.cat_slug AS category_slug
    FROM blogs
    LEFT JOIN category 
        ON blogs.category_id = category.cat_id
    WHERE blogs.status = 'published'
    ORDER BY blogs.created_at DESC
";

$query = mysqli_query($conn, $select);

if ($query) {

    $output = mysqli_fetch_all($query, MYSQLI_ASSOC);

    echo json_encode([
        "status" => true,
        "message" => "API working",
        "debug" => $debug,
        "data" => $output
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Query failed: " . mysqli_error($conn),
        "debug" => $debug,
        "data" => []
    ]);
}
?>