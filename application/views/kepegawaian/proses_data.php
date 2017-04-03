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
                            
            </div>  
                 </form>
                </div> 
                
            </div>
          </div>
                  
             
                
    </div>
            
 </div>
  
</div>




