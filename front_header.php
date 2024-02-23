<?php 
session_start();
include 'conection.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="./style.css">
</head>

<body>

<header>
<nav class="navbar navbar-expand-lg bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="/">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-light" aria-current="page" href="/">Home</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-light" href="./login.php"><?php if (isset($_SESSION['admin'])){echo"Dashboard";}else{echo"Login";}  ?> </a>
        </li>
        
      </ul>
      <?php
if(isset($_GET['keyword'])){
  $keyword = $_GET['keyword'] ;
}
else{
  $keyword = '' ;
}

      ?>
      <form class="d-flex"  action="search.php" method="GET">
        <input class="form-control me-2" type="search" autocomplete="off" name="keyword" value="<?= $keyword ?>" required placeholder="Search" >
        <button class="btn btn-outline-success"  type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</header>








  </body>

</html>