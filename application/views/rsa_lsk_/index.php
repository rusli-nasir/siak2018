<script type="text/javascript">
$(document).ready(function(){
     // $("#notif-dpa").load( "<?=site_url('dpa/get_notif_dpa')?>");
     // $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
     $("#notif-dpa-tup").load( "<?=site_url('dpa/get_notif_dpa_siap/3')?>");

     $("#notif-tambah-tup-spp-spm").load( "<?=site_url('rsa_tambah_tup/get_notif_approve')?>");
     $("#notif-tup-spp-spm").load( "<?=site_url('rsa_tup/get_notif_approve')?>");
});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>KELOLA TUP</h2>   
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
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_tup/daftar_unit_kbuu" >
 <i class="fa fa-arrow-circle-down fa-5x"></i>
                      <h4>TUP</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-tambah-tup-spp-spm">0</span>
                     
                     
                  </div>

                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tup/daftar_unit_kbuu" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>TUP-NIHIL</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 3) : // VERIFIKATOR ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_tup/daftar_unit" >
 <i class="fa fa-arrow-circle-down fa-5x"></i>
                      <h4>TUP</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-tambah-tup-spp-spm">0</span>
                     
                     
                  </div>

                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tup/daftar_unit" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>TUP-NIHIL</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                     
                     
                  </div>

                    
                    <?php elseif($this->check_session->get_level() == 13) : // BENDAHARA ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/dpa/realisasi_dpa/SELAIN-APBN/3" >
 <i class="fa fa-pencil-square fa-5x"></i>
                      <h4>DPA</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-dpa-tup">0</span>


                  </div>

                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_tup/spp_tambah_tup" >
 <i class="fa fa-arrow-circle-down fa-5x"></i>
                      <h4>TUP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/kuitansi/daftar_kuitansi/TP" >
 <i class="fa fa-file-archive-o fa-5x"></i>
                      <h4>Kuitansi</h4>
                      </a>
                      </div>


                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tup/spp_tup" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>TUP NIHIL</h4>
                      </a>
                      </div>
                    
                     
                  </div>


                  
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_gup/daftar_spp" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    
                    
                    <?php elseif($this->check_session->get_level() == 14) : // PPK ?>
                    

                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_tup/spm_tambah_tup" >
 <i class="fa fa-arrow-circle-down fa-5x"></i>
                      <h4>TUP</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-tambah-tup-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tup/spm_tup" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>TUP NIHIL</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                     
                  </div>

                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_gup/daftar_spm" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>

                    
                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_tup/spm_tambah_tup_kpa" >
 <i class="fa fa-arrow-circle-down fa-5x"></i>
                      <h4>TUP</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-tambah-tup-spp-spm">0</span>
                     
                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tup/spm_tup_kpa" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>TUP NIHIL</h4>
                      </a>
                      </div>
                     <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                     
                  </div>

                                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_gup/daftar_spm" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 4) : // PUMK ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/dpa/realisasi_dpa/SELAIN-APBN/1" >
 <i class="fa fa-pencil-square fa-5x"></i>
                      <h4>DPA</h4>
                      </a>
                      </div>


                  </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/kuitansi/daftar_kuitansi/GP" >
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