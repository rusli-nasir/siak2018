<?php if (!defined("BASEPATH")) exit("No direct script access allowed"); ?>
<script type="text/javascript">
$(document).ready(function () {	
	$('#username').focus(function(){
		$('#username').css('background','#fff');
	});
	
	$('#username').blur(function(){
		$('#username').val($.trim($('#username').val()));
		if($('#username').val()!=''){
			$('#username').css('background','#fff');
		}else{
			//$('#username').css('background','#fff url(<?php echo base_url();?>frontpage/images/username.png) no-repeat');
		}
	});
	
	$('#password').focus(function(){
		$('#password').css('background','#fff');
	});
	
	$('#password').blur(function(){
		$('#password').val($.trim($('#password').val()));
		if($('#password').val()!=''){
			$('#password').css('background','#fff');
		}else{
			//$('#password').css('background','#fff url(<?php echo base_url();?>frontpage/images/password.png) no-repeat');
		}
	});
	
	$('#username').val($.trim($('#username').val()));
	$('#password').val($.trim($('#password').val()));
	
	if($('#username').val()!=''){
		$('#username').focus();
	}else{
		$('#username').blur();
	}
	
	if($('#password').val()!=''){
		$('#password').focus();
	}else{
		$('#password').blur();
	}
});
</script>



<nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
			
                <?php echo form_open("user/login",array("class"=>"nav","id"=>"form-login"));?>
			
  <div class="form-group">
    
    <label for="exampleInputEmail1">Username</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo set_value("username");?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value("password");?>">
  </div>

  <button type="submit" class="btn btn-default">Submit</button>
</form>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->