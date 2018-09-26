<!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    <a class="navbar-brand" href="index.php">Landor Managment System</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text"> Managment</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseNews"><i class="fa fa-fw fa-comments"></i> Table</a>
              <ul class="sidenav-third-level collapse" id="collapseNews">
                <li>
                  <a href="manage.php"><i class="fa fa-fw fa-gear"></i> Manage table</a>
                </li>
                <li>
                  <a href="add.php"><i class="fa fa-fw fa-plus"></i> Add row</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseCategorie"><i class="fa fa-fw fa-filter"></i> Dropdown</a>
              <ul class="sidenav-third-level collapse" id="collapseCategorie">
                <li>
                  <a href="managedropdown.php"><i class="fa fa-fw fa-gear"></i> Manage dropdown</a>
                </li>
                <li>
                  <a href="adddropdown.php"><i class="fa fa-fw fa-plus"></i> Insert row</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="manageimages.php"><i class="fa fa-fw fa-gear"></i> Manage Images</a>
            </li>
            
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i><span class="nav-link-text">Logout</span></a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>