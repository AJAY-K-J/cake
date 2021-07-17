<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Date</th>
                        <th>Income Category</th>
                        <th>Remarks</th>
                        <th>Amount</th>
                        <th>Payment Type</th>
                     
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(income,index) in incomes">
                        <td>{{ index+1 }}</td>
                        <td>{{ convert_date(income.created_at) }}</td>
                        <td>{{ income.incomecategory }}</td>
                        <td>{{ income.name }}</td>
                        <td>{{ income.amount }}</td>
                        <td>{{ income.payment_type}}</td>
                      
                     
                        <td ><button class="btn btn-danger btn-sm m-0" @click="delete_income(income.id)">Delete</button></td>
                  
                    </tr>
                    <tr v-if="incomes.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Incomes'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
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
                        <add-income :payment_types="payment_types" :edit="true"></add-income>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props:['payment_types'],
        created(){
            this.get_incomes();
            var vm =this;
            bus.$on('income-added', function(){
                vm.get_incomes();
            });
        },
        data () {
            return {
                incomes: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            convert_date(date) {
               return moment(date).format('DD-MM-YYYY  h:mm:ss a');
               },
            get_incomes() {
                this.loading = true;
                axios.get('get_incomes').
                then(response => {
                    this.incomes = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_income(income) {
                bus.$emit('edit-income',income);

            },

            delete_income(id) {
                swal({
                    title: "Delete Income?",
                    text: "Are you sure you want to delete this Income? This cannot be undone!",
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
                        axios.post('/delete_income',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Income deleted", "", "success");
                            this.get_incomes();
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