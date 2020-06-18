<?php
  require_once("config.php");
session_start();
$status = $_SESSION['loggedin'];
$insert=false;
$update=false;
$delete=false;

if ($_SESSION['loggedin'] != true) {
  header("location: login.php");
}

if(isset($_GET['delete']))
{$name = $_SESSION['username'];
  $sno= $_GET['delete'];
  $sql="DELETE FROM $name WHERE `$name`.`id` =$sno;";
 
  $result = mysqli_query($conn, $sql);
  //echo "Error: " . $sql . "<br>" . $conn->error;
  //$conn->error;
  if($result)
  {
   // echo "The record is updated";
    $delete=true;
   
  }
}
if($_SERVER['REQUEST_METHOD'] == "POST")
{
if(isset($_POST['snoEdit']))
{
  echo "hello";
  $name = $_SESSION['username'];
  $title=$_POST["titleEdit"];
  $desc=$_POST["descEdit"];
  $sno=$_POST['snoEdit'];

  $sql="UPDATE $name SET `note_title` ='$title', `note_desc` = '$desc', `date_time`= current_timestamp() WHERE `$name`.`id` =$sno;";
 
  $result = mysqli_query($conn, $sql);
  //echo "Error: " . $sql . "<br>" . $conn->error;
  //$conn->error;
  if($result)
  {
   // echo "The record is updated";
    $update=true;
   
  }

}else{

  $name = $_SESSION['username'];
  $title=$_POST["title"];
  $desc=$_POST["desc"];
 

  $sql="INSERT INTO $name (`note_title`, `note_desc`, `date_time`) VALUES ('$title', '$desc', current_timestamp());";
 
  $result = mysqli_query($conn, $sql);
  //echo "Error: " . $sql . "<br>" . $conn->error;
  //$conn->error;
  if($result)
  {
  //  echo "The record is inserted";
    $insert=true;
   
  }
}
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
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
 
  <title>I-Notes</title>
</head>

<body>
  <!-- edit modal -->


<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal">Edit This Note:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action ="welcome.php" method="POST">
          <input type="hidden" name="snoEdit" id="snoEdit" >
          <div class="form-group ">
            <label for="title">Note Title:</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp" required>
    
          </div>
          <div class="form-group">
            <label for="desc">Note Description:</label>
            <textarea class="form-control" id="descEdit" name="descEdit" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">I-Notes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./logout.php">Logout</a>
        </li>


      </ul>
      <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#"><?php echo "Welcome " . $_SESSION['username'] ?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?php
  if($insert)
  {
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  if($update)
  {
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been Updated successfully.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  if($delete)
  {
  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  ?>

  <div class="container mt-4">

    <h3><?php echo "Hi, " .ucfirst($_SESSION['username']). " Welcome To this Site" ?></h3>
    <hr>
  </div>
  
  <div class="container my-4">
    <h2>Add a Note:</h2>
    <form action ="welcome.php" method="POST">
      <div class="form-group ">
        <label for="title">Note Title:</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" required>

      </div>
      <div class="form-group">
        <label for="desc">Note Description:</label>
        <textarea class="form-control" id="desc" name="desc" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-8">
  
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No.</th>
          <th scope="col">Title</th>
          <th scope="col">Created At</th>
          <th scope="col">Descripiton</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>

      <?php
  
    $name = $_SESSION['username'];
    $sql = "SELECT * FROM $name";
    $result = mysqli_query($conn, $sql);
    $sno=0;
    while ($row = mysqli_fetch_assoc($result)) {
      $sno+=1;
      echo "<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['note_title']."</td>
      <td>".$row['date_time']."</td>
      <td>".$row['note_desc']."</td>
      <td><button class='btn btn-sm btn-primary edit' id=".$row['id'].">Update</button>  <button class='btn btn-sm btn-primary delete' id=d".$row['id'].">Delete</button></td>
    </tr>";
    }

    
    ?>
       
      </tbody>
    </table>
  </div>
  <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
  </script>
   <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
  </script>
  <script>
   
   edits=document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
      element.addEventListener("click", (e)=>{
      tr=e.target.parentNode.parentNode;
      title=tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[2].innerText;
      titleEdit.value=title;
      descEdit.value=description;
      snoEdit.value=e.target.id;
      $('#editModal').modal('toggle');
   
       
      })
      })
   
   deletes=document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click", (e)=>{
        sno=e.target.id.substr(1,);
   
         if(confirm("Press a Button!"))
         {
           console.log("Yes");
           window.location=`/login_and_register/welcome.php?delete=${sno}`;
         }else{
           console.log("No");
         }
      })
      })
    
  </script>
</body>

</html>