<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Invoice No
                        <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Invoice No" @change="check_sale()" v-model="stock.invoice_no" required>
                         <small v-if="errors.invoice_no" class="text-danger">{{ errors.invoice_no[0] }}</small>
                    </div>
                </div>
              
            </div>
             <div class="row">
              <div class="col-md-12">
                 <label>Product<span class="text-danger">*</span></label>
                 <select class="form-control" v-model="stock.product" required >
                  <option value="">Select Product</option>
                  <option v-for="product in products" :value="product.product_id">{{ product.product }} - Qty - {{ product.qty }}</option>
                </select>
                <small v-if="errors.product" class="text-danger">{{ errors.product[0] }}</small>
                 
             </div>
            </div>  
              
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Return Qty</label>
                        <input type="number" class="form-control" placeholder="Return Qty" v-model="stock.qty" required>
                        <small v-if="errors.qty" class="text-danger">{{ errors.qty[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" placeholder="Enter Remarks" v-model="stock.remarks" required>
                        <small v-if="errors.remarks" class="text-danger">{{ errors.name[0] }}</small>
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
    props: ['edit','vendors'],
    created(){
        if(this.edit)
        {

            
        }
    },
    data () {
        return {
            stock: {

                purchase_id:'',
                vendor_id:'',
                product:'',
                qty:'',
                remarks: '',

            },
            products:{},
            loading: false,
            errors: {},
        }
    },
    computed: {
      
    },
    methods : {
        clear_data() {
            this.stock.purchase_id='';
            this.stock.vendor_id='';
            this.stock.remarks = '';
            this.stock.qty = '';
            this.stock.product = '';
            this.errors = '';
        },
        check_sale(){
           if(this.stock.invoice_no!=''){
            axios.post('/check_sale',{ 
                    id: this.stock.invoice_no,  
                })
                .then(response => {
                  console.log(response.data);
                if(response.data){
                   
                    this.products = response.data.items;

                }
                else{
                   swal("Couldn't find Purchase details", "", "error");
                }  

                          
                
            });
          }
          
      },
        save() {
            this.loading = true;
            axios.post('/return_sale',this.stock)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    
                        swal("Sale returned successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    

                    bus.$emit('stock-added');
                    
                }
                else if(response.data=="not stock"){
                    swal("Not in stock", "", "error");
                }
                else if(response.data=="not product"){
                    swal("Invalid Product Name", "", "error");
                }
                else
                {
                        swal("Couldn't add stock", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update stock details", "", "error");
                else
                    swal("Couldn't add stock", "", "error");
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

     
            'stock.remarks' : function(){
                this.stock.remarks = this.stock.remarks.toUpperCase();
               
            },
            
    }
}
</script>

<style lang="css" scoped>
.dropdown-content {
      position: absolute;
      background-color: #fff;
      min-width: 248px;
      max-width: 248px;
      max-height: 248px;
      border: 1px solid #e7ecf5;
      box-shadow: 0px -8px 34px 0px rgba(0,0,0,0.05);
      overflow: auto;
      z-index: 1;
      .dropdown-item {
        color: black;
        font-size: .7em;
        line-height: 1em;
        padding: 8px;
        text-decoration: none;
        display: block;
        cursor: pointer;
        &:hover {
          background-color: #e7ecf5;
        }
  }
}
</style>