
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
                        <th>Booking Date</th>
                        <th>JC No/Receipt No</th>
                        <th>Name</th>
                        <th>Mobile</th>

                        <th>Model</th>
                        <th>Serial No</th>
                        <th class="nosearch">Total Amount</th>
                        <th >Payment</th>
                        <th class="nosearch">View</th>
                        <th class="nosearch">Print Bill</th>
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
                        <h3 class="modal-title title my-0">View JOBCARD</h3>
                    </div>
                    <div class="modal-body">
                       <div class="row" style="font-size:100%">
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Customer Name: </label> <b>{{ customer.name }}</b>
                                  
                                  
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Customer Mobile: </label> <b>{{ customer.mobile }}</b>
                                  
                                  
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Jobcard No: </label> <b>JC000{{ customer.jobcard_no }}</b>
                                  
                                  
                               </div>
                           </div>

                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Jobcard Advisor: </label> <b>{{ customer.advisor?customer.advisor.name:''}}</b>
                                  
                                  
                               </div>
                           </div>

                       </div> 
                       <div class="row" style="font-size:100%">
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Make: </label> <b>{{ customer.make }}</b>
                                  
                                  
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Model: </label> <b>{{ customer.make }}-{{ customer.model }}</b>
                                  
                                  
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>IMEI/Serial No: </label> <b>{{ customer.serial_no }}</b>
                                  
                                  
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label>Type: </label> <b>{{ customer.dealer }}</b>
                                  
                                  
                               </div>
                           </div>

                       </div> 
                       <div>
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label>Customer Voice: </label> <b>{{ customer.customer_voice }}</b>
                                  
                                  
                               </div>
                           </div>

                       </div>
                       <div>
                           <div class="col-md-12">
                               <div class="form-group">
                                   <label>Remarks: </label> <b>{{ customer.remarks }}</b>
                                  
                                  
                               </div>
                           </div>

                       </div>
                      
                       <div class="row" style="font-size:100%">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="custom-table table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">S/N</th>
                                            <th style="width: 55%;">Service</th>
                                           
                                            <th style="width: 10%;">Rate</th>
                                         
                                            <th style="width: 30%;">Technician</th>
                                    
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in customer.jobcards">
                                           <td>
                                               {{ index+1 }}
                                           </td>
                                           <td>
                                               {{ item.service?item.service.name:item.service_string}}
                                           </td>
                                         
                                           <td>
                                               {{ item.rate}}
                                           </td>
                                            
                                           <td>
                                               {{ item.technician?item.technician.name:''}}
                                           </td>
                                          
                                           </tr>

                                           <tr >
                                               <td colspan="2" align="right">
                                                   Total Rate: 
                                               </td>
                                               <td colspan="2">
                                                   <b>{{ customer.spare_amount }}</b>
                                               </td>
                                           </tr>
                                          
                                           <tr >
                                               <td colspan="2" align="right">
                                                   Discount: 
                                               </td>
                                               <td colspan="2">
                                                   <b>{{ customer.discount?customer.discount:0 }}</b>
                                               </td>
                                           </tr>
                                           <tr >
                                               <td colspan="2" align="right">
                                                   Total Amount: 
                                               </td>
                                               <td colspan="2">
                                                   <b>{{ customer.total_amount }}</b>
                                               </td>
                                           </tr>

                                           </tbody>
                                
                                   
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div  class="form-group">
                             <span v-for="(image, index) in customer.images" class="imageshow">
                                <img :src="'/storage/'+image.image_path">
                            </span>
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
    mixins:[mixins],  props:['camp_select','company_id'],
    created(){

    },
    mounted() {
        var vm = this
         if(vm.company_id)
        {

            var url = '/reports/deliveries/data?company_id='+this.company_id;  

        }
        else
        {
           var url = '/reports/deliveries/data';
        }
        this.table = $("#report-table").DataTable({
            ajax: {
                url: url,
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
                            if(row.sale_status==1)
                            {

                             return "RPT"+row.receipt_no;
                            }
                            else
                            {
                                return row.jobcard_prefix+row.jobcard_no;
                            }
                         }
                     },
            { data: 'name' },
            { data: 'mobile' },
            {data: '',
                           render: function(data, type, row, meta) {
                              if(row.recovery==1)
                              {

                               return row.item_type;
                              }
                              else
                              {
                                  return row.model;
                              }
                           }
                       },
           {data: '',
                                     render: function(data, type, row, meta) {
                                        if(row.recovery==1)
                                        {

                                         return row.item_size;
                                        }
                                        else
                                        {
                                            return row.serial_no;
                                        }
                                     }
                                 },
           
            {data: '',
                           render: function(data, type, row, meta) {
                              if(row.renter_status==1)
                              {

                               return "Re-enter Jobcard";
                              }
                              else
                              {
                                  return row.total_amount;
                              }
                           }
                       },
                       {data: '',
                                      render: function(data, type, row, meta) {
                                         if(row.renter_status==1)
                                         {

                                          return "NA";
                                         }
                                         else
                                         {
                                             return row.payment_type;
                                         }
                                      }
                                  },
            
           {
            data: '',
            render: function(data, type, row, meta) {
                if(row.sale_status==0)
                {

                return `<button class="btn btn-primary btn-sm view-button" data-toggle="modal" data-target="#jobcardModal" data-id="${row.id}"><i class="fa fa-eye" aria-hidden="true"></button>`;
            }
            else{
               return `<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#editSaleModal" data-id="${row.id}"><i class="fa fa-edit" aria-hidden="true"></button>`;
            }
            }
           },
           {
               data: '',
               render: function(data, type, row, meta) {
                if(row.sale_status==0)
                {

                   return `<a class='btn btn-primary btn-sm' style='background-color:red;' href='/print_bill/${row.id}' target='_blank'>Print Bill</a>`;
                }
                else{
                    return `<a class='btn btn-primary btn-sm' style='background-color:red;' href='/print_sale/${row.id}' target='_blank'>Sale Bill</a>`;
                }
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