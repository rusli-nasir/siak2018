<style>

.file-wrapper {
   cursor: pointer;
   display: inline-block;
   overflow: hidden;
   position: relative;
}
.file-wrapper input {
   cursor: pointer;
   font-size: 0px;
   height: 100%;
   width: 100%;
   filter: alpha(opacity=1);
   -moz-opacity: 0.01;
   opacity: 0.01;
   position: absolute;
   right: 0;
   top: 0;
}
.file-wrapper .button {
   display: inline-block;
   outline: 0;
   padding: 0;
   vertical-align: middle;
   overflow: hidden;
   text-decoration: none;
   text-align: center;
   cursor: pointer;
   color: #000;
   border: 2px solid #d1d1d1;
   border-radius: 15px;
   border-style: dashed;
   width: 100px;
   height: 100px;
}
</style>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<h2>UPLOAD GAJI APBN</h2>   
			</div>
	
			<div class="col-lg-12">
				<form action="<?php echo site_url() ?>/rsa_gaji_apbn/do_upload" id="form_gaji_apbn" method="post" enctype='multipart/form-data' >
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="no_spm_apbn">No. SPM APBN</label>
								<input type="text" class="validate[required] form-control" id="no_spm_apbn" name="no_spm_apbn">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="tahun">Tahun</label>
									<select class="form-control" name="tahun" id="tahun">
										<option value="">- Pilih Tahun -</option>
										<option value="2018" selected>2018</option>
										<option value="2017">2017</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="bulan">Bulan</label>
									<select class="form-control" name="bulan" id="bulan">
										<option value="">- Pilih Bulan -</option>
										<option value="01">Januari</option>
										<option value="02">Februari</option>
										<option value="03">Maret</option>
										<option value="04">April</option>
										<option value="05">Mei</option>
										<option value="06">Juni</option>
										<option value="07">Juli</option>
										<option value="08">Agustus</option>
										<option value="09">September</option>
										<option value="10">Oktober</option>
										<option value="11">November</option>
										<option value="12">Desember</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="kode_unit">Unit</label>
								<select class="form-control" name="kode_unit" id="kode_unit">
									<option value="">- Pilih Unit -</option>
									<?php foreach ($data_unit as $unit): ?>
										<option value="<?php echo $unit->kode_unit ?>"><?php echo $unit->nama_unit ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="jenis_gaji">Jenis Gaji</label>
								<select class="form-control" name="jenis_gaji" id="jenis_gaji">
									<option value="">- Pilih Jenis Gaji -</option>
									<option value="gapok_tunjangan">Gaji Pokok dan Tunjangan</option>
									<option value="profesi">Tunjangan Profesi Dosen</option>
									<option value="kehormatan">Tunjangan Kehormatan</option>
									<!-- <option value="uang_makan">Tunjangan Uang Makan</option> -->
									<!-- <option value="lembur">Tunjangan Lembur</option> -->
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="jabatan">Posisi Jabatan</label>
								<select class="form-control" name="jabatan" id="jabatan">
									<option value="">- Pilih Posisi Jabatan -</option>
									<option value="dosen">Dosen</option>
									<option value="tendik">Tenaga Pendidik</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4"></div>
						<div class="col-lg-4" style="text-align: center;">
							<div class="file-wrapper">
								<label for="excel" class="col-sm-12 control-label" id="label_img" style="padding: 0px;">Tambah Foto Produk</label>
								<input type="file" name="excel" id="excel" required />
								<div class="button" id="excel_btn">
									<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAzMDkuNTI5IDMwOS41MjkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMwOS41MjkgMzA5LjUyOTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzNEQjM5RTsiIGQ9Ik0xNzkuNzI4LDI1MS4yNzljMC0zOS41ODYsMzIuMDk2LTcxLjY4Miw3MS42ODItNzEuNjgyYzYuNjk4LDAsMTMuMTczLDAuOTk1LDE5LjMyOSwyLjcxNlY4Ni43MTEgICBMMTgzLjY5LDBIMTkuNDZDOC43OSwwLDAuMTMsOC42NSwwLjEzLDE5LjMyOXYyNzAuNjA5YzAsMTAuNjc5LDguNjU5LDE5LjMyOSwxOS4zMjksMTkuMzI5aDE4OS45MjkgICBDMTkxLjQ0MSwyOTYuMjM5LDE3OS43MjgsMjc1LjE2MSwxNzkuNzI4LDI1MS4yNzl6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojMkY4QTc4OyIgZD0iTTI3MC40Niw4Ni45ODFoLTY3LjM3MmMtMTAuNjcsMC0xOS4zMjktOC42NTktMTkuMzI5LTE5LjMyOVYwLjE5M0wyNzAuNDYsODYuOTgxeiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzNEQjM5RTsiIGQ9Ik0yNTEuNDEsMTkzLjU1M2MzMi4wMjgsMCw1Ny45ODgsMjUuOTY5LDU3Ljk4OCw1Ny45ODhjMCwzMi4wMDktMjUuOTU5LDU3Ljk4OC01Ny45ODgsNTcuOTg4ICAgYy0zMi4wMDksMC01Ny45ODgtMjUuOTc4LTU3Ljk4OC01Ny45ODhDMTkzLjQyMiwyMTkuNTIyLDIxOS40MDEsMTkzLjU1MywyNTEuNDEsMTkzLjU1M3oiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGRkZGRkY7IiBkPSJNMjcwLjc0LDI0MS44NzZoLTkuNjY1di05LjY2NWMwLTUuMzQ1LTQuMzItOS42NjUtOS42NjUtOS42NjVjLTUuMzQ1LDAtOS42NjUsNC4zMi05LjY2NSw5LjY2NSAgIHY5LjY2NWgtOS42NjVjLTUuMzQ1LDAtOS42NjUsNC4zMi05LjY2NSw5LjY2NWMwLDUuMzU0LDQuMzIsOS42NjUsOS42NjUsOS42NjVoOS42NjV2OS42NjVjMCw1LjM1NCw0LjMyLDkuNjY1LDkuNjY1LDkuNjY1ICAgYzUuMzQ0LDAsOS42NjUtNC4zMSw5LjY2NS05LjY2NXYtOS42NjVoOS42NjVjNS4zNDUsMCw5LjY2NS00LjMxLDkuNjY1LTkuNjY1QzI4MC40MDQsMjQ2LjIwNiwyNzYuMDg1LDI0MS44NzYsMjcwLjc0LDI0MS44NzZ6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojOEJEMUM1OyIgZD0iTTE4My43NTgsMjI4LjAyNnYtNS43NDFoMi4yNTJjMS41MDgtMy4zNzMsMy4yNjctNi42MDEsNS4yNTgtOS42NjVoLTcuNTA5VjE5My4zaDE5LjMyOXY1LjQyMiAgIGMzLjAwNi0yLjc1NCw2LjIyNC01LjI1OCw5LjY2NS03LjQ3MVYxMjUuNjRINTguMTE4djEyNS42NGgxMjEuNjE5QzE3OS43NzYsMjQzLjEyMywxODEuMjE2LDIzNS4zMzMsMTgzLjc1OCwyMjguMDI2eiAgICBNMTgzLjc1OCwxMzUuMzA0aDE5LjMyOXYxOS4zMjloLTE5LjMyOVYxMzUuMzA0eiBNMTgzLjc1OCwxNjQuMzA4aDE5LjMyOXYxOS4zMmgtMTkuMzI5VjE2NC4zMDh6IE04Ny4xMTIsMjQxLjYyNUg2Ny43ODN2LTE5LjMzOSAgIGgxOS4zMjlWMjQxLjYyNXogTTg3LjExMiwyMTIuNjIxSDY3Ljc4M3YtMTkuMzJoMTkuMzI5VjIxMi42MjF6IE04Ny4xMTIsMTgzLjYyN0g2Ny43ODN2LTE5LjMyaDE5LjMyOVYxODMuNjI3eiBNODcuMTEyLDE1NC42MzQgICBINjcuNzgzdi0xOS4zMjloMTkuMzI5VjE1NC42MzR6IE0xMTYuMTA2LDI0MS42MjVoLTE5LjMzdi0xOS4zMzloMTkuMzI5TDExNi4xMDYsMjQxLjYyNUwxMTYuMTA2LDI0MS42MjV6IE0xMTYuMTA2LDIxMi42MjEgICBoLTE5LjMzdi0xOS4zMmgxOS4zMjlMMTE2LjEwNiwyMTIuNjIxTDExNi4xMDYsMjEyLjYyMXogTTExNi4xMDYsMTgzLjYyN2gtMTkuMzN2LTE5LjMyaDE5LjMyOUwxMTYuMTA2LDE4My42MjdMMTE2LjEwNiwxODMuNjI3eiAgICBNMTE2LjEwNiwxNTQuNjM0aC0xOS4zM3YtMTkuMzI5aDE5LjMyOUwxMTYuMTA2LDE1NC42MzRMMTE2LjEwNiwxNTQuNjM0eiBNMTQ1LjA5OSwyNDEuNjI1SDEyNS43N3YtMTkuMzM5aDE5LjMyOVYyNDEuNjI1eiAgICBNMTQ1LjA5OSwyMTIuNjIxSDEyNS43N3YtMTkuMzJoMTkuMzI5VjIxMi42MjF6IE0xNDUuMDk5LDE4My42MjdIMTI1Ljc3di0xOS4zMmgxOS4zMjlWMTgzLjYyN3ogTTE0NS4wOTksMTU0LjYzNEgxMjUuNzd2LTE5LjMyOSAgIGgxOS4zMjlWMTU0LjYzNHogTTE3NC4wOTMsMjQxLjYyNWgtMTkuMzI5di0xOS4zMzloMTkuMzI5VjI0MS42MjV6IE0xNzQuMDkzLDIxMi42MjFoLTE5LjMyOXYtMTkuMzJoMTkuMzI5VjIxMi42MjF6ICAgIE0xNzQuMDkzLDE4My42MjdoLTE5LjMyOXYtMTkuMzJoMTkuMzI5VjE4My42Mjd6IE0xNTQuNzY0LDE1NC42MzR2LTE5LjMyOWgxOS4zMjl2MTkuMzI5SDE1NC43NjR6Ii8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" style="width: 50%;margin: 0 auto;margin-top: 25%;" id="showimage" />
								</div>
							</div>

							<span style="display: block;font-size: 12px;" id="filename_text">Unggah File (.csv atau .xls)</span>
						</div>
						<div class="col-lg-4"></div>
					</div>
					
					<div class="row" style="margin-top: 20px;">
						<div class="col-lg-4"></div>
						<div class="col-lg-4 text-center">
							<button type="submit" class="btn btn-success" style="border-radius: 0px;width: 100%;">Submit</button>
						</div>
						<div class="col-lg-4"></div>
					</div>
				</form>
			</div>
		</div>
		<!-- /. PAGE INNER  -->
	</div>
	<!-- /. PAGE WRAPPER  -->
