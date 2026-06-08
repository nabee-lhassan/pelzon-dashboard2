<?php
include '../conection.php';
include 'sidebar.php';

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

<div class="wrapper">

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">Blogs</h1>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="add-blog.php" class="btn btn-primary">
                            Add New Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row">

                    <?php if ($query && mysqli_num_rows($query) > 0): ?>

                        <?php while ($row = mysqli_fetch_assoc($query)): ?>

                            <?php
                            $maxContentLength = 120;

                            $content = !empty($row['content']) ? strip_tags($row['content']) : '';

                            $body_content = strlen($content) > $maxContentLength
                                ? substr($content, 0, $maxContentLength) . '...'
                                : $content;

                            $image = !empty($row['featured_image'])
                                ? 'image/' . $row['featured_image']
                                : 'image/default-blog.jpg';

                            $category = !empty($row['category_name'])
                                ? $row['category_name']
                                : 'Uncategorized';

                            $status = !empty($row['status']) ? $row['status'] : 'draft';

                            $statusBadge = $status == 'published'
                                ? '<span class="badge badge-success">Published</span>'
                                : '<span class="badge badge-warning">Draft</span>';

                            $createdDate = !empty($row['created_at'])
                                ? date('d M, Y', strtotime($row['created_at']))
                                : '-';

                            $blogTitle = !empty($row['title']) ? $row['title'] : 'Untitled Blog';

                            $blogSlug = !empty($row['slug']) ? $row['slug'] : '';
                            ?>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card blog-card h-100">

                                    <img 
                                        src="<?= htmlspecialchars($image); ?>" 
                                        class="card-img-top" 
                                        alt="<?= htmlspecialchars($row['image_alt'] ?? $blogTitle); ?>"
                                        style="height: 200px; object-fit: cover;"
                                    >

                                    <div class="card-body">

                                        <div class="mb-2">
                                            <small class="text-muted">
                                                Category: <?= htmlspecialchars($category); ?>
                                            </small>
                                        </div>

                                        <h5 class="card-title" style="font-weight:700; font-size:18px;">
                                            <?= htmlspecialchars($blogTitle); ?>
                                        </h5>

                                        <p class="card-text">
                                            <?= htmlspecialchars($body_content); ?>
                                        </p>

                                        <div class="mb-2">
                                            <?= $statusBadge; ?>
                                        </div>

                                        <small class="text-muted">
                                            Created: <?= $createdDate; ?>
                                        </small>

                                    </div>

                                    <div class="card-footer bg-white d-flex justify-content-between">

                                        <a 
                                            href="edit-blog.php?id=<?= (int)$row['id']; ?>" 
                                            class="btn btn-sm btn-info"
                                        >
                                            Edit
                                        </a>

                                        <?php if (!empty($blogSlug)): ?>
                                            <a 
                                                href="../single.php?slug=<?= htmlspecialchars($blogSlug); ?>" 
                                                target="_blank" 
                                                class="btn btn-sm btn-success"
                                            >
                                                View
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                View
                                            </button>
                                        <?php endif; ?>

                                        

                                        <a 
                                                class="btn btn-danger btn-sm" 
                                                href="trash.php?id=<?php echo $row['id']; ?>&action=delete" 
                                                onclick="return confirm('Are you sure you want to delete this blog?')"
                                            >
                                                Delete
                                            </a>

                                        

                                    </div>

                                </div>
                            </div>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <div class="col-12">
                            <div class="alert alert-info">
                                No blogs found. Please add your first blog.
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </section>

    </div>

</div>

<?php include 'footer.php'; ?>