<?php 
$ci =& get_instance();
$tahun = $this->session->userdata('setting_tahun');
 ?>

<div class="row m-t-lg" id="tab-kuitansi">
    <div class="col-lg-12">
        <div class="tabs-container">
            <div class="tabs-left">
                <ul class="nav nav-tabs">
                    <li v-for="each_jenis in all_jenis" v-bind:class="{ active: each_jenis['aktif'] }">
                    <a data-toggle="tab">
                        {{each_jenis['nama_jenis']}}
                        <span class="label label-warning">{{each_jenis['notif']}}</span>
                    </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-10" class="tab-pane active">
                        <div class="panel-body">
                            PANEL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>

<script src="https://unpkg.com/vuetable-2@1.6.0"></script>

<script>
    tab_kuitansi = new Vue({
        el : '#tab-kuitansi',
        data : {
            'all_jenis' : <?=$all_jenis?>
        },
    });
</script>
