<?php 
include 'front_header.php';

$keyword = $_GET['keyword'];


?>


<aside class="content-left">

<div class="container">
  <div class="row ">
    <h3 class="m-4"> Search Result For <span style="color:blue;"> <?= $keyword ?> </span> </h3>

  </div>
</div>


</aside>






<?php 

include 'front_footer.php';
include 'right_side.php';

?>

<script>
  $(document).ready(function(){

    $.ajax({ 
      url: "http://localhost/pelzon-dashboard2/dashboard/api.php",
      type: "GET",
      success: function(data){
// $('.content-left').append(data.Blog_id)

$.each(data, function(kay,value){

 console.log(data)
 console.log(value)
  
  if (value.Blog_title.toLowerCase().includes("<?= strtolower($keyword) ?>") || value.cat_name.toLowerCase().includes("<?= strtolower($keyword) ?>") || value.Blog_body.toLowerCase().includes("<?= strtolower($keyword) ?>") || value.username.toLowerCase().includes("<?= strtolower($keyword) ?>")) {
    // if (value.Blog_body.toLowerCase().includes("<?= strtolower($keyword) ?>")) {

 
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
    
    
    

  })
</script>

  </body>

</html>