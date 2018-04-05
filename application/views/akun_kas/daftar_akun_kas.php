<script type="text/javascript">
var status_edit = true;
$(document).ready(function(){
    //action untuk tambah data kegiatan
    $(document).on("click","#add",function(){
    //$("#add").live("click",function(){
        var data=$("#form_add_akun_kas").serialize();
        if($("#form_add_akun_kas").validationEngine("validate")){
            $.ajax({
                type:"POST",
                url:"<?=site_url("akun_kas/exec_add_akun_kas")?>",
                data:data,
                success:function(respon){
                    if (respon=="berhasil"){
                        refresh_row();
                    } else {
                        var r = respon; 
                        while (r.search(/<[^>]*>/)!=-1){
                            r = r.replace(/<[^>]*>/,'');
                        }
                        alert(r);
                    }
                }
            });
        }
    })
    
    //action untuk mengambil form ubah data kegiatan
    $(document).on("click",".edit",function(){
    //$(".edit").live('click',function(){
        if(status_edit){
            $("#form_edit_akun_kas").validationEngine('hide');
            $("#form_add_akun_kas").validationEngine('hide');
            status_edit = false;
            $("#add_akun_kas").hide();
            
            // RESET CLASS //

            $('tr.alert-success').removeClass('alert-success');
            $('tr.form-horizontal').removeClass('form-horizontal');

            // END RESET CLASS //

            $(this).closest('tr').addClass('alert-success').addClass('form-horizontal');

            //cek ada data di temporari atau tidak
            if($("#temp").html()!=""){
                //kembalikan ke semula
                var id_temp = $("#temp td:first").html();
                $("#"+id_temp).html($("#temp").html());
                $("#temp").empty();
            }
            
            var id=$(this).attr("rel");
            $("#temp").html($("#"+id).html());
            $("#"+id).html("<td colspan='4' align='center'>Loading..</td>");
            var data= "kd_kas_="+id;
            //load form edit
            $.ajax({
                type:"POST",
                url:"<?=site_url("akun_kas/get_form_edit")?>",
                data:data,
                success:function(respon){
                    $("#"+id).html(respon);
                    status_edit = true;
                }
            });
        }
    });
    
    //action untuk mengubah data kegiatan
    $(document).on("click",".submit",function(){
    //$(".submit").live("click",function(){
        var kd_kas_ = $(this).attr("rel");
        var nm_kas_ = $("#"+kd_kas_+" input.nm_kas_").val();
        var data="kd_kas_="+kd_kas_+"&nm_kas_="+nm_kas_;
        if($("#form_edit_akun_kas").validationEngine("validate")){
            $("#"+kd_kas_).html("<td colspan='4' align='center'>Loading..</td>");
            $.ajax({
                type:"POST",
                url :"<?=site_url("akun_kas/exec_edit_akun_kas")?>",
                data:data,
                success:function(respon){
                    $("#"+kd_kas_).replaceWith(respon);
                    $("#temp").empty();
                    $("#add_akun_kas").show();
                }
            })
        }
    })
    
    //action untuk membatalkan pengubahan data
    $(document).on("click",".cancel",function(){
    //$(".cancel").live("click",function(){
        var id=$(this).attr("rel");
        $("#form_edit_akun_kas").validationEngine('hide');
        
        $(this).closest('tr').removeClass('alert-success').removeClass('form-horizontal');

        $("#"+id).html($("#temp").html());
        $("#temp").empty();
        $("#add_akun_kas").show();
    });
    
    $('#reset').click(function(){
        $('#form_add_akun_kas').validationEngine('hide');
    });
    
    //action untuk hapus data kegiatan
    $(document).on("click",".delete",function(){
    //$(".delete").live("click",function(){


        $("#myModal").load('<?php echo site_url('akun_kas/confirmation_delete/');?>/' + $(this).attr('rel')
            ,function(){
                $("#myModal").modal('show');
            }
        );

        /*

        $.colorbox({
            href: '<?php echo site_url('kegiatan/confirmation_delete/');?>/' + $(this).attr('rel'),
            opacity : 0.65,
            onCleanup:function(){
                refresh_row();
                $("#add_kegiatan").show();
            }
        });

        */

    })
    
    //action untuk filterisasi
    $("#filter_akun_kas").bind("keyup",function(){
        $("#form_edit_akun_kas").validationEngine('hide');
        $("#form_add_akun_kas").validationEngine('hide');
        var keyword = $(this).val();
        if (keyword!="- Masukkan kata kunci untuk memfilter data -"){
            $.ajax({
                data    : "keyword="+keyword,
                url     : "<?=site_url("akun_kas/filter_akun_kas")?>",
                type    : "POST",
                success : function(respon){
                    $("#row_space").html(respon);
                    $("#add_akun_kas").show();
                }
            });
        }
    })
    
    $("#filter_akun_kas").click(function(){
        $(this).val("");
    });
    
    $("#filter_akun_kas").bind("blur",function(){
        if($(this).val()==''){
            $(this).val("- Masukkan kata kunci untuk memfilter data -");
        };
    })
    
    $("#tampil_semua").click(function(){
        refresh_row();
        $("#add_akun_kas").show();
    });
});
function refresh_row(){
    $("#form_edit_akun_kas").validationEngine('hide');
    $("#form_add_akun_kas").validationEngine('hide');
    $("#filter_akun_kas").val("- Masukkan kata kunci untuk memfilter data -");
    $("#row_space").load("<?=site_url('akun_kas/get_row_akun_kas')?>");
    $("#add_akun_kas input[type='text']").val("");
}
</script>
<div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">

                <div class="row">
                    <div class="col-lg-12">
                        <h2>DAFTAR AKUN</h2>    
                    </div>
                </div>
                <hr />
<div id="temp" style="display:none"></div>
<form id="form_edit_akun_kas" onsubmit="return false">
<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr >
        <th class="col-md-1" >Kode </th>
        <th class="col-md-10" >Nama Kode </th>
        <!-- <th class="col-md-1" colspan="2" style="text-align:center">Aksi</th> -->
    </tr>
<!--     <tr>
        <th colspan="2" align="center"><input type="text" name="filter" class="form-control" id="filter_akun_kas" value="- Masukkan kata kunci untuk memfilter data -" style="text-align:center"></th>
        <th colspan="2" align="center"><input type="button" name="show_all" class="btn btn-default" id="tampil_semua" value="Tampilkan Semua"></th>
    </tr> -->
    </thead>
    <tbody id="row_space">
    <?=isset($row_akun_kas)?$row_akun_kas:""?>
    </tbody>
</table>
</form>
<!-- <form id="form_add_akun_kas" onsubmit="return false">
<table class="table table-striped">
<tbody>
    <tr id="add_akun_kas">
        <td class="col-md-1"><input type="text" class="validate[required,maxSize[2],minSize[2],custom[integer]] form-control" id="kd_kas_" name="kd_kas_"></td>
        <td class="col-md-10"><input type="text" class="validate[required] form-control" id="nm_kas_" name="nm_kas_"></td>
        <td align="center" class="col-md-1">
            <div class="btn-group">
                <button type="submit" class="btn btn-default btn-sm" id="add" aria-label="Left Align"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                <button type="reset" class="btn btn-default btn-sm" id="reset" aria-label="Center Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
            </div>
            <input type="submit" class="btn btn-default" name="submit" id="add" value="simpan">
        </td>
    </tr>
</tbody>
</table>
</form> -->


</div>
</div>
</div>
</div>
</div>