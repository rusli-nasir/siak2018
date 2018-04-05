<script type="text/javascript">
$(document).ready(function(){

    // <?php if($this->check_session->user_session() && (($this->check_session->get_level()==13)||($this->check_session->get_level()==3)||($this->check_session->get_level()==11)||($this->check_session->get_level()==4))){ ?>
    //     var msg = "Menu <a href='http://10.69.12.215/rsa/index.php/rsa_sspb'><b>SSPB(Surat Setoran Pengembalian Belanja)</b></a> dan Menu <a href='http://10.69.12.215/rsa/index.php/rsa_potongan_lainnya'><b>Potongan Lainnya</b></a> sudah dapat dicoba untuk digunakan. Jika terdapat masalah hub. programmer. Terimakasih";
    // <?php }else{ ?>
    //     var msg = "Menu <a href='http://10.69.12.215/rsa/index.php/rsa_sspb'><b>SSPB(Surat Setoran Pengembalian Belanja)</b></a> sudah dapat dicoba untuk digunakan. Jika terdapat masalah hub. programmer. Terimakasih";
    // <?php } ?>

     // bootbox.alert({
     //     title: "<b class='text-info'><i class='fa fa-info-circle'></i> INFORMASI </b> ",
     //     message: "Menu <a href='http://10.69.12.215/rsa/index.php/rsa_sspb'><b>SSPB(Surat Setoran Pengembalian Belanja)</b></a> dan Menu <a href='http://10.69.12.215/rsa/index.php/rsa_potongan_lainnya'><b>Potongan Lainnya</b></a> sudah dapat dicoba untuk digunakan. Jika terdapat masalah hub. programmer. Terimakasih",
     //     animate: false,
     // });
        
     $("#notif-dpa").load( "<?=site_url('dpa/get_notif_dpa')?>");
     $("#notif-dpa-gup").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
     $("#notif-dpa-gup-nihil").load( "<?=site_url('dpa/get_notif_dpa_siap/1')?>");
     $("#notif-dpa-lsp").load( "<?=site_url('dpa/get_notif_dpa_siap/2')?>");
     $("#notif-dpa-tup-nihil").load( "<?=site_url('dpa/get_notif_dpa_siap/3')?>");
     // $("#notif-dpa-tup").load( "<?=site_url('dpa/get_notif_dpa_siap/3')?>");
     $("#notif-dpa-lsk").load( "<?=site_url('dpa/get_notif_dpa_siap/4')?>");
     $("#notif-dpa-lsnk").load( "<?=site_url('dpa/get_notif_dpa_siap/6')?>");
     $("#notif-dpa-em").load( "<?=site_url('dpa/get_notif_dpa_siap/7')?>");
     $("#notif-dpa-ks-nihil").load( "<?=site_url('dpa/get_notif_dpa_siap/5')?>");

     $("#notif-up-spp-spm").load( "<?=site_url('rsa_up/get_notif_approve_all')?>");
     $("#notif-pup-spp-spm").load( "<?=site_url('rsa_pup/get_notif_approve_all')?>");
     $("#notif-gup-spp-spm").load( "<?=site_url('rsa_gup/get_notif_approve_all')?>");
     $("#notif-tup-spp-spm").load( "<?=site_url('rsa_tup/get_notif_approve_all')?>");
     $("#notif-lsnk-spp-spm").load( "<?=site_url('rsa_lsnk/get_notif_approve_all')?>");
     $("#notif-lsk-spp-spm").load( "<?=site_url('rsa_lsk/get_notif_approve_all')?>");
     $("#notif-ks-spp-spm").load( "<?=site_url('rsa_ks/get_notif_approve_all')?>");
     $("#notif-em-spp-spm").load( "<?=site_url('rsa_em/get_notif_approve_all')?>");
     // $("#notif-tidak-sesuai").load( "<?=site_url('penyesuaian/get_notif_all')?>");
     $("#notif-gup-nihil-spp-spm").load( "<?=site_url('rsa_gup_nihil/get_notif_approve_all')?>");
     $("#notif-tup-nihil-spp-spm").load( "<?=site_url('rsa_tup_nihil/get_notif_approve_all')?>");
     $("#notif-ks-nihil-spp-spm").load( "<?=site_url('rsa_ks_nihil/get_notif_approve_all')?>");
     $("#notif-sspb").load( "<?=site_url('rsa_sspb/get_notif_sspb_approve')?>");
     $("#notif-ptla").load( "<?=site_url('rsa_potongan_lainnya/get_notif_ptla_approve')?>");




     <?php if($_SESSION['rsa_kode_unit_subunit'] == '99'): ?>
        <?php // if($_SESSION['rsa_username'] == 'verifikator3'): ?>

        // bootbox.alert({
        //     title: "PESAN",
        //     message: "TO VERIFIKATOR LPPM : BAGI VERIFIKATOR LPPM BOLEH KE TEMPATE SAYA SEBENTAR.<br>THX. BY : MISTER IYUS", 
        // });

        <?php // endif; ?>
    <?php endif; ?>

    <?php if($this->check_session->get_level() == 14 ): ?>

        // bootbox.alert({
        //     title: "PESAN",
        //     message: "DPA Kontrak sudah bisa dicoba, jika masih ada masalah hubungi Programmer", 
        // });

    <?php endif; ?>

    

            // $('.bg-notif').each(function(){
            //     if($(this).text()=='0'){
            //         // console.log($(this).text());
            //         $(this).addClass('badge-success');
            //     }
            // });

        
        

});

