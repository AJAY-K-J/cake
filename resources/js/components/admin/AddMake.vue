<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'makeForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Brand Name</label>
                        <input type="text" class="form-control" placeholder="Brand Name" v-model="make.name" required>
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
            bus.$on('edit-make',function(make) {
                vm.clear_data();
                vm.make.id = make.id;
                vm.make.name = make.name;
            });
        }
    },
    data () {
        return {
            make: {
                id: '',
                name: '',
            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.make.id = '';
            this.make.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_make',this.make)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Brand updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Brand added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('make-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Brand details", "", "error");
                    else
                        swal("Couldn't add Brand", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Brand details", "", "error");
                else
                    swal("Couldn't add Brand", "", "error");
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

     
            'make.name' : function(){
                this.make.name = this.make.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>