<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Date</th>
                        <th>Expense Category</th>
                        <th>Remark</th>
                        <th>Amount</th>
                        <th>Payment Type</th>
                        
                     
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(expense,index) in expenses">
                        <td>{{ index+1 }}</td>
                        <td>{{ convert_date(expense.created_at) }}</td>
                        <td>{{ expense.expensecategory }}</td>
                        <td>{{ expense.name }}</td>
                        <td>{{ expense.amount }}</td>
                      <td>{{ expense.payment_type }}</td>
                     
                        <td ><button class="btn btn-danger btn-sm m-0" @click="delete_expense(expense.id)">Delete</button></td>
                  
                    </tr>
                    <tr v-if="expenses.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Expenses'}}</td>
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
                        <add-expense :payment_types="payment_types" :edit="true"></add-expense>
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
            this.get_expenses();
            var vm =this;
            bus.$on('expense-added', function(){
                vm.get_expenses();
            });
        },
        data () {
            return {
                expenses: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            convert_date(date) {
               return moment(date).format('DD-MM-YYYY  h:mm:ss a');
               },
            get_expenses() {
                this.loading = true;
                axios.get('get_expenses').
                then(response => {
                    this.expenses = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_expense(expense) {
                bus.$emit('edit-expense',expense);

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
                            this.get_expenses();
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