<?php
include '../conection.php';

header("Content-Type: application/json");

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
        "message" => "Published blogs fetched successfully",
        "data" => $output
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "Query failed: " . mysqli_error($conn),
        "data" => []
    ]);
}
?>