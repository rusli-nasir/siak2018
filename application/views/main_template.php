<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $start = $time;
    ?>
    <script type="text/javascript">
         var timerStart = Date.now();
    </script>
       
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?php echo base_url(); ?>frontpage/assets/ico/favicon.ico">
    <title>.: RSA UNDIP :.</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="<?php echo base_url(); ?>frontpage/css/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONTAWESOME STYLES-->
    <link href="<?php echo base_url() ?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
   
    <!-- GOOGLE FONTS-->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> -->
   
   
    <link href="<?php echo base_url(); ?>frontpage/css/custom.css" rel="stylesheet" />
	
    <link media="screen" rel="stylesheet" href="<?php echo base_url(); ?>frontpage/plugins/jvalidation/css/validationEngine.jquery.css" />
    
    <link href="<?php echo base_url(); ?>frontpage/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    
	<!--<link href="<?php echo base_url(); ?>frontpage/css/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet"/>-->

    <link href="<?php echo base_url(); ?>frontpage/plugins/datepicker/css/datepicker.css" rel="stylesheet"/>

    <link href="<?php echo base_url(); ?>frontpage/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet"/>
	
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>

    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-2.2.4/jquery-2.2.4.min.js"></script>-->

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/colorbox/js/jquery.colorbox.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jvalidation/js/jquery.validationEngine-id.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jvalidation/js/jquery.validationEngine.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/excelexportjs/dist/jquery.techbytarun.excelexportjs.js"></script>
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/excelexportjs/dist/jquery.btechco.excelexport.js"></script>--> 
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.base64.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/dragscroll.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/autosize/autosize.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/FileSaver.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/canvas-toBlob.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/html2canvas.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/html2canvas.svg.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/moment/moment-with-locales.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.PrintArea.js"></script>
    
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>-->
    
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jsPDF/dist/jspdf.min.js"></script>-->
    
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jsPDF/libs/html2pdf.js"></script>-->
    
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jsPDF/plugins/addhtml.js"></script>-->

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.marquee.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/bootbox.min.js"></script>

    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>-->

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/datepicker/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.visible.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/bootstrap3-typeahead.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/notify.min.js"></script>

    
    
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>-->
	
	

    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/KeyTable.js"></script>-->
    
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.ba-dotimeout.js"></script>-->
    
    
    <!--
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/tableexport/tableExport.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/tableexport/jquery.base64.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/tableexport/html2canvas.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/tableexport/jspdf/libs/sprintf.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/tableexport/jspdf/jspdf.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/tableexport/jspdf/libs/base64.js"></script>
    -->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        
        $.fn.editable.defaults.mode = 'popup'; 
        
        $(window).on("load resize",function(e){

                if ($(this).width() < 768) {
                        $('div.sidebar-collapse').addClass('collapse')
                    } else {
                        $('div.sidebar-collapse').removeClass('collapse')
                    }
            });
            
            
            
      $(document).ready(function(){
          
            jQuery.fx.off = true;
          
            if( $.trim( $('.body-msg-text').html() ).length ) {
                //alert($('.body-msg-text').text());
                $('#myModalMsg').modal('show');
            }
         
            $('.marquee-div').marquee({
                    //speed in milliseconds of the marquee
                    duration: 20000,
                    //gap in pixels between the tickers
                    gap: 500,
                    //time in milliseconds before the marquee will start animating
                    delayBeforeStart: 0,
                    //'left' or 'right'
                    direction: 'left',
                    //true or false - should the marquee be duplicated to show an effect of continues flow
                    duplicated: true,
                    
                    pauseOnHover: true,
            });
            
            var urln = window.location.href ;
            
            $('a[href="' + urln + '"]').parent().addClass('active-link');
            
            $(document).on('show.bs.modal', '.modal', function () {
                var zIndex = 1040 + (10 * $('.modal:visible').length);
                $(this).css('z-index', zIndex);
                setTimeout(function() {
                    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                }, 0);
            });
            
            $(document).on('hidden.bs.modal', '.modal', function () {
                $('.modal:visible').length && $(document.body).addClass('modal-open');
            });
            

            $("#infoModal").modal("show");
            

      });

    </script>
  
    
  
   
    
