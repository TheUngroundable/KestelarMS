<?php

  include("util/phplib.php");

  checkIfLogged();

  require 'util/compressor/autoload.php';


  $err = false;
  !empty($_GET['success']) ? $success = true : $success = false; 

  if(isset($_GET['id'])){

      $getID = $_GET['id'];
      $newsID = $getID;

    } else {

      $err = true;

    }

  $italianTitle = $englishTitle = $italianDescription = $englishDescription = $category = $dateTime = "";
  $err = false;

  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //validation

    !empty($_POST['italianTitle']) ? $italianTitle = sanitize($_POST['italianTitle'], $conn) : $err = true;

    !empty($_POST['englishTitle']) ? $englishTitle = sanitize($_POST['englishTitle'], $conn) : $err = true;

    !empty($_POST['italianDescription']) ? $italianDescription = sanitize($_POST['italianDescription'], $conn) : $err = true;

    !empty($_POST['englishDescription']) ? $englishDescription = sanitize($_POST['englishDescription'], $conn) : $err = true;

    $_POST['Category'] != "-1" ? $category = $_POST['Category'] : $err = true;

    $dateTime = $_POST['dateTime'];

    //let's work with images

    if(!$err){

      //update press

      $sql = "UPDATE news SET FK_Categoria = ".$category.", Data = '".$dateTime."' WHERE ID = ".$newsID;

    
      
      $conn->query($sql) or die ("Non mi va di aggiornare questa News. Error: ".$conn->error);

      
      

      //insert contenuto_press per lingua  

      //insert english text with this ID

      $sql = "UPDATE contenuto_news SET Titolo = '".$englishTitle."', Descrizione = '".$englishDescription."' WHERE FK_News = '".$newsID."' AND FK_Lang = '1'";

      

      $conn->query($sql) or die ("Non mi va di aggiornare il contenuto in Inglese di questa news. Error: ".$conn->error);

      //insert italian text with this ID

      $sql = "UPDATE contenuto_news SET Titolo = '".$italianTitle."', Descrizione = '".$italianDescription."' WHERE FK_News = '".$newsID."' AND FK_Lang = '2'";

      $conn->query($sql) or die ("Non mi va di aggiornare il contenuto in Italiano di questa news. Error: ".$conn->error);
    
      //Multiple Images for News

        $errors = array();
        $uploadedFiles = array();
        $bytes = 1024;
        $KB = 2048;
        $totalBytes = $bytes * $KB;

        $extension = array("jpeg","jpg","png","gif","tiff","tif");

        //handle thumbnail image

        $thumbnailsFolder = "../img/news/thumbnails";
        $hdFolder = "../img/news/hd";

        
        $sql = "SELECT MAX(Progressivo) as Progressivo FROM img_news WHERE FK_News = ".$newsID;


        $result = $conn->query($sql);
        $temp = $result->fetch_array();

        $progressivo = $temp['Progressivo'];

        $progressivo++;
         
        foreach($_POST['images'] as $id){

          //link to the press

          $sql = "UPDATE img_news SET FK_News = ".$newsID.", progressivo = ".$progressivo." WHERE ID = ".$id;

          $conn->query($sql) or die ("non son riuscito a linkare la foto");

          $progressivo++;

        }

        header("Location: editnews.php?id=".$newsID."&success=true");
    
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
        <li class="breadcrumb-item active">Modifica una News</li>
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

          $sql = "SELECT * FROM news, categoria WHERE news.FK_Categoria = categoria.ID AND news.ID = ".$getID;
          $result = $conn->query($sql);

          $news = $result->fetch_array();

          ?>

          <div class="card mx-auto">
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <?php

                        $sql = "SELECT Titolo FROM contenuto_news WHERE FK_Lang = 2 AND FK_News = ".$getID;

                        $result = $conn->query($sql);

                        $contenuto = $result->fetch_array();

                        ?>
                        <label for="InputItalianTitle">Titolo in Italiano</label>
                        <input class="form-control" id="InputItalianTitle" type="text" aria-describedby="italianTitleHelp" placeholder="Inserisci il Titolo in Italiano" name="italianTitle" value="<?php echo $contenuto['Titolo'] ?>"required>
                      </div>
                      <div class="col-md-6">
                        <?php

                        $sql = "SELECT Titolo FROM contenuto_news WHERE FK_Lang = 1 AND FK_News = ".$getID;

                        $result = $conn->query($sql);

                        $contenuto = $result->fetch_array();

                        ?>
                        <label for="InputEnglishTitle">Titolo in Inglese</label>
                        <input class="form-control" id="InputEnglishTitle" type="text" aria-describedby="englishTitleHelp" placeholder="Inserisci il Titolo in Inglese" name="englishTitle" value="<?php echo $contenuto['Titolo'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <div class="form-row">
                      <div class="col-md-6">
                        <?php

                        $sql = "SELECT Descrizione FROM contenuto_news WHERE FK_Lang = 2 AND FK_News = ".$getID;

                        $result = $conn->query($sql);

                        $contenuto = $result->fetch_array();

                        ?>
                        <label for="InputItalianDescription">Descrizione in Italiano</label>
                        <textarea class="form-control" id="InputItalianDescription" type="text" aria-describedby="italianDescriptionHelp" placeholder="Inserisci la Descrizione in Italiano" name="italianDescription" required><?php echo $contenuto['Descrizione'] ?></textarea>
                      </div>
                      <div class="col-md-6">
                        <?php

                        $sql = "SELECT Descrizione FROM contenuto_news WHERE FK_Lang = 1 AND FK_News = ".$getID;

                        $result = $conn->query($sql);

                        $contenuto = $result->fetch_array();

                        ?>
                        <label for="InputEnglishDescription">Descrizione in Inglese</label>
                        <textarea class="form-control" id="InputEnglishDescription" type="text" aria-describedby="englishDescriptionHelp" placeholder="Inserisci la Descrizione in Inglese" name="englishDescription" required><?php echo $contenuto['Descrizione'] ?></textarea>
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

                            <option value="<?php echo $row['ID'] ?>" <?php if($news['Categoria'] == $row['Categoria']){echo "selected";} ?>><?php echo $row['Categoria']?></option>

                          <?php

                            }

                          ?>


                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="InputEnglishText">Data e Ora</label>
                        <div class='input-group date' id='datetimepicker'>
                          <input name="dateTime" type='text' class="form-control" required value="<?php echo $news['Data'] ?>">
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

                            $sql = "SELECT * FROM img_news WHERE FK_News = ".$getID." ORDER BY Progressivo";

                            $result = $conn->query($sql) or die ($conn->error);

                            while($image = $result->fetch_array()){

                            ?>
                            <div class="col-md-2">
                              <div class="card">
                                <div class="card-header" style="text-align: right; color: red">
                                  <a href="util/news/unlinkimage.php?id=<?php echo $getID.'&img='.$image['ID'] ?>"><i class="fa fa-times-circle-o"></i></a>
                                </div>
                                <img class="card-img-top" src="../img/news/thumbnails<?php echo $image['Percorso'] ?>" alt="Card image cap">
                                <div class="card-footer">
                                  <div class="container" style="text-align: center">
                                    <div class="row">
                                      <div class="col-sm-6">
                                        <a href="util/news/moveleft.php?id=<?php echo $getID?>&img=<?php echo $image['Progressivo'] ?>"><i class="fa fa-caret-left"></i></a>
                                      </div>
                                      <div class="col-sm-6">
                                        <a href="util/news/moveright.php?id=<?php echo $getID?>&img=<?php echo $image['Progressivo'] ?>"><i class="fa fa-caret-right"></i></a>
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

                            $sql = "SELECT * FROM img_news WHERE FK_News is null";
                            $result = $conn->query($sql);

                            while($row = $result->fetch_assoc()){

                            ?>
                            <div class="col-sm-3">
                              
                              <div class="card card-selectable">
                                <div class="card-header">
                                  <input type="checkbox" class="d-none" name="images[]" value="<?php echo $row['ID'] ?>">
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

    <!-- MOVE IMAGE RIGHT -->
 

  </div>
</body>

</html>