clear_local_storage();

function clear_local_storage(){
    localStorage.removeItem("row_expand_sub_subunit");
    localStorage.removeItem("row_expand_akun4d");
    localStorage.removeItem("row_expand_akun5d");
    localStorage.removeItem("row_expand_akun6d");
    localStorage.removeItem("row_focus");
}
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
                             <a href="<?php echo base_url(); ?>index.php/dpa/daftar_revisi" >
   <i class="fa fa-cubes fa-5x"></i>
                        <h4>DPA</h4>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_pup" >
   <i class="fa fa-arrow-circle-up fa-5x"></i>
                        <h4>Kelola PUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-pup-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup_nihil" >
   <i class="fa fa-stop-circle fa-5x"></i>
                        <h4>GUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-nihil-spp-spm">0</span>

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup_nihil" >
   <i class="fa fa-pause fa-5x"></i>
                        <h4>TUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-nihil-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsk" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LSK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsk-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsnk" >
   <i class="fa fa-sitemap fa-5x"></i>
                        <h4>Kelola LSNK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsnk-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks_nihil" >
   <i class="fa fa-steam fa-5x"></i>
                        <h4>KS-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-nihil-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_em" >
   <i class="fa fa-money fa-5x"></i>
                        <h4>Kelola EM</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-em-spp-spm">0</span>
                    </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_sspb" >
   <i class="fa fa-share fa-5x"></i>
                        <h4>Kelola SSPB</h4>
                        </a>
                        </div>
                    <span class="badge badge-danger bg-notif" id="notif-sspb">0</span>
                    </div>
                   
<!--
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    -->

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_pup" >
   <i class="fa fa-arrow-circle-up fa-5x"></i>
                        <h4>Kelola PUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-pup-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup_nihil" >
   <i class="fa fa-stop-circle fa-5x"></i>
                        <h4>GUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-nihil-spp-spm">0</span>

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup_nihil" >
   <i class="fa fa-pause fa-5x"></i>
                        <h4>TUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-nihil-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsk" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LSK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsk-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsnk" >
   <i class="fa fa-sitemap fa-5x"></i>
                        <h4>Kelola LSNK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsnk-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks_nihil" >
   <i class="fa fa-steam fa-5x"></i>
                        <h4>KS-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-nihil-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_em" >
   <i class="fa fa-money fa-5x"></i>
                        <h4>Kelola EM</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-em-spp-spm">0</span>
                    </div>
            <!--

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    -->

                    

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo base_url(); ?>index.php/rsa_potongan_lainnya" >
                                <i class="fa fa-scissors fa-5x"></i>
                                <h4>Pot. Lain</h4>
                            </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ptla">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_sspb" >
   <i class="fa fa-share fa-5x"></i>
                        <h4>Kelola SSPB</h4>
                        </a>
                        </div>
                         <span class="badge badge-danger bg-notif" id="notif-sspb">0</span>
                    </div>

                    

                <?php elseif($this->check_session->get_level() == 4): // PUMK?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>Kelola DPA</h4>
                                            </a>
                                            </div>

                    </div>
                    
                    