</head>
<body>
<!--
    <div class="modal_ajax_loading" style="background-color: rgba(242, 156, 152, 0.1);width:100%;height:100vh;z-index:9999;position:fixed;display:none;">
      <div style="position: fixed;top: 50%; left: 50%;transform: translate(-50%,-50%);width: 60px;height: 60px;color:#fff;font-weight: bold;text-align: center;">
        <img src="<?php echo base_url(); ?>assets/img/heart.gif" width="60"/>
      </div>
    </div>
    -->

    <div class="modal_ajax_loading" style="background-color: rgba(242, 156, 152, 0.1);width:100%;height:100vh;z-index:9999;position:fixed;display:none;">
      <div style="position: fixed;top: 50%; left: 50%;transform: translate(-50%,-50%);color:#fff;font-weight: bold;text-align: center;">
        <img src="<?php echo base_url(); ?>assets/img/heart.gif" />
      </div>
    </div>
    <div id="wrapper">
         <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <!--<div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">-->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                        </button>
                   <a class="navbar-brand" href="#">
                                <img src="<?php echo base_url(); ?>frontpage/images/logo.png" />

                        </a>
                         
                        <h3 class="app-title visible-lg-block"><b>REALISASI ANGGARAN ( RSA ) UNDIP</b></h3>
                        <h3 class="app-title hidden-lg"><b>RSA UNDIP </b></h3>
                        <h4 class="app-title visible-lg-block">Tahun Anggaran : <b><span style="color: #fff903"><?php echo isset($cur_tahun)?$cur_tahun:''; ?></span></b></h4>
                        <h4 class="app-title hidden-lg">TA : <b><span style="color: #fff903"><?php echo isset($cur_tahun)?$cur_tahun:''; ?></span></b></h4>
                        
                    <!--</div>-->
<!--                        <div class="row">
                                <div class="col-sm-1">

                                </div>
                                <div class="col-sm-9">

                                </div>
                                <div class="col-sm-2">

                                </div>
                        </div>-->
                </div>
              
                
            </div>
        </div>
        <!-- /. NAV TOP  -->
	
	

    <?php // echo (isset($message))?$message:'';?>

    <?php echo (isset($main_menu))?$main_menu:'';?>
        
        <div >
            &nbsp;
        </div>
        <?php if(isset($_SESSION['rsa_nama_unit'])): ?>
        <div id="panel-user">
            <div id="panel-inner">
                <div class="row" style="margin: 0">    
                    <div class="col-md-6">
                        <ul class="list-group" style="margin:0 0 5px;">
                            <li class="list-group-item">
                                <div class="row" style="margin: 0">
                                    <?php if(strlen($_SESSION['rsa_kode_unit_subunit']) == 2): ?>
                                    <div class="col-md-4"><b>SUKPA</b></div><div class="col-md-8">: <span class="text-danger"><b><?=$_SESSION['rsa_nama_unit']?></b></span></div> 
                                    <?php elseif(strlen($_SESSION['rsa_kode_unit_subunit']) == 4): ?>
                                    <div class="col-md-4"><b>SUKPA</b></div><div class="col-md-8">: <span class="text-danger"><b><?=get_h_unit(substr($_SESSION['rsa_kode_unit_subunit'],0,2))?></b></span></div> 
                                    <div class="col-md-4"><b>SUBUNIT</b></div><div class="col-md-8">: <span class="text-danger"><b><?=$_SESSION['rsa_nama_unit']?></b></span></div> 
                                    <?php elseif(strlen($_SESSION['rsa_kode_unit_subunit']) == 6): ?>
                                    <div class="col-md-4"><b>SUKPA</b></div><div class="col-md-8">: <span class="text-danger"><b><?=get_h_unit(substr($_SESSION['rsa_kode_unit_subunit'],0,2))?></b></span></div> 
                                    <div class="col-md-4"><b>SUBUNIT</b></div><div class="col-md-8">: <span class="text-danger"><b><?=get_h_subunit(substr($_SESSION['rsa_kode_unit_subunit'],0,4))?></b></span></div> 
                                    <div class="col-md-4"><b>SUB SUBUNIT</b></div><div class="col-md-8">: <span class="text-danger"><b><?=$_SESSION['rsa_nama_unit']?></b></span></div> 
                                    <?php endif; ?>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-4"><b>SEBAGAI</b></div><div class="col-md-8">: <span class="text-danger"><b><?=get_level($_SESSION['rsa_level'])?></b></span></div> 
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php if($_SESSION['rsa_kode_unit_subunit'] == '99'): ?>
                        <?php if($_SESSION['rsa_level'] == '11'): ?>
                    <div class="col-md-6">
                        <div class="panel panel-danger" style="margin-bottom: 0;">
                            <div class="panel-heading">
                              <h3 class="panel-title">SALDO KAS</h3>
                            </div>
                            <div class="panel-body">
                                <h3 style="margin: 0"><span class="text-danger">Rp. <?=number_format(get_total_kas(), 0, ",", ".")?>,-</span></h3>
                            </div>
                        </div>
                    </div>
                        <?php endif; ?>
                    <?php else: ?>
                    <div class="col-md-6">
                    <ul class="list-group" style="margin:0 0 5px;">
                        <li class="list-group-item">
                            <div class="row" style="margin: 0">
                                <div class="col-md-4"><b>SELAIN APBN</b></div><div class="col-md-1">:</div> <div class="col-md-5" style="text-align: right"><span class="text-danger"><b>Rp. <span id="pagu_rkat"><?=number_format(get_pagu_rkat($_SESSION['rsa_kode_unit_subunit'],$cur_tahun,'SELAIN-APBN'), 0, ",", ".")?></span></b></span></div><div class="col-md-2">&nbsp;</div>
                                <div class="col-md-4"><b>BPPTNBH</b></div><div class="col-md-1">:</div> <div class="col-md-5" style="text-align: right"><span class="text-danger"><b>Rp. <span id="pagu_rkat"><?=number_format(get_pagu_rkat($_SESSION['rsa_kode_unit_subunit'],$cur_tahun,'APBN-BPPTNBH'), 0, ",", ".")?></span></b></span></div><div class="col-md-2">&nbsp;</div>
                                <div class="col-md-4"><b>SILPA, DLL</b></div><div class="col-md-1">:</div> <div class="col-md-5" style="text-align: right"><span class="text-danger"><b>Rp. <span id="pagu_rkat"><?=number_format(get_pagu_rkat($_SESSION['rsa_kode_unit_subunit'],$cur_tahun,'APBN-LAINNYA'), 0, ",", ".")?></span></b></span></div><div class="col-md-2">&nbsp;</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row" style="margin: 0">
                                <div class="col-md-4"><b>PENGELUARAN</b></div><div class="col-md-1">:</div> <div class="col-md-5" style="text-align: right"><span class="text-danger"><b>Rp. <span id="pagu_rkat"><?=number_format(get_total_pengeluaran($_SESSION['rsa_kode_unit_subunit'],$cur_tahun), 0, ",", ".")?></span></b></span></div><div class="col-md-2">&nbsp;</div>
                            </div>
                        </li>
<!--                        <li class="list-group-item">
                            <div class="row" style="margin: 0">
                                <div class="col-md-4"><b>UP TERSEDIA</b></div><div class="col-md-8">: <span class="text-danger">Rp. <span id="saldo_kas"><?=number_format(get_saldo_up($_SESSION['rsa_kode_unit_subunit'],$cur_tahun), 0, ",", ".")?></span>,-</span></div> 
                            </div>
                        </li>-->
                    </ul>
                    </div>
<!--                    <div class="col-md-6">
                        <div class="panel panel-danger" style="margin-bottom: 0;">
                            <div class="panel-heading">
                              <h3 class="panel-title">UP TERSEDIA</h3>
                            </div>
                            <div class="panel-body">
                                <h3 style="margin: 0"><span class="text-danger">Rp. <span id="saldo_kas"><?=number_format(get_saldo_up($_SESSION['rsa_kode_unit_subunit'],$cur_tahun), 0, ",", ".")?></span>,-</span></h3>
                            </div>
                        </div>
                    </div>-->
                    <?php endif; ?>
                    <?php // var_dump($_SESSION); ?>
                </div>
            </div>
        </div>
        
        <?php endif; ?>
	
    <?php echo (isset($main_content))?$main_content:'';?>
      
     
		
    <div class="footer" style="background-color: #ca5053;">
      
    
            <div class="row">
                <div class="col-lg-12" >
                    &copy;  2016 BAUK | TIM IT BAPSI
                </div>
            </div>
        </div>
          
<div class="modal" id="myModalMsg" tabindex="-1" role="dialog" aria-labelledby="myModalMsgLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Perhatian</h4>
          </div>
          <div class="modal-body body-msg-text">
            <?php if($this->session->flashdata('message')){ ?>
                <?php echo $this->session->flashdata('message'); ?>
            <?php } ?>
          </div>
           
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
          </div>
        </div>
    </div>
</div>
    
    
    
    <!-- MODAL -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

</div>
<div class="modal" id="myModalMsg" tabindex="-1" role="dialog" aria-labelledby="myModalMsgLabel">

</div>
<div class="modal" id="myModalOption" tabindex="-1" role="dialog" aria-labelledby="myModalOptionLabel">

</div>
<?php
$pengumuman = 0;
if($pengumuman !=0){
?>
	<!-- modal maintenance by andys -->
	<div class="modal" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>
				 <!-- <h4 class="modal-title" id="memberModalLabel">Maintenance System!</h4> -->
                 <h4 class="modal-title" id="memberModalLabel">PERHATIAN</h4>

			</div>
			<div class="modal-body">
                <p>TOLONG JANGAN ADA BUAT DPA BARU SEKITAR 5 MENIT DARI SEKARANG . KARENA AKAN ADA EKSPOR PERUBAHAN RKAT DARI MWA.</p>
                <p>( tinggal sholat ashar dulu kalo bisa..)</p>
            <!--
				<p>
				Terima kasih telah menjadi inspirasi kami untuk selalu berusaha meningkatkan performa system setiap saat. 
				Oleh karena itu, kami akan melakukan proses maintenance pada: 
				<br/><br/>
				<b>Rabu, 5 Mei 2017</b> mulai pukul <b>12:00 WIB</b> sampai dengan pukul <b>13:00 WIB</b>.
				<br/><br/>
				Kami mohon maaf atas ketidaknyamanannya dan pastikan Anda Tidak menggunakan system di luar jam di atas.
				</p>
            -->
				<br>
            <!--
				<p>
					Terima kasih<br><br>
					ttd<br>
					Ka. Subbag Data. & Applikasi
				<p>
            -->
                <p>
                    TERIMA KASIH<br><br>
                    <br>
                    
                <p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	</div>
	<!-- modal -->
	<!-- END MODAL -->
	<?php if(!empty($_SESSION['rsa_kode_unit_subunit'])){ ?>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#infoModal').modal('show');
		});
	</script>
	<?php } ?>
<?php } ?>
<!-- END MODAL -->
        
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <!-- <script src="assets/js/jquery-1.10.2.js"></script> -->
      <!-- BOOTSTRAP SCRIPTS -->
    <!-- <script src="assets/js/bootstrap.min.js"></script> -->
      <!-- CUSTOM SCRIPTS -->
    <!-- <script src="assets/js/custom.js"></script> -->
      
      
      
<script src="<?php echo base_url(); ?>assets/kepeg_js/run.js"></script>
<script type="text/javascript">
    $(document).on({
    ajaxStart: function() { $('.modal_ajax_loading').show();  },
    ajaxStop: function() { $('.modal_ajax_loading').hide(); }
    });
	$(document).ready(function(e){
		$('a, button').tooltip({
			delay:0,
			template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner" style="max-width:200px;min-width:150px;"></div></div>',
			trigger: 'hover'
		});
	});

    // $(document).ajaxComplete(function( event, xhr, settings ) {
        

        // });


</script>
<script type="text/javascript">
   $(document).ready(function() {
    var time_dom =  (Date.now()-timerStart) / 1000;
    $("#time_dom").html("Time until DOMready: "+time_dom+" seconds");
});
   $(window).on('load', function() {
    var time_all_load = (Date.now()-timerStart) / 1000;
    $("#time_all_load").html("Time until everything loaded: "+time_all_load+" seconds");
});
</script>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
?>
<div class="col-md-12 text-right" style="color: #fff;z-index: 1;">
    <span>Page generated in <?php echo $total_time ?> seconds</span>
    <br>
    <span id="time_dom" style="margin: 0px;padding: 0px;"></span>
    | 
    <span id="time_all_load" style="margin: 0px;padding: 0px;"></span>
</div>
</body>
</html>
