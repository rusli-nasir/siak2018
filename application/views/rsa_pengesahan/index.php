<?php 
$kd_jenis = 1;
$kd_kuitansi = 'GP';
switch ($jenis) {
  case "gup":
    # code...
    $kd_jenis = 1;
    $kd_kuitansi = 'GP';
    break;
  case "gup-nihil":
    # code...
    $kd_jenis = 1;
    $kd_kuitansi = 'GP';
    break;
  case "tup_nihil": 
    $kd_jenis = 3;
    $kd_kuitansi = 'TP';
    break;
  case "lsk": 
    $kd_jenis = 4;
    $kd_kuitansi = 'LK';
    break;
  case "ks_nihil":
    $kd_jenis = 5;
    $kd_kuitansi = 'KS';
    break;
  case "lsnk":
    $kd_jenis = 6;
    $kd_kuitansi = 'LN';
    break;
  case "em":
    $kd_jenis = 7;
    $kd_kuitansi = 'EM';
    break;
  default:
    $kd_jenis = 1;
    $kd_kuitansi = 'GP';
    break;
}
?>
<script type="text/javascript">
$(document).ready(function(){
     // $("#notif-dpa").load( "<?=site_url('dpa/get_notif_dpa')?>");
     // $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
     $("#notif-dpa-<?=$jenis?>").load( "<?=site_url('dpa/get_notif_dpa_siap/'.$kd_jenis)?>");

     // $("#notif-tambah-tup-spp-spm").load( "<?=site_url('rsa_tambah_tup/get_notif_approve')?>");
     // $("#notif-tup-spp-spm").load( "<?=site_url('rsa_tup/get_notif_approve')?>");
     // $("#notif-lsnk-spp-spm").load( "<?=site_url('rsa_lsnk/get_notif_approve_all')?>");
     $("#notif-<?=$jenis?>-spp-spm").load( "<?=site_url('rsa_'.$jenis.'/get_notif_approve_all')?>");
});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>KELOLA <?php echo strtoupper($jenis); ?></h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <!--
                <div class="row">
                    
                    <div class="col-lg-12 ">
                        <div class="alert alert-info">
                             <strong>Welcome Jhon Doe ! </strong> You Have No pending Task For Today.
                        </div>
                       
                    </div>
                    
                </div>
                  -->
                  <!-- /. ROW  --> 
                <div class="row text-center pad-top">
                    <?php if($this->check_session->get_level() == 11) : // KUASA BUU ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_unit_kbuu'); ?>" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-<?=$jenis?>-spp-spm">0</span>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 3) : // VERIFIKATOR ?>
                    

                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_unit'); ?>" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-<?=$jenis?>-spp-spm">0</span>
                     
                     
                  </div>
 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsk/tampil_data_kontrak" >
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>Daftar Kontrak</h4>
                      </a>
                      </div>
                     
                     
                  </div>

                    
                    <?php elseif($this->check_session->get_level() == 13) : // BENDAHARA ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           
                           <a href="<?php echo site_url('dpa/realisasi_dpa/SELAIN-APBN/'.$kd_jenis); ?>" >
 <i class="fa fa-pencil-square fa-5x"></i>
                      <h4>DPA</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-dpa-<?=$jenis?>">0</span>


                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('kuitansi/daftar_kuitansi/'.$kd_kuitansi); ?>" >
 <i class="fa fa-file-archive-o fa-5x"></i>
                      <h4>Kuitansi</h4>
                      </a>
                      </div>


                  </div>


                  
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('/rsa_'.$jenis.'/daftar_spp'); ?>" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPP</h4>
                      </a>
                      </div>
                     
                     
                  </div>


                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('/rsa_gaji_kuitansi/spm/'.$jenis); ?>" >
 <i class="fa fa-exclamation-triangle fa-5x"></i>
                      <h4>Pajak Kuitansi</h4>
                      </a>
                      </div>
                     
                     
                  </div>
  
                    
                    
                    
                    <?php elseif($this->check_session->get_level() == 14) : // PPK ?>
                    

                    
                    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsnk/spm_lsnk" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM</h4>
                      </a>
                      </div>


                  </div> -->


                  
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_spm'); ?>" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-<?=$jenis?>-spp-spm">0</span>
                     
                     
                  </div>

                    
                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_spm_kpa'); ?>" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-<?=$jenis?>-spp-spm">0</span>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 4) : // PUMK ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('dpa/realisasi_dpa/SELAIN-APBN/'.$kd_jenis); ?>" >
 <i class="fa fa-pencil-square fa-5x"></i>
                      <h4>DPA</h4>
                      </a>
                      </div>


                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('kuitansi/daftar_kuitansi/'.$kd_kuitansi); ?>" >
 <i class="fa fa-file-archive-o fa-5x"></i>
                      <h4>Kuitansi</h4>
                      </a>
                      </div>


                  </div>
 

                    <?php endif; ?>
                    
<!--                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-usd fa-5x"></i>
                      <h4>Saldo</h4>
                      </a>
                      </div>
                     
                     
                  </div> -->
                     
                    <!--        
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-key fa-5x"></i>
                      <h4>Admin </h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-comments-o fa-5x"></i>
                      <h4>Support</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    -->
              </div>
                 <!-- /. ROW  --> 
                 <!--
                <div class="row text-center pad-top">
                 
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>All Docs</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-gear fa-5x"></i>
                      <h4>Settings</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-wechat fa-5x"></i>
                      <h4>Live Talk</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-bell-o fa-5x"></i>
                      <h4>Notifications </h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-rocket fa-5x"></i>
                      <h4>Launch</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-user fa-5x"></i>
                      <h4>Register User</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
              </div>  
                 
                 -->
                  
                 <!-- /. ROW  -->  
                 <!--
          <div class="row">
                    <div class="col-lg-12 ">
          <br/>
                        <div class="alert alert-danger">
                             <strong>Want More Icons Free ? </strong> Checkout fontawesome website and use any icon <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Click Here</a>.
                        </div>
                       
                    </div>
                    </div>
                 
                 -->
                  <!-- /. ROW  --> 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>