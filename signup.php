<?php
// session_start();
include 'conection.php';

// if (isset($_SESSION['admin'])) {

//   echo 'You have log out';
//   header("Location:dashboard/admin.php");

// }



// if (isset($_POST['submit'])) {


//   $username = $_POST['user'];
//   $password = $_POST['pass'];

//   $sql = "SELECT * FROM login WHERE username = '$username' AND password= '$password' ";
//   $result = mysqli_query($conn, $sql);
//   $count = mysqli_num_rows($result);







//   if ($count == 1) {

//     $arr = mysqli_fetch_assoc($result);

//     $data = array($arr['username'], $arr['password']);


//     $_SESSION['admin'] = $data;

//     header("Location:dashboard/admin.php");






//   } else {

//     echo '<script>

//     window.location.href="login.php";
//     alert("invalid user or Password ")


//     </script>';
//   }

// }







if (isset($_POST['submit'])) {
  $user = $_POST['user'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $fileName = $_FILES['user_image']['name'];
  $fileTemp = $_FILES['user_image']['tmp_name'];
  $fileSize = $_FILES['user_image']['size'];

  $image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


  $allowed_types = ['png', 'jpg', 'jpeg'];

  $destination = "image/" . $fileName;


  if (in_array($image_ext, $allowed_types)) {



    if ($fileSize <= 2000000) {
      move_uploaded_file($fileTemp, $destination);

      // $insert = "INSERT INTO Blog (Blog_title, Blog_body, Blog_image, category, Author_id) 
      //      VALUES ('$title', '$body', '$fileName', '$cat', '$user_id')";

      // $query = mysqli_query($conn, $insert);

      $check_email = "SELECT * FROM login WHERE email= '$email'";

      $data_excut = mysqli_query($conn, $check_email);
      $result = mysqli_fetch_array($data_excut);

      if ($result > 0) {
        $error = 'this email is already exists';
        echo '
<script>
  alert("this email is already exists");

</script>';
      } else {
        $encrypted_pass = md5($pass);

        $insert = "INSERT INTO login (username,email,user_image,password) VALUES('$user','$email','$fileName', '$encrypted_pass')";

        $q = mysqli_query($conn, $insert);

        if ($q === true) {

          echo '
      <script>
        alert("you are registerd successfully")
           window.location.href="login.php";
      
      </script>';



        }

      }

      if ($query) {
        ?>
        <script>
          alert('Blog added Successfully')
        </script>
        <?php
      } else {
        ?>
        <script>
          alert('Oops! Something went wrong')
        </script>
        <?php
      }

    } else {

      $big_file = ' <p style="color:red;">File Limit 200mb </p>';
    }


  } else {

    $file_type = '<p style="color:red;"> Only allowed jpeg, png, jpg </p>';

  }



}












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

</head>

<body>


  <section class="login-main">

    <div class="container">

      <div class="row d-flex justify-content-center ">
        <div class="col-lg-4 ">
          <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
              <h2>SignUp Here</h2>
              <label for="exampleInputEmail1" class="form-label">User Name</label>
              <input type="text" class="form-control" name="user" value="" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" value="" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Profile Image</label>
              <input type="file" class="form-control" name="user_image" value="" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3" style="position:relative;">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" value="" id="pass" name="pass">
              <span style="position:absolute;top: 55%;right: 3%;cursor:pointer;" onclick="view()">

                <div id="view-icon" style="display:none;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                    viewBox="0 0 16 16">
                    <path
                      d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                  </svg>
                </div>

                <div id="hide-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-eye-slash" viewBox="0 0 16 16">
                    <path
                      d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486z" />
                    <path
                      d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                    <path
                      d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708" />
                  </svg>
                </div>
              </span>

            </div>







            <button type="submit" name="submit" class="btn btn-primary">SignUp</button>
            <p id='form-error'></p>
          </form>
          <a href="./login.php">login</a>

        </div>
      </div>
    </div>

  </section>



  <script>

    const inp_pass = document.querySelector('#pass');
    const icon_view = document.querySelector('#view-icon');
    const icon_hide = document.querySelector('#hide-icon');



    function view() {
      // alert('not showing')
      if (inp_pass.type == 'password') {
        inp_pass.type = 'text'
        icon_view.style.display = "block"
        icon_hide.style.display = "none"
      }
      else {
        inp_pass.type = 'password'
        icon_view.style.display = "none"
        icon_hide.style.display = "block"
      }

    }




  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>
</body>

</html>