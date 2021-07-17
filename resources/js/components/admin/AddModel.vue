<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Brand<span class="text-danger">*</span></label>
                        
                          <select class="form-control" v-model="model.make_id" required >
                              <option value="">Select Brand</option>
                              <option v-for="make in vehiclemakes" :value="make.id">{{ make.name }}</option>
                          </select>
                         <small v-if="errors.make" class="text-danger">{{ errors.make[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Model Name</label>
                        <input type="text" class="form-control" placeholder="Model Name" v-model="model.name" required>
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
    props: ['edit','vehiclemakes'],
    created(){
        if(this.edit)
        {

            var vm = this;
            bus.$on('edit-model',function(model) {
        // console.log(this.vehiclemakes);

                vm.model.id = model.id;
                vm.model.make_id = model.make_id;
                vm.model.name = model.name;
            });
        }
    },
    data () {
        return {
            model: {

                id: '',
                make_id:'',
                name: '',

            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.model.id = '';
            this.model.make_id='';
            this.model.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_model',this.model)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Model updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Model added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('model-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update model details", "", "error");
                    else
                        swal("Couldn't add model", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update  model details", "", "error");
                else
                    swal("Couldn't add model", "", "error");
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

     
            'model.name' : function(){
                this.model.name = this.model.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>