<script type="text/javascript">
	//action untuk hapus data kegiatan
	$(document).on("click","#show-user",function(){
	//$(".delete").live("click",function(){


		$("#myModal").load('<?php echo site_url('user/show_user');?>' 
			,function(){
				$("#myModal").modal('show');
			}
		);

	})
</script>
<ul class="nav navbar-nav navbar-right">        
	<li><a href="javascript:void(0)" id="show-user"><?php echo $this->check_session->get_nama_unit() ?></a></li>
	<!-- <li><a href="/index.php/users/login"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</a></li> -->
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User<span class="caret"></span></a>
      	<ul class="dropdown-menu">
			<li ><a href="<?php echo site_url("user/ubah_password");?>">Ganti Password</a></li>
			<li ><a href="<?php echo site_url("user/logout");?>">Logout</a></li>
		<!--
	        <li><a href="#">Action</a></li>
	        <li><a href="#">Another action</a></li>
	        <li><a href="#">Something else here</a></li>
	        <li role="separator" class="divider"></li>
	        <li><a href="#">Separated link</a></li>
	    -->
	    </ul>
    </li>
</ul>