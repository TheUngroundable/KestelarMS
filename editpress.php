<?php

  include("util/phplib.php");
  
  checkIfLogged();

  require 'util/compressor/autoload.php';


  $err = false;
  !empty($_GET['success']) ? $success = true : $success = false; 

  if(isset($_GET['id'])){

      $getID = $_GET['id'];
      $pressID = $getID;

    } else {

      $err = true;

    }

  $italianText = $englishText = $category = $dateTime = "";
  $err = false;

  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //validation

    !empty($_POST['italianText']) ? $italianText = sanitize($_POST['italianText'], $conn) : $err = true;

    !empty($_POST['englishText']) ? $englishText = sanitize($_POST['englishText'], $conn) : $err = true;

    $_POST['Category'] != "-1" ? $category = $_POST['Category'] : $err = true;

    $dateTime = $_POST['dateTime'];

    //let's work with images

    if(!$err){

      //update press

      $sql = "UPDATE press SET FK_Categoria = ".$category.", Data = '".$dateTime."' WHERE ID = ".$pressID;

    
      
      $conn->query($sql) or die ("Non mi va di aggiornare questa press. Error: ".$conn->error);

      
      

      //insert contenuto_press per lingua  

      //insert english text with this ID

      $sql = "UPDATE contenuto_press SET Testo = '".$englishText."' WHERE FK_Press = '".$pressID."' AND FK_Lang = '1'";

      

      $conn->query($sql) or die ("Non mi va di aggiornare il contenuto in Inglese di questa press. Error: ".$conn->error);

      //insert italian text with this ID

      $sql = "UPDATE contenuto_press SET Testo = '".$italianText."' WHERE FK_Press = '".$pressID."' AND FK_Lang = '2'";

      $conn->query($sql) or die ("Non mi va di aggiornare il contenuto in Italiano di questa press. Error: ".$conn->error);
    
      //Multiple Images for Press

        $errors = array();
        $uploadedFiles = array();
        $bytes = 1024;
        $KB = 2048;
        $totalBytes = $bytes * $KB;

        $extension = array("jpeg","jpg","png","gif","tiff","tif");

        //handle thumbnail image

        $thumbnailsFolder = "../img/press/thumbnails";
        $hdFolder = "../img/press/hd";

        
        $sql = "SELECT MAX(Progressivo) as Progressivo FROM img_press WHERE FK_Press = ".$pressID;


        $result = $conn->query($sql);
        $temp = $result->fetch_array();

        $progressivo = $temp['Progressivo'];

        $progressivo++;
         
        foreach($_POST['images'] as $id){

          //link to the press

          $sql = "UPDATE img_press SET FK_Press = ".$pressID.", progressivo = ".$progressivo." WHERE ID = ".$id;

          $conn->query($sql) or die ("non son riuscito a linkare la foto");

          $progressivo++;

        }

        header("Location: editpress.php?id=".$pressID."&success=true");
    
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
        <li class="breadcrumb-item active">Modifica una Press</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-lg-12">
          <div class="alert alert-warning" role="alert">
            Per come è strutturato questo sistema, è consigliato prima di tutto di lavorare sulle immagini (aggiungerne, rimuoverne, cambiare l' ordine, etc..), poi sui contenuti.
          </div>
          <?php

          if($success){

          ?>
          <div class="alert alert-success" role="alert">
            Record aggiornato correttamente!
          </div>
          <?php
          }
          ?>

          <?php

          $sql = "SELECT * FROM press, categoria WHERE press.FK_Categoria = categoria.ID AND press.ID = ".$getID;
          $result = $conn->query($sql);

          $press = $result->fetch_array();

          ?>

          <div class="card mx-auto">
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <?php

                        $sql = "SELECT * FROM contenuto_press WHERE FK_Lang = 2 AND FK_Press = ".$getID;

                        $result = $conn->query($sql);

                        $contenuto = $result->fetch_array();

                        ?>
                        <label for="InputItalianText">Testo in Italiano</label>
                        <input class="form-control" id="InputItalianText" type="text" aria-describedby="italianText" placeholder="Inserisci il Testo in Italiano" name="italianText"  value="<?php echo $contenuto['Testo'] ?>" required>
                      </div>
                      <div class="col-md-6">
                        <?php

                        $sql = "SELECT * FROM contenuto_press WHERE FK_Lang = 1 AND FK_Press = ".$getID;

                        $result = $conn->query($sql);

                        $contenuto = $result->fetch_array();

                        ?>
                        <label for="InputEnglishText">Testo in Inglese</label>
                        <input class="form-control" id="InputEnglishText" type="text" aria-describedby="englishTextHelp" placeholder="Inserisci il Testo in Inglese" name="englishText" value="<?php echo $contenuto['Testo'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <label for="exampleFormControlSelect1">Categoria</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="Category" required>
                          <option value="-1">Seleziona una Categoria</option>
                          
                          <?php 

                            $sql = "SELECT * FROM categoria";

                            $result = $conn->query($sql);

                            while($row = $result->fetch_array()){

                          ?>

                            <option value="<?php echo $row['ID'] ?>" <?php if($press['Categoria'] == $row['Categoria']){echo "selected";} ?>><?php echo $row['Categoria']?></option>

                          <?php

                            }

                          ?>


                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="InputEnglishText">Data e Ora</label>
                        <div class='input-group date' id='datetimepicker'>
                          <input name="dateTime" type='text' class="form-control" required value="<?php echo $press['Data'] ?>">
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
                        <div class="col">
                          <label for="images">Immagini In Archivio</label>
                            <div class="form-row" id="images">
                             
                            <?php 

                            $sql = "SELECT * FROM img_press WHERE FK_Press = ".$getID." ORDER BY Progressivo";

                            $result = $conn->query($sql) or die ($conn->error);

                            while($image = $result->fetch_array()){

                            ?>
                            <div class="col-md-2">
                              <div class="card">
                                <div class="card-header" style="text-align: right; color: red">
                                  <a href="util/press/unlinkimage.php?id=<?php echo $getID.'&img='.$image['ID'] ?>"><i class="fa fa-times-circle-o"></i></a>
                                </div>
                                <img class="card-img-top" src="../img/press/thumbnails<?php echo $image['Percorso'] ?>" alt="Card image cap">
                                <div class="card-footer">
                                  <div class="container" style="text-align: center">
                                    <div class="row">
                                      <div class="col-sm-6">
                                        <a href="util/press/moveleft.php?id=<?php echo $getID?>&img=<?php echo $image['Progressivo'] ?>"><i class="fa fa-caret-left"></i></a>
                                      </div>
                                      <div class="col-sm-6">
                                        <a href="util/press/moveright.php?id=<?php echo $getID?>&img=<?php echo $image['Progressivo'] ?>"><i class="fa fa-caret-right"></i></a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php

                            }

                            ?>

                          </div>
                          <p id="imagesHelp" class="form-text text-muted">
                            Queste modifiche avranno effetto immediato sul Database.
                          </p>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="form-row">
                        <div class="col-md-12">
                          <label for="images">Immagini senza press</label>
                          <div class="row">
                            <?php 

                            $sql = "SELECT * FROM img_press WHERE FK_Press is null";
                            $result = $conn->query($sql);

                            while($row = $result->fetch_assoc()){

                            ?>
                            <div class="col-sm-3">
                              
                              <div class="card card-selectable">
                                <div class="card-header">
                                  <input type="checkbox" class="d-none" name="images[]" value="<?php echo $row['ID'] ?>">
                                </div>
                                <div class="card-body text-center">
                                  <img class="img-fluid" src='<?php echo "../img/press/thumbnails".$row['Percorso']; ?>'>
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
                  <button class="btn btn-primary btn-block" type="submit" name="submit">Aggiorna in Archivio</button>
                </form>
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
    <script src="js/bootstrap-datetimepicker.min.js"></script>

    <script src="js/bootstrap-datetimepicker.it.js"></script>

    
    <!-- MOVE IMAGE RIGHT -->
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
