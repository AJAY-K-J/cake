<template>

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <div class="row">
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
                        <a :href="`/reports/balance_sheet/data?from=${shiner.from}&to=${shiner.to}&export=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
                    </div>
                    <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                        <a :href="`/reports/balance_sheet/data?from=${shiner.from}&to=${shiner.to}&print=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Today Report</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="report-table" class="table custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Date</th>
                       <th>JC No/Description</th>
                                   <th>Credit</th>
                                   <th>Debit</th>
                                   <th>Payment Type</th>
                               
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
    mixins:[mixins],  props:[],
    created(){

    },
    data() {
        return {
            customer: '',
            code: '',
            history_table: '',
        }
    },
    mounted() {
        var vm = this
        this.table = $("#report-table").DataTable({
            ajax: {
                url: "/reports/balance_sheet/data",
                type: "GET",
                dataSrc: '',
                data: function(d) {
                    d.from = vm.shiner.from;
                    d.to = vm.shiner.to;
                },
            },
            columns: [
            {
                render: function(data, type, row, meta) {
                    return '';
                },
            },
            { data: '',
                render: function(data, type, row, meta) {
                    return moment(row.transaction_date).format('DD/MM/YYYY h:mm:ss a');
                }
            },
          
            { data: 'description' },
           { data: '',
                         render: function(data, type, row, meta) {
                             return row.credit?row.credit:'';
                         }
                     },
          { data: '',
                        render: function(data, type, row, meta) {
                            return row.debit?row.debit:'';
                        }
                    },
                    { data: '',
                                  render: function(data, type, row, meta) {
                                      return row.payment_type?row.payment_type:'';
                                  }
                              },

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
            },
            
            loading: false,
            errors: {},
            table: ''
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
            this.get_data();
        },
    },
}
</script>

