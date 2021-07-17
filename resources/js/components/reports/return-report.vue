
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
                   <!--  <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                       <a :href="`/reports/deliveries/data?from=${shiner.from}&to=${shiner.to}&export=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
                   </div> -->
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="report-table" class="table custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Date</th>
                        <th>JC No</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th class="nosearch">Model</th>
                        <th class="nosearch">Serial No</th>
                        <th class="nosearch">Return Date</th>
                        <th class="nosearch">Delivery Date</th>
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
                        <h3 class="modal-title title my-0">Mark Delivered</h3>
                    </div>
                    <div class="modal-body">
                       <div class="row" style="font-size:100%">
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label>Enter Amount<span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" placeholder="amount" autocomplete="on"  required style="text-transform: uppercase;">
                                   
                               </div>
                           </div>
        
                       
                           <div class="col-md-12">
                               <div class="form-group">
                                 <td>
                                     <button class="btn btn-success btn-sm m-0" type="button" @click="mark_jobcarddelivered(id,amount)"> <i class="fa fa-check" aria-hidden="true" ></i></button>
                                 </td>
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
    mixins:[mixins],  props:['camp_select'],
    created(){

    },
    mounted() {
        var vm = this
        this.table = $("#report-table").DataTable({
            ajax: {
                url: "/reports/return_report/data",
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
            {data: '',
                render: function(data, type, row, meta) {
                    return moment(row.created_at, 'YYYY-MM-DD').format('DD/MM/YYYY');
                }
            },

            
           {data: '',
                           render: function(data, type, row, meta) {
                               return row.jobcard_prefix+row.jobcard_no;
                           }
                       },

            { data: 'name' },
            { data: 'mobile' },

            {data: '',
                            render: function(data, type, row, meta) {
                                return row.make+"-"+row.model;
                            }
                        },
          
            { data: 'serial_no' },
            {data: '',
                render: function(data, type, row, meta) {
                    return moment(row.return_date, 'YYYY-MM-DD').format('DD/MM/YYYY')+"<br />"+"Remarks: "+row.return_remarks;
                }
            },
        
           {
            data: '',
            render: function(data, type, row, meta) {
                if(row.reg_status==2)
                {
                    return moment(row.delivered_date, 'YYYY-MM-DD').format('DD/MM/YYYY');
                }
                else{
                   return `<a class='btn btn-primary btn-sm' style='background-color:red;' href='/return_delivered/${row.id}' target='_blank'>Delivered</a>`;
                }
              
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
            customer:{
                name:'',
                jobcards:[],
            },
            deliveries: [],
            loading: false,
            amount: '',
            errors: {},
            table: ''
        }
    },
    methods : {
        get_data(){
            this.table.ajax.reload();
        },
        getdate(date){
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },
        
        clear_filter(){
            this.shiner.from='';
            this.shiner.to='';
            
            this.get_data();
        },
        clear_data(){
            this.customer='';
        },
        show_modal(id) {
            axios.get('/find_jobcard/'+id)
                .then(response => this.customer = response.data)
                .catch(function (error) {
                    console.log(error);
                });
        },
          mark_jobcarddelivered(id,amount) {
            swal({
                title: "Mark Delivery?",
                text: "Are you sure you want to Deliver this Jobcard",
                icon: "warning",
                buttons: {
                    cancel: "No",
                    catch: {
                      text: "Yes",
                      value: "willDelete",
                      closeModal: false,
                  },
              },
              dangerMode: true,
          })
            .then((willDelete) => {
                if(willDelete)
                {
                    axios.post('/mark_jobcarddelivered',{
                        id: id  
                    })
                    .then(response => {
                        if (response.data.status == 1) 

                            swal("Jobcard Delivered Successfully", "", "success");
                        else
                            swal(response.data.response,"", "error");

                       
                    }).
                    catch(error => {
                        swal.stopLoading();
                        swal.close();
                        this.errors  = error.response.data.errors;
                        this.loading = false;
                    });
                }
            });
        }

    },
}
</script>

<style lang="css">
.imageshow {
    height: 200px;
    width:200px;
    display: inline-block;
    border: 1px solid #ccc;
    padding: 2px;
    margin-right: 15px;
    margin-bottom: 15px;
}

.imageshow img {
    height: 100%;
    width: 100%;
    object-fit: contain;
    object-position: center;
}
</style>