<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>KELOLA LS PIHAK KE 3</h2>   
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
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_unit_kbuu" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM LS PIHAK KE 3</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_unit_kbuu_nk" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>SPM LS PIHAK KE 3 NK</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                   
                    <?php elseif($this->check_session->get_level() == 3) : // VERIFIKATOR ?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_unit" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>DAFTAR UNIT L3K</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_unit_nk" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>DAFTAR UNIT LS3 NK</h4>
                      </a>
                      </div>
                  </div>
                    <?php elseif($this->check_session->get_level() == 13) : // BENDAHARA ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/dpa/realisasi_dpa/SELAIN-APBN/4" >
 <i class="fa fa-pencil-square fa-5x"></i>
                      <h4>DPA</h4>
                      </a>
                      </div>


                  </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/kuitansi_lsphk3/daftar_kuitansi2/L3" >
 <i class="fa fa-file-archive-o fa-5x"></i>
                      <h4>Kuitansi</h4>
                      </a>
                      </div>
					   </div>
                   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/dpa/realisasi_dpa/SELAIN-APBN/6" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>DPA L3NK</h4>
                      </a>
                      </div>
                  </div>
				   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/kuitansi_lsphk3/daftar_data_sppnk/L3NK" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>Data L3NK</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                                      
                     
                  </div>
				  
                    
                    <?php elseif($this->check_session->get_level() == 14) : // PPK ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_spp" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPP LS P3</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_spp_l3nk" >
 <i class="fa fa-bars fa-5x"></i>
                      <h4>SPP LSP3 NK</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                    
                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_spm" >
 <i class="fa fa-file-text fa-5x"></i>
                      <h4>SPM LS PIHAK KE 3</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/daftar_spm_nk" >
 <i class="fa fa-file fa-5x"></i>
                      <h4>SPM LS PIHAK KE 3 NK</h4>
                      </a>
                      </div>
                  </div>
                   
                    
                    
                    <?php endif; ?>
              </div>
                 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>