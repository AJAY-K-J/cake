<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'serviceForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Income Category Name</label>
                        <input type="text" class="form-control" placeholder="Income Category Name" v-model="incomecategory.name" required>
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
            bus.$on('edit-incomecategory',function(incomecategory) {
                vm.clear_data();
                vm.incomecategory.id = incomecategory.id;
                vm.incomecategory.name = incomecategory.name;
            });
        }
    },
    data () {
        return {
            incomecategory: {
                id: '',
                name: '',
            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.incomecategory.id = '';
            this.incomecategory.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_incomecategory',this.incomecategory)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                    {
                        swal("Income Category updated", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }
                    
                    else{
                        swal("Income Category added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('incomecategory-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update incomecategory details", "", "error");
                    else
                        swal("Couldn't add incomecategory", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update incomecategory details", "", "error");
                else
                    swal("Couldn't add incomecategory", "", "error");
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

        'incomecategory.name' : function(){
            this.incomecategory.name = this.incomecategory.name.toUpperCase();

        },
    }
}
</script>

<style lang="css" scoped>

</style>