<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/css/all.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/css/adminlte.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dashboards/js/plugins/notifications/sweetalert2.css')?>">

  <script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/notifications/sweetalert2.js'); ?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/validation/validate.min.js')?>"></script>
  <script type="text/javascript" src="<?= base_url('assets/dashboards/js/pages/login.js')?>"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>RF </b>Studio</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?= base_url('auth/do_login')?>" method="post" enctype="multipart/form-data" id="form-login" name="form-login">
        <div class="input-group mb-3">
          <input autocomplete="off" type="email" class="form-control" placeholder="Email" name="email" id="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input autocomplete="off" type="password" class="form-control" placeholder="Password" name="password" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
