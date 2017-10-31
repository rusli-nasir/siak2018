<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Program Akuntansi UNDIP</title>

<link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker3.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/styles.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/my_style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>frontpage/css/custom.css" rel="stylesheet" />
<!-- datepicker -->
<link rel="stylesheet" href="<?php echo base_url('assets/akuntansi/assets/jquery-ui-1.11.4/jquery-ui.css'); ?>">
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/jquery.visible.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.PrintArea.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/moment-with-locales.js"></script>
<script src="<?php echo base_url('assets/akuntansi/assets/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/notify.min.js"></script>
    <script>
    moment.locale("id");
    </script>

<link rel="icon" type="image/png" href="<?php echo base_url();?>/assets/akuntansi/assets/images/favicon.png">
    <style>
        .badge-notify{
           background:red;
        }
        .close-tab-button {
            height: 20px;
            width: 20px;
            line-height: 20px;

            background-color: black;
            padding: 0px 2px;
            color: white;
            text-align: center;
            font-size: 1em;
        }
    </style>

<!--Icons-->
<script src="<?php echo base_url();?>/assets/akuntansi/js/lumino.glyphs.js"></script>


<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<nav id="myheader" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- <a class="navbar-brand" href="#">Sistem Informasi Rencana Umum Pengadaan Aset ULP UNDIP</a> -->
				<a href="#"><img class="img-responsive" src="<?php echo base_url(); ?>/assets/akuntansi/assets/images/logo-konten.png" alt="" /></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $this->session->userdata('username'); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							
							<li><a href="<?php echo site_url('akuntansi/pengaturan/ganti_password');?>"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Ganti Password</a></li>
							<li><a href="<?php echo site_url('akuntansi/login/logout');?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.container-fluid -->
	</nav>
	<br/>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li> <br/> </li>
		</ul>
		<ul class="nav menu">
			<?php if($this->session->userdata('level')==1){ ?>
            	<li class="<?php if(isset($menu1)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Kuitansi <?php if(isset($jumlah_notifikasi->kuitansi)) { ?><span class="badge <?= $jumlah_notifikasi->kuitansi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->kuitansi; ?></span> <?php } ?></a></li>
            	<li class="<?php if(isset($menu2)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Kuitansi Jadi <?php if(isset($jumlah_notifikasi->kuitansi_jadi)) { ?><span class="badge <?= $jumlah_notifikasi->kuitansi_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->kuitansi_jadi; ?></span> <?php } ?></a></li>
				<li class="<?php if(isset($menu5)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/memorial/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Memorial</a></li>
				<li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
						<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
				<li class="<?php if(isset($menu16)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Rekap SPM</a></li>
			<?php }else if($this->session->userdata('level')==2){ ?>
				<li class="<?php if(isset($menu2)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Verifikasi</a></li>
                <li class="<?php if(isset($menu3)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Posting</a></li>
				<li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
						<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
			      <li class="<?php if(isset($menu16)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Rekap SPM</a></li>
			<?php }else if($this->session->userdata('level')==3){ ?>
				<li class="<?php if(isset($menu4)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/penerimaan/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Penerimaan</a></li>
				<li class="<?php if(isset($menu5)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/memorial/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Memorial</a></li>
				<li class="<?php if(isset($menu6)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/jurnal_umum/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Jurnal-APBN</a></li>
				<li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
						<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>			
			        </ul>
			      </li>
			     <li class="<?php if(isset($menu6)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/lainnya'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Laporan Utama</a></li>
				<li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Adminsitrasi
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li class="<?php if(isset($menu13)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/user/manage'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Manj. User</a></li>	
					     <li class="<?php if(isset($menu14)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/pejabat/manage'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Manj. Pejabat</a></li>	
					     <li class="<?php if(isset($menu15)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/akun/list_akun'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Manj. Akun</a></li>	
						<li class="<?php if(isset($menu7)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/rekening/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Manj. Rekening</a></li>
						<li class="<?php if(isset($menu8)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/saldo/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Man. Saldo</a></li>
						<li class="<?php if(isset($menu12)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/editor/edit_kuitansi'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Manj. Kuitansi terjurnal RSA</a></li>
			        </ul>
			      </li>	
			      <li class="<?php if(isset($menu16)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Rekap SPM</a></li>			
			<?php }else if($this->session->userdata('level')==4){ ?>
				<li class="<?php if(isset($menu5)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/monitor'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Monitoring</a></li>	
				<li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
			<?php } else if($this->session->userdata('level')==5){ ?>
			     <li class="<?php if(isset($menu6)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/jurnal_umum/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Jurnal-APBN</a></li>
			     <li class="<?php if(isset($menu16)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/jurnal_umum/import_jurnal_umum'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>Import Jurnal-APBN</a></li>
                <li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
			<?php } else if($this->session->userdata('level')==6){ ?>
			     <li class="<?php if(isset($menu6)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/monitor'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Monitoring</a></li>
                <li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
			      <li class="<?php if(isset($menu16)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_spm'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Rekap SPM</a></li>
			<?php } else if($this->session->userdata('level')==7){ ?>
                <li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
			<?php } else if($this->session->userdata('level')==8){ ?>
                <li class="<?php if(isset($menu4)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/penerimaan/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Penerimaan</a></li>
                <li class="<?php if(isset($menu13)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/penerimaan/import_penerimaan'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Import Penerimaan</a></li>
                <li class="<?php if(isset($menu5)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/memorial/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Memorial</a></li>
                <li class="dropdown">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
			        <span class="caret"></span></a>
			        <ul class="dropdown-menu">
			          	<li class="<?php if(isset($menu9)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/buku_besar'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Besar</a></li>
			          	<li class="<?php if(isset($menu10)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/rekap_jurnal'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Buku Jurnal</a></li>
						<li class="<?php if(isset($menu11)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/laporan/neraca_saldo'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Neraca Saldo</a></li>
			        </ul>
			      </li>	
			<?php } else if($this->session->userdata('level')==9){ ?>
			     <li class="<?php if(isset($menu13)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/user/manage'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Manj. User</a></li>	
			     <li class="<?php if(isset($menu14)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/pejabat/manage'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Manj. Pejabat</a></li>	
			     <li class="<?php if(isset($menu15)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/akun/list_akun'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Manj. Akun</a></li>	
			<?php } ?>

		</ul>

	</div><!--/.sidebar-->
	
	<div id="mycontent" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="padding-bottom:10px;">
	<?php echo $content;?>
	<?php 
	if(isset($bukti)){
		echo $main_content;
	}
	?>
	</div>	<!--/.main-->

	<!-- <script src="<?php echo base_url();?>/assets/akuntansi/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script> -->
	<!--<script src="<?php echo base_url();?>/js/chart.min.js"></script>
	<script src="<?php echo base_url();?>/js/chart-data.js"></script>
	<script src="<?php echo base_url();?>/js/easypiechart.js"></script>
	<script src="<?php echo base_url();?>/js/easypiechart-data.js"></script>-->
	<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/akuntansi/assets/EasyAutocomplete-1.3.5/easy-autocomplete.min.css'); ?>">
	<script type="text/javascript" src="<?php echo base_url('assets/akuntansi/assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script>
		$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){
		        $(this).find('em:first').toggleClass("glyphicon-minus");
		    });
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) {$('#sidebar-collapse').collapse('show')}
		  if ($(window).width() <= 767) {$('#sidebar-collapse').collapse('hide')}
			var myheadheight = $('#myheader').height();
				$("#mycontent").css('margin-top',myheadheight);
		})

		$(document).ready(function () {
			var myheadheight = $('#myheader').height();
				$("#mycontent").css('margin-top',myheadheight);
		})

		$( ".navbar-toggle " ).mouseup(function() {
			// alert($(".col-sm-3.col-lg-2.sidebar.collapse.in"));
			var myheadheight = $('#myheader').height();
			// alert(myheadheight);
		  $("#sidebar-collapse").css({"margin-top": myheadheight, "margin-bottom": - myheadheight});
		});

	</script>
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
