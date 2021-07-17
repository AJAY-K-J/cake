<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Date</th>
                        <th>Vendor</th>
                        <th>Remark</th>
                        <th>Amount</th>
                        <th>PaymentType</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(purchase,index) in purchases">
                        <td>{{ index+1 }}</td>
                        <td>{{ convert_date(purchase.created_at) }}</td>
                        <td>{{ purchase.vendor.name }}</td>
                        <td>{{ purchase.remarks }}</td>
                        <td>{{ purchase.amount }}</td>
                      <td v-if="purchase.payment==0">Credit</td>
                      <td v-else>Payed</td>
                     
                        <td ><button class="btn btn-danger btn-sm m-0" @click="delete_purchase(purchase.id)">Delete</button></td>
                  
                    </tr>
                    <tr v-if="purchases.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Today Purchases'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expenseModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT PURCHASE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-purchase :vendors="vendors" products="products" :payment_types="payment_types" :edit="true"></add-purchase>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props:['vendors','products','payment_types'],
        created(){
            this.get_purchases();
            var vm =this;
            bus.$on('purchase-added', function(){
                vm.get_purchases();
            });
        },
        data () {
            return {
                purchases: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            convert_date(date) {
               return moment(date).format('DD-MM-YYYY  h:mm:ss a');
               },
            get_purchases() {
                this.loading = true;
                axios.get('get_purchases').
                then(response => {
                    this.purchases = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_purchase(purchase) {
                bus.$emit('edit-purchase',purchase);

            },

            delete_purchase(id) {
                swal({
                    title: "Delete purchase?",
                    text: "Are you sure you want to delete this Purchase Entry? This cannot be undone!",
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
                            swal("Purchase deleted", "", "success");
                            this.get_purchases();
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