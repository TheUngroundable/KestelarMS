<?php


  include("util/phplib.php");
  checkIfLogged();
  
  //Init
  $err = false;
  $success = false;

  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    !empty($_POST['dropdown']) ? $dropdown = sanitize($_POST['dropdown'], $conn) : $err = true;

    if(!$err){

      $sql = "INSERT INTO dropdown (Dropdown) VALUES ('".$dropdown."')";
      $conn->query($sql);
      $success = true;

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
  <title>Landor managment System</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?php include('navbar.php') ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Insert a Dropdown</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-lg-12">

          <?php

          if($success){

          ?>
          <div class="alert alert-success" role="alert">
            Inserted Record correctly
          </div>

          <?php

          } else if($err){

          ?>
          <div class="alert alert-danger" role="alert">
            A problem occurred. Are you sure to have put the right datas? 
          </div>
          <?php
          }
          ?>
          <div class="card mx-auto">
              <div class="card-body">
                <form method="POST">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="inputDropdown">Dropdown Value</label>
                        <input class="form-control" id="inputDropdown" type="number" aria-describedby="dropdownHelp" placeholder="Insert dropdown value" name="dropdown" required>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <hr>
                  <button class="btn btn-primary btn-block" type="submit" name="submit">Insert in Archive</button>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include("footer.php"); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
