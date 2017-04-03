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
                <li role="presentation" ><a href="<?php echo base_url(); ?>index.php/kepegawaian/index">Gaji PNS</a></li>
                <li role="presentation" ><a href="<?php echo base_url(); ?>index.php/kepegawaian/gjnonpns">Gaji Non PNS</a></li>
                <li role="presentation"><a href="<?php echo base_url(); ?>index.php/kepegawaian/proses_data">Cek Proses Data</a></li>
                <li role="presentation" class="active"><a href="<?php echo base_url(); ?>index.php/kepegawaian/load_dtpeg">Data Karyawan</a></li>
                
              </ul>
          
           <div class="panel panel-default" style="margin-top:10px; ">
            <div class="panel-body" id="contain-page">
               
                <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nip</th>
                <th>Golongan</th>
                
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                
            </tr>
        </tfoot>
        <tbody>
           <?php if ($dtpeg->num_rows()>0){
              foreach($dtpeg->result() as $row){
                 echo "
                       <tr>
                            <td> $row->nama</td>
                            <td> $row->nip</td>
                            <td> $row->golongan_id</td>
                       </tr>
                 ";
            }
                }else {
                echo "<tr>
                            <td> Data Kosong</td>

                       </tr>
                       ";
            } ?>
        </tbody>
                </table>

                     
               
                
            </div>
          </div>
                  
             
                
    </div>
            
 </div>
  
</div>

