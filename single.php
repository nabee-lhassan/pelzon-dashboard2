<?php 
include 'front_header.php';
?>

<aside class="content-left">

    <div class="container">
        <div class="row single-blog-row"></div>
    </div>

</aside>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
?>

<?php 
include 'front_footer.php';
include 'right_side.php';
?>

<script>
$(document).ready(function(){

    let blogId = "<?= htmlspecialchars($id); ?>";
    let blogSlug = "<?= htmlspecialchars($slug); ?>";

    $.ajax({ 
        url: "http://localhost/pelzon-dashboard2/dashboard/api.php",
        type: "GET",
        dataType: "json",
        success: function(response){

            let blogs = response.data ? response.data : response;

            let foundBlog = null;

            $.each(blogs, function(key, value){

                if (blogSlug !== "" && value.slug == blogSlug) {
                    foundBlog = value;
                }

                if (blogId !== "" && value.id == blogId) {
                    foundBlog = value;
                }

            });

            if (foundBlog) {

                let image = foundBlog.featured_image 
                    ? `./dashboard/image/${foundBlog.featured_image}` 
                    : `./dashboard/image/default-blog.jpg`;

                let category = foundBlog.category_name 
                    ? foundBlog.category_name 
                    : 'Uncategorized';

                let title = foundBlog.title 
                    ? foundBlog.title 
                    : 'Untitled Blog';

                let content = foundBlog.content 
                    ? foundBlog.content 
                    : '';

                let createdDate = foundBlog.created_at 
                    ? foundBlog.created_at 
                    : '';

                let singleBlog = `
                    <div class="col-lg-12">
                        <div class="card mb-3 single-blog-card">

                            <img 
                                src="${image}" 
                                class="card-img-top" 
                                alt="${foundBlog.image_alt ? foundBlog.image_alt : title}"
                                style="max-height:450px; object-fit:cover;"
                            >

                            <div class="card-body">

                                <p class="text-muted mb-2">
                                    ${category}
                                </p>

                                <h1 class="card-title">
                                    ${title}
                                </h1>

                                <p class="card-text">
                                    <small class="text-muted">
                                        Published: ${createdDate}
                                    </small>
                                </p>

                                <div class="blog-content">
                                    ${content}
                                </div>

                            </div>
                        </div>
                    </div>
                `;

                $('.single-blog-row').append(singleBlog);

            } else {

                $('.single-blog-row').html(`
                    <div class="col-12">
                        <div class="alert alert-warning">
                            Blog not found.
                        </div>
                    </div>
                `);

            }
        },
        error: function(){
            $('.single-blog-row').html(`
                <div class="col-12">
                    <div class="alert alert-danger">
                        Failed to load blog.
                    </div>
                </div>
            `);
        }
    });

});
</script>

<style>
.single-blog-card {
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.single-blog-card .card-body {
    padding: 30px;
}

.single-blog-card h1 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 15px;
}

.blog-content {
    font-size: 17px;
    line-height: 1.8;
    color: #333;
}

.blog-content p {
    margin-bottom: 18px;
}
</style>

</body>
</html>