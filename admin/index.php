<?php
include_once('includes/header.php');
if ($_POST['password'] != "SILIQUASERBO") {
  die("Password errata");
}
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="">Pannello di amministrazione di Quoting</a>
  </div>
  <!-- /.navbar-header -->

  <ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->

    <!-- /.dropdown -->
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
      </ul>
      <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
  </ul>
  <!-- /.navbar-top-links -->

  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <li>
          <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Gestione eventi</a>
        </li>

        <li>
          <a href="#"><i class="fa fa-user-circle fa-fw"></i> Gestione esiti</a>
        </li>
      </ul>
    </div>
    <!-- /.sidebar-collapse -->
  </div>
  <!-- /.navbar-static-side -->
</nav>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Pannello admin</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-3">
              <i class="fa fa-user fa-5x"></i>
            </div>
            <div class="col-xs-9 text-right">
              <div class="huge">ciaoa</div>
              <div>Customers</div>
            </div>
          </div>
        </div>
        <a href="customers.php">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">
      <div class="panel panel-green">
        <a href="#">
          <div class="panel-footer">
            <span class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-lg-3 col-md-6">

    </div>
    <div class="col-lg-3 col-md-6">

    </div>
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-8">


      <!-- /.panel -->
    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">

      <!-- /.panel .chat-panel -->
    </div>
    <!-- /.col-lg-4 -->
  </div>
  <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
