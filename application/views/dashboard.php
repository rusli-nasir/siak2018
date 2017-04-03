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
                             <a href="<?php echo base_url(); ?>index.php/dpa/index" >
   <i class="fa fa-cubes fa-5x"></i>
                        <h4>Kelola DPA</h4>
                        </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/dpa/kroscek" >
   <i class="fa fa-cubes fa-5x"></i>
                        <h4>Kroscek</h4>
                        </a>
                        </div>
                    </div>

                    <?php elseif($this->check_session->get_level() == 2) : // KPA ?>
<!--                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                             <a href="<?php echo base_url(); ?>index.php/dpa/index" >
   <i class="fa fa-cubes fa-5x"></i>
                        <h4>Kelola DPA</h4>
                        </a>
                        </div>

                    </div>-->

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
                    </div>

                     <?php elseif($this->check_session->get_level() == 3): // VERIFIKATOR?>

                     <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/index" >
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
                    </div>
                <?php elseif($this->check_session->get_level() == 4): // PUMK?>
                    
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/index" >
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
                    </div>

                    <?php elseif($this->check_session->get_level() == 13): // BENDAHARA ?>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/index" >
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
                    </div>

                    <?php elseif($this->check_session->get_level() == 14): // PPK?>

                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                            <div class="div-square">
                                                 <a href="<?php echo base_url(); ?>index.php/dpa/index" >
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
