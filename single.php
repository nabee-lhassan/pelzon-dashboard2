<?php 
include 'front_header.php';

?>


<aside class="content-left">

<div class="container">
  <div class="row ">

  </div>
</div>

</aside>
<aside class="content-right">

</aside>



<?php
$id = $_GET['id'];

?>

<?php 

include 'front_footer.php';

?>

<script>
  $(document).ready(function(){

    $.ajax({ 
      url: "http://localhost/pelzon%20dashboard/dashboard/api.php",
      type: "GET",
      success: function(data){
// $('.content-left').append(data.Blog_id)

$.each(data, function(kay,value){

  if (value.Blog_id == <?= $id ?>){

    
    $Blog = `<div class="card mb-3">
  <img src="./dashboard/image/${value.Blog_image}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">${value.Blog_title}</h5>
    <p class="card-text">${value.Blog_body}</p>
    <p class="card-text"><small class="text-muted">${value.Publish_data}</small></p>
  </div>
</div>`;
$('.row').append($Blog)
  }

 

  
})
      }
    })

  })
</script>

  </body>

</html>