<?php 

  include("util/phplib.php");

  checkIfLogged();

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
        <li class="breadcrumb-item active">Manage</li>
      </ol>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>Manage Table</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Dropdown</th>
                  <th>Date</th>
                  <th>Titole</th>
                  <th>Titole</th>
                  <th>Images</th>
                  <th>Remove</th>
                  <th>Edit</th>
                  <th>Sposta in Basso</th>
                </tr>
              </thead>
              <tbody class="text-center">

                <?php

                  $sql = "SELECT table.id as ID, table.data as Data, dropdown.dropdown as Dropdown, table.title as Title, table.description as Description FROM table, dropdown WHERE table.fk_dropdown = dropdown.id ORDER BY Dropdown desc";
                  $result = $conn->query($sql);

                  while($row = $result->fetch_array()){
                ?>

                <tr>
                  <td><?php echo $row['Dropdown'] ?></td>
                  <td><?php echo $row['Data'] ?></td>
                  
                  <td><?php echo $riga['Title'] ?></td>

                  <?php

                  $query = "SELECT COUNT(FK_Table) as Count FROM img_table WHERE FK_Table = ".$row['ID'];

                  $response = $conn->query($query);

                  while($rowIn = $response->fetch_array()){

                  ?>

                  <td><?php echo $rowIn['Count'] ?></td>

                  <?php

                  }

                  ?>


                  
                  <td>
                    <a href="util/table/delete.php?id=<?php echo $row['ID'] ?>">
                      <button class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>
                    </a>
                  </td>
                  <td>
                    <a href="edit.php?id=<?php echo $row['ID'] ?>">
                      <button class="btn btn-warning">
                        <i class="fa fa-wrench"></i>
                      </button>  
                    </a>
                  </td>
                </tr>

                <?php

                }

                ?>
                
              </tbody>
            </table>
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
