<?php

  include("util/phplib.php");
  
  checkIfLogged();

  require 'util/compressor/autoload.php';

  !empty($_GET['id']) ? $id = $_GET['id'] : header("Location: index.php");
  !empty($_GET['type']) ? $type = $_GET['type'] : header("Location: index.php");

  !empty($_GET['success']) ? $success = true : $success = false; 

  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){


        //we get the thumbnail name, we remove it from the server and we put the new image with the saved name :
        $sql="SELECT Percorso FROM img_".$type." WHERE ID = ".$id;
        $result = $conn->query($sql) or die ($conn->mysql_errno());
        $percorsoTemp = $result->fetch_array();

        $percorso = $percorsoTemp['Percorso'];
        $temp = $_FILES["files"]["tmp_name"];
        
         
        $thumbnailsFolder = "../img/".$type."/thumbnails";

                   
        //let's compress it

        $quality = 60; // Value that I chose

        if(file_exists("../img/".$type."/thumbnails".$percorso)){

          unlink("../img/".$type."/thumbnails".$percorso);

        }
        
        $percorso = substr($percorso, 1);
        
         //move_uploaded_file($temp, $thumbnailsFolder."/".$percorso);
        $image_compress = new Compress($temp, $percorso, $quality, $thumbnailsFolder);

        $image_compress->compress_image();

        //the compressed one goes into the thumbnails folder

        header("Location: manage".$type."images.php?success=true");

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
        <li class="breadcrumb-item">
          <a href="../index.php">.nobody&co.</a>
        </li>
        <li class="breadcrumb-item active">Modifica una Thumbnail</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-file"></i> Modifica una Thumbnail
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <input class="form-control" id="images" type="file" aria-describedby="imagesHelp" placeholder="Aggiungi Foto" name="files" required ><br>
                  <button class="btn btn-primary btn-block" type="submit" name="submit">Sostituisci la Thumbnail</button>
                </div>
              </div>
            </div>        
          </form>
          <div class="row text-center">
            <?php 
            
            $sql = "SELECT Percorso FROM img_".$type." WHERE ID = ".$id;
            $result = $conn->query($sql);

            $percorsoTemp = $result->fetch_assoc();
            $percorso = $percorsoTemp['Percorso'];

            ?>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  Immagine HD
                </div>
                <div class="card-body">
                  <img src="../img/<?php echo $type."/hd".$percorso ?>">
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  Immagine Thumbnail
                </div>
                <div class="card-body">
                  <img src="../img/<?php echo $type."/thumbnails".$percorso ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Landor Managment System</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pronto ad Uscire?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Premi "Logout" qui sotto per concludere la Sessione</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
            <a class="btn btn-primary" href="util/logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
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

    
    
 
</body>

</html>
