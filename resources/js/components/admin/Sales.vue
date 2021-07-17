<template>
    <div class="row">

      <div class="nav-tabs-navigation mb-4">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-pills nav-pills-primary" data-tabs="pills">
                   
                    <li>
                        <form v-on:submit.prevent="get_todaysales">  
                            <div class="input-group">
                                <input type="search" placeholder="Receipt/Mobile No: " v-model="search" class="form-control" style="width:120px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" style="background-color:#454334">Search</button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li>
                        <button class="btn btn-primary btn-sm" style="background-color:#ff4433" @click="search='';get_todaysales();">Reset</button>
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
                            <th>Sale details</th>
                            <th>Edit</th>
                            <th v-if="company_id">Delete</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(sale,index) in sales">
                            <td>{{ index+1 }}</td>
                            <td>{{ sale.customer_name }} <br> {{ sale.mobile }} <br> Receipt No: {{ sale.receipt_no }}</td>
                            <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#makeModal"  @click="edit_sale(sale)">Edit</button></td>
                          
                            <td v-if="company_id"><button class="btn btn-danger btn-sm m-0" @click="delete_sale(sale.id)">Delete</button></td>
                            <td v-if="company_id">
                                <a class="btn btn-success btn-sm m-0" :href="'/print_sale/'+sale.id+'?company_id='+company_id" target="_blank" style="background-color:  #008CBA;">
                                <i class="fa fa-print" aria-hidden="true"></i> </a>
                            <td v-else>
                                <a class="btn btn-success btn-sm m-0" :href="'/print_sale/'+sale.id" target="_blank" style="background-color: #008CBA;">
                                <i class="fa fa-print" aria-hidden="true"></i> </a>
                            </td>
                         
                        </tr>
                        <tr v-if="sales.length==0">
                            <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Sales'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="makeModal" data-backdrop="static">
            <div class="modal-dialog mt-5 modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT SALE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-sale :edit="true" :company_id="company_id" :products="products" :payment_types="payment_types"></add-sale>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import moment from 'moment';

export default {
    props:['company_id','products','payment_types'],
    created(){
        this.get_todaysales();
        var vm =this;
        bus.$on('sale-added', function(){
            vm.get_todaysales();
        });
    },
    data () {
        return {
            sales: {},
            loading : false,
            errors  : {},
             search: '',
        }
    },
    methods : {
        get_todaysales() {
             if(this.company_id)
             {
                 var url = '/get_todaysales?company_id='+this.company_id+'&search='+this.search;   

             }
             else
             {
                var url = '/get_todaysales?search='+this.search;
            }
            this.loading = true;
            axios.get(url).
            then(response => {
                this.sales = response.data;
                this.loading = false;
            }).
            catch(err => {
                this.loading = false;
            });
        },

        edit_sale(sale) {
            bus.$emit('edit-sale',sale);

        },

        delete_sale(id) {
            swal({
                title: "Delete Sale?",
                text: "Are you sure you want to delete this Sale? This cannot be undone!",
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
                        var url = '/delete_sale?company_id='+this.company_id;   

                    }
                    else
                    {
                        var url = '/delete_sale';
                    }
                    axios.post(url,{
                        id: id  
                    })
                    .then(response => {
                        if (response.data== 'Success') 
                        {
                         swal.stopLoading();
                         swal.close();
                         swal("Sale deleted", "", "success");

                     } 
                     else
                     {
                        swal.stopLoading();
                        swal.close();
                        swal("Remark Exists - please delete Remarks first to Delete Sale", "", "error");

                    }
                    this.get_todaysales();
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