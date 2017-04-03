<style>
    
    hr {
  -moz-border-bottom-colors: none;
  -moz-border-image: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  border-color: #EEEEEE -moz-use-text-color #FFFFFF;
  border-style: solid none;
  border-width: 1px 0;
  margin: 18px 0;
  
  .table-responsive{
      height: 180px;
  } 
}
</style>

<div id="page-wrapper" >
     <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h4>Kepegawaian</h4>   
                    </div>
                   
                 </div>
          <hr>
               <ul class="nav nav-pills">
                <!--li role="presentation" class="active"><a href="<?php echo base_url(); ?>index.php/kepegawaian/index">Gaji PNS</a></li>
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/gjnonpns">Gaji Non PNS</a></li-->
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/proses_data">Cek Proses Data</a></li>
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/load_dtpeg">Data Karyawan</a></li>
                
              </ul>
          
           <div class="panel panel-default" style="margin-top:10px; ">
            <div class="panel-body" id="contain-page"> 
         
                   
                
                <div class="panel panel-default">
                    <div class="panel-body" style="font-weight:bold;">Proses Gaji </div>
                
                <div class="col-md-12" style="margin-top:20px;">
                             
                      <?php echo form_open('kepegawaian/proses_data_fakultas'); ?> 
                    <div class="form-group">
                             <label for="sel1">Unit Kerja</label>
                            <select class="form-control"name="unit">
                           <option value="1">1 - Fakultas Hukum</option>
                           <option value="2">2 - Fakultas Ekonomika dan Bisnis</option>
                           <option value="3">3 - Fakultas Teknik</option>
                           <option value="4">4 - Fakultas Kedokteran</option>
                           <option value="5">5 - Fakultas Peternakan dan Pertanian</option>
                           <option value="6">6 - Fakultas Ilmu Budaya</option>
                           <option value="7">7 - Fakultas Ilmu Sosial dan Ilmu Politik</option>
                           <option value="8">8 - Fakultas Sains dan Matematika</option>
                           <option value="9">9 - Fakultas Kesehatan Masyarakat</option>
                           <option value="10">10 - Fakultas Perikanan dan Ilmu Kelautan</option>
                           <option value="11">11 - Fakultas Psikologis</option>
                           <option value="12">12- Sekolah Pascasarjana</option>
                         </select>     
                                 
                            <label for="sel1">Bulan Gaji</label>
                            <select class="form-control"name="bulan">
                           <option value="01">1 - January</option>
                           <option value="02">2 - Februari</option>
                           <option value="03">3 - Maret</option>
                           <option value="04">4 - April</option>
                           <option value="05">5 - Mei</option>
                           <option value="06">6 - Juni</option>
                           <option value="07">7 - Juli</option>
                           <option value="08">8 - Agustus</option>
                           <option value="09">9 - September</option>
                           <option value="10">10 - Oktober</option>
                           <option value="11">11 - November</option>
                           <option value="12">12- Desember</option>
                         </select>
                            
                           <select class="form-control" style="margin-top:5px;" name="tahun">
                           <option value="2016">2016</option>    
                           <option value="2017">2017</option>
                           <option value="2018">2018</option>
                           <option value="2019">2019</option>
                           <option value="2020">2020</option>
                           <option value="2021">2021</option>
                           <option value="2022">2022</option>
                         </select> 
                            
                            <input type="submit" name="proses" value="lihat data" class="btn btn-info" style="margin-top:5px;">
                            
                            
                            
                            <input type="submit" name="proses" value="cetak pdf" class="btn btn-info" style="margin-top:5px;">
                            
                         
                            
            </div>  
                 </form>
                </div> 
              
                     <div class="col-md-12" style="margin-top:20px;">
                    <h3>Unit Kerja : <?php echo $id_fak."-".$nama_fak; ?></h3>
  <p>Lihat Gaji Pada Bulan  <?php echo $bulan;?> tahun  <?php echo $tahun;?></p>
    <h4>Perhitungan Gaji Pegawai Dosen PNS</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Gaji Bersih</th>
        <th>IKW</th>
        <th>IKK</th>
         <th>Status</th>
      </tr>
    </thead>
    <tbody>
         <?php 
            $no=0;

         foreach ($dtpegfak->result() as $peg) {
             $no++;
             $nip=$peg->nip;
              $this->load->model('M_kepeg');
              $dtad = $this->M_kepeg->cari_get_gaji_q($bulan,$tahun,$peg->nip); 
              foreach($dtad->result() as $ada){$hasil=$ada->hasil;}
              
              
             ?>  
      <tr <?php if($hasil!='1'){echo "class=\"danger\"";${'gaji_bersih_pns'.$no}='-';}else{ echo "class=\"success\"";
      
            $dtgaji = $this->M_kepeg->cari_get_gaji_data($bulan,$tahun,$peg->nip);
            foreach ($dtgaji->result() as $gaji){
                ${'gaji_bersih_pns'.$no}=$gaji->bersih;
            }
            
      } ?>>
        <td><?php echo $no;?></td>
        <td><?php echo $peg->glr_dpn." ".$peg->nama." ".$peg->glr_blkg;?></td>
        <td><?php echo ${'gaji_bersih_pns'.$no};?></td>
        <td></td>
        <td></td>
        <td><?php if($peg->status=='1'){ echo "aktif";}else{ echo" tidak aktif";}  ?> - <a href="<?php echo base_url();?>/index.php/kepegawaian/view_pegawai/<?php echo $bulan;?>/<?php echo $tahun;?>/<?php echo $nip;?>">
          <span class="glyphicon glyphicon-list-alt"></span>
        </a></td>
      </tr>
         <?php } ?>
    </tbody>
  </table>
   <h4>Perhitungan Gaji Pegawai PNS</h4>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Gaji Bersih</th>
        <th>IKW</th>
        <th>IKK</th>
         <th>Status</th>
      </tr>
    </thead>
    <tbody>
         <?php 
            $no=0;

         foreach ($dtpegfak_nondosen->result() as $peg) {
             $no++;
              $this->load->model('M_kepeg');
              $dtad = $this->M_kepeg->cari_get_gaji_q($bulan,$tahun,$peg->nip); 
              foreach($dtad->result() as $ada){$hasil=$ada->hasil;}
              
              
             ?>  
      <tr <?php if($hasil!='1'){echo "class=\"danger\""; ${'gaji_bersih_pns_nondosen'.$no}='-';}else{ echo "class=\"success\"";
      
            $dtgaji = $this->M_kepeg->cari_get_gaji_data($bulan,$tahun,$peg->nip);
            foreach ($dtgaji->result() as $gaji){
                ${'gaji_bersih_pns_nondosen'.$no}=$gaji->bersih;
            }
            
      } ?>>
        <td><?php echo $no;?></td>
        <td><?php echo $peg->glr_dpn." ".$peg->nama." ".$peg->glr_blkg;?></td>
        <td><?php echo  ${'gaji_bersih_pns_nondosen'.$no};?></td>
        <td></td>
        <td></td>
        <td><?php if($peg->status=='1'){ echo "aktif";}else{ echo" tidak aktif";}  ?> - <a href="<?php echo base_url();?>/index.php/kepegawaian/view_pegawai/<?php echo $bulan;?>/<?php echo $tahun;?>/<?php echo $nip;?>">
          <span class="glyphicon glyphicon-list-alt"></td>
      </tr>
         <?php } ?>
    </tbody>
  </table>
   
   <h4>Perhitungan Gaji Badan Layanan Umum (BLU)</h4>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Gaji Bersih</th>
        <th>IKW</th>
        <th>IKK</th>
         <th>Status</th>
      </tr>
    </thead>
    <tbody>
         <?php 
            $no=0;

         foreach ($dtpegfak_blu->result() as $peg) {
             $no++;
              $this->load->model('M_kepeg');
              $dtad = $this->M_kepeg->cari_get_gaji_q_nonpns($bulan,$tahun,$peg->nip); 
              foreach($dtad->result() as $ada){$hasil=$ada->hasil;}
              
              
             ?>  
      <tr <?php if($hasil!='1'){echo "class=\"danger\"";${'gaji_bersih_blu'.$no}="-";}else{ echo "class=\"success\"";
      
            $dtgaji = $this->M_kepeg->cari_get_gaji_data_nonpns($bulan,$tahun,$peg->nip);
            foreach ($dtgaji->result() as $gaji){
                ${'gaji_bersih_blu'.$no}=$gaji->gaji_pokok;
            }
            
      } ?>>
        <td><?php echo $no;?></td>
        <td><?php echo $peg->glr_dpn." ".$peg->nama." ".$peg->glr_blkg;?></td>
        <td><?php echo ${'gaji_bersih_blu'.$no};?></td>
        <td></td>
        <td></td>
        <td><?php if($peg->status=='1'){ echo "aktif";}else{ echo" tidak aktif";}  ?> - <a href="<?php echo base_url();?>/index.php/kepegawaian/view_pegawai/<?php echo $bulan;?>/<?php echo $tahun;?>/<?php echo $nip;?>">
          <span class="glyphicon glyphicon-list-alt"></td>
      </tr>
         <?php } ?>
    </tbody>
  </table>
   
   <h4>Perhitungan Gaji CPNS</h4>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Gaji Bersih</th>
        <th>IKW</th>
        <th>IKK</th>
         <th>Status</th>
         
      </tr>
    </thead>
    <tbody>
         <?php 
            $no=1;

         foreach ($dtpegfak_cpns->result() as $peg) {
             
              $this->load->model('M_kepeg');
              $dtad = $this->M_kepeg->cari_get_gaji_q($bulan,$tahun,$peg->nip); 
              foreach($dtad->result() as $ada){$hasil=$ada->hasil;}
              
              
             ?>  
      <tr <?php if($hasil!='1'){echo "class=\"danger\"";}else{ echo "class=\"success\"";
      
            $dtgaji = $this->M_kepeg->cari_get_gaji_data($bulan,$tahun,$peg->nip);
            foreach ($dtgaji->result() as $gaji){
                $gaji_bersih=$gaji->bersih;
            }
            
      } ?>>
        <td><?php echo $no++;?></td>
        <td><?php echo $peg->glr_dpn." ".$peg->nama." ".$peg->glr_blkg;?></td>
        <td><?php echo $gaji_bersih;?></td>
        <td></td>
        <td></td>
        <td><?php if($peg->status=='1'){ echo "aktif";}else{ echo" tidak aktif";}  ?> - <a href="<?php echo base_url();?>/index.php/kepegawaian/view_pegawai/<?php echo $bulan;?>/<?php echo $tahun;?>/<?php echo $nip;?>">
          <span class="glyphicon glyphicon-list-alt"></td>
      </tr>
         <?php } ?>
    </tbody>
  </table>
   
   <h4>Perhitungan Gaji Kontrak</h4>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Gaji Bersih</th>
        <th>IKW</th>
        <th>IKK</th>
         <th>Status</th>
         
      </tr>
    </thead>
    <tbody>
         <?php 
            $no=0;

         foreach ($dtpegfak_kontrak->result() as $peg) {
             $no++;
              $this->load->model('M_kepeg');
              $dtad = $this->M_kepeg->cari_get_gaji_q_nonpns($bulan,$tahun,$peg->nip); 
              foreach($dtad->result() as $ada){$hasil=$ada->hasil;}
              
              
             ?>  
      <tr <?php if($hasil!='1'){echo "class=\"danger\"";${'gaji_bersih_kontrak'.$no}="-";}else{ echo "class=\"success\"";
      
            $dtgaji = $this->M_kepeg->cari_get_gaji_data_nonpns($bulan,$tahun,$peg->nip);
            foreach ($dtgaji->result() as $gaji){
                ${'gaji_bersih_kontrak'.$no}=$gaji->gaji_pokok;
            }
            
      } ?>>
        <td><?php echo $no;?></td>
        <td><?php echo $peg->glr_dpn." ".$peg->nama." ".$peg->glr_blkg;?></td>
        <td><?php echo ${'gaji_bersih_kontrak'.$no};?></td>
        <td></td>
        <td></td>
        <td><?php if($peg->status=='1'){ echo "aktif";}else{ echo" tidak aktif";}  ?> - <a href="<?php echo base_url();?>/index.php/kepegawaian/view_pegawai/<?php echo $bulan;?>/<?php echo $tahun;?>/<?php echo $nip;?>">
          <span class="glyphicon glyphicon-list-alt"></td>
      </tr>
         <?php } ?>
    </tbody>
  </table>
                    </div>         
                    
                    
            </div>
          </div>
                  
             
                
    </div>
            
 </div>
  
</div>




