<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">
                <h2>KELOLA SP2D</h2>   
            </div>
        </div>              
        <hr />
        <div class="row text-center pad-top">
            <?php if($this->check_session->get_level() == 11 || $this->check_session->get_level() == 55) : ?>
                <div class="row" style="padding-left: 15px;">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo site_url('rsa_sp2d/tambah_sp2d'); ?>" >
                                <i class="fa fa-upload fa-5x"></i>
                                <h4>SP2D</h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo site_url('rsa_sp2d/tambah_retur'); ?>" >
                                <i class="fa fa-download fa-5x"></i>
                                <h4>RETUR</h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-left: 15px;">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo site_url('rsa_sp2d/daftar_sp2d'); ?>" >
                                <i class="fa fa-list fa-5x"></i>
                                <h4>DAFTAR SP2D</h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo site_url('rsa_sp2d/daftar_retur'); ?>" >
                                <i class="fa fa-list fa-5x"></i>
                                <h4>DAFTAR RETUR</h4>
                            </a>
                        </div>
                    </div>
                     <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                        <div class="div-square">
                            <a href="<?php echo site_url('rsa_sp2d/sp2d_per_spm'); ?>" >
                                <i class="fa fa-list fa-5x"></i>
                                <h4>LAPORAN SP2D</h4>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>