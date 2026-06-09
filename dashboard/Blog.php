<?php 
include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

/* =========================
   DELETE SELECTED BLOGS
========================= */

if (isset($_POST['delete_data'])) {

    if (empty($_POST['blog_id'])) {
        echo '
        <script>
            alert("Oops! No blog selected to delete");
            window.location.href="blog.php";
        </script>';
        exit;
    }

    $allId = $_POST['blog_id'];

    // Safe IDs
    $allId = array_map('intval', $allId);
    $extract_id = implode(',', $allId);

    // Fetch images before deleting blogs
    $imageSelect = "SELECT featured_image FROM blogs WHERE id IN ($extract_id)";
    $imageQuery = mysqli_query($conn, $imageSelect);

    if ($imageQuery) {
        while ($imageRow = mysqli_fetch_assoc($imageQuery)) {
            if (!empty($imageRow['featured_image'])) {
                $imagePath = "image/" . $imageRow['featured_image'];

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
    }

    // Delete selected blogs
    $delete = "DELETE FROM blogs WHERE id IN ($extract_id)";
    $deleteQuery = mysqli_query($conn, $delete);

    if ($deleteQuery) {
        echo '
        <script>
            alert("Selected blogs deleted successfully");
            window.location.href="blog.php";
        </script>';
        exit;
    } else {
        echo '
        <script>
            alert("Something went wrong while deleting");
            window.location.href="blog.php";
        </script>';
        exit;
    }
}

include 'sidebar.php';

/* =========================
   FETCH BLOGS
========================= */

$select = "
    SELECT 
        blogs.*,
        category.cat_name AS category_name
    FROM blogs
    LEFT JOIN category 
        ON blogs.category_id = category.cat_id
    ORDER BY blogs.created_at DESC
";

$query = mysqli_query($conn, $select);

if (!$query) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">Blog</h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="./add-blog.php" class="btn btn-primary">
                            Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <form action="" method="POST">

                    <div class="card">
                        <div class="card-body">

                            <table class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th style="width:10px;">SR.NO</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Publish Date</th>
                                        <th style="width:10px;">Action</th>
                                        <th style="width:10px;">
                                            <button 
                                                type="submit"
                                                class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete selected blogs?')" 
                                                name="delete_data"
                                            >
                                                Delete
                                            </button>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php   
                                    $SR = 0;

                                    if (mysqli_num_rows($query) > 0) {

                                        while ($row = mysqli_fetch_assoc($query)) {

                                            $formattedDate = !empty($row['created_at'])
                                                ? date("Y-m-d", strtotime($row['created_at']))
                                                : '-';

                                            $image_name = $row['featured_image'];

                                            $maxContentLength = 40;
                                            $content = strip_tags($row['content']);

                                            $body_content = strlen($content) > $maxContentLength 
                                                ? substr($content, 0, $maxContentLength) . '...' 
                                                : $content;

                                            $category_name = !empty($row['category_name']) 
                                                ? $row['category_name'] 
                                                : 'Uncategorized';
                                    ?>

                                    <tr>
                                        <td><?php echo ++$SR; ?></td>

                                        <td>
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($body_content); ?>
                                        </td>

                                        <td>
                                            <?php if (!empty($image_name)) { ?>
                                                <img 
                                                    width="50" 
                                                    height="50"
                                                    style="object-fit:cover;"
                                                    src="image/<?php echo htmlspecialchars($image_name); ?>" 
                                                    alt="<?php echo htmlspecialchars($row['image_alt'] ?? $row['title']); ?>"
                                                >
                                            <?php } else { ?>
                                                No Image
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($category_name); ?>
                                        </td>

                                        <td>
                                            <?php if ($row['status'] == 'published') { ?>
                                                <span class="badge badge-success">Published</span>
                                            <?php } else { ?>
                                                <span class="badge badge-warning">Draft</span>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <?php echo $formattedDate; ?>
                                        </td>

                                        <td>
                                            <a class="btn btn-success btn-sm" href="edit-blog.php?id=<?php echo $row['id']; ?>">
                                                Edit
                                            </a>
                                            <a 
                                                class="btn btn-danger btn-sm" 
                                                href="trash.php?id=<?php echo $row['id']; ?>&action=delete" 
                                                onclick="return confirm('Are you sure you want to delete this blog?')"
                                            >
                                                Delete
                                            </a>
                                        </td>

                                        <td>
                                            <input 
                                                type="checkbox" 
                                                name="blog_id[]" 
                                                value="<?php echo $row['id']; ?>" 
                                                class="single_check"
                                            >
                                        </td>
                                    </tr>

                                    <?php 
                                        }

                                    } else {
                                    ?>

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No Blog Data Found
                                        </td>
                                    </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>
                    </div>

                </form>

            </div>
        </section>

    </div>

</div>

<?php include 'footer.php'; ?>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>