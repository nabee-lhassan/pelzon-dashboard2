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
  


  $Blog = `<div  class="m-2 card" style="width: 18rem;">
  <img src="./dashboard/image/${value.Blog_image}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">${value.category}</h5>
    <h5 class="card-title">${value.Blog_title}</h5>
    <p class="card-text">${value.Blog_body.substring(0, 100)}</p>
    <h5 class="card-title">${value.Author_Name}</h5>
    <a href="./single.php?id=${value.Blog_id}" class="btn btn-primary">View</a>
  </div>
</div>`;

$('.row').append($Blog)
  
})
      }
    })

  })
</script>

  </body>

</html>