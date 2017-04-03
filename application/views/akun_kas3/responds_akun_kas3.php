<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$kd_kas_2 = $this->input->post('kd_kas_2')?$this->input->post('kd_kas_2'):$this->uri->segment(3);

if(isset($data_row))
{
if(is_array($data_row) && count($data_row)>0)
{
	$keyword = trim($this->input->post('keyword'));
	$str_replace = ($this->input->post('keyword') || $this->input->post('keyword')=='0')?'<b>'.$keyword.'</b>':'';
foreach($data_row as $value){
?>
<tr>
	<td align="center" id="kode"><?php echo str_replace($keyword,$str_replace,$value->kd_kas_3);?></td>
	<td align="left" id="nama"><?php echo str_replace($keyword,$str_replace,$value->nm_kas_3);?></td>
	<td style="text-align:center">
		<div class="btn-group">
				<button type="button" class="btn btn-success" onclick="outputdopick('<?php echo $value->nm_kas_3;?>','<?php echo $value->kd_kas_2.'/'.$value->kd_kas_3;?>')" aria-label="Left Align" alt="<?php echo $value->kd_kas_2.'/'.$value->kd_kas_3;?>" rel="<?php echo $value->nm_kas_3;?>"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Pilih</button>
			</div>
	</td>
</tr>
<?php
}
}
}
?>