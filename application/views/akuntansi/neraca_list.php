<link href="<?php echo base_url();?>/assets/akuntansi/css/selectize.bootstrap3.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/selectize.js"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/vue.js"></script>
<!-- <script src="<?php echo base_url();?>/assets/akuntansi/js/vue-selectize.js"></script> -->
<script src="<?php echo base_url();?>/assets/akuntansi/js/vue-multiselect.min.js"></script>
<script src="<?php echo base_url();?>/assets/akuntansi/js/bootstrap-datepicker.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/datepicker.css" rel="stylesheet">
<link href="<?php echo base_url();?>/assets/akuntansi/css/vue-multiselect.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url();?>/assets/akuntansi/js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/akuntansi/css/daterangepicker.css" />
<!-- javascript -->
<style>
  input[type=checkbox] {
    margin: 8px 0 0;
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		var host = "<?=site_url('/')?>";

		$("#filter_tahun").change(function(){
			$("#form_filter_tahun").submit();
		});
		$("#filter_status").change(function(){
			$("#form_filter").submit();
		});
        $('.input-daterange input').each(function() {
            $(this).datepicker();
            $(this).datepicker('update', new Date());
        });
        $('#akun_kas_list').selectize();
        $('#akun_akrual_list').selectize();
        $('#unit_list').selectize();
	});
    
    $('#basis').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        if(optionSelected == 'kas'){
            $('#kas_list').removeAttr('style');
            $('#akrual_list').attr('style', 'display:none');
        } else {
            $('#akrual_list').removeAttr('style');
            $('#kas_list').attr('style', 'display:none');
        }
    });
</script>
<!-- javascript -->

<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Neraca Saldo</li>
	</ol>
</div><!--/.row-->
<hr/>
<div class="row">
	<div class="col-sm-9">
		<h1 class="page-header">Neraca Saldo</h1>
	</div>
	<div class="col-sm-3" align="right">
	</div>
</div><!--/.row-->
<br />
<div class="container">
    <?php echo form_open('akuntansi/laporan/cetak_neraca_saldo',array("class"=>"form-horizontal", "id" => "form_pop")); ?>
	<!-- Text input-->
	<div class="form-group">
      <label class="col-md-2 control-label">Unit</label>  
      <div class="col-md-6">
          <?php if($this->session->userdata('level')==1 or $this->session->userdata('level')==2 or $this->session->userdata('level')==5){ ?>
          <?php foreach($query_unit->result() as $unit){
            if($unit->kode_unit==$this->session->userdata('kode_unit')){
              $nama_unit = $unit->nama_unit;
            }
          }
          ?>
          <input type="hidden" class="form-control" name="unit" value="<?php echo $this->session->userdata('kode_unit') ?>">
          <input type="text" class="form-control" value="<?php echo $nama_unit; ?>" readonly>
          <?php }else{ ?>
          <select id="unit_list" name="unit" class="form-control" required="">
              <option value="all" selected=""> Semua</option>
            <?php foreach($query_unit->result() as $unit): ?>
              <option value="<?php echo $unit->kode_unit ?>"><?= $unit->alias." - ".$unit->nama_unit ?></option>
            <?php endforeach; ?>
            <option value="9999">Penerimaan</option>
          </select>
          <?php } ?>
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-md-2 control-label">Periode</label>  
      <div class="col-md-6">
        <input class="form-control" type="text" name="daterange">
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Sumber Dana</label>  
      <div class="col-md-6">
          <select id="sumber_dana" name="sumber_dana" class="form-control" required="">
            <option value="all">Semua</option>
            <option value="tidak_terikat">Tidak Terikat</option>
            <option value="terikat_temporer">Terikat Temporer</option>
            <option value="terikat_permanen">Terikat Permanen</option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Basis</label>  
      <div class="col-md-6">
          <select id="basis" name="basis" class="form-control" required="">
            <option value="kas">Kas</option>
            <option value="akrual">Akrual</option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">Tingkat</label>  
      <div class="col-md-6">
          <select id="tingkat" name="tingkat" class="form-control">
            <option value="">Pilih</option>
            <option value="biaya">Laporan Berdasarkan Biaya</option>
            <option value="tujuan">Tujuan</option>
            <option value="output">Output / Sasaran</option>
            <option value="program">Program</option>
            <option value="kegiatan">Kegiatan</option>
            <option value="subkegiatan">Sub Kegiatan</option>
          </select>
      </div>
    </div>
    
  <div id='vue_unit'>
    <div class="form-group">
      <label class="col-md-2 control-label">Level Laporan</label>  
      <div class="col-md-3">
          <select v-model="level_laporan" id="level" name="level" class="form-control" required="">
            <option value="3">Header</option>
            <option value="4">Sub-Header</option>
            <option value="6">Detail</option>
          </select>
      </div>
    </div>
   <div class="form-group">
    <label class="col-md-2 control-label">Tipe</label>  
    <div class="col-md-2 checkbox">
      <label><input type="checkbox" name="tipe[]" value="pengeluaran" onclick="cek()" checked>Transaksi</label>
   </div>
   <div class="col-md-2 checkbox" v-if="level_laporan == '6'">
     <label><input type="checkbox" name="tipe[]" value="pajak" onclick="cek()">Pajak</label>
   </div>
   <?php if ($this->session->userdata('kode_unit') == 92): ?>
   <div class="col-md-2 checkbox">
     <label><input type="checkbox" name="tipe[]" value="pengembalian" onclick="cek()">Pengembalian</label>
   </div>
  </div>
  <?php endif ?>
    <!-- Button (Double) -->
    <div class="form-group">
      <div class="col-md-12" style="text-align:center;">
        <button id="simpan" name="simpan" class="btn btn-success" type="submit">Buka Neraca</button>
      </div>
    </div>
  </div>  
    <?php echo form_close(); ?>
