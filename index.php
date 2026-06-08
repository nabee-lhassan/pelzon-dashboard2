<?php 
include 'front_header.php';
?>

<aside class="content-left">

    <div class="container">

        <!-- <div class="row filter-row">
            <div class="filter-tab mb-4">
                <button class="filter-btn active" data-category="all">All</button>
            </div>
        </div> -->

        <div class="row Blog-row"></div>

    </div>

</aside>

<?php 
include 'front_footer.php';
include 'right_side.php';
?>

<script>
$(document).ready(function(){

    let allBlogs = [];

    function renderBlogs(blogs) {

        $('.Blog-row').html('');

        if (!blogs || blogs.length === 0) {
            $('.Blog-row').html(`
                <div class="col-12">
                    <p style="text-align:center; padding:20px; font-weight:600;">
                        No blogs found.
                    </p>
                </div>
            `);
            return;
        }

        $.each(blogs, function(key, value){

            let image = value.featured_image 
                ? `./dashboard/image/${value.featured_image}` 
                : `./dashboard/image/default-blog.jpg`;

            let category = value.category_name 
                ? value.category_name 
                : 'Uncategorized';

            let title = value.title 
                ? value.title 
                : 'Untitled Blog';

            let content = value.content 
                ? value.content.replace(/(<([^>]+)>)/gi, "") 
                : '';

            let shortContent = content.length > 100 
                ? content.substring(0, 100) + '...' 
                : content;

            let blogLink = value.slug 
                ? `./single.php?slug=${value.slug}` 
                : `./single.php?id=${value.id}`;

            let blogCard = `
                <div class="col-lg-4 col-md-6 mb-4 blog-item" data-category="${value.category_id}">
                    <div class="m-2 card h-100" style="width: 18rem;">
                        <img 
                            src="${image}" 
                            class="card-img-top" 
                            alt="${value.image_alt ? value.image_alt : title}"
                            style="height:200px; object-fit:cover;"
                        >

                        <div class="card-body">
                            <h6 class="card-title text-muted">${category}</h6>
                            <h5 class="card-title">${title}</h5>
                            <p class="card-text">${shortContent}</p>
                            <a href="${blogLink}" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            `;

            $('.Blog-row').append(blogCard);
        });
    }

    // Fetch Blogs
    $.ajax({ 
        url: "http://localhost/pelzon-dashboard2/dashboard/api.php",
        type: "GET",
        dataType: "json",
        success: function(response){

            /*
              Agar API wrapped response de rahi hai:
              { status:true, data:[...] }
              to response.data use hoga.

              Agar plain array aa raha hai:
              [...]
              to response direct use hoga.
            */

            allBlogs = response.data ? response.data : response;

            renderBlogs(allBlogs);
        },
        error: function(){
            $('.Blog-row').html(`
                <div class="col-12">
                    <p style="text-align:center; color:red;">
                        Failed to load blogs.
                    </p>
                </div>
            `);
        }
    });

    // Fetch Categories
    $.ajax({ 
        url: "http://localhost/pelzon-dashboard2/dashboard/category_api.php",
        type: "GET",
        dataType: "json",
        success: function(response){

            let categories = response.data ? response.data : response;

            $.each(categories, function(key, value){

                let categoryButton = `
                    <button 
                        class="filter-btn" 
                        data-category="${value.cat_id}"
                    >
                        ${value.cat_name}
                    </button>
                `;

                $('.filter-tab').append(categoryButton);
            });
        }
    });

    // Filter Blogs
    $(document).on('click', '.filter-btn', function(){

        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        let selectedCategory = $(this).data('category');

        if (selectedCategory === 'all') {
            renderBlogs(allBlogs);
        } else {
            let filteredBlogs = allBlogs.filter(function(blog){
                return String(blog.category_id) === String(selectedCategory);
            });

            renderBlogs(filteredBlogs);
        }
    });

});
</script>

<style>
.filter-tab {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-btn {
    border: none;
    background: #e9e9e9;
    padding: 8px 18px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
}

.filter-btn.active {
    background: #007bff;
    color: #fff;
}

.Blog-row {
    display: flex;
    flex-wrap: wrap;
}
</style>

</body>
</html>