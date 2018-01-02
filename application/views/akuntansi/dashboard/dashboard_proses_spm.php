
<script src="<?php echo base_url();?>/assets/akuntansi/js/vue.js"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/jquery.print.js"></script>

<div id="app">
  <div class="container-fluid">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">SPM Dalam Proses</li>
      </ol>
    </div><!--/.row-->
    <hr/>
    <div style="font-size:20pt;margin-bottom:20px;">
      <span class="glyphicon glyphicon-dashboard"></span> SPM sedang diproses RSA <div style="font-size:12pt;margin-left:35px;"></div>
    </div>
    <div class="row">
      <div class="col-sm-8">

      </div>
      <div class="col-sm-2">
        <form class="form-horizontal" action="<?php echo site_url('akuntansi/laporan/rekap_spm/cetak'); ?>" method="post" target="_blank">
          <input type="hidden" name="unit" value="<?php if(isset($kode_unit)) echo $kode_unit; ?>">
          <input type="hidden" name="daterange" value="<?php if(isset($periode)) echo $periode; ?>">
          <!-- <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> Download Excel</button> -->
          <a download="rekap_spm.xls" id="download_excel" class="no-print"><button  class="btn btn-success" type="button">Download excel</button></a>
          <button class="btn btn-success no-print" type="button" id="print_tabel">Cetak</button>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12"> 
        Pilih Jenis : <br/>
        <button class="btn btn-primary" type="button" v-on:click="selected='all'" v-bind:class="{ disabled: selected=='all' }">Semua ({{spm.all.length}})</button>&nbsp;
        <span v-for="entry_rekap in rekap">
          <button class="btn btn-primary" type="button"  v-on:click="selected=entry_rekap.real_jenis.toLowerCase() " v-bind:class="{ disabled: selected==entry_rekap.real_jenis.toLowerCase() }">{{entry_rekap.jenis}} ({{entry_rekap.jumlah}})</button>
          &nbsp;
        </span>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12"> 
        <div id="printed_table">
          <table class="table" id="tabel_spm">
            <thead>
              <tr>
                <th colspan="7" style="text-align: center;">
                  SPM Sedang Diproses <br/> 
                </th>
              </tr>
              <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>No. SPM</th>
                <th width="40% !important">Keterangan</th>
                <th>Jumlah</th>
                <th>Status terakhir</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(entry_spm,nomor) in selected_spm">
                <td>{{nomor+1}}</td>
                <td>{{entry_spm.jenis}}</td>
                <td>{{entry_spm.nomor_spm}}</td>
                <td>{{entry_spm.untuk_bayar}}</td>
                <td>{{entry_spm.jumlah_bayar}}</td>
                <td>{{entry_spm.posisi}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var data = {
    spm: <?php echo $spm ?>,
    rekap :<?php echo $rekap ?>,
    selected : 'all',
  };

  new Vue({
    el : '#app',
    data : data,
    methods : {},
    computed : {
      selected_spm (){
        return data.spm[data.selected];
      }
    },
  })
</script>

<script type="text/javascript">
  $('#download_excel').click(function(){
    // var printed = jQuery.extend(true,{}, $('#printed_table'))
      var printed = $('#printed_table').clone()
      printed.find('label').first().remove()
      printed.find('div.dataTables_info').last().remove()
      printed.find('table').attr('border', '1')
      printed.find('tr').css("background-color", "");
      var result = 'data:application/vnd.ms-excel,'+ encodeURIComponent(printed.html()) 
      this.href = result;
      this.download = "rekap_spm.xls";


      return true;
    })

    $('#print_tabel').click(function(){
      var printed = $('#printed_table').clone()
      printed.find('label').first().remove()
      printed.find('div.dataTables_info').last().remove()
      printed.find('table').attr('border', '1')
      printed.find('table').attr('width', '80%')
      printed.find('div').css("zoom", "90%");
      printed.find('tr').css("background-color", "");
        printed.print();
    })
</script>