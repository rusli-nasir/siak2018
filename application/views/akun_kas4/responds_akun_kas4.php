<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$kode_kegiatan = $this->input->post('kode-kegiatan')?$this->input->post('kode-kegiatan'):$this->uri->segment(3);
	$kode_output = $this->input->post('kode-output')?$this->input->post('kode-output'):$this->uri->segment(4);

if(isset($data_row))
{
if(is_array($data_row) && count($data_row)>0)
{
	$keyword = trim($this->input->post('keyword'));
	$str_replace = ($this->input->post('keyword') || $this->input->post('keyword')=='0')?'<b>'.$keyword.'</b>':'';
foreach($data_row as $value){
?>
<tr>
	<td align="center" id="kode"><?php echo str_replace($keyword,$str_replace,$value->kode_program);?></td>
	<td align="left" id="nama"><?php echo str_replace($keyword,$str_replace,$value->nama_program);?></td>
	<td align="left" id="bidang"><?php echo str_replace($keyword,$str_replace,$value->bidang);?></td>
	<td style="text-align:center">
		<div class="btn-group">
				<button type="button" class="btn btn-success" onclick="programdopick('<?php echo $value->nama_program;?>','<?php echo $value->kode_kegiatan.'/'.$value->kode_output.'/'.$value->kode_program;?>')" aria-label="Left Align" alt="<?php echo $value->kode_kegiatan.'/'.$value->kode_output.'/'.$value->kode_program;?>" rel="<?php echo $value->nama_program;?>"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pilih</button>
			</div>
	</td>
</tr>
<?php
}
}
}
?>