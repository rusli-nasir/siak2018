<?php

?>
<div id="page-wrapper" >
	<div id="page-inner">


    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h3 class="page-header">
          <i class="fa fa-users"></i>&nbsp;&nbsp;
          Kepegawaian #3
        </h3>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <!-- <div class="input-group input-group-lg"> -->
            <!-- <div class="input-group-btn"> -->
              <!-- <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="width:100%;">
                <i class="fa fa-spinner"></i>&nbsp;&nbsp;Insentif
                <span class="fa fa-caret-down"></span>
              </button> -->
              <h4 class="page-header text-info"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Insentif</h4>
              <!-- <ul class="dropdown-menu"> -->
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('ipp'); ?>"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Insentif Perbaikan Penghasilan</a>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('ikw'); ?>"><i class="fa fa-coffee"></i>&nbsp;&nbsp;Insentif Kinerja Wajib</a>
              <a><?php //echo $_SESSION['rsa_kode_unit_subunit']; ?>&nbsp;</a>
              <?php
                if(in_array(substr($_SESSION['rsa_kode_unit_subunit'],0,2),array('15','25'))){
              ?>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('tutam'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan</a>
              <?php
                }else{
                  if($_SESSION['rsa_kode_unit_subunit'] == '21'){
              ?>
              <a class="btn btn-warning" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('tutam_mwa'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan MWA</a>
              <?php
                  }
                  if($_SESSION['rsa_kode_unit_subunit'] == '18'){
              ?>
              <a class="btn btn-warning" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('tutam_rsnd'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan RSND</a>
              <?php
                  }
                }
              ?>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('ikk_dosen'); ?>"><i class="glyphicon glyphicon-arrow-up"></i>&nbsp;&nbsp;Insentif Kelebihan Kinerja (IKK) Dosen</a>
              <a>&nbsp;</a>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('itkk'); ?>"><i class="fa fa-coffee"></i>&nbsp;&nbsp;Insentif Tenaga Kontrak</a>
  <?php
  /*
              <ul>
                <li><a class="btn btn-default" href="<?php echo site_url('ikw'); ?>"><i class="fa fa-coffee"></i>&nbsp;&nbsp;Insentif Kinerja Wajib</a></li>
                <!-- <li><a href="<?php echo site_url('ipp'); ?>"><i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Insentif Perbaikan Penghasilan</a></li> -->
                <li><a class="btn btn-default" href="<?php echo site_url('tutam'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan</a></li>
                <!-- <li><a href="<?php echo site_url('ikk_dosen'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Kelebihan Kinerja (IKK) Dosen</a></li> -->
             <?php
              
              if(intval($_SESSION['rsa_kode_unit_subunit'])==51){
             ?>
                <li><a href="<?php echo site_url('tutam_rsnd'); ?>"><i class="glyphicon glyphicon-gift"></i>&nbsp;&nbsp;Insentif Tugas Tambahan RSND</a></li>
             <?php
              }
              
             ?>
              </ul>
  */
  ?>
            <!-- </div> -->
          <!-- </div> -->
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          
              <h4 class="page-header text-info"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Uang Kinerja</h4>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('uk'); ?>"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp;Uang Kinerja Umum</a>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('uk_dosen'); ?>"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp;Uang Kinerja Dosen</a>
              <a>&nbsp;</a>
  
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          
              <h4 class="page-header text-info"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Pokok</h4>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('gaji_tkk'); ?>"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;Gaji Pokok TKK</a>
              <a class="btn btn-default" style="width: 100%;border-radius:0;text-align:left;" href="<?php echo site_url('um_tkk'); ?>"><i class="glyphicon glyphicon-cutlery"></i>&nbsp;&nbsp;Uang Makan TKK</a>
              <a>&nbsp;</a>
  
        </div>

      </div>

    </div>


  </div>
</div>
