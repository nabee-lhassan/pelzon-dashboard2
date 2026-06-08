<?php 
include '../conection.php';

error_reporting(E_ERROR | E_PARSE);

/* =========================
   DELETE SELECTED CATEGORIES
========================= */

if (isset($_POST['delete_data'])) {

    if (empty($_POST['cat_id'])) {
        echo '
        <script>
            alert("Oops! No category selected to delete");
            window.location.href="category.php";
        </script>';
        exit;
    }

    $allId = $_POST['cat_id'];

    // Safe integer IDs
    $allId = array_map('intval', $allId);
    $extract_id = implode(',', $allId);

    /*
      Optional safety:
      Agar category kisi blog me use ho rahi hai,
      to delete karne se pehle blogs ko Uncategorized kar do.
    */
    $updateBlogs = "UPDATE blogs SET category_id = NULL WHERE category_id IN ($extract_id)";
    mysqli_query($conn, $updateBlogs);

    $delete = "DELETE FROM category WHERE cat_id IN ($extract_id)";
    $deleteQuery = mysqli_query($conn, $delete);

    if ($deleteQuery) {
        echo '
        <script>
            alert("Selected categories deleted successfully");
            window.location.href="category.php";
        </script>';
        exit;
    } else {
        echo '
        <script>
            alert("Something went wrong while deleting");
            window.location.href="category.php";
        </script>';
        exit;
    }
}

include 'sidebar.php';

/* =========================
   FETCH CATEGORIES
========================= */

$select = "SELECT * FROM category ORDER BY created_at DESC";
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
                        <h1 class="m-0">Category</h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="./add-cat.php" class="btn btn-primary">
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
                                        <th>Category</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th style="width:10px;">Action</th>
                                        <th style="width:10px;">
                                            <button 
                                                type="submit"
                                                class="btn btn-danger btn-sm delete-all-btn" 
                                                onclick="return confirm('Are you sure you want to delete selected categories?')" 
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

                                            $createdDate = !empty($row['created_at'])
                                                ? date("Y-m-d", strtotime($row['created_at']))
                                                : '-';

                                            $status = !empty($row['status']) 
                                                ? $row['status'] 
                                                : 'active';
                                    ?>

                                    <tr>
                                        <td><?php echo ++$SR; ?></td>

                                        <td>
                                            <?php echo htmlspecialchars($row['cat_name']); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($row['cat_slug'] ?? '-'); ?>
                                        </td>

                                        <td>
                                            <?php if ($status == 'active') { ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php } else { ?>
                                                <span class="badge badge-warning">Inactive</span>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <?php echo $createdDate; ?>
                                        </td>

                                        <td>
                                            <a class="btn btn-success btn-sm" href="edit.php?id=<?php echo $row['cat_id']; ?>">
                                                Edit
                                            </a>
                                        </td>

                                        <td>
                                            <input 
                                                type="checkbox" 
                                                name="cat_id[]" 
                                                value="<?php echo $row['cat_id']; ?>" 
                                                class="single_check"
                                            >
                                        </td>
                                    </tr>

                                    <?php 
                                        }
                                    } else {
                                    ?>

                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No Category Data Found
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