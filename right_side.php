<?php 
// include 'front_header.php';

?>



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

// include 'front_footer.php';

?>

<script>
  $(document).ready(function(){

    
    $.ajax({ 
      url: "http://localhost/pelzon-dashboard2/dashboard/category_api.php",
      type: "GET",
      success: function(data){
// $('.content-left').append(data.Blog_id)

let tab_count = 0

$.each(data, function(kay,value){
  

  $Categories = ` <tr>
      <th  style="text-align:left;background-color:white;"><a href="./B_category.php?id=${value.cat_id}" style="color:Black; text-decoration:none;font-weight:400;">${value.cat_name} </a></th>
      
    </tr>`;

$('.display-cate').append($Categories)
  
})
      }
    })

  })




</script>

  </body>

</html>