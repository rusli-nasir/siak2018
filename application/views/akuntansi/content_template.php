<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sistem Informasi Rencana Pengambangan Sarana dan Prasarana UNDIP</title>

<link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker3.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/styles.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/my_style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>frontpage/css/custom.css" rel="stylesheet" />
<!-- datepicker -->
<link rel="stylesheet" href="<?php echo base_url('assets/akuntansi/assets/jquery-ui-1.11.4/jquery-ui.css'); ?>">
<script src="<?php echo base_url('assets/akuntansi/assets/datepicker/jquery-1.10.2.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/moment-with-locales.js"></script>
<script src="<?php echo base_url('assets/akuntansi/assets/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>

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
							
							<li><a href="<?php echo site_url('user_setting');?>"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="<?php echo site_url('akuntansi/login/logout');?>"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.container-fluid -->
	</nav>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<?php if($this->session->userdata('level')==1){ ?>
            	<li class="<?php if(isset($menu1)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Kuitansi<span class="badge <?= $jumlah_notifikasi->kuitansi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->kuitansi; ?></span></a></li>
            	<li class="<?php if(isset($menu2)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Kuitansi Jadi<span class="badge <?= $jumlah_notifikasi->kuitansi_jadi ? "badge-notify" : ""; ?> right"><?= $jumlah_notifikasi->kuitansi_jadi; ?></span></a></li>
			<?php }else if($this->session->userdata('level')==2){ ?>
				<li class="<?php if(isset($menu2)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/jadi'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Kuitansi Jadi</a></li>
                <li class="<?php if(isset($menu3)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/kuitansi/posting'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Posting</a></li>
			<?php }else if($this->session->userdata('level')==3){ ?>
				<li class="<?php if(isset($menu4)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/penerimaan/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Penerimaan</a></li>
				<li class="<?php if(isset($menu5)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/memorial/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Memorial</a></li>
				<li class="<?php if(isset($menu6)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/memorial/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Jurnal-APBN</a></li>
				<hr/>
				<li class="<?php if(isset($menu7)) echo 'active'; ?>"><a href="<?php echo site_url('akuntansi/rekening/index'); ?>"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Rekening</a></li>
			<?php } ?>
		</ul>

	</div><!--/.sidebar-->
	
	<div id="mycontent" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="padding-bottom:10px;">
	<?php echo $content;?>
	</div>	<!--/.main-->

	<!-- <script src="<?php echo base_url();?>/assets/akuntansi/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap.min.js"></script> -->
	<!--<script src="<?php echo base_url();?>/js/chart.min.js"></script>
	<script src="<?php echo base_url();?>/js/chart-data.js"></script>
	<script src="<?php echo base_url();?>/js/easypiechart.js"></script>
	<script src="<?php echo base_url();?>/js/easypiechart-data.js"></script>-->
	<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>/assets/akuntansi/js/detail_kegiatan.js"></script>
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
</body>

</html>
