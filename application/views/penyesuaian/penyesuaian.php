<script type="text/javascript">
$(document).ready(function(){
$("#notif-tidak-sesuai").load( "<?=site_url('penyesuaian/get_notif_tidak_sesuai')?>");
$("#notif-sesuai-trx").load( "<?=site_url('penyesuaian/get_notif_trx')?>");
$("#notif-sesuai-kuitansi").load( "<?=site_url('penyesuaian/get_notif_kuitansi')?>");
// $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
// $("#notif-dpa-tup").load( "<?=site_url('dpa/get_notif_dpa_siap/3')?>");
  $('#penyesuaian').on("click",function(){
    if(confirm("Konfirmasi, Lakukan Penyesuaian Sekarang?")){
      $.ajax({
          type:"GET",
          url :"<?=site_url("penyesuaian/sesuaikan")?>",
          data:'',
          success:function(data){
              if(data == 'sukses'){
                  bootbox.alert({
                      title: "PESAN",
                      message: "PENYESUAIAN BERHASIL DILAKUKAN <i class='fa fa-check fa-2x text-success'></i>"
                  });
                  $("#notif-tidak-sesuai").load( "<?=site_url('penyesuaian/get_notif_tidak_sesuai')?>");
             }
          }
      });
    }
    else{
      return false;
    }
  })

  $('#penyesuaian2').on("click",function(){
    if(confirm("Konfirmasi, Lakukan Penyesuaian Sekarang?")){
      $.ajax({
          type:"GET",
          url :"<?=site_url("penyesuaian/sesuaikan2")?>",
          data:'',
          success:function(data){
              if(data == 'sukses'){
                  bootbox.alert({
                      title: "PESAN",
                      message: "PENYESUAIAN BERHASIL DILAKUKAN <i class='fa fa-check fa-2x text-success'></i>"
                  });
                  $("#notif-sesuai-trx").load( "<?=site_url('penyesuaian/get_notif_trx')?>");
             }
          }
      });
    }
    else{
      return false;
    }
  });

  $('#penyesuaian3').on("click",function(){
    if(confirm("Konfirmasi, Lakukan Penyesuaian Sekarang?")){
      $.ajax({
          type:"GET",
          url :"<?=site_url("penyesuaian/sesuaikan3")?>",
          data:'',
          success:function(data){
              if(data == 'sukses'){
                  bootbox.alert({
                      title: "PESAN",
                      message: "PENYESUAIAN BERHASIL DILAKUKAN <i class='fa fa-check fa-2x text-success'></i>"
                  });
                  $("#notif-sesuai-kuitansi").load( "<?=site_url('penyesuaian/get_notif_kuitansi')?>");
             }
          }
      });
    }
    else{
      return false;
    }
  });


});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>PENYESUAIAN DATA BELANJA</h2>   
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
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                        <div class="div-square">
                         <a href="javascript:void(0)" id="penyesuaian">
                           <i class="fa fa-refresh fa-5x"></i>
                           <h4>Sesuaikan Belanja</h4>
                         </a>
                       </div>

                     </div>

                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                      <div class="div-square">
                       <a href="<?php echo base_url(); ?>index.php/penyesuaian/daftar_belum_sesuai" >
                         <i class="fa fa-th-list fa-5x"></i>
                         <h4>Daftar Belanja Belum Sesuai</h4>
                       </a>
                     </div>
                     <span class="badge badge-danger bg-notif" id="notif-tidak-sesuai">0</span>
                   </div>

                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                        <div class="div-square">
                         <a href="javascript:void(0)" id="penyesuaian2">
                           <i class="fa fa-refresh fa-5x"></i>
                           <h4>Sesuaikan TRX</h4>
                         </a>
                       </div>
                      <span class="badge badge-danger bg-notif" id="notif-sesuai-trx">0</span>
                     </div>

                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                        <div class="div-square">
                         <a href="javascript:void(0)" id="penyesuaian3">
                           <i class="fa fa-refresh fa-5x"></i>
                           <h4>Sesuaikan Kuitansi</h4>
                         </a>
                       </div>
                      <span class="badge badge-danger bg-notif" id="notif-sesuai-kuitansi">0</span>
                     </div>

                    <?php endif; ?>
                </div>
              </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>