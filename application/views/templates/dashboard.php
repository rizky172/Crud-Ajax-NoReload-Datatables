<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $titleWeb ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/css/all.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/css/datatables/jquery.dataTables.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/css/adminlte.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/js/plugins/notifications/sweetalert2.css')?>">
  <?php if(isset($_CSS) and !empty($_CSS)) echo $_CSS; ?>

	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/notifications/sweetalert2.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/pages/notif.js'); ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/jquery.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/adminlte.min.js'); ?>"></script>
  
  <?php if(isset($_JS) and !empty($_JS)) echo $_JS; ?>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?= base_url('assets/dashboards/images/avatar5.png')?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?= $this->session->userdata('userlog')['sess_name'] ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li class="user-header bg-primary">
            <img src="<?= base_url('assets/dashboards/images/avatar5.png')?>" class="img-circle elevation-2" alt="User Image">
            <p>
              Rizky Fathurahman - Web Developer
              <small><?= date('d F Y')?></small>
            </p>
          </li>
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="<?= base_url('auth/logout')?>" onclick="return confirm('Apakah anda yakin ingin keluar ?')" 
              class="btn btn-default btn-flat float-right">Log out
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link">
      <img src="<?= base_url('assets/dashboards/images/AdminLTELogo.png')?>"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">E-KMS</span>
    </a>
    <div class="sidebar">
      <?php $this->load->view('templates/sidebar'); ?>
    </div>
  </aside>
  <div class="content-wrapper">
    <?= $body ?>
  </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.1
    </div>
    <strong>Copyright &copy; 2019 <a href="#">RF Studio</a>.</strong> All rights
    reserved.
  </footer>
  <div id="tampilModal"></div>
</div>
<script type="text/javascript" charset="utf-8" async defer>

</script>
</body>
</html>
