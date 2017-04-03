<style>
  .table-responsive{
      height: 180px;
  }
  .height-100{
    /*max-height: 100vh;*/
    min-height: 60vh;
    width: 100%;
    /*border:1px solid #000;*/
    margin:0;
    border:0;
  }

</style>
<div id="page-wrapper" >
  <!-- <div id="page-inner"> -->
    <div class="row">
      <h4 class="page-header">Kepegawaian #2</h4>
      <iframe src="<?php echo base_url(); ?>hack-sign/?_v=<?php echo base64_encode(serialize($_SESSION)); ?>" class="height-100" onload="javascript:iframeLoaded(this);"></iframe>
    </div>
  <!-- </div> -->
</div>
<script>
  function iframeLoaded(obj){
    // var iFrameID = document.getElementById('ifr');
    // if(iFrameID){
    //   iFrameID.height = '';
    //   iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 'px';
    // }
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
