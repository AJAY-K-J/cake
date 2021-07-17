<template>

    <div>
     <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="searchForm" v-on:submit.prevent="filterData">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Search By</label>
                            <select class="form-control" v-model="search.type" required>
                                <option value="1">Customer Code</option>
                                <option value="3">Mobile</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ search_label }}</label>
                            <input type="text" v-model="search.value" class="form-control" :placeholder="search_label" required>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-2">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" :disabled="searching">
                                <span v-if="searching">Searching...</span>
                                <span v-else>Search</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>

                <th>Name of Customer</th>
                <th>Mobile Number</th>
                <th>Customer Code</th>
                <th>Location</th>
                <th>Credit Balance</th>
                <th>Edit</th>
                <th>View</th>
                <th>Pay Credit</th>
            </tr>                           
        </thead>

        <tbody>
            <tr v-if="customer">
                <td>
                    {{ customer.name }}
                </td>
                <td>
                    {{ customer.mobile }}
                </td>
                <td>
                    {{ customer.customer_code }}
                </td>
                <td>
                    {{ customer.location }}
                </td>
                <td>
                    {{ customer.credit }}
                </td>
                <td>
                    <button v-if="customer" class="btn btn-sm btn-primary my-0 btn-block" data-toggle="modal" data-target="#editModal" @click='show_modal(customer)'>Edit</button>
                </td>
                <td>
                    <button v-if="customer" class="btn btn-sm btn-success my-0 btn-block" data-toggle="modal" data-target="#viewModal" @click='get_history(customer)'>View</button>
                </td>
                <td>
                    <button v-if="customer" class="btn btn-sm btn-success my-0 btn-block" data-toggle="modal" data-target="#payModal" @click='show_modal(customer)'>Pay Credit</button>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal" data-backdrop="static" ref="editModal">
        <div class="modal-dialog mt-5" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">CUSTOMER DETAILS</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name of Customer</label>
                                    <input type="text" class="form-control" v-model="shiner.name" required>
                                    <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="tel" class="form-control" v-model="shiner.mobile" required>
                                    <small class="text-danger" v-if="errors.mobile">{{ errors.mobile[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" class="form-control" v-model="shiner.location" required>
                                    <small class="text-danger" v-if="errors.location">{{ errors.location[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Customer Code</label>
                                    <input type="number" class="form-control" v-model="shiner.customer_code" required :readonly="code">
                                    <small class="text-danger" v-if="errors.customer_code">{{ errors.customer_code[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="submit" :disabled="loading">Save</button>
                                    <button class="btn btn-light float-right mr-2" data-dismiss="modal" @click="clear_data()" ref="cancel_btn" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="payModal" data-backdrop="static" ref="payModal">
        <div class="modal-dialog mt-5" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">Enter Credit Amount To Pay</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Credit Left to Pay</label>
                                    <input type="number" class="form-control" v-model="shiner.credit" disabled >
                                    <small class="text-danger" v-if="errors.credit" >{{ errors.credit[0] }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Enter Amount to pay</label>
                                    <input type="text" class="form-control" v-model="shiner.pay" required>
                                    <small class="text-danger" v-if="errors.pay" >{{ errors.pay[0] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary float-right" type="button" @click="credit_payed()" :disabled="loading">Save</button>
                                    <button class="btn btn-light float-right mr-2" data-dismiss="modal" @click="clear_data()" ref="cancel_btn" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="viewModal" data-backdrop="static" ref="viewModal">
        <div class="modal-dialog mt-5 modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">History</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" placeholder="From Date" autocomplete="off"  required="required" v-model="filter.from" class="form-control" :max="filter.to">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" placeholder="To Date" autocomplete="off" required="required" v-model="filter.to" class="form-control" :min="filter.from">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center mb-3 mb-md-0">
                            <button @click="table.ajax.reload()" class="btn btn-block btn-success btn-sm m-0 mr-md-2">Filter</button>
                        </div>
                        <div class="col-md-3 d-flex align-items-center mb-3 mb-md-0">
                            <button @click="clear_filter"  class="btn btn-block btn-info btn-sm m-0">Clear Filters</button>
                        </div>

                    </div>
                   
                    <div class="table-responsive">
                        <table id="history-table" class="table custom-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date</th>
                                    <th>JC No</th>
                                    <th>Description</th>
                                    <th>credit</th>
                                    <th>debit</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>
<script>
import moment from 'moment';
import {bus} from '../../app.js';
import DataTable from 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
    props: [],
    created(){

    },
    data() {
        return {
            customer: '',
            code: '',
            history_table: '',
            search:{
                type: '1',
                value: ''
            },
            shiner: {
                id: '',
                name : '',
                mobile : '',
                customer_code : '',
                location : '',
                pay : '',
            },
            nomatch: false,
            search_label : 'Search Customer Code',
            loading : false,
            searching : false,
            errors  : {},
            filter: {
                from: '',
                to: '',
                customer_code: '',
                mobile: ''
            }
        }
    },

    methods: {
        filterData() {
            this.fetchData();
        },


        fetchData() {
            this.searching = true;
            this.nomatch = false;

            this.customer = '';
            axios.post('find_loyalcustomer',this.search)
            .then(response => {
             this.searching = false;
             this.customer = response.data;
         })
            .catch(error => {
             this.searching = false;
             this.nomatch = false;
             console.log(error.response);
         });
        },

        formatDate(date){
            return moment(date).format('DD-MM-YYYY h:mm a')
        },
        save() {
           
            this.loading = true;
            axios.post('/loyalcustomer',this.shiner).
            then(response => {
                this.loading = false;
                swal("Success", "", "success");
                this.clear_data();
                this.$refs.cancel_btn.click();
                this.fetchData();

            }).
            catch(error => {
                this.errors  = _.get(error, 'response.data.errors', {})
                this.loading = false;
            });
        },
        credit_payed() {
           
            this.loading = true;
            axios.post('/credit_payed',this.shiner).
            then(response => {
                this.loading = false;
                swal("Success", "", "success");
                this.clear_data();
                this.$refs.cancel_btn.click();
                this.fetchData();

            }).
            catch(error => {
                this.errors  = _.get(error, 'response.data.errors', {})
                this.loading = false;
            });
        },
        show_modal(customer) {
            this.shiner.id = customer.customer_code ? customer.id : '';
            this.shiner.name = customer.name;
            this.shiner.mobile = customer.mobile;
            this.shiner.customer_code = customer.customer_code;
            this.shiner.location = customer.location;
            this.shiner.credit=customer.credit;
            this.code = customer.customer_code;

      //  this.shiner.credit_amount = customer.credit_amount;
  },
  clear_data() {
    this.shiner.id = '';
    this.shiner.name = '';
    this.shiner.mobile = '';
    this.shiner.customer_code = '';
    this.shiner.location = '';
    this.shiner.pay = '';
    this.code = '';
    this.shiner.credit = '';

       // this.shiner.credit_amount = '';
   },
  
   get_history(customer) {
   
    this.filter.mobile = customer.mobile;
    this.filter.customer_code = customer.customer_code;
    this.clear_filter();
    this.table.ajax.reload();

},
clear_filter(){

    this.filter.from='';
    this.filter.to='';
    this.table.ajax.reload();
},

},

mounted() {
    var vm = this;

    this.table = $("#history-table").DataTable({
        ajax: {
            url: "/loyalcustomer/get_history",
            type: "GET",
            dataSrc: '',
            data: function(d) {
                d.from = vm.filter.from;
                d.to = vm.filter.to;
                d.customer_code = vm.filter.customer_code;
                d.mobile = vm.filter.mobile;
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
                 return moment(row.created_at).format('DD/MM/YYYY h:mm:ss a');
             }
        },
        { data: 'jobcard_no' },
       { data: '',
                    render: function(data, type, row, meta) {
                        if(row.type==4 && row.reg_status==2)
                        return "Credit Delivery";
                        else  if(row.type==5)
                            return "Amount Received against credit";
                        else if(row.type==2 && row.reg_status==2)
                            return "Amount Payed during Delivery";
                        else 
                            return "Delivery Pending";
                    }
               },

        { data: '',
                     render: function(data, type, row, meta) {
                         if(row.type==4)
                         return row.total_amount;
                        else
                        
                            return "NA";
                        
                     }
                },
                
        { data: '',
                           render: function(data, type, row, meta) {
                               if(row.type==5)
                               return row.total_amount;
                              else
                              
                                  return "NA";
                              
                           }
                      },
      
     
       
        ],
        columnDefs: [
        ]
    });

    this.table.on( 'order.dt search.dt', ()=> {
        this.table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
},
watch: {
    'search.type' : function()
    {
        console.log(this.search.type);
        switch(this.search.type)
        {
            case "1": this.search_label = 'Search Customer Code'; break;
            case "3": this.search_label = 'Search Mobile'; break;
            default: this.search_label = 'Search'; break;
        }
    },
    'shiner.name' : function(val){
       if(val) {
           this.shiner.name = val.toUpperCase();
       }
   },

},
}
</script>