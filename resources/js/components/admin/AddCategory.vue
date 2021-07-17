<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'makeForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" placeholder="Category Name" v-model="category.name" required>
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
            bus.$on('edit-category',function(category) {
                vm.clear_data();
                vm.category.id = category.id;
                vm.category.name = category.name;
            });
        }
    },
    data () {
        return {
            category: {
                id: '',
                name: '',
            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.category.id = '';
            this.category.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_category',this.category)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Category updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Category added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('category-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Category details", "", "error");
                    else
                        swal("Couldn't add Category", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Category details", "", "error");
                else
                    swal("Couldn't add Category", "", "error");
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

     
            'category.name' : function(){
                this.category.name = this.category.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>