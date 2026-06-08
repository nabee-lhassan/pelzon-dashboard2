<?php
session_start();
include '../conection.php';
include 'sidebar.php';

error_reporting(E_ERROR | E_PARSE);

function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

$BlogId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($BlogId <= 0) {
    header("Location: Blog.php");
    exit;
}

/* DELETE BLOG */
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    
    // Fetch the blog image
    $imageSelect = "SELECT featured_image FROM blogs WHERE id = $BlogId";
    $imageQuery = mysqli_query($conn, $imageSelect);
    
    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
        $imageRow = mysqli_fetch_assoc($imageQuery);
        
        // Delete image file if exists
        if (!empty($imageRow['featured_image'])) {
            $imagePath = "image/" . $imageRow['featured_image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
    
    // Delete the blog
    $delete = "DELETE FROM blogs WHERE id = $BlogId";
    $deleteQuery = mysqli_query($conn, $delete);
    
    if ($deleteQuery) {
        $_SESSION["msg"] = '<div class="alert alert-success">Blog deleted successfully.</div>';
        header("Location: Blog.php");
        exit;
    } else {
        $_SESSION["msg"] = '<div class="alert alert-danger">Failed to delete blog: ' . mysqli_error($conn) . '</div>';
        header("Location: Blog.php");
        exit;
    }
}

/* Fetch blog data */
$select = "SELECT * FROM blogs WHERE id = $BlogId";
$query = mysqli_query($conn, $select);

if (!$query || mysqli_num_rows($query) == 0) {
    $_SESSION["msg"] = '<div class="alert alert-warning">Blog not found.</div>';
    header("Location: Blog.php");
    exit;
}

$blog = mysqli_fetch_assoc($query);

/* Update blog */
if (isset($_POST['update_blog'])) {

    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $slug = mysqli_real_escape_string($conn, trim($_POST['slug']));
    $short_description = mysqli_real_escape_string($conn, trim($_POST['short_description']));
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = !empty($_POST['category_id']) ? (int) $_POST['category_id'] : "NULL";
    $image_alt = mysqli_real_escape_string($conn, trim($_POST['image_alt']));
    $meta_title = mysqli_real_escape_string($conn, trim($_POST['meta_title']));
    $meta_description = mysqli_real_escape_string($conn, trim($_POST['meta_description']));
    $meta_keywords = mysqli_real_escape_string($conn, trim($_POST['meta_keywords']));
    $canonical_url = mysqli_real_escape_string($conn, trim($_POST['canonical_url']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($slug)) {
        $slug = createSlug($title);
    } else {
        $slug = createSlug($slug);
    }

    /* Check duplicate slug except current blog */
    $checkSlug = "SELECT id FROM blogs WHERE slug = '$slug' AND id != $BlogId";
    $checkQuery = mysqli_query($conn, $checkSlug);

    if ($checkQuery && mysqli_num_rows($checkQuery) > 0) {
        $_SESSION["msg"] = '<div class="alert alert-info">This slug already exists. Please use another slug.</div>';
        header("Location: edit-blog.php?id=$BlogId");
        exit;
    }

    $featured_image = $blog['featured_image'];

    /* If new image selected */
    if (!empty($_FILES['image']['name'])) {

        $fileName = $_FILES['image']['name'];
        $fileTemp = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];

        $image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed_types = ['png', 'jpg', 'jpeg', 'webp'];

        if (!in_array($image_ext, $allowed_types)) {
            $_SESSION["msg"] = '<div class="alert alert-danger">Only jpeg, png, jpg, webp images are allowed.</div>';
            header("Location: edit-blog.php?id=$BlogId");
            exit;
        }

        if ($fileSize > 2000000) {
            $_SESSION["msg"] = '<div class="alert alert-danger">File size must be less than 2MB.</div>';
            header("Location: edit-blog.php?id=$BlogId");
            exit;
        }

        $newFileName = time() . '-' . createSlug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . $image_ext;
        $destination = "image/" . $newFileName;

        if (move_uploaded_file($fileTemp, $destination)) {

            if (!empty($blog['featured_image'])) {
                $oldImage = "image/" . $blog['featured_image'];

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $featured_image = $newFileName;
        }
    }

    $update = "
        UPDATE blogs SET
            category_id = $category_id,
            title = '$title',
            slug = '$slug',
            short_description = '$short_description',
            content = '$content',
            featured_image = '$featured_image',
            image_alt = '$image_alt',
            meta_title = '$meta_title',
            meta_description = '$meta_description',
            meta_keywords = '$meta_keywords',
            canonical_url = '$canonical_url',
            status = '$status'
        WHERE id = $BlogId
    ";

    $updateQuery = mysqli_query($conn, $update);

    if ($updateQuery) {
        $_SESSION["msg"] = '<div class="alert alert-success">Blog updated successfully.</div>';
        header("Location: Blog.php");
        exit;
    } else {
        $_SESSION["msg"] = '<div class="alert alert-danger">Something went wrong: ' . mysqli_error($conn) . '</div>';
        header("Location: edit-blog.php?id=$BlogId");
        exit;
    }
}

/* Fetch categories */
$catSelect = "SELECT * FROM category WHERE status = 'active' ORDER BY cat_name ASC";
$catQuery = mysqli_query($conn, $catSelect);
?>

<div class="wrapper">

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Blog</h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="./Blog.php" class="btn btn-secondary">Go Back</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <?php
                        if (isset($_SESSION["msg"])) {
                            echo $_SESSION["msg"];
                            unset($_SESSION["msg"]);
                        }
                        ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Blog Details</h3>
                            </div>

                            <div class="card-body">

                                <form action="" method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Blog Title</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="title" 
                                            value="<?= htmlspecialchars($blog['title']); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Slug / URL</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="slug" 
                                            value="<?= htmlspecialchars($blog['slug']); ?>"
                                            placeholder="example: best-flooring-options"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea 
                                            name="short_description" 
                                            class="form-control" 
                                            rows="3"
                                        ><?= htmlspecialchars($blog['short_description']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Blog Content</label>
                                        <textarea 
                                            name="content" 
                                            class="form-control" 
                                            rows="8"
                                            required
                                        ><?= htmlspecialchars($blog['content']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Current Image</label><br>

                                        <?php if (!empty($blog['featured_image'])): ?>
                                            <img 
                                                src="image/<?= htmlspecialchars($blog['featured_image']); ?>" 
                                                width="120" 
                                                height="80"
                                                style="object-fit:cover;"
                                            >
                                        <?php else: ?>
                                            <p>No Image</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label>Change Featured Image</label>
                                        <input 
                                            type="file" 
                                            name="image" 
                                            class="form-control"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Image Alt Text</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="image_alt" 
                                            value="<?= htmlspecialchars($blog['image_alt']); ?>"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select Category</option>

                                            <?php if ($catQuery && mysqli_num_rows($catQuery) > 0): ?>
                                                <?php while ($cat = mysqli_fetch_assoc($catQuery)): ?>
                                                    <option 
                                                        value="<?= $cat['cat_id']; ?>"
                                                        <?= $blog['category_id'] == $cat['cat_id'] ? 'selected' : ''; ?>
                                                    >
                                                        <?= htmlspecialchars($cat['cat_name']); ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            <?php endif; ?>

                                        </select>
                                    </div>

                                    <hr>

                                    <h5>SEO Settings</h5>

                                    <div class="form-group">
                                        <label>Meta Title</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="meta_title" 
                                            value="<?= htmlspecialchars($blog['meta_title']); ?>"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea 
                                            name="meta_description" 
                                            class="form-control" 
                                            rows="3"
                                        ><?= htmlspecialchars($blog['meta_description']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="meta_keywords" 
                                            value="<?= htmlspecialchars($blog['meta_keywords']); ?>"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Canonical URL</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="canonical_url" 
                                            value="<?= htmlspecialchars($blog['canonical_url']); ?>"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : ''; ?>>
                                                Draft
                                            </option>
                                            <option value="published" <?= $blog['status'] == 'published' ? 'selected' : ''; ?>>
                                                Published
                                            </option>
                                        </select>
                                    </div>

                                    <button name="update_blog" type="submit" class="btn btn-primary">
                                        Update Blog
                                    </button>

                                    <a href="./Blog.php" class="btn btn-secondary">
                                        Cancel
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