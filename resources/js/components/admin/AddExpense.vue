<template>
    <div>
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
                    <label>Payment Type</label>
                     <select class="form-control" required v-model="expense.payment_type">
                          <option value="">Select a payment type</option>
                          <option v-for="payment_type in payment_types" :value="payment_type.id">{{ payment_type.name }}</option>
                        </select>
                    <small class="text-danger " v-if="errors.payment_type">{{ errors.payment_type[0] }}</small>
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
                        <label>Expense Remarks</label>
                        <input type="text" class="form-control" placeholder="Expense Remarks" v-model="expense.name" required>
                        <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
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
</template>

<script>
import moment from 'moment';

export default {
    props: ['edit','expensecategories','payment_types'],
    created(){
        if(this.edit)
        {

            var vm = this;
            bus.$on('edit-expense',function(expense) {
        // console.log(this.vehiclemakes);

                vm.expense.id = expense.id;
                vm.expense.created_at = expense.created_at;
                vm.expense.expensecategory = expense.expensecategory;
                vm.expense.name = expense.name;
                vm.expense.payment_type = expense.payment_type;
                vm.expense.amount = expense.amount;
            });
        }
    },
    data () {
        return {
            expense: {

                id: '',
                created_at:'',
                expensecategory:'',
                name: '',
                amount: '',
                payment_type:'',

            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.expense.id = '';
            this.expense.created_at = '';
            this.expense.expensecategory='';
            this.expense.name = '';
            this.expense.amount = '';
            this.expense.payment_type='';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_expense',this.expense)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Expense updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Expense added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('expense-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Expense details", "", "error");
                    else
                        swal("Couldn't add Expense", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Expense details", "", "error");
                else
                    swal("Couldn't add Expense", "", "error");
                this.loading = false;
                if(error.response.data.errors)
                    this.errors  = error.response.data.errors;
                else
                    this.errors = '';
            });
        },
        
    },
    mounted() {
    },
    watch: {

     
            'expense.name' : function(){
                this.expense.name = this.expense.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>