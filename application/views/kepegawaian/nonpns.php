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
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/index">Gaji PNS</a></li>
                <li role="presentation"  class="active"><a href="<?php echo base_url(); ?>index.php/kepegawaian/gjnonpns">Gaji Non PNS</a></li>
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/proses_data">Cek Proses Data</a></li>
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/load_dtpeg">Data Karyawan</a></li>
                
              </ul>
          
           <div class="panel panel-default" style="margin-top:10px; ">
            <div class="panel-body" id="contain-page"> 
               <div class="row">
                   <div class="col-md-6">
                       <label for="basic-url">Search Pegawai</label>
                       <div class="input-group col-xs-12 table-responsive">
                           <span class="input-group-addon" style="text-align:left;">Nama Pegawai</span>
                        <input type="text" class="form-control autocomplete" id="dtcari" name="nama" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                        <span class="input-group-addon" style="text-align:left;">NIP</span>
                        <input type="text" class="form-control autocomplete" id="dtcari2" name="nip" >
                        </div>
                        
                   </div>
                   <div class="col-md-6">
                             <div class="form-group">
                            <label for="sel1">Bulan Gaji</label>
                            <select class="form-control" >
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
                            
                           <select class="form-control" style="margin-top:5px;">
                           <option value="2017">2017</option>
                           <option value="2018">2018</option>
                           <option value="2019">2019</option>
                           <option value="2020">2020</option>
                           <option value="2021">2021</option>
                           <option value="2022">2022</option>
                         </select> 
                            
                            <button type="button" class="btn btn-info" style="margin-top:5px;">Lihat Data</button>
            </div>                
             </div>
                   
                   <div class="col-md-12" style="border: buttonface">
                         <div class="input-group col-xs-12 table-responsive">
                           <span class="input-group-addon" style="text-align:left;">Nama Lengkap</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Gaji Bersih</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                   </div>
                   
                   <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data </label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Satker</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Anak</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Sub Anak</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Pos</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Negara</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       
                   </div>
                   <div class="col-md-6" style="border: buttonface">
                       <label for="basic-url" style="margin-top:10px;">Data Pegawai</label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tipe Sub</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Golongan</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Nomer NPWP</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Jenis</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode PPN</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                   </div>
                   
                     <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data </label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Nama Bank</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Nomer Rekening</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                     </div>
                    <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data Bank</label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Kode Bank Span</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Nama Bank Span</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                     </div>
                   
                   <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data </label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Gaji Pokok</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Istri</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                         <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Anak</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Lain</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Kopensasi</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Pembul</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                       
                        
                     </div>
                    <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data Gaji dan Tunjangan</label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Struktural</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan UPNS</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                         <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Daerah</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                         <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Pencil</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan Beras</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Tunjangan PPH</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>             
                        
                     </div>
                   
                     <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data</label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Potpfkbul</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Potpfk 10</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Pot PPH</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                     </div>   
                   
                   <div class="col-md-6" style="border: buttonface">
                        <label for="basic-url" style="margin-top:10px;">Data Potongan</label>
                       <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Potpfk2</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Potswrum</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                        <div class="input-group col-xs-12 table-responsive" style="margin-top:5px;">
                           <span class="input-group-addon" style="text-align:left;">Potkelbjt</span>
                        <input type="text" class="form-control autocomplete" id="" name="" >
                       </div>
                     </div> 
              </div>

              
              
                

                     
               
                
            </div>
          </div>
                  
             
                
    </div>
            
 </div>
  
</div>

