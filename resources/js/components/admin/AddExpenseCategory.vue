<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'serviceForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Expense Category Name</label>
                        <input type="text" class="form-control" placeholder="Expense Category Name" v-model="expensecategory.name" required>
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
    props: ['edit'],
    created(){
        if(this.edit)
        {
            var vm = this;
            bus.$on('edit-expensecategory',function(expensecategory) {
                vm.clear_data();
                vm.expensecategory.id = expensecategory.id;
                vm.expensecategory.name = expensecategory.name;
            });
        }
    },
    data () {
        return {
            expensecategory: {
                id: '',
                name: '',
                
            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.expensecategory.id = '';
            this.expensecategory.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_expensecategory',this.expensecategory)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                    {
                        swal("Expense Category updated", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }
                    
                    else{
                        swal("Expense Category added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('expensecategory-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update expensecategory details", "", "error");
                    else
                        swal("Couldn't add expensecategory", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update expensecategory details", "", "error");
                else
                    swal("Couldn't add expensecategory", "", "error");
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

        'expensecategory.name' : function(){
            this.expensecategory.name = this.expensecategory.name.toUpperCase();

        },
    }
}
</script>

<style lang="css" scoped>

</style>