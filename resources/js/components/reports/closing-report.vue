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
                        <th>Opening</th>
                       <th>Collection</th>
                       <th>Expense</th>
                        <th>Closing Balance</th>
                         <th>View</th>      
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="jobcardModal" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">View Closing Details</h3>
                    </div>
                    <div class="modal-body">
                       <div class="row" style="font-size:100%">
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>DATE </label> <b>{{ closing_data.date }}</b>
                                  
                                  
                               </div>
                           </div>

                       </div> 
                           
                       <div class="row" style="font-size:100%">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="custom-table table table-hover" v-if="!loading">
                                     <thead>
                                         <tr>
                                            <th>Slno</th>
                                            <th>Date</th>
                                            <th>Opening</th>
                                            <th>Collection</th>
                                            <th>Expense</th>
                                            <th>Closing</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr>    
                                            <td>1</td>
                                            <td>date</td>
                                            <td><tr v-for="open in closing_data.opening_balance">{{ open.type }} : {{ open.amount }}</tr> 
                                            </td>
                                            <td><tr v-for="open in closing_data.collection">{{ open.type }} : {{ open.amount }}</tr> 
                                            </td>
                                            <td><tr v-for="open in closing_data.expense">{{ open.type }} : {{ open.amount }}</tr> 
                                            </td>
                                            <td>{{ closing_data.closing_balance }} 
                                            </td>
                                            
                            
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       </div>
                       
                           <div class="col-md-12">
                               <div class="form-group">
                                 
                                 <button class="btn btn-light float-right mr-2" ref="cancel_btn" data-dismiss="modal" @click="clear_data()" type="button">Close</button>
                                  
                                  
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import mixins from '../../mixins/jarvis';
import DataTable from 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
    mixins:[mixins],  props:['payment_types'],
    created(){

    },
    mounted() {
        var vm = this
        this.table = $("#report-table").DataTable({
            ajax: {
                url: "/reports/closing/data",
                type: "GET",
                dataSrc: '',
                data: function(d) {
                    var today=new Date();
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
                    return moment(row.date).format('DD/MM/YYYY');
                }
            },
            {
                data: '',
                render: function(data, type, row, meta) {
                    return row.total_opening == null ? 'Not Available' : row.total_opening;
                }
            },
            {
                data: '',
                render: function(data, type, row, meta) {
                    return row.total_collection == null ? 'Not Available' : row.total_collection;
                }
            },
            {
                data: '',
                render: function(data, type, row, meta) {
                    return row.total_expense == null ? 'Not Available' : row.total_expense;
                }
            },
            {
                data: '',
                render: function(data, type, row, meta) {
                    return row.closing_balance == null ? 'Not Available' : row.closing_balance;
                }
            },
            {
            data: '',
            render: function(data, type, row, meta) {
                return `<button class="btn btn-primary view-button" data-id="${row.id}"><i class="fa fa-eye" aria-hidden="true"></button>`;
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

        var vm = this;
        $(document).on('click','.view-button',function(){
            var id = $(this).data('id');
            vm.show_modal(id);
        })
    },
    data () {
        return {
            shiner: {
                from:'',
                to:'',
            },
            closing_data:[],
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
        clear_data(){
            this.closing_data='';
        },
        show_modal(id) {
            axios.get('/find_closing/'+id)
                .then(response =>{
                    this.closing_data = response.data;
      
                    $('#jobcardModal').modal('show');
                })
                .catch(function (error) {    
                });   
        },
    },
}
</script>

