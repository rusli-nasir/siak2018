<script>
	$(document).ready(function(){
		$("#cetak").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#div-cetak").printArea( options );
     });

	});

	function fnExcelReport()
		{
		    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		    var textRange; var j=0;
		    tab = document.getElementById('print'); // id of table

		    for(j = 0 ; j < tab.rows.length ; j++) 
		    {     
		        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
		        //tab_text=tab_text+"</tr>";
		    }

		    tab_text=tab_text+"</table>";
		    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE "); 

		    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		    {
		        txtArea1.document.open("txt/html","replace");
		        txtArea1.document.write(tab_text);
		        txtArea1.document.close();
		        txtArea1.focus(); 
		        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		    }  
		    else                 //other browser not tested on IE 11
		        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

		    return (sa);
		}
		

</script>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">
				<h3><b>CETAK DAFTAR UNIT SUB-UNIT</b></h3><hr>
				<div id="temp" style="display:none">
				</div>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active">
						<div style="background-color: #EEE;">
							<div id="div-cetak" style="padding-top:10px;padding-bottom:10px;">
								<table class="table_print table table-striped" id="print" style="font-family:arial;font-size:12px; line-height: 21px;border-collapse: collapse;width: 800px;background-color: #FFF;" cellspacing="0px" border="0">
									<thead>
										<tr>
											<th>KODE UNIT</th>
											<th>KODE SUBUNIT</th>
											<th>KODE SUB SUBUNIT</th>
											<th>UNIT</th>
											<th>SUBUNIT</th>
											<th>SUB SUBUNIT</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$kode_unit = '';
										$kode_subunit = '';
										?>
										<?php foreach ($data_unit as $unit): ?>

											<?php if ($kode_unit == '' || $kode_unit != $unit->kode_unit): ?>
												<tr>
													<td><?php echo $unit->kode_unit ?></td>
													<td></td>
													<td></td>
													<td><?php echo $unit->nama_unit ?></td>
													<td></td>
													<td></td>
												</tr>
											<?php endif ?>

											<?php if ($kode_subunit == '' || $kode_subunit != $unit->kode_subunit): ?>
												<tr>
													<td></td>
													<td><?php echo $unit->kode_subunit ?></td>
													<td></td>
													<td></td>
													<td><?php echo $unit->nama_subunit ?></td>
													<td></td>
												</tr>
											<?php endif ?>

											<tr>
												<td></td>
												<td></td>
												<td><?php echo $unit->kode_sub_subunit ?></td>
												<td></td>
												<td></td>
												<td><?php echo $unit->nama_sub_subunit ?></td>
											</tr>

											<?php $kode_unit = $unit->kode_unit ?>
											<?php $kode_subunit = $unit->kode_subunit ?>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<iframe id="txtArea1" style="display:none"></iframe>
		<div class="alert alert-warning" style="text-align:center">
			<button type="button" class="btn btn-info" id="cetak" rel=""><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak</button>
			<button id="btnExport" onclick="fnExcelReport();"> EXPORT </button>
		</div>
	</div>
</div>