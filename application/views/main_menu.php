<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <?php if($this->check_session->get_level() == 1): // AKUNTANSI?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>

                    <?php elseif($this->check_session->get_level() == 2): // KPA?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_rsa_kpa/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>



                    <?php elseif($this->check_session->get_level() == 3): // VERIFIKATOR?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_dpa/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>
                    
                    <?php elseif($this->check_session->get_level() == 4): // PUMK?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>

                    <?php elseif($this->check_session->get_level() == 5): // BUU?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>


                    <?php elseif($this->check_session->get_level() == 11): // KUASA BUU?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_dpa_kbuu/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>
					 <li>
                        <a href="<?php echo base_url(); ?>index.php/setting/tahun" ><i class="fa fa-circle "></i>Setting Tahun </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/user/daftar_user"><i class="fa fa-user"></i>Daftar user  </a>
                    </li>

                    <?php elseif($this->check_session->get_level() == 13): // BENDAHARA?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>
                    
<!--                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/dashboard_dpa" ><i class="fa fa-cubes"></i>Kelola DPA  <span class="badge">Included</span> </a>
                    </li>-->
                    
                    <?php //if($this->check_session->get_unit() == 42): // BENDAHARA?>
                     <li>
                        <a href="<?php echo site_url('modul_gaji'); ?>"><i class="fa fa-clipboard"></i>Kepegawaian </a>

                    </li>
                    <?php //endif; ?>



                    <?php elseif($this->check_session->get_level() == 14): // PPK?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_rsa_ppk/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>

                    <?php endif; ?>
					
					 <li>
                        <a href="<?php echo base_url(); ?>index.php/user/ubah_password" ><i class="fa fa-key "></i>Ubah Password </a>
                    </li>
					
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/user/logout"><i class="fa fa-power-off "></i>Logout</a>
                    </li>


                </ul>
                            </div>

        </nav>
        <!-- /. NAV SIDE  -->
