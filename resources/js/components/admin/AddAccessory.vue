<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'makeForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Accessory Name</label>
                        <input type="text" class="form-control" placeholder="Accessory Name" v-model="accessory.name" required>
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
            bus.$on('edit-accessory',function(accessory) {
                vm.clear_data();
                vm.accessory.id = accessory.id;
                vm.accessory.name = accessory.name;
            });
        }
    },
    data () {
        return {
            accessory: {
                id: '',
                name: '',
            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.accessory.id = '';
            this.accessory.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_accessory',this.accessory)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("accessory updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("accessory added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('accessory-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update accessory details", "", "error");
                    else
                        swal("Couldn't add accessory", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update accessory details", "", "error");
                else
                    swal("Couldn't add accessory", "", "error");
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

     
            'accessory.name' : function(){
                this.accessory.name = this.accessory.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>