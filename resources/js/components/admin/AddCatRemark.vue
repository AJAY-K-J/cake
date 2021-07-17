<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Category<span class="text-danger">*</span></label>
                        
                          <select class="form-control" v-model="catremark.category_id" required >
                              <option value="">Select Category</option>
                              <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                          </select>
                         <small v-if="errors.category" class="text-danger">{{ errors.category[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Remark</label>
                        <input type="text" class="form-control" placeholder="Enter Remark" v-model="catremark.name" required>
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
    props: ['edit','categories'],
    created(){
        if(this.edit)
        {

            var vm = this;
            bus.$on('edit-catremark',function(catremark) {
        // console.log(this.vehiclemakes);

                vm.catremark.id = catremark.id;

                vm.catremark.category_id = catremark.category_id;
                vm.catremark.name = catremark.name;
            });
        }
    },
    data () {
        return {
            catremark: {

                id: '',
                company_id:'',
                category_id:'',
                name: '',

            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.catremark.id = '';
            this.catremark.category_id='';
            this.catremark.name = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_catremark',this.catremark)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Remark updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Remark added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('catremark-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Remark details", "", "error");
                    else
                        swal("Couldn't add  Remark", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update  Remark details", "", "error");
                else
                    swal("Couldn't add Remark", "", "error");
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

     
            'catremark.name' : function(){
                this.catremark.name = this.catremark.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>