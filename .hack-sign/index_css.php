<?php
if(isset($_GET['page']) && strlen(trim($_GET['page']))>0){
  if(file_exists($_CONFIG['folder'].$_GET['page']."/css.php")){
    require_once $_CONFIG['folder'].$_GET['page']."/css.php";
  }
}
?>
<style>
  .<?php echo $_CONFIG['skin']; ?> .content-wrapper{
    border-left:0;
  }
  .scroll-100{
    overflow-x:hidden;max-height:100px;
  }
  .scroll-150{
    overflow-x:hidden;max-height:100px;
  }
  .scroll-300{
    overflow-x:hidden;max-height:300px;
  }
</style>
