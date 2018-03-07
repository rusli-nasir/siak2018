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
                    <a data-toggle="tab" @click="get_data(each_jenis['nama_terjurnal']) ">
                        {{each_jenis['nama_jenis']}}
                        <span v-if="each_jenis['notif'] == 0" class="label label-primary">{{each_jenis['notif']}}</span>
                        <span v-if="each_jenis['notif'] != 0" class="label label-warning">{{each_jenis['notif']}}</span>
                    </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-10" class="tab-pane active">
                        <div class="panel-body ">
                            <div v-if="item_loading" class="sk-spinner sk-spinner-double-bounce sk-loading">
                                <div class="sk-double-bounce1"></div>
                                <div class="sk-double-bounce2"></div>
                            </div>
                            <span v-if="!loading">
                                 <vuetable ref="vuetable"
                                v-bind:api-url="api_url"
                                :fields="fields"
                                data-path="query"
                                pagination-path=""
                                @vuetable:pagination-data="onPaginationData"
                                @vuetable:loaded="onLoaded"
                                :per-page="20" 
                                >
                                    <template slot="actions" scope="props">
                                        <div class="table-button-container">
                                            <button class="ui button" :disabled="item_loading" ><i class="fa fa-edit"></i> Edit</button>&nbsp;&nbsp;
                                            <button class="ui basic red button" :disabled="item_loading"><i class="fa fa-remove"></i> Delete</button>&nbsp;&nbsp;
                                        </div>
                                    </template>
                                </vuetable>
                                <vuetable-pagination ref="pagination"
                                    @vuetable-pagination:change-page="onChangePage"
                                ></vuetable-pagination>
                            </span>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>

<script src="https://unpkg.com/vue-loading-overlay@2"></script>
<link href="https://unpkg.com/vue-loading-overlay@latest/dist/vue-loading.min.css" rel="stylesheet">

<script src="https://unpkg.com/vuetable-2@1.6.0"></script>

<script>
    Vue.use(Vuetable);
    tab_kuitansi = new Vue({
        el : '#tab-kuitansi',
        components:{
        'vuetable-pagination': Vuetable.VuetablePagination,
        'Loading': VueLoading
        },
        data : {
            'all_jenis' : <?=$all_jenis?>,
            'active' : '<?=$jenis_aktif?>',
            'item_loading' : true,
            'loading' : false,
            'panel' : '',
            'page' : 1,
            'changed' : false,
            'fields' : ['__slot:actions','tgl_kuitansi','str_nomor_trx_spm','kode_usulan_belanja','no_bukti'],
            'api_url' : '',
        },
        methods : {
            get_data(check){
                this.active = check;
                this.api_url = '<?=site_url().'/akuntansi/kuitansi/lists/'?>' + this.active + '/' + this.page;
                this.item_loading = true;
                // axios.get()
                // .then(response => {
                //     this.loading = false;
                //     console.log(response);
                //     this.panel = this.active + ' ' + response.data.query
                // })
                // .catch(error => {
                //     this.loading = false;
                //     this.panel = this.active + ' ' + 'There was an error: ' + error.message
                // })
            },
            onLoaded (){
                this.item_loading = false;
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            },
            editRow(rowData){
                alert("You clicked edit on"+ JSON.stringify(rowData))
            },
            deleteRow(rowData){
                alert("You clicked delete on"+ JSON.stringify(rowData))
            }
        },
        created() {
            this.get_data(this.active);
        }
    });
</script>
