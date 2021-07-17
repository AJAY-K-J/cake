<template>

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Expense Category </label>
                            <select class="form-control"  v-model="shiner.expensecategory_name">
                                <option selected  value=''>Select Expense Category</option>
                                <option  v-for="expensecategory in expensecategories" :value="expensecategory.name">{{ expensecategory.name }}</option>
                            </select> 
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
                        <a :href="`/reports/expenses/data?expensecategory_name=${shiner.expensecategory_name}&from=${shiner.from}&to=${shiner.to}&export=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
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
                       <th>Expense Category</th>
                                   <th>Expense Description</th>
                                   <th>Amount</th>
                                    <th>Delete</th>
                                    
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
   
     <div class="modal fade" tabindex="-1" role="dialog" id="expenseModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT EXPENSE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
                <div class="row">
                <div class="col-12 ">
                    <div class="form-group">
                        <label> Date (please select if any change)</label>
                      <input type="date" class="form-control" placeholder="Select Date" autocomplete="on" v-model="expense.created_at">
                      <small v-if="errors.created_at" class="text-danger">{{ errors.created_at[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Expense Category<span class="text-danger">*</span></label>
                        
                          <select class="form-control" v-model="expense.expensecategory" required >
                              <option value="">Select Expense Category</option>
                              <option v-for="expensecategory in expensecategories" :value="expensecategory.name">{{ expensecategory.name }}</option>
                          </select>
                         <small v-if="errors.expensecategory" class="text-danger">{{ errors.expensecategory[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Expense Remarks</label>
                        <input type="text" class="form-control" placeholder="Expense Remarks" v-model="expense.name" required>
                        <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Expense Amount</label>
                        <input type="number" class="form-control" placeholder="Expense Amount" v-model="expense.amount" required>
                        <small v-if="errors.amount" class="text-danger">{{ errors.amount[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Payment Type</label>
                   <select class="form-control" v-model="expense.payment_type" required>
                        <option disabled value="">Please select one</option>
                       <option>Cash</option>
                        <option>HDFC-Bank</option>
                         <option>AXIS-Bank</option>
                        <option>GooglePay</option>
                    </select>
                    <small class="text-danger " v-if="errors.payment_type">{{ errors.payment_type[0] }}</small>
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
 </div>
</template>

<script>
import moment from 'moment';
import mixins from '../../mixins/jarvis';
import DataTable from 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
    mixins:[mixins],  props:['expensecategories','company_id'],
  
    created(){

    },
    mounted() {
        var vm = this
         if(vm.company_id)
        {

            var url = '/reports/expenses/data?company_id='+this.company_id;  

        }
        else
        {
           var url = '/reports/expenses/data';
        }
        this.table = $("#report-table").DataTable({
            ajax: {
                url: url,
                type: "GET",
                dataSrc: '',
                data: function(d) {
                    d.from = vm.shiner.from;
                    d.to = vm.shiner.to;
                    d.expensecategory_name = vm.shiner.expensecategory_name;
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
            { data: 'expensecategory' },
            { data: 'name' },
            { data: 'amount' },
            { data: '',
                    render: function(data, type, row, meta) {
                        return `<button class='btn btn-danger btn-sm delete-report-btn' data-id='${row.id}'>Delete</button>`;
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

        $(document).on('click', '.delete-report-btn', function() {
            var id = $(this).attr('data-id');
            vm.delete_expense(id);
        })

        $(document).on('click','.edit-button',function(){
            var id = $(this).data('id');
            vm.show_modal(id);
        })
    },
    data () {
        return {
            shiner: {
                from:'',
                to:'',
                expensecategory_name:'',
            },
            expense:{

                id: '',
                created_at:'',
                expensecategory:'',
                name: '',
                amount: '',
                payment_type:'',

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
            this.shiner.expensecategory_name='';
            this.get_data();
        },
        show_modal(id) {
            axios.get('/find_expense/'+id)
                .then(response => this.expense = response.data)
                .catch(function (error) {
                    console.log(error);
                });
        },

        clear_data() {
            this.expense.id = '';
            this.expense.created_at = '';
            this.expense.expensecategory='';
            this.expense.name = '';
            this.expense.amount = '';
            this.expense.payment_type='';
            this.errors = '';
        },
       
        delete_expense(id) {

            swal({
                title: "Delete Expense?",
                text: "Are you sure you want to delete this Expense? This cannot be undone!",
                icon: "warning",
                buttons: {
                    cancel: "No",
                    catch: {
                      text: "Delete",
                      value: "willDelete",
                      closeModal: false,
                  },
              },
              dangerMode: true,
          })
            .then((willDelete) => {
                if(willDelete)
                {
                    axios.post('/delete_expense',{
                        id: id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        swal("Expense deleted", "", "success");
                        this.get_data();
                    }).
                    catch(error => {
                        swal.stopLoading();
                        swal.close();
                        this.errors  = error.response.data.errors;
                        this.loading = false;
                    });
                }
            });
        },
    },
}
</script>

