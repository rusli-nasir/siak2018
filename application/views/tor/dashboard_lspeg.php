<script type="text/javascript">
$(document).ready(function(){
     // $("#notif-dpa").load( "<?=site_url('dpa/get_notif_dpa')?>");
     // $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
     $("#notif-dpa-lsp").load( "<?=site_url('dpa/get_notif_dpa_siap/2')?>");
     // $("#notif-dpa-tup").load( "<?=site_url('dpa/get_notif_dpa_siap/3')?>");
});
</script>
<div id="page-wrapper" >
  <div id="page-inner">
      
      <div class="row">
                    <div class="col-lg-12">
                     <h2>KELOLA LS-Pegawai</h2>   
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
       <!-- /. ROW  -->
        <!-- /. ROW  -->
      <div class="row text-center pad-top">
          <?php if(in_array($this->check_session->get_level(),array(11,13,3,2,14))) : ?>
          
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/dpa/realisasi_dpa/SELAIN-APBN/2" >
 <i class="fa fa-pencil-square fa-5x"></i>
                      <h4>DPA</h4>
                      </a>
                      </div>
                      <span class="badge badge-danger bg-notif" id="notif-dpa-lsp">0</span>


                  </div>

          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
              <div class="div-square">
                   <a href="<?php echo base_url(); ?>index.php/tor/daftar_spplspeg" >
<i class="fa fa-file fa-5x"></i>
              <h4>SPP LSP</h4>
              </a>
              </div>
          </div>

          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
              <div class="div-square">
                   <a href="<?php echo base_url(); ?>index.php/tor/daftar_spmlspeg" >
<i class="fa fa-file-text fa-5x"></i>
              <h4>SPM LSP</h4>
              </a>
              </div>
          </div>

          <?php endif; ?>
    </div>
       <!-- /. ROW  -->
</div>
   <!-- /. PAGE INNER  -->
  </div>
<!-- /. PAGE WRAPPER  -->
</div>
