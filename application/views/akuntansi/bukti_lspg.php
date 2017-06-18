<script type="text/javascript">

$(document).ready(function(){
   $('#spm_tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

      // store the currently selected tab in the hash value
      $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
      });

      // on load of the page: switch to the currently selected tab
      var hash = window.location.hash;
      $('#spm_tab a[href="' + hash + '"]').tab('show');
    
    $('#back').on('click',function(e){
        e.preventDefault();
        window.history.back();
    });
    $('#list').on('click',function(e){
        e.preventDefault();
        window.location='<?php echo site_url('tor/daftar_spmlspeg')."/tahun/".$detail_up->tahun; ?>';
    });
    $('#down').on('click',function(e){
        var uri = $("#table_spp_up").excelexportjs({
            containerid: "table_spp_up"
            , datatype: "table"
            , returnUri: true
        });
        $('#dtable').val(uri);
        $('#form_spp').submit();
    });
});

function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
}

</script>
<style type="text/css">
    .edit{border-bottom: 1px solid #f00;}
</style>

<div> 
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="spm_tab">
        <li role="presentation" class="active"><a href="#spp" aria-controls="home" role="tab" data-toggle="tab">SPP</a></li>
        <li role="presentation"><a href="#spm" aria-controls="profile" role="tab" data-toggle="tab">SPM</a></li>
  </ul>
        
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="spm">
            <div style="background-color: #EEE; padding: 10px;">
                    <?= $spm ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane active" id="spp">
            <div style="background-color: #EEE; padding: 10px;">
                    <?= $spp ?>
            </div>
        </div>
    </div>
</div>
