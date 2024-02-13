<?php 
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>welcome <?php echo $_SESSION['admin'] ?></h1>

<form method="POST">
<button name="logout"> Log out</button>

              </form>
    

              <?php 

if(isset($_POST['logout'])){
  session_destroy();
//   header("Location:login.php");
}

?>

</body>
</html>