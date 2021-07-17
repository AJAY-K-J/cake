<template>

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Item</label>
                            <input class="form-control"
                                      autocomplete="off"
                                      name="name"
                                      @focus="showOptions()"

                                      @keyup="set()"
                                      @blur="exit()"
                                      v-model="shiner.product"
                                      placeholder="Product Name" />

                                    <!-- Dropdown Menu -->
                                    <div class="dropdown-content"
                                      v-show="show">
                                      <div 
                                        class="dropdown-item"
                                        @mousedown="selectOption(option);"
                                        v-for="(option, index) in filteredOptions"
                                        :key="index" >
                                          {{ option.name  }}
                                      </div>
                                    </div>
                            <!--  <input type="texr" placeholder="Product Name" autocomplete="off"  required="required" v-model="shiner.product" class="form-control"> -->
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" placeholder="From Date" autocomplete="off"  required="required" v-model="shiner.from" class="form-control" :max="shiner.to">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" placeholder="To Date" autocomplete="off" required="required" v-model="shiner.to" class="form-control" :min="shiner.from">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <button @click="get_data" class="btn btn-block btn-success btn-sm m-0 mr-md-2">Filter</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <button @click="clear_filter"  class="btn btn-block btn-info btn-sm m-0">Clear Filters</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <a :href="`/reports/items/data?product=${shiner.product}&from=${shiner.from}&to=${shiner.to}&export=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="report-table" class="table custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Product Name</th>
                        <th>Date</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Purchase No/Invoice No</th>
                        <th>Vendor Name</th>
                                   
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
   
   
 </div>
</template>

<script>
import moment from 'moment';
import mixins from '../../mixins/jarvis';
import DataTable from 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
    mixins:[mixins],  props:['products'],
  
    created(){

    },
    mounted() {
        var vm = this
       
        var url = '/reports/items/data';
        
        this.table = $("#report-table").DataTable({
            ajax: {
                url: url,
                type: "GET",
                dataSrc: '',
                data: function(d) {
                    d.from = vm.shiner.from;
                    d.to = vm.shiner.to;
                    d.product = vm.shiner.product;
                },
            },
            columns: [
            {
                render: function(data, type, row, meta) {
                    return '';
                },
            },
            { data: 'product' },
            { data: '',
                render: function(data, type, row, meta) {
                    return moment(row.created_at).format('DD/MM/YYYY h:mm:ss a');
                }
            },
            { data: 'qty' },
            { data: 'status' },
            { data: 'invoice' },
            { data: 'customer' },
            ],
            columnDefs: [
                { "targets": ['nosearch'], "searchable": false },
                { "targets": 0, "sortable": false }
            ]
        });

        this.table.on( 'order.dt search.dt', ()=> {
            this.table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

    },
    data () {
        return {
            shiner: {
                from:'',
                to:'',
                product:'',
            },
            show:false,
            optionsShown:false,
            searchFilter: '',
            selected: {},
            loading: false,
            errors: {},
            table: ''
        }
    },
    computed: {
      filteredOptions() {
        const filtered = []; 
        const regOption = new RegExp(this.searchFilter, 'ig');
        for (const option of this.products) {
              if (this.searchFilter.length < 1 || option.name.match(regOption)){
                if (filtered.length < 6) filtered.push(option);
           }
        }
        return filtered;
      }
    },
    methods : {
        getformatteddate(date) {
                        return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
                    },
        get_data(){
            this.table.ajax.reload();
        },
        clear_filter(){
            this.shiner.from='';
            this.shiner.to='';
            this.shiner.product='';
            this.get_data();
        },
        set(){
             this.searchFilter =  this.shiner.product;
        },
        selectOption(option) {
            this.selected = option;
             this.show = false;
            //this.optionsShown = false;
            this.shiner.product = this.selected.name;
            this.$emit('selected', this.selected);
        },
        showOptions(){
            if (!this.disabled) {
              this.searchFilter = '';
              this.show = true;
            }
        },
        exit() { 
            
            if (!this.selected.id) {
              this.selected = {};
                
            }
            this.$emit('selected', this.selected);
            this.show = false;
        },
    },
}
</script>

