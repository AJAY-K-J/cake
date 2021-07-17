<template>
    <div>
      <form v-on:submit.prevent="save" class="bookingForm">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Product Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Product Name" autocomplete="on" v-model="product.name" required >
                    <small v-if="errors.name" 
                    class="text-danger">{{ errors.name[0] }}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Set MRP<span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" placeholder="Set MRP" v-model="product.mrp">
                    <small v-if="errors.mrp" class="text-danger">{{ errors.mrp[0] }}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>GST%<span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" placeholder="GST%" v-model="product.gst">
                    <small v-if="errors.gst" class="text-danger">{{ errors.gst[0] }}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                <button class="btn btn-primary float-right" type="submit" :disabled="loading">Save</button>
                <button class="btn btn-light float-right mr-2" ref="cancel_btn" data-dismiss="modal" @click="clear_data()" type="button">Close</button>
            </div>
        </div>
    </div>
</form>
</div>
</template>




<script>
import moment from 'moment';
import Autocomplete from 'vuejs-auto-complete'


export default {
   props: ['edit'],
    created(){
        
        if(this.edit)
        {
           var vm = this;
            bus.$on('edit-product',function(product) {
                vm.clear_data();
                vm.product.id = product.id;
                vm.product.name = product.name;
                vm.product.mrp = product.mrp;
                vm.product.gst = product.gst;
               
              
            });
        }
    },
    data () {
        return {
            product: {
                id:'',
                name: '',
                mrp:'',
                gst:'',
              
              
            

            },
            test: {},
            models:{},
            loading: false,
            errors: {},

        }
    },
    components: {
        Autocomplete,
    },
    methods : {
        clear_data() {
            this.product.id='';
            this.product.name = '';
            this.product.mrp = '';
            this.product.gst = '';
            
          

        },
        save() {

            this.loading = true;
            axios.post('/add_product',this.product).
            then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        swal("Product Updated", "", "success");
                    else
                        swal("Product Added Successfully", "", "success");

                  
                    this.$refs.cancel_btn.click();
                    bus.$emit('product-added');
                    this.clear_data();
                }
                else if(response.data=="NoSMS"){
                    swal("Low SMS Credit, Please Top Up SMS", "", "error");
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update product", response.data, "error");
                    else
                        swal("Couldn't add product", response.data, "error");
                }
            }).
            catch(error => {
                if(this.edit)
                    swal("Couldn't update product", "", "error");
                else
                    swal("Couldn't add product", "", "error");
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
    watch:{
        
    }
}
</script>

<style lang="css" scoped>
[disabled] {
    background-color: inherit;
    font-weight: bold;
}

.day-checkbox {
    margin: 10px 5px;
}

.day-checkbox,
.day-label,
.day-checkbox input {
    cursor: pointer;
}

.day-checkbox:hover input:not(:disabled) ~ .day-label {
    border-color: #9c27b0;
    color: #9c27b0;
    box-shadow: 1px 1px 8px -1px rgba(0, 0, 0, 0.4);
}

.day-checkbox:hover .day-label.all-days {
    border-color: #4caf50 !important;
    color: #4caf50 !important;
}

.day-label {
    border: 1px solid #ccc;
    /*width: 40px;*/
    padding: 0 10px;
    height: 30px;
    font-size: 12px;
    display: flex;
    justify-content: center;
    border-radius: 20px;
    text-align: center;
    flex-direction: column;
    transition: background 0.25s, border-color 0.25s, color 0.25s, box-shadow 0.25s;
}

.day-checkbox input{
    position: absolute;
    opacity: 0;
}

.day-checkbox input:checked + .day-label{
    background: #9c27b0 !important;
    border-color: #9c27b0 !important;
    color: white !important;
    box-shadow: 1px 1px 8px -1px rgba(0, 0, 0, 0.4);
}

.day-checkbox input:checked + .day-label.all-days{
    background: #4caf50 !important;
    border-color: #4caf50 !important;
    color: white !important;
}

.day-label.fade-label {
    /*background: #14963c69!important;*/
    border-style: dashed;
    border-color: #4caf50 !important;
    color: #4caf50 !important;
}
</style>