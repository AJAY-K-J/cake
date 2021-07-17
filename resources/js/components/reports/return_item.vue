<template>

    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Expense Category </label>
                             <input type="number" placeholder="Invoice no" autocomplete="off"  required="required" v-model="shiner.invoice_no" class="form-control" :max="shiner.to">
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
                    

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="report-table" class="table custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Date</th>
                       <th>Invoice no</th>
                    
                                    
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
    mounted() {
        var vm = this
     
        var url = '/return_item/invoice_no';
        
        this.table = $("#report-table").DataTable({
            ajax: {
                url: url,
                type: "GET",
                dataSrc: '',
                data: function(d) {
                    d.from = vm.shiner.from;
                    d.to = vm.shiner.to;
                    d.invoice_no = vm.shiner.invoice_no;
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
            { data: 'invoice_no' },
           
            
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
                invoice_no:'',
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
            this.shiner.invoice_no='';
            this.get_data();
        },
        show_modal(id) {
            axios.get('/find_expense/'+id)
                .then(response => this.expense = response.data)
                .catch(function (error) {
                    console.log(error);
                });
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