</div>
<br/>
<div class="row">
	<div class="col-sm-12">
		<?php //foreach($query_debet->result() as $result){ ?>
			<?php //echo $result->akun_debet; ?><br/>
		<?php //} ?>
		<?php //foreach($query_debet_akrual->result() as $result){ ?>
			<?php //echo $result->akun_debet_akrual; ?><br/>
		<?php //} ?>
		<?php //foreach($query_kredit->result() as $result){ ?>
			<?php //echo $result->akun_kredit; ?><br/>
		<?php //} ?>
		<?php //foreach($query_kredit_akrual->result() as $result){ ?>
			<?php //echo $result->akun_kredit_akrual; ?><br/>
		<?php //} ?>
	</div>
</div>

<script type="text/javascript">
  var data = {
    state : 1,
    items : <?php echo json_encode($program) ?>,
    selected_tujuan : {kode_kegiatan : null},
    selected_sasaran : {kode_output : null},
    selected_program : {kode_program : null},
    selected_kegiatan : {kode_komponen : null},
    selected_subkegiatan : {kode_subkomponen: null},
  }
  // require('vue-multiselect');
  // Vue.use('vue-multiselect');

  // Vue.component(Multiselect);

  new Vue({
    components: {
      Multiselect: window.VueMultiselect.default
    },
    el : '#app_select',
    data : data,
    computed : {
      filteredSasaran : function() {
        if (typeof data.selected_tujuan.kode_kegiatan == 'undefined') {
          return data.items.sasaran;
        } else {
          return data.items.sasaran.filter(function(el){
              return el.kode_kegiatan == data.selected_tujuan.kode_kegiatan;
          })
        }
      },
      filteredProgram : function() {
        if (typeof data.selected_sasaran.kode_output == 'undefined') {
          return data.items.program;
        } else {
          return data.items.program.filter(function(el){
              return el.kode_output == data.selected_sasaran.kode_output && el.kode_kegiatan == data.selected_tujuan.kode_kegiatan;
          })
        }
      },
      filteredKegiatan : function() {
        if ( typeof data.selected_program.kode_program == 'undefined') {
          return data.items.kegiatan;
        } else {
          return data.items.kegiatan.filter(function(el){
              return el.kode_program == data.selected_program.kode_program && el.kode_output == data.selected_sasaran.kode_output && el.kode_kegiatan == data.selected_tujuan.kode_kegiatan;
          })
        }
      },
      filteredSubkegiatan : function() {
        if ( typeof data.selected_kegiatan.kode_komponen == 'undefined') {
          return data.items.subkegiatan;
        } else {
          return data.items.subkegiatan.filter(function(el){
              return el.kode_komponen == data.selected_kegiatan.kode_komponen && el.kode_program == data.selected_program.kode_program && el.kode_output == data.selected_sasaran.kode_output && el.kode_kegiatan == data.selected_tujuan.kode_kegiatan;
          })
        }
      },
    },
    methods : {
      resetToAkun : function() {
        data.state = 0;
        data.selected_tujuan = {kode_kegiatan : null};
        data.selected_sasaran = {kode_output : null};
        data.selected_program = {kode_program : null};
        data.selected_kegiatan = {kode_komponen : null};
        data.selected_subkegiatan = {kode_subkomponen: null};
      },
      resetToProgram : function() {
        data.state = 1;
      }
    }
  })
