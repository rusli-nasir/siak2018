<script type="text/javascript">
$(document).ready(function(){
        // bootbox.alert({
        //     title: "PESAN",
        //     message: "TUP SUDAH BISA DIGUNAKAN, SILAHKAN DIPAKAI.<br>THX.",
        // });
     $("#notif-dpa").load( "<?=site_url('dpa/get_notif_dpa')?>");
     $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
     $("#notif-dpa-lsp").load( "<?=site_url('dpa/get_notif_dpa_siap/2')?>");
     $("#notif-dpa-tup").load( "<?=site_url('dpa/get_notif_dpa_siap/3')?>");
     $("#notif-dpa-ks").load( "<?=site_url('dpa/get_notif_dpa_siap/5')?>");

     $("#notif-up-spp-spm").load( "<?=site_url('rsa_up/get_notif_approve_all')?>");
     $("#notif-gup-spp-spm").load( "<?=site_url('rsa_gup/get_notif_approve')?>");
     $("#notif-tup-spp-spm").load( "<?=site_url('rsa_tup/get_notif_approve_all')?>");

});
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2>DASHBOARD</h2>
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

                    <?php if($this->check_session->get_level() == 1) : // AKUNTANSI ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" >
   <i class="fa fa-cubes fa-5x"></i>
                        <h4>Revisi DPA</h4>
                        </a>
                        </div>
                    </div>
          
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/dpa/kroscek" >
   <i class="fa fa-exchange fa-5x"></i>
                        <h4>Kroscek</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_rsa_kpa/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup" >
   <i class="fa fa-th-large fa-5x"></i>
                        <h4>Kelola GUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/lspeg" >
   <i class="fa fa-users fa-5x"></i>
                        <h4>Kelola LSP</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/daftar_spplspeg" >
   <i class="fa fa-steam-square fa-5x"></i>
                        <h4>Kelola KS</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                     <?php elseif($this->check_session->get_level() == 3): // VERIFIKATOR?>

                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_dpa/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>
                                            <span class="badge badge-danger bg-notif" id="notif-dpa">0</span>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup" >
   <i class="fa fa-th-large fa-5x"></i>
                        <h4>Kelola GUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/lspeg" >
   <i class="fa fa-users fa-5x"></i>
                        <h4>Kelola LSP</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/daftar_spplspeg" >
   <i class="fa fa-steam-square fa-5x"></i>
                        <h4>Kelola KS</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-spp-spm">0</span>
                    </div>

                    <!--

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                    -->

                <?php elseif($this->check_session->get_level() == 4): // PUMK?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>

                    </div>
                    
                    
<!--                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                    </div>-->

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup" >
   <i class="fa fa-th-large fa-5x"></i>
                        <h4>Kelola GUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-gup">0</span>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/lspeg" >
   <i class="fa fa-users fa-5x"></i>
                        <h4>Kelola LS-PG</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/daftar_spplspeg" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/daftar_spplspeg" >
   <i class="fa fa-steam-square fa-5x"></i>
                        <h4>Kelola KS</h4>
                        </a>
                        </div>
                    </div>

                    
                    <?php elseif($this->check_session->get_level() == 11) : // KUASA BUU ?>
                    

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/akun_kas2/daftar_akun_kas2" >
   <i class="fa fa-columns fa-5x"></i>
                        <h4>Akun Kas</h4>
                        </a>
                      </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_dpa_kbuu/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>
                                            <!--<span class="badge badge-danger bg-notif" id="notif-dpa">0</span>-->

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup" >
   <i class="fa fa-th-large fa-5x"></i>
                        <h4>Kelola GUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/lspeg" >
   <i class="fa fa-users fa-5x"></i>
                        <h4>Kelola LSP</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks" >
   <i class="fa fa-steam-square fa-5x"></i>
                        <h4>Kelola KS</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                    <?php elseif($this->check_session->get_level() == 13): // BENDAHARA ?>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup" >
   <i class="fa fa-th-large fa-5x"></i>
                        <h4>Kelola GUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-gup">0</span>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-tup">0</span>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/lspeg" >
   <i class="fa fa-users fa-5x"></i>
                        <h4>Kelola LSP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-lsp">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks" >
   <i class="fa fa-steam-square fa-5x"></i>
                        <h4>Kelola KS</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-ks">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                    <?php elseif($this->check_session->get_level() == 14): // PPK?>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_rsa_ppk/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>
                                            <span class="badge badge-danger bg-notif" id="notif-dpa">0</span>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-up-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup" >
   <i class="fa fa-th-large fa-5x"></i>
                        <h4>Kelola GUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-spp-spm">0</span>
                    </div>



                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/lspeg" >
   <i class="fa fa-users fa-5x"></i>
                        <h4>Kelola LSP</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks" >
   <i class="fa fa-steam-square fa-5x"></i>
                        <h4>Kelola KS</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>


                    <?php endif; ?>


                  <!--
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/tor/daftar_tor" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Daftar TOR</h4>
                      </a>
                      </div>


                  </div>
                    -->
<!--                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="blank.html" >
 <i class="fa fa-user fa-5x"></i>
                      <h4>Register User</h4>
                      </a>
                      </div>


                  </div> -->


<!--                   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/geser/daftar_unit" >
 <i class="fa fa-key fa-5x"></i>
                      <h4>Geser Program</h4>
                      </a>
                      </div>-->


<!--                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?php echo base_url(); ?>index.php/rsa_up/input_rsa_up" >
 <i class="fa fa-key fa-5x"></i>
                      <h4>SPP</h4>
                      </a>
                      </div>-->

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