<!--
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_up" >
   <i class="fa fa-inbox fa-5x"></i>
                        <h4>Kelola UP</h4>
                        </a>
                        </div>
                    </div>
-->

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup_nihil" >
   <i class="fa fa-pause fa-5x"></i>
                        <h4>TUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-tup-nihil">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsk" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LSK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-lsk">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsnk" >
   <i class="fa fa-sitemap fa-5x"></i>
                        <h4>Kelola LSNK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-lsnk">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_em" >
   <i class="fa fa-money fa-5x"></i>
                        <h4>Kelola EM</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-em">0</span>
                    </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>
                   
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_pumk" >
   <i class="fa fa-cloud-download fa-5x"></i>
                        <h4>Uang Panjar</h4>
                        </a>
                        </div>
                    </div>
                    <!--

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/tor/daftar_spplspeg" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    -->
                    
                    <?php elseif($this->check_session->get_level() == 11) : // KUASA BUU ?>
                    

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/akun_kas/daftar_akun_kas" >
   <i class="fa fa-columns fa-5x"></i>
                        <h4>Akun Kas</h4>
                        </a>
                      </div>
                    </div>


                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/user/mapping/" >
   <i class="fa fa-compass fa-5x"></i>
                        <h4>Ver - Unit</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_dpa_kbuu/SELAIN-APBN" >
                       <i class="fa fa-cubes fa-5x"></i>
                                            <h4>DPA</h4>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_pup" >
   <i class="fa fa-arrow-circle-up fa-5x"></i>
                        <h4>Kelola PUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-pup-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup_nihil" >
   <i class="fa fa-stop-circle fa-5x"></i>
                        <h4>GUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-nihil-spp-spm">0</span>

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup_nihil" >
   <i class="fa fa-pause fa-5x"></i>
                        <h4>TUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-nihil-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsk" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LSK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsk-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsnk" >
   <i class="fa fa-sitemap fa-5x"></i>
                        <h4>Kelola LSNK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsnk-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks_nihil" >
   <i class="fa fa-steam fa-5x"></i>
                        <h4>KS-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-nihil-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_em" >
   <i class="fa fa-money fa-5x"></i>
                        <h4>Kelola EM</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-em-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_cair/spm" >
   <i class="fa fa-file-text fa-5x"></i>
                        <h4>SPM</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo base_url(); ?>index.php/rsa_sp2d">
                                <i class="fa fa-thumbs-o-up fa-5x"></i>
                                <h4>SP2D</h4>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo base_url(); ?>index.php/rsa_potongan_lainnya" >
                                <i class="fa fa-scissors fa-5x"></i>
                                <h4>Pot. Lain</h4>
                            </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ptla">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/kuitansi/daftar_kuitansi_cair_99/GP/2017/11" >
   <i class="fa fa-file-archive-o fa-5x"></i>
                        <h4>Kuitansi</h4>
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
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_sspb" >
   <i class="fa fa-share fa-5x"></i>
                        <h4>Kelola SSPB</h4>
                        </a>
                        </div>
                    <span class="badge badge-danger bg-notif" id="notif-sspb">0</span>
                    </div>

                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_gaji_apbn" >
   <i class="fa fa-newspaper-o fa-5x"></i>
                        <h4>Gaji APBN</h4>
                        </a>
                        </div>
                    <span class="badge badge-danger bg-notif" id="notif-apbn">0</span>
                    </div>
                   

                    


                <!--     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/penyesuaian" >
   <i class="fa fa-wrench fa-5x"></i>
                        <h4>Penyesuaian</h4>
                        </a>
			<span class="badge badge-danger bg-notif" id="notif-tidak-sesuai">0</span>
                        </div>
                    </div> -->

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_kas/transaksi_kas" >
   <i class="fa fa-file-text fa-5x"></i>
                        <h4>Trx Kas</h4>
                        </a>
                        </div>
                    </div>
                    <!--

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3/" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    -->

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_pup" >
   <i class="fa fa-arrow-circle-up fa-5x"></i>
                        <h4>Kelola PUP</h4>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup_nihil" >
   <i class="fa fa-stop-circle fa-5x"></i>
                        <h4>GUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-gup-nihil">0</span>

                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup" >
   <i class="fa fa-trello fa-5x"></i>
                        <h4>Kelola TUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" >0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup_nihil" >
   <i class="fa fa-pause fa-5x"></i>
                        <h4>TUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-tup-nihil">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsk" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LSK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-lsk">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsnk" >
   <i class="fa fa-sitemap fa-5x"></i>
                        <h4>Kelola LSNK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-lsnk">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks_nihil" >
   <i class="fa fa-steam fa-5x"></i>
                        <h4>KS-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-ks-nihil">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_em" >
   <i class="fa fa-money fa-5x"></i>
                        <h4>Kelola EM</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-dpa-em">0</span>
                    </div>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>
                   
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_pumk" >
   <i class="fa fa-cloud-download fa-5x"></i>
                        <h4>Uang Panjar</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo base_url(); ?>index.php/rsa_potongan_lainnya" >
                                <i class="fa fa-scissors fa-5x"></i>
                                <h4>Pot. Lain</h4>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_sspb" >
   <i class="fa fa-share fa-5x"></i>
                        <h4>Kelola SSPB</h4>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_pup" >
   <i class="fa fa-arrow-circle-up fa-5x"></i>
                        <h4>Kelola PUP</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-pup-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_gup_nihil" >
   <i class="fa fa-stop-circle fa-5x"></i>
                        <h4>GUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-gup-nihil-spp-spm">0</span>

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
                             <a href="<?php echo base_url(); ?>index.php/rsa_tup_nihil" >
   <i class="fa fa-pause fa-5x"></i>
                        <h4>TUP-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-tup-nihil-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsk" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LSK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsk-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsnk" >
   <i class="fa fa-sitemap fa-5x"></i>
                        <h4>Kelola LSNK</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-lsnk-spp-spm">0</span>
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
                             <a href="<?php echo base_url(); ?>index.php/rsa_ks_nihil" >
   <i class="fa fa-steam fa-5x"></i>
                        <h4>KS-NIHIL</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-ks-nihil-spp-spm">0</span>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_em" >
   <i class="fa fa-money fa-5x"></i>
                        <h4>Kelola EM</h4>
                        </a>
                        </div>
                        <span class="badge badge-danger bg-notif" id="notif-em-spp-spm">0</span>
                    </div>


                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/serapan" >
   <i class="fa fa-external-link fa-5x"></i>
                        <h4>Serapan</h4>
                        </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_sspb" >
   <i class="fa fa-share fa-5x"></i>
                        <h4>Kelola SSPB</h4>
                        </a>
                        </div>
                         <span class="badge badge-danger bg-notif" id="notif-sspb">0</span>
                    </div>
                   
                    <!--

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_lsphk3" >
   <i class="fa fa-share-alt-square fa-5x"></i>
                        <h4>Kelola LS-P3</h4>
                        </a>
                        </div>
                    </div>

                    -->


                    <?php elseif($this->check_session->get_level() == 55) : // SP2D ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo base_url(); ?>index.php/rsa_sp2d">
                                <i class="fa fa-thumbs-o-up fa-5x"></i>
                                <h4>SP2D</h4>
                            </a>
                        </div>
                    </div>
                    <?php elseif($this->check_session->get_level() == 17) : // AUDITOR ?>
                        
<!--                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php//daftar_revisi" >
   <i class="fa fa-file fa-5x"></i>
                        <h4>SPP</h4>
                        </a>
                        </div>
                    </div> -->
          
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/rsa_cair/spm" >
   <i class="fa fa-file-text fa-5x"></i>
                        <h4>SPM</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/kuitansi/daftar_kuitansi_cair_99/GP/2017/11" >
   <i class="fa fa-file-archive-o fa-5x"></i>
                        <h4>Kuitansi</h4>
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
