<?php 
include 'front_header.php';

?>


<aside class="content-left" >

<div class="container">
  <div class="row filter-row">
<div class="filter-tab">

</div>
  </div>
  <div class="row Blog-row">

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

$('.Blog-row').append($Blog)
  
})
      }
    })
    
    
    $.ajax({ 
      url: "http://localhost/pelzon-dashboard2/dashboard/category_api.php",
      type: "GET",
      success: function(data){
// $('.content-left').append(data.Blog_id)

let tab_count = 0

$.each(data, function(kay,value){
  
  $Categories_filter = ` 
      <button class="filter-btn"  data-category="${++tab_count}" >${value.cat_name} </button>`;

    $('.filter-tab').append($Categories_filter)

   
// var filter_btn = $(".filter-btn");

// filter_btn.each(function(i, e) {
  
//   var cat_att = $(e).attr('data-category');
  
//   $(e).on('click', function() {

//     if (cat_att == $(e).innerHtml ){
//       console.log(cat_att);
//     }
//     else{
//       console.log("not found");

//     }
      
//   });
// });



var filter_btn = $(".filter-btn");

filter_btn.each(function(i, e) {
    var cat_att = $(e).attr('data-category');

    $(e).on('click', function(ev) {
      // console.log(ev);  
      // let asd = $(ev).text(); 
      
      if (cat_att == 1) {
            $(e).addClass('class1 ');
            console.log(cat_att);
          } else  {
            $(e).removeClass('class1 ');
            console.log("not found");
        }
    });
});




  
})
      }
    })

  })




</script>

  </body>

</html>