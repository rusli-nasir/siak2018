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
                      
                    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/setting_up" >
 <i class="fa fa-file-text-o fa-5x"></i>
                      <h4>Setting UP</h4>
                      </a>
                      </div>
                     
                     
                  </div> -->

                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_unit_kbuu'); ?>" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    
                    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/saldo" >
 <i class="fa fa-credit-card fa-5x"></i>
                      <h4>Saldo UP</h4>
                      </a>
                      </div>
                     
                     
                  </div> -->

                    <?php elseif($this->check_session->get_level() == 3) : // VERIFIKATOR ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_unit'); ?>" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 13) : // BENDAHARA ?>
                    
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_spp'); ?>" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <!--
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_tambah_up/spp_tambah_up" >
 <i class="fa fa-arrow-circle-up fa-5x"></i>
                      <h4>PUP</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  -->
                    
                    
                    
                    <?php elseif($this->check_session->get_level() == 14) : // PPK ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_spm'); ?>" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>Daftar SPM</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo site_url('rsa_'.$jenis.'/daftar_spm_kpa'); ?>" >
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
                    
                    
                  <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
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
                        <a href="<?php echo base_url(); ?>index.php/kuitansi/daftar_kuitansi/TP" >
                            <i class="fa fa-file-archive-o fa-5x"></i>
                            <h4>Kuitansi</h4>
                        </a>
                    </div>
                </div> -->


                </div>
                    <?php endif; ?>
              </div>
                 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>