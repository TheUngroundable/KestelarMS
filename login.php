<?php

$username = $password = $loginErr = "";

session_start();

//Check if Post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  //connect to DB
  include("util/phplib.php");

  $username = sanitize($_POST['username'], $conn);
  $password = sanitize($_POST['password'], $conn);


  //Encrypt password
  $passmd5 = md5($password);

  //Query users
  $query="SELECT ID, Username FROM users WHERE Username='".$username."' and Password='".$passmd5."'";
  $result = $conn->query($query) or die ("Problema a fare il Login..");
  
  if($result){ 

    $count = $result->num_rows;

    if($count!=0){

      if(!isset($_SESSION)){ 
  
        session_start();

      }

      $row = $result->fetch_array();
      $_SESSION['session'] = 1;
      $_SESSION['ID'] = $row['ID'];
      $_SESSION['Username'] = $username;
      header("Location: index.php");  //go to homepage
      exit;

    } else {

      $loginErr = "Username or Password incorrect!";
    
    }

  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Landor Managment System</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Landor - Login</div>
      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="InputUsername">Username</label>
            <input class="form-control" id="InputUsername" type="text" aria-describedby="usernameHelp" placeholder="Inserisci Nome Utente" name="username" required >
          </div>
          <div class="form-group">
            <label for="InputPassword">Password</label>
            <input class="form-control" id="InputPassword" type="password" placeholder="Password" name="password" required >
          </div>
          <button class="btn btn-primary btn-block" type="submit">Login</button>
          <label style="color:red"><?php echo $loginErr;?></label>
        </form>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
