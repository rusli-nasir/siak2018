<?php
  if(isset($_GET['page']) && strlen(trim($_GET['page']))>0){
    if(file_exists($_CONFIG['folder'].$_GET['page']."/js.php")){
      require_once $_CONFIG['folder'].$_GET['page']."/js.php";
    }
  }
?>
<script type="text/javascript">
  $(document).on({
    ajaxStart: function() { $('.modal_ajax_loading').show();  },
    ajaxStop: function() { $('.modal_ajax_loading').hide(); }
  });
</script>