</div>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script>
  function readURL(input) {

    if (input.files && input.files[0]) {
      $('#showimage').attr('src', "data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MDQuMTIgNTA0LjEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MDQuMTIgNTA0LjEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPGNpcmNsZSBzdHlsZT0iZmlsbDojM0RCMzlFOyIgY3g9IjI1Mi4wNiIgY3k9IjI1Mi4wNiIgcj0iMjUyLjA2Ii8+CjxwYXRoIHN0eWxlPSJmaWxsOiMzN0ExOEU7IiBkPSJNNDYzLjE2MywxMTQuNjA5TDI0MC4yNDYsMzQ1LjQwM2wwLjM5NCwyNC44MTJoMTAuMjRsMjQxLjQyOC0xOTQuNTYgIEM0ODUuMjE4LDE1My45OTQsNDc1LjM3MiwxMzMuMTIsNDYzLjE2MywxMTQuNjA5eiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRjJGMUVGOyIgZD0iTTQ5OS4zOTcsMTAzLjU4MmwtNDQuNTA1LTQ0LjExMWMtNS45MDgtNS45MDgtMTUuNzU0LTUuOTA4LTIyLjA1NSwwTDI0Mi42MDksMjU2bC04Mi4zMTQtODEuMTMyICBjLTUuOTA4LTUuOTA4LTE1Ljc1NC01LjkwOC0yMi4wNTUsMGwtMzkuMzg1LDM4Ljk5MWMtNS45MDgsNS45MDgtNS45MDgsMTUuNzU0LDAsMjEuNjYyTDIzMC40LDM2NS44ODMgIGMzLjU0NSwzLjU0NSw4LjI3MSw0LjcyNiwxMi45OTcsNC4zMzJjNC43MjYsMC4zOTQsOS40NTItMC43ODgsMTIuOTk3LTQuMzMybDI0My4wMDMtMjQwLjI0NiAgQzUwNS4zMDUsMTE5LjMzNSw1MDUuMzA1LDEwOS40ODksNDk5LjM5NywxMDMuNTgyeiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRTZFNUUzOyIgZD0iTTI1Ni4zOTQsMzY1Ljg4M2wyNDMuMDAzLTI0MC4yNDZjNS45MDgtNS45MDgsNS45MDgtMTUuNzU0LDAtMjEuNjYybC03LjA4OS02LjY5NUwyNDMuMDAzLDM0Mi4yNTIgIEwxMDUuMTU3LDIwNy45NTFsLTUuOTA4LDUuOTA4Yy01LjkwOCw1LjkwOC01LjkwOCwxNS43NTQsMCwyMS42NjJsMTMxLjU0NSwxMzAuMzYzYzMuNTQ1LDMuNTQ1LDguMjcxLDQuNzI2LDEyLjk5Nyw0LjMzMiAgQzI0OC4xMjMsMzcwLjYwOSwyNTIuODQ5LDM2OS40MjgsMjU2LjM5NCwzNjUuODgzeiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K");
    }
  }


  $("#excel").change(function(){
      readURL(this);
      $('#showimage').css({
                   'width' : '100%',
                   'height' : 'auto',
                   'padding' : '25px',
                   'margin' : '0px'
                  });

      $('#filename_text').html($('#excel').val().split('\\').pop());
  });

  $(document).ready(function() {
  	$("#label_img").click(function(e) {
  		e.preventDefault();
  	});

   $('#form_gaji_apbn').validate({ // initialize the plugin
     	rules: {
     		excel: {
     			required: true,
     			extension: "xls"
     		}
     	},
        submitHandler: function (form) { // for demo
            alert('valid form submitted'); // for demo
            return true; // for demo
         }
      });
  });

</script>