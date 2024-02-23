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
<table class="table">
  <thead>
    <tr>
      <th scope="col" style="text-align:left;">Categories</th>
      
    </tr>
  </thead>
  <tbody class="display-cate">
    
    
    
  </tbody>
</table>

</aside>





<?php 

include 'front_footer.php';

?>

<script>
  $(document).ready(function(){

    $.ajax({ 
      url: "http://localhost/pelzon-dashboard2/dashboard/api.php",
      type: "GET",
      success: function(data){
// $('.content-left').append(data.Blog_id)

$.each(data, function(kay,value){
  


  $Blog = `<div  class="m-2 card" style="width: 18rem;">
  <img src="./dashboard/image/${value.Blog_image}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">${value.cat_name}</h5>
    <h5 class="card-title">${value.Blog_title}</h5>
    <p class="card-text">${value.Blog_body.substring(0, 100)}</p>
    <h5 class="card-title">${value.username}</h5>
    <a href="./single.php?id=${value.Blog_id}" class="btn btn-primary">View</a>
  </div>
</div>`;

$('.row').append($Blog)
  
})
      }
    })
    
    
    $.ajax({ 
      url: "http://localhost/pelzon-dashboard2/dashboard/category_api.php",
      type: "GET",
      success: function(data){
// $('.content-left').append(data.Blog_id)

$.each(data, function(kay,value){
  


  $Categories = ` <tr>
      <th  style="text-align:left;background-color:white;"><a href="" style="color:Black; text-decoration:none;font-weight:400;">${value.cat_name} </a></th>
      
    </tr>`;

$('.display-cate').append($Categories)
  
})
      }
    })

  })
</script>

  </body>

</html>