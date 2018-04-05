<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
	
	
   <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>

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

    <script type="text/javascript" src="<?php echo base_url(); ?>frontpage/plugins/jquery.marquee.js"></script>
    
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

      });
      
    

    </script>
    
    <!--script type="text/javascript" src="//code.jquery.com/jquery-1.12.3.js"></script-->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/kepeg_js/run_awal.js"></script>
   
    <link href="<?php echo base_url(); ?>assets/kepeg_js/css/my.css" rel="stylesheet" />
   
    <script type='text/javascript' src='<?php echo base_url();?>assets/kepeg_js/js/jquery.autocomplete.js'></script>
    <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script-->
   
    <link href='<?php echo base_url();?>assets/kepeg_js/js/jquery.autocomplete.css' rel='stylesheet' />

  

    
</head>
<body>
     
           
          
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
                        <h4 class="app-title visible-lg-block">Tahun Anggaran : <b><span style="color: #fff903">2018</span></b></h4>
                        <h4 class="app-title hidden-lg">TA : <b><span style="color: #fff903">2017</span></b></h4>
                        
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
	
	

      <?php echo (isset($message))?$message:'';?>

		<?php echo (isset($main_menu))?$main_menu:'';?>
	
      <?php echo (isset($main_content))?$main_content:'';?>
      
     
		
    <div class="footer">
      
    
            <div class="row">
                <div class="col-lg-12" >
                    &copy;  2016 BAUK | TIM IT BAPSI
                </div>
            </div>
        </div>
          
<div class="modal fade" id="myModalMsg" tabindex="-1" role="dialog" aria-labelledby="myModalMsgLabel">
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
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <!--<button type="button" class="btn btn-primary">Save changes</button>-->
          </div>
        </div>
    </div>
</div>
        
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <!-- <script src="assets/js/jquery-1.10.2.js"></script> -->
      <!-- BOOTSTRAP SCRIPTS -->
    <!-- <script src="assets/js/bootstrap.min.js"></script> -->
      <!-- CUSTOM SCRIPTS -->
    <!-- <script src="assets/js/custom.js"></script> -->
      <script src="<?php echo base_url(); ?>assets/kepeg_js/run.js" type="text/javascript"></script> 
   
</body>
</html>
