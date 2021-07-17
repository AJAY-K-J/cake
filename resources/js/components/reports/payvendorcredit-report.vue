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
                        <a :href="`/reports/deliveries/data?from=${shiner.from}&to=${shiner.to}&export=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
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
                        <th>Vendor</th>
                        <th class="nosearch">Amount</th>
                        <th class="nosearch">Payment Type</th>
                        <th class="nosearch">Remarks</th>
                        <th class="nosearch">Operations</th>
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
    mixins:[mixins],  props:['camp_select'],
    created(){

    },
    mounted() {
        var vm = this
        this.table = $("#report-table").DataTable({
            ajax: {
                url: "/reports/payvendorcredits/data",
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
            {
                data: '',
                render: function(data, type, row, meta) {
                    return moment(row.created_at, 'YYYY-MM-DD').format('DD/MM/YYYY');
                }
            },
            { data: 'vendor.name' },
            { data: 'amount' },
            {data: 'payment_type'},
            {data: 'remarks'},
            { data: '',
                    render: function(data, type, row, meta) {
                        return `<button class='btn btn-danger btn-sm delete-report-btn' data-id='${row.id}'>Delete</button>`;
                    }
                }
           
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
            vm.delete_booking(id);
        })
    },
    data () {
        return {
            shiner: {
                from:'',
                to:'',
            },
            deliveries: [],
            loading: false,
            errors: {},
            table: ''
        }
    },
    methods : {
        get_data(){
            this.table.ajax.reload();
        },
        clear_filter(){
            this.shiner.from='';
            this.shiner.to='';
            this.get_data();
        },
        delete_booking(id) {

            swal({
                title: "Delete Credit Payment Against Purchase?",
                text: "Are you sure you want to delete this  Credit Payment Against Purchase? This cannot be undone!",
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
                    axios.post('/delete_purchase',{
                        id: id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        swal(" Credit Payment Against Purchase deleted", "", "success");
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

<style lang="css">

</style>