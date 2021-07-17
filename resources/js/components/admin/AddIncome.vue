<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
            <div class="row">
            <div class="col-12 ">
                <div class="form-group">
                    <label> Date (please select if any change)</label>
                  <input type="date" class="form-control" placeholder="Select Date" autocomplete="on" v-model="income.created_at">   
                  <small v-if="errors.created_at" class="text-danger">{{ errors.created_at[0] }}</small>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Income Category<span class="text-danger">*</span></label>
                        
                          <select class="form-control" v-model="income.incomecategory" required >
                              <option value="">Select Income Category</option>
                              <option v-for="incomecategory in incomecategories" :value="incomecategory.name">{{ incomecategory.name }}</option>
                          </select>
                         <small v-if="errors.incomecategory" class="text-danger">{{ errors.incomecategory[0] }}</small>
                    </div>
                </div>
            </div>
            
           
                <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Payment Type</label>
                       <select class="form-control" required v-model="income.payment_type">
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
                        <label>Income Amount</label>
                        <input type="number" class="form-control" placeholder="Income Amount" v-model="income.amount" required>
                        <small v-if="errors.amount" class="text-danger">{{ errors.amount[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Income Remarks</label>
                        <input type="text" class="form-control" placeholder="Income Remarks" v-model="income.name" required>
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
    props: ['edit','incomecategories','payment_types'],
    created(){
        if(this.edit)
        {

            var vm = this;
            bus.$on('edit-income',function(income) {
        // console.log(this.vehiclemakes);

                vm.income.id = income.id;
                vm.income.created_at = income.created_at;
                vm.income.incomecategory = income.incomecategory;
                vm.income.name = income.name;
                vm.income.payment_type = income.payment_type;
                vm.income.amount = income.amount;
            });
        }
    },
    data () {
        return {
            income: {

                id: '',
                created_at:'',
                incomecategory:'',
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
            this.income.id = '';
            this.income.created_at='';
            this.income.incomecategory='';
            this.income.name = '';
            this.income.amount = '';
            this.income.payment_type='';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_income',this.income)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Income updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Income added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('income-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Income details", "", "error");
                    else
                        swal("Couldn't add Income", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Income details", "", "error");
                else
                    swal("Couldn't add Income", "", "error");
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

     
            'income.name' : function(){
                this.income.name = this.income.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>