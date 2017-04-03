<?php
  session_name('ci_session');
  session_start();
  // start require config.php (include db)
  /*if(isset($_GET['_v'])){
    $v_ = unserialize(base64_decode($_GET['_v']));
    $_SESSION = $v_;
  }*/
  require_once("inc/config.php");
  /*if(!isset($_SESSION['rsa_username'])){
    echo "<h3 style=\"text-align:center;font-family:Arial;color:#f00;background-color:#fff;\">Sesi habis. Silahkan reload halaman ini.</h3>"; exit;
  }else{
    if(!isExist($_SESSION['rsa_username'],'rsa_user','username')){
      echo "<h3 style=\"text-align:center;font-family:Arial;color:#f00;background-color:#fff;\">Sesi habis. Silahkan reload halaman ini.</h3>"; exit;
    }
  }*/
  require_once("inc/config2.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $_CONFIG['title']; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo $_PATH; ?>/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $_PATH; ?>/dist/font-awesome/css/font-awesome.min.css"/>
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $_PATH; ?>/dist/ionicons/css/ionicons.min.css"/>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $_PATH; ?>/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $_PATH; ?>/dist/css/skins/<?php echo $_CONFIG['skin']; ?>.min.css">
  <?php require_once "index_css.php"; ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?php echo $_PATH; ?>/dist/js/html5shiv.min.js"></script>
  <script src="<?php echo $_PATH; ?>/dist/js/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition <?php echo $_CONFIG['skin']; ?> layout-top-nav">
<div class="modal_ajax_loading" style="background-color: rgba(156, 156, 156, 0.5);width:100%;height:100vh;z-index:9999;position:fixed;display:none;">
  <div style="position: absolute;top: 50%; left: 50%;transform: translate(-50%,-50%);width: 100px;height: 100px;">
    <img src="<?php echo $_CONFIG['path']; ?>/dist/img/gears.gif"/>
  </div>
</div>
<div class="wrapper">

  <header class="main-header">
    <?php require_once "index_nav.php"; ?>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <!-- <div class="container"> -->
      <?php //require_once "index_content_header.php"; ?>
      <!-- Main content -->
      <section class="content">
        <?php require_once "index_content.php"; ?>
      </section>
      <!-- /.content -->
    <!-- </div> -->
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <?php //require_once "index_footer.php"; ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo $_PATH; ?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $_PATH; ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $_PATH; ?>/dist/js/app.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $_PATH; ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $_PATH; ?>/plugins/fastclick/fastclick.js"></script>
<?php require_once "index_js.php"; ?>
</body>
</html>
