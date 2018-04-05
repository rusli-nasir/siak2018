<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <?php if($this->check_session->get_level() == 1): // AKUNTANSI?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>

                    <!--<li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_dpa/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA<span class="badge">Included</span> </a>
                    </li>-->

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

                <?php elseif($this->check_session->get_level() == 55): // sp2d?>

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
                        <a href="<?php echo base_url(); ?>index.php/user/daftar_user"><i class="fa fa-user"></i>Daftar User  </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/setting/buka_tutup"><i class="fa fa-folder-open"></i>Buka Tutup</a>
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

                    <?php //if($this->check_session->get_unit() == 42): // BENDAHARA ?>

                     <li>
                        <a href="<?php echo site_url('kepegawaian'); ?>"><i class="fa fa-users"></i>Kepegawaian</a>

                    </li>

                    <?php //endif; ?>



                    <?php elseif($this->check_session->get_level() == 14): // PPK?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dpa/daftar_validasi_rsa_ppk/SELAIN-APBN" ><i class="fa fa-cubes"></i>Kelola DPA <!-- <span class="badge">Included</span> --></a>
                    </li>

                    <?php elseif($this->check_session->get_level() == 17): // AUDITOR?>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/dashboard" ><i class="fa fa-desktop "></i>Dashboard <!-- <span class="badge">Included</span> --></a>
                    </li>

                    <?php endif; ?>

					 <li>
                        <a href="<?php echo base_url(); ?>index.php/user/ubah_password" ><i class="fa fa-key "></i>Ubah Password </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/user/logout"><i class="fa fa-power-off "></i>Logout</a>
                    </li>
                    <li>&nbsp;</li>

                    <li>
                       <div class="alert alert-success" style="    margin: 5px;">
                           <b><u>Kontak Programmer</u> :</b><br>
                           M Arief Kurniawan
                           <br>
                           <a href="https://api.whatsapp.com/send?phone=6285641125599" target="_blank"><i class="fa fa-whatsapp fa-lg"></i> +62 856-4112-5599 </a>
                           <br>
                           M Fahmi Mukhlishin
                           <br>
                           <a href="https://api.whatsapp.com/send?phone=6285713745349" target="_blank"> <i class="fa fa-whatsapp fa-lg"></i> +62 857-1374-5349 </a>
                       </div>
                    </li>


                </ul>
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
