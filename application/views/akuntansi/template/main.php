<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.2">

    
    <title>SiAk | Sistem Akuntansi</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/akuntansi/insinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/akuntansi/insinia/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/akuntansi/insinia/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/akuntansi/insinia/css/plugins/codemirror/codemirror.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/akuntansi/insinia/css/plugins/codemirror/ambiance.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/akuntansi/insinia/css/style.css" rel="stylesheet">

    <!-- Dari template lama -->
    <link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker3.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="<?php echo base_url();?>/assets/akuntansi/assets/images/favicon.png">
</head>

<body class="fixed-sidebar no-skin-config full-height-layout">

    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" src="<?php echo base_url();?>/assets/img/logo.png" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <h2><span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">SiAk</strong>
                             </span> <span class="text-muted text-xs block">Universitas Diponegoro</span> </span> </h2> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
               <?php 
                    echo $list_menu;
               ?>
        
                
<!--
                <li><a href="http://localhost/siak2018/index.php/akuntansi/kuitansi/monitor">Monitoring</a></li>
                <li><a href="http://localhost/siak2018/index.php/akuntansi/penerimaan/import_penerimaan">Import Penerimaan</a></li>
                <li><a href="http://localhost/siak2018/index.php/akuntansi/kuitansi/jadi">Kuitansi Jadi</a>0</li>
                <li><a href="http://localhost/siak2018/index.php/akuntansi/kuitansi/index">Kuitansi</a>0</li>
                <li >
                    <a href="#"><span class="nav-label">Laporan</span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="http://localhost/siak2018/index.php/akuntansi/laporan/rekap_jurnal">Buku Jurnal</a></li>
                        <li><a href="http://localhost/siak2018/index.php/akuntansi/laporan/buku_besar">Buku Besar</a></li>
                        <li><a href="http://localhost/siak2018/index.php/akuntansi/laporan/neraca_saldo">Neraca Saldo</a></li>
                    </ul>
                </li>
                <li><a href="http://localhost/siak2018/index.php/akuntansi/laporan/lra_unit">Laporan Realisasi Anggaran</a></li>
                <li><a href="http://localhost/siak2018/index.php/akuntansi/dashboard/dashboard_spm_terjurnal">Rekap SPM Siak</a></li>
-->
            </ul>
                


        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg" style="height:auto;">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message"> Selamat Datang di Sistem Akuntansi</span>
                </li>
                <li>
                    <a href="<?php echo site_url('akuntansi/pengaturan/ganti_password');?>">
                        <i class="fa fa-wrench"></i> Ubah Password
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('akuntansi/login/logout');?>">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <!-- <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">=
                    <h2>Outlook view</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Layouts</a>
                        </li>
                        <li class="active">
                            <strong>Outlook view</strong>
                        </li>
                    </ol>
                </div>
            </div> -->
            <div class="wrapper wrapper-content">
                <div class="animated fadeInRightBig row">
                    <div class="col-lg-12">
                        <?php if (isset($content)) { 
                            echo $content;
                        }
                        if(isset($bukti)){
                            echo $main_content;
                        }
                        ?>
                    </div>
                </div>
            </div>


            <div class="footer">
                <div class="pull-right">
                    SiAk 2018
                </div>
                <div>
                    <strong>Copyright</strong> Diponegoro University &copy; 2018
                </div>
            </div>
        </div>
        </div>



    <!-- Mainly scripts -->
    <script src="<?php echo base_url();?>/assets/akuntansi/insinia/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>/assets/akuntansi/insinia/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>/assets/akuntansi/insinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>/assets/akuntansi/insinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url();?>/assets/akuntansi/insinia/js/inspinia.js"></script>
    <script src="<?php echo base_url();?>/assets/akuntansi/insinia/js/plugins/pace/pace.min.js"></script>

    <!-- Tambahan diluar template -->
    <link rel="stylesheet" href="<?php echo base_url('assets/akuntansi/assets/EasyAutocomplete-1.3.5/easy-autocomplete.min.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/akuntansi/assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.PrintArea.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/moment-with-locales.js"></script>
    <script src="<?php echo base_url();?>/assets/akuntansi/js/notify.min.js"></script>

    <script type="text/javascript">
	<?php if ($this->session->flashdata('warning')): ?>
		$.notify('<?php echo $this->session->flashdata('warning') ?>',{
			globalPosition: 'top center',
			className : 'error'
		});
	<?php endif ?>
	<?php if ($this->session->flashdata('success')): ?>
		$.notify('<?php echo $this->session->flashdata('success') ?>',{
			globalPosition: 'top center',
			className : 'success'
		});
	<?php endif ?>
	</script>


</body>

</html>
