<script type="text/javascript">
$(document).ready(function(){
    // $("#notif-dpa").load( "<?=site_url('dpa/get_notif_dpa')?>");
     // $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");

     $("#notif-up-spp-spm").load( "<?=site_url('rsa_up/get_notif_approve')?>");
     $("#notif-tambah-up-spp-spm").load( "<?=site_url('rsa_tambah_up/get_notif_approve')?>");
});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>KELOLA UP</h2>   
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
                           <a href="<?php echo base_url(); ?>index.php/setting_up" >
 <i class="fa fa-file-text-o fa-5x"></i>
                      <h4>Setting UP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/daftar_unit_kbuu" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM UP</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_up/daftar_unit_kbuu" >
 <i class="fa fa-arrow-circle-up fa-5x"></i>
                      <h4>PUP</h4>
                      </a>
                      </div>
                       <span class="badge badge-danger bg-notif" id="notif-tambah-up-spp-spm">0</span>
                     
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/spp_up" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/saldo" >
 <i class="fa fa-credit-card fa-5x"></i>
                      <h4>Saldo UP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    <?php elseif($this->check_session->get_level() == 3) : // VERIFIKATOR ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/daftar_unit" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM UP</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_up/daftar_unit" >
 <i class="fa fa-arrow-circle-up fa-5x"></i>
                      <h4>PUP</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-tambah-up-spp-spm">0</span>
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 13) : // BENDAHARA ?>
                    
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/spp_up" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>SPP UP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_up/spp_tambah_up" >
 <i class="fa fa-arrow-circle-up fa-5x"></i>
                      <h4>PUP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/daftar_spp" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    
                    
                    <?php elseif($this->check_session->get_level() == 14) : // PPK ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/spm_up" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM UP</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_up/spm_tambah_up" >
 <i class="fa fa-arrow-circle-up fa-5x"></i>
                      <h4>PUP</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-tambah-up-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/daftar_spm" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/spm_up_kpa" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM UP</h4>
                      </a>
                      </div>
                       <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span> 
                        
                     
                     
                  </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_up/spm_tambah_up_kpa" >
 <i class="fa fa-arrow-circle-up fa-5x"></i>
                      <h4>PUP</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-tambah-up-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/spp_up" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    <?php elseif($this->check_session->get_level() == 4) : // PUMK ?>
                    
                    
<!--                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/spp_up" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>SPP UP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/daftar_spp" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPP</h4>
                      </a>
                      </div>
                     
                     
                  </div>-->
                    
                    <?php endif; ?>
              </div>
                 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>