<?php
include '../conection.php';
include 'sidebar.php';

function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

if (isset($_POST['add'])) {

    $cate = mysqli_real_escape_string($conn, $_POST['cate']);
    $cate = trim($cate);

    if (empty($cate)) {
        $_SESSION["msg"] = '<div class="alert alert-warning" role="alert">Please enter category name.</div>';
        header("Location: add-cat.php");
        exit;
    }

    $cat_slug = createSlug($cate);

    // Check duplicate category
    $select = "SELECT * FROM category WHERE cat_name = '$cate' OR cat_slug = '$cat_slug'";
    $query = mysqli_query($conn, $select);

    if (mysqli_num_rows($query) > 0) {

        $_SESSION["msg"] = '<div class="alert alert-info" role="alert">
            This category is already added.
        </div>';

        header("Location: add-cat.php");
        exit;

    } else {

        $insert = "INSERT INTO category (cat_name, cat_slug, status) 
                   VALUES ('$cate', '$cat_slug', 'active')";

        $insert_query = mysqli_query($conn, $insert);

        if ($insert_query) {

            $_SESSION["msg"] = '<div class="alert alert-success" role="alert">
                Category added successfully.
            </div>';

            header("Location: category.php");
            exit;

        } else {

            $_SESSION["msg"] = '<div class="alert alert-warning" role="alert">
                Something went wrong: ' . mysqli_error($conn) . '
            </div>';

            header("Location: add-cat.php");
            exit;
        }
    }
}
?>

<div class="wrapper">

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Category</h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="category.php" class="btn btn-secondary">View Categories</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-lg-6">

                        <?php
                        if (isset($_SESSION["msg"])) {
                            echo $_SESSION["msg"];
                            unset($_SESSION["msg"]);
                        }
                        ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Category Details</h3>
                            </div>

                            <div class="card-body">

                                <form action="" method="POST">

                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="cate" 
                                            placeholder="Enter Category Name"
                                            required
                                        >
                                    </div>

                                    <button name="add" type="submit" class="btn btn-primary">
                                        Add Category
                                    </button>

                                    <a href="category.php" class="btn btn-secondary">
                                        Go Back
                                    </a>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </div>

</div>

<?php include 'footer.php'; ?>