<?php

include '../conection.php';
// error_reporting(E_ERROR | E_PARSE);
include 'sidebar.php';

function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

if (isset($_POST['add_blog'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $short_description = mysqli_real_escape_string($conn, $_POST['short_description']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $image_alt = mysqli_real_escape_string($conn, $_POST['image_alt']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($conn, $_POST['meta_description']);
    $meta_keywords = mysqli_real_escape_string($conn, $_POST['meta_keywords']);
    $canonical_url = mysqli_real_escape_string($conn, $_POST['canonical_url']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($slug)) {
        $slug = createSlug($title);
    } else {
        $slug = createSlug($slug);
    }

    $featured_image = "";

    if (!empty($_FILES['image']['name'])) {

        $fileName = $_FILES['image']['name'];
        $fileTemp = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];

        $image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed_types = ['png', 'jpg', 'jpeg', 'webp'];

        $newFileName = time() . '-' . createSlug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . $image_ext;
        $destination = "image/" . $newFileName;

        if (!in_array($image_ext, $allowed_types)) {
            $_SESSION["alert"] = '<p style="color:red;">Only jpeg, png, jpg, webp images are allowed.</p>';
            header("Location:add-blog.php");
            exit;
        }

        if ($fileSize > 2000000) {
            $_SESSION["alert"] = '<p style="color:red;">File size must be less than 2MB.</p>';
            header("Location:add-blog.php");
            exit;
        }

        if (move_uploaded_file($fileTemp, $destination)) {
            $featured_image = $newFileName;
        }
    }

    $insert = "
        INSERT INTO blogs (
            category_id,
            title,
            slug,
            short_description,
            content,
            featured_image,
            image_alt,
            meta_title,
            meta_description,
            meta_keywords,
            canonical_url,
            status
        ) VALUES (
            '$category_id',
            '$title',
            '$slug',
            '$short_description',
            '$content',
            '$featured_image',
            '$image_alt',
            '$meta_title',
            '$meta_description',
            '$meta_keywords',
            '$canonical_url',
            '$status'
        )
    ";

    $insert_query = mysqli_query($conn, $insert);

    if ($insert_query) {
        $_SESSION["msg"] = '<div class="alert alert-success" role="alert">Blog Added Successfully</div>';
        header("Location:blog.php");
        exit;
    } else {
        $_SESSION["msg"] = '<div class="alert alert-danger" role="alert">Oops! Something went wrong: ' . mysqli_error($conn) . '</div>';
        header("Location:add-blog.php");
        exit;
    }
}

$select = "SELECT * FROM category WHERE status = 'active' ORDER BY cat_name ASC";
$query = mysqli_query($conn, $select);

?>

<div class="wrapper">

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Blog</h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="./blog.php" class="btn btn-secondary">Go Back</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <?php
                        if (isset($_SESSION['alert'])) {
                            echo $_SESSION['alert'];
                            unset($_SESSION['alert']);
                        }

                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Blog Details</h3>
                            </div>

                            <div class="card-body">

                                <form action="" method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Blog Title</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="title" 
                                            placeholder="Enter Blog Title"
                                            required
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Slug / URL</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="slug" 
                                            placeholder="example: best-flooring-options"
                                        >
                                        <small class="text-muted">Empty choro to title se auto generate ho jayega.</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea 
                                            name="short_description" 
                                            class="form-control" 
                                            rows="3"
                                            placeholder="Short summary for blog listing"
                                        ></textarea>
                                    </div>

<div class="form-group">
    <label>Blog Content</label>
    <textarea 
        name="content" 
        id="blogEditor"
        class="form-control" 
        rows="10"
        placeholder="Write full blog content here"
    ></textarea>
</div>

                                    <div class="form-group">
                                        <label>Featured Image</label>
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
                                            placeholder="Describe image for SEO"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select Category</option>

                                            <?php if ($query && mysqli_num_rows($query) > 0): ?>
                                                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                                                    <option value="<?= $row['cat_id']; ?>">
                                                        <?= htmlspecialchars($row['cat_name']); ?>
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
                                            placeholder="SEO Meta Title"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea 
                                            name="meta_description" 
                                            class="form-control" 
                                            rows="3"
                                            placeholder="SEO Meta Description"
                                        ></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="meta_keywords" 
                                            placeholder="keyword 1, keyword 2, keyword 3"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Canonical URL</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="canonical_url" 
                                            placeholder="https://yourwebsite.com/blog/blog-slug"
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>

                                    <button name="add_blog" type="submit" class="btn btn-primary">
                                        Add Blog
                                    </button>

                                    <a href="./blog.php" class="btn btn-secondary">
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
let editor;

ClassicEditor
    .create(document.querySelector('#blogEditor'), {
       toolbar: [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'imageUpload',
    '|',
    'alignment',
    '|',
    'bulletedList',
    'numberedList',
    'blockQuote',
    '|',
    'undo',
    'redo'
]
    })
    .then(e => {
        editor = e;
    })
    .catch(error => {
        console.error(error);
    });

// Validate form before submission
document.querySelector('form').addEventListener('submit', function(e) {
    if (!editor.getData().trim()) {
        e.preventDefault();
        alert('Blog content is required. Please write some content.');
        return false;
    }
});
</script>