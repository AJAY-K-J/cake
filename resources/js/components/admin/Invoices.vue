<template>
    <div class="row">

      <div class="nav-tabs-navigation mb-4">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-pills nav-pills-primary" data-tabs="pills">
                   
                    <li>
                        <form v-on:submit.prevent="get_todayinvoices">  
                            <div class="input-group">
                                <input type="search" placeholder="Invoice No/Mobile No: " v-model="search" class="form-control" style="width:200px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" style="background-color:#454334">Search</button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li>
                        <button class="btn btn-primary btn-sm" style="background-color:#ff4433" @click="search='';get_todayinvoices();">Reset</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-12">
            <div class="table-responsive">
                <table class="custom-table table table-hover">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Invoice details</th>
                            <th>Edit</th>
                            <th>Receipt</th>
                            <th>Delete</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(invoice,index) in invoices">
                            <td>{{ index+1 }}</td>
                            <td>{{ invoice.name }} <br> {{ invoice.mobile }} <br> Invoice No: {{ invoice.invoice_no }}</td>
                            <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#makeModal"  @click="edit_invoice(invoice)"> <i class="fa fa-pencil" aria-hidden="true"> </i></button></td>
                            <td >
                                <a class="btn btn-success btn-sm m-0" :href="'/payments/'+invoice.id" target="_blank" style="background-color: #008CBA;">
                               <i class="fas fa-receipt"  aria-hidden="true" ></i></a>
                            </td>
                            <td><button class="btn btn-danger btn-sm m-0" @click="delete_invoice(invoice.id)">X</i></button></td>
                          
                            <td >
                                <a class="btn btn-success btn-sm m-0" :href="'/print_invoice/'+invoice.id" target="_blank" style="background-color: #008CBA;">
                                <i class="fa fa-print" aria-hidden="true"></i> </a>
                            </td>
                         
                        </tr>
                        <tr v-if="invoices.length==0">
                            <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Invoices'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="makeModal" data-backdrop="static">
            <div class="modal-dialog mt-5 modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT INVOICE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-invoice :edit="true" :company_id="company_id" :products="products" :rubbers="rubbers" :companies="companies" :payment_types="payment_types"></add-invoice>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import moment from 'moment';

export default {
    props:['company_id','products','payment_types','rubbers','companies'],
    created(){
        this.get_todayinvoices();
        var vm =this;
        bus.$on('invoice-added', function(){
            vm.get_todayinvoices();
        });
    },
    data () {
        return {
            invoices: {},
            loading : false,
            errors  : {},
             search: '',
        }
    },
    methods : {
        get_todayinvoices() {
             if(this.company_id)
             {
                 var url = '/get_todayinvoices?company_id='+this.company_id+'&search='+this.search;   

             }
             else
             {
                var url = '/get_todayinvoices?search='+this.search;
            }
            this.loading = true;
            axios.get(url).
            then(response => {
                this.invoices = response.data;
                this.loading = false;
            }).
            catch(err => {
                this.loading = false;
            });
        },

        edit_invoice(invoice) {
            bus.$emit('edit-invoice',invoice);

        },

        delete_invoice(id) {
            swal({
                title: "Delete invoice?",
                text: "Are you sure you want to delete this Invoice? This cannot be undone!",
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
                    if(this.company_id)
                    {
                        var url = '/delete_invoice?company_id='+this.company_id;   

                    }
                    else
                    {
                        var url = '/delete_invoice';
                    }
                    axios.post(url,{
                        id: id  
                    })
                    .then(response => {
                        if (response.data== 'Success') 
                        {
                         swal.stopLoading();
                         swal.close();
                         swal("Invoice deleted", "", "success");

                     } 
                     else
                     {
                        swal.stopLoading();
                        swal.close();
                        swal("Remark Exists - please delete Remarks first to Delete Invoice", "", "error");

                    }
                    this.get_todayinvoices();
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

<style lang="css" scoped>

</style>