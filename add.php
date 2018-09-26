<?php

  include("util/phplib.php");
  checkIfLogged();
  require 'util/compressor/autoload.php';

  //Init
  empty($_GET['success']) ? $success = false : $success = true;

  $title = $description = $dropdown = $dateTime = "";
  $err = false;
  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Validation
    !empty($_POST['title']) ? $title = sanitize($_POST['title'], $conn) : $err = true;
    !empty($_POST['description']) ? $description = sanitize($_POST['description'], $conn) : $err = true;
    $_POST['dropdown'] != "-1" ? $dropdown = $_POST['dropdown'] : $err = true;
    $dateTime = $_POST['dateTime'];

    if(!$err){

      //Add row in database
      $sql = "INSERT INTO table (FK_Dropdon, Data) VALUES ('".$dropdown."', '".$dateTime."')";
      $conn->query($sql) or die ("Error with inserting in Table. Error: ".$conn->error);
      $newsID = $conn->insert_id;

      //Multiple Images Selected
      $thumbnailsFolder = "../img/table/thumbnails";
      $hdFolder = "../img/table/hd";

      $index = 0;
       
      foreach($_POST['images'] as $image){

        //Link to the table
        $sql = "UPDATE img_table SET FK_Table = ".$tableID.", index = ".$index." WHERE ID = ".$image;
        $conn->query($sql) or die ("Error with linking images to the table");
        $index++;

      }

        header("Location: add.php?success=true");
    
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

  <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
  <style type="text/css">
    .selected{

      border-color: blue;

    }
  </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?php include('navbar.php') ?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Insert a table</li>
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

          <?php echo $dateTime ?>
          <div class="card mx-auto">
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="title">Title</label>
                        <input class="form-control" id="title" type="text" aria-describedby="titleHelp" placeholder="Insert Title" name="title" required>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" type="text" aria-describedby="descriptionHelp" placeholder="Insert Description" name="description" required></textarea>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="dropdown">Dropdown</label>
                        <select class="form-control" id="dropdown" name="dropdown" required>
                          <option value="-1">Seleziona una Categoria</option>
                          
                          <?php 

                            $sql = "SELECT * FROM dropdown";

                            $result = $conn->query($sql);

                            while($row = $result->fetch_array()){

                          ?>

                            <option value="<?php echo $row['ID'] ?>"><?php echo $row['Dropdown'] ?></option>

                          <?php

                            }

                          ?>


                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="InputDateTime">Data & Time</label>
                        <div class='input-group date' id='datetimepicker'>
                          <input name="dateTime" type='text' class="form-control" required>
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12">
                          <label for="images">Images without Table</label>
                          <div class="row">
                            <?php 

                            $sql = "SELECT * FROM img_table WHERE FK_Table is null";
                            $result = $conn->query($sql);

                            while($row = $result->fetch_assoc()){

                            ?>
                            <div class="col-sm-3">
                              
                              <div class="card card-selectable">
                                <div class="card-header">
                                  <input type="checkbox" class="d-none" name="images[]" value="<?php echo $row['ID'] ?>">
                                </div>
                                <div class="card-body text-center">
                                  <img class="img-fluid" src='<?php echo "../img/table/thumbnails".$row['Pathname']; ?>'>
                                </div>
                              </div>
                            </div>

                            <?php
                            }
                            ?>

                          </div>
                        </div>
                      </div>
                  </div>  
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
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>

    <script src="js/bootstrap-datetimepicker.min.js"></script>

    <script src="js/bootstrap-datetimepicker.it.js"></script>

    <script type="text/javascript">
      $(function () {
        $('#datetimepicker').datetimepicker();
      });
      $(".card-selectable").click(function(){
        $(this).toggleClass('selected');
        var $checkbox = $(this).find('input[type="checkbox"]');
        $checkbox.prop("checked",!$checkbox.prop("checked"))

      });
    </script>
  </div>
</body>

</html>
