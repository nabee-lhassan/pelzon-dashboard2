<?php 
include 'front_header.php';

$keyword = strtolower($_GET['keyword']);


?>


<aside class="content-left">

<div class="container">
  <div class="row ">
    <h3 class="m-4"> Search Result For <span style="color:blue;"> <?= $keyword ?> </span> </h3>

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

 
  
  if (value.Blog_title.toLowerCase() === "<?= strtolower($keyword) ?>" || value.Blog_body.toLowerCase() === "<?= strtolower($keyword) ?>" || value.username.toLowerCase() === "<?= strtolower($keyword) ?>") {

 
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
  
}else{

  $Nodata = `<div  class=" " style="width: 32rem; margin:15% auto;">
 
  <div class="card-body">
    <h5 class="card-title" style="font-size:50px;">Oops No Data Found</h5>
   
  </div>
</div>`;

// $('.row').append($Nodata)

}

})



      }
    })
    
    
    $.ajax({ 
      url: "http://localhost/pelzon%20dashboard/dashboard/category_api.php",
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