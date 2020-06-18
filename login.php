<?php
session_start();

$error1=false;
$error2=false;
require_once "config.php";
if(isset($_SESSION['username']))
{
  header("location: welcome.php");
  exit();
}
$username = $password = "";
$err = "";

if($_SERVER['REQUEST_METHOD'] =="POST")
{
    if(empty(trim($_POST['username'])) || empty(trim($_POST['username'])))
    {
        $error1=true;
        $err="Username or password cannot be blank";
       
    
    }
    else{
      $username=trim($_POST['username']);
      $password=trim($_POST['password']);
    }
if(empty($err))
{
  $sql="SELECT id,username,password FROM users WHERE username = ?";
  $stmt =mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt,"s",$param_username);

      $param_username=trim($_POST['username']);
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          
          if(mysqli_stmt_num_rows($stmt)==1)
          {
              mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
              if(mysqli_stmt_fetch($stmt))
              {
                if(password_verify($password,$hashed_password))
                {
                    //allow user to login
                    session_start();
                    $_SESSION["username"]=$username;
                    $_SESSION["id"]=$id;
                    $_SESSION['loggedin']= true;
                    
                    echo "hello";
                    header("location: welcome.php");
                }
              }

          }else{
            $error2=true;
              $username =trim($_POST['username']);
          }

}}}



?>









<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>I-Notes</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">I-Notes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav mx-5">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./register.php">Register</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./login.php">Login<span class="sr-only">(current)</span></a>
      </li>
 

    </ul>
  </div>
</nav>
<?php
if($error1)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Username or Password cannot be blank.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
if($error2)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Please fill in your correct credentials.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}

?>
<div class="container mt-4" >
    <h3>Please Login Here:</h3>
    <hr>



    <form action="login.php" method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>