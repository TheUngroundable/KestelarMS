<?php 

  include("util/phplib.php");
  
  checkIfLogged();

  require 'util/compressor/autoload.php';


  !empty($_GET['success']) ? $success = true : $success = false; 

  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
      //Multiple Images for Press

        $errors = array();
        $uploadedFiles = array();
        $bytes = 1024;
        $KB = 2048;
        $totalBytes = $bytes * $KB;

        $extension = array("jpeg","jpg","png","gif","tiff","tif");

        //handle thumbnail image

        $thumbnailsFolder = "../img/news/thumbnails";
        $hdFolder = "../img/news/hd";

         
        foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){

            $temp = $_FILES["files"]["tmp_name"][$key];
            $name = $_FILES["files"]["name"][$key];
             
            if(empty($temp)){
                break;
            }
                         
            //let's compress it

            $quality = 60; // Value that I chose

            $ran = mt_rand();

            $image_compress = new Compress($temp, $ran.$name, $quality, $thumbnailsFolder);

            $image_compress->compress_image();

            //the original goes in the HD

            move_uploaded_file($temp, $hdFolder."/".$ran.$name);

            //the compressed one goes into the thumbnails folder
            
            $pathname = "/".$ran.$name;

            unset($image_compress);

            //load on db the images on img_press

            $sql = "INSERT INTO img_news (FK_News, Percorso, Progressivo) VALUES (NULL, '".$pathname."', '0')";

            $conn->query($sql) or die ("Non mi va di inserire l' immagine di questa news. Error: ".$conn->error);
  
        }

        header("Location: managenewsimages.php?success=true");
    
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
  <style type="text/css">
    
  


  </style>
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
        <li class="breadcrumb-item active">Archivio Immagini NEWS</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-file"></i> Inserisci altre immagini per NEWS
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <input class="form-control" id="images" type="file" aria-describedby="imagesHelp" placeholder="Aggiungi Foto" name="files[]" multiple>
                  <p id="imagesHelp" class="form-text text-muted">
                    Per selezionare più foto contemporaneamente usa <i>Shift-click</i> per foto in ordine, <i>Ctrl-Click</i> per pescarle una ad una
                  </p>
                  <button class="btn btn-primary btn-block" type="submit" name="submit">Aggiorna in Archivio</button>
                </div>
              </div>
            </div>        
          </form>
        </div>
      </div>

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-archive"></i> Gestisci le Immagini</div>
        <div class="card-body">
          <div class="row">
            <?php 

            $sql = "SELECT * FROM img_news";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){

            ?>
            <div class="col-sm-3">
              <div class="card">
                <div class="card-header">
                  <a href="util/news/removeimage.php?img=<?php echo $row['ID'] ?>" class="trash btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  <a href="updatethumbnail.php?id=<?php echo $row['ID'] ?>&type=news" class="btn btn-warning view_data"><i class="fa fa-gear"></i></a>
                </div>
                <div class="card-body text-center">
                  <img class="img-fluid" src='<?php echo "../img/news/thumbnails".$row['Percorso']; ?>'>
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

    <script type="text/javascript">
      
      /*$(".card-selectable").click(function(){
        
        if($(this).hasClass("selected")){

          $(this).removeClass("selected");

        }else{

          $(this).addClass("selected");

        }

      });
*/
    </script>
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
