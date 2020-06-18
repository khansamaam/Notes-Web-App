
<?php
$user_blank=false;
$user_exists=false;
$error=false;
$acc_created=false;
$pass_blank=false;
$pass_char=false;
$pass_match=false;
$pass_error=false;
require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty(trim($_POST['username']))) {
        $username_err = "Username Cannot be Blank";
        $user_blank=true;
    } else {
        
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
           
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST['username']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
            
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                    $user_exists=true;
                } else {
                    
                    $username = trim($_POST['username']);
                }
            } else {
                $error=true;
                echo "Something is wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }




    //check password

    if (empty(trim($_POST['password']))) {
        $password_err = "Password Cannot be Blank";
        $pass_blank=true;
    } else if (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password Cannot be less than five characters";
        $pass_char=true;
    } else {
        $password = $_POST['password'];
    }
    //check confirm password 

    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {

        $password_err = "Passwords should match";
        $pass_match=true;
    }
    //if no errors, insert in database

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
      
        $sql = "INSERT INTO users (username,password) VALUES (? ,  ?); ";
        $sql1 = "";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
           
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $username;
            $param_password =  password_hash($password, PASSWORD_DEFAULT);
            //try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                // sql to create table
                $sql1 = "CREATE TABLE $username (
                 id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          note_title VARCHAR(100) NOT NULL,
                            note_desc VARCHAR(500) NOT NULL,
    
                             date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            )";

                if (mysqli_query($conn, $sql1)) {
                    
                  $acc_created=true;
                } else {
                   // echo "Error creating table: " . mysqli_error($conn);
                    $pass_error=true;
                }
              
            } else {
               // echo "Something went wrong Cannot Redirect";
                $pass_error=true;
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
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
                <li class="nav-item active ">
                    <a class="nav-link" href="#">Register <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Login</a>
                </li>



            </ul>
        </div>
    </nav>
    <?php
if($error)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Check all the fields.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
if($user_blank)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Username cannot be blank.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
if($user_exists)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> User already exist. Try Logging in.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
if($acc_created)
{
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your account is created. Try Logging in.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}

if($pass_blank)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Password cannot be blank.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
if($pass_char)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Password must be more than 5 characters.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
if($pass_match)
{
  echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Passwords should match.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}



?>
    <div class="container mt-4">
        <h3>Please Register Here:</h3>
        <hr>
        <form action="register.php" method="POST">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control" name ="username" id="exampleInputEmail1" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">We'll never share your username with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password"  id="exampleInputPassword1">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" class="form-control" name="confirm_password" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
</form>
        
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>