</script>

<script type="text/javascript">
  var myForm = document.getElementById('form_pop');
    myForm.onsubmit = function() {
        var lebar = 0.9 * document.body.clientWidth;
        var win_name = Date.now();
        var w = window.open('about:blank',win_name,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width='+lebar+',height=700,left = 312,top = 234');
        this.target = win_name;
    };
    
    $('input[name="daterange"]').daterangepicker(
        {
          locale: {
              format: 'DD MMMM YYYY',
               "separator": " - ",
                "applyLabel": "Simpan",
                "cancelLabel": "Batalkan",
                "fromLabel": "Dari",
                "toLabel": "Sampai",
                "customRangeLabel": "Tentukan Periode",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
                "firstDay": 1
          },
          ranges: {
            'Triwulan I': [moment().month(0).startOf('month'), moment().month(2).endOf('month')],
            'Triwulan II': [moment().month(3).startOf('month'), moment().month(5).endOf('month')],
            'Triwulan III': [moment().month(6).startOf('month'), moment().month(8).endOf('month')],
            'Triwulan IV': [moment().month(9).startOf('month'), moment().month(11).endOf('month')],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment(),
          endDate: moment(),
          showDropdowns: true
        }
    );
</script>
<script type="text/javascript">
      vue_unit = new Vue({
        el : "#vue_unit",
        data : {
                  level_laporan : 3,
                  unit : 'all',
                },
        methods : {

        },
        computed : {

        },
        watch : {
        }
      });

      function cek(){
        checked = $("input:checkbox[name^='tipe']:checked").length;
        if (!checked) {
          $("input:checkbox[name^='tipe']").prop('required', true);
        } else {
          $("input:checkbox[name^='tipe']").prop('required', false);
        }
      };
</script>
<?php
function get_pengeluaran($id_kuitansi){
	$ci =& get_instance();

	$query = "SELECT SUM(volume*harga_satuan) AS pengeluaran FROM rsa_kuitansi_detail WHERE id_kuitansi='$id_kuitansi'";
	$q = $ci->db->query($query)->result();
	foreach($q as $result){
		return number_format($result->pengeluaran);
	}
}
function get_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->alias;
	}
}
function get_nama_unit($unit){
	$ci =& get_instance();
	$ci->db2 = $ci->load->database('rba', true);

	$query = "SELECT * FROM unit WHERE kode_unit='$unit'";
	$q = $ci->db2->query($query)->result();
	foreach($q as $result){
		return $result->nama_unit;
	}
}
?>