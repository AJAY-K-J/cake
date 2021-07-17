<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
                <div class="row">
                <div class="col-12 ">
                    <div class="form-group">
                        <label> Date (please select if any change)</label>
                      <input type="date" class="form-control" placeholder="Select Date" autocomplete="on" v-model="purchase.created_at">
                      <small v-if="errors.created_at" class="text-danger">{{ errors.created_at[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Vendors<span class="text-danger">*</span></label>
                        
                          <select class="form-control" v-model="purchase.vendor_id" required >
                              <option value="">Select Vendor</option>
                              <option v-for="vendor in vendors" :value="vendor.id">{{ vendor.name }}</option>
                          </select>
                         <small v-if="errors.vendor_id" class="text-danger">{{ errors.vendor_id[0] }}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                       <label> Select PayOption</label>
                          <select class="form-control" style="width: 100%;" id="pay-select" v-model="purchase.pay_type">          
                          <option value=0 required>Credit</option>
                          <option value=1 required>Pay</option> 
                          </select>
                         <small v-if="errors.pay_type" class="text-danger">{{ errors.pay_type[0] }}</small>
                    </div>
                </div>
            </div>
              <div class="col-md-12">
                    <h4> <button @click="add_more" class="btn btn-info float-right" type="button">ADD ITEM</button></h4>
                    <table class="table table-bordered" style="background-color: #f5f8fa;">
                        <thead>
                            <tr>
                                <th style="width:10px">S/N</th>
                                <th style="width:350px">Product</th>
                                <th>Quantity</th>
                                <th style="width:100px">Rate</th>
                                <th style="width:100px">GST%</th>
                                <th>X</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in purchase.items">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <input class="form-control"
                                      autocomplete="off"
                                      name="name"
                                      @focus="showOptions(index)"

                                      @keyup="set(index)"
                                      @blur="exit(index)"
                                      v-model="purchase.items[index].product"
                                      placeholder="placeholder" />

                                    <!-- Dropdown Menu -->
                                    <div class="dropdown-content"
                                      v-show="shows[index].show">
                                      <div 
                                        class="dropdown-item"
                                        @mousedown="selectOption(option);"
                                        v-for="(option, index) in filteredOptions"
                                        :key="index" >
                                          {{ option.name  }}
                                      </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="decimal" v-model="purchase.items[index].qty" 
                                    class="form-control" placeholder="Qty" @change="amount_cal($event.target.value)">
                                </td>
                                <td>
                                    <input type="decimal" v-model="purchase.items[index].rate" min="0" 
                                    class="form-control"  placeholder="Rate" @change="amount_cal($event.target.value)">
                                </td>
                                 <td>
                                    <input type="decimal" v-model="purchase.items[index].gst" min="0" 
                                    class="form-control"  placeholder="GST%" @change="amount_cal($event.target.value)">
                                </td>
                                <td>
                                    <button @click="deleteRow(index)" class="btn btn-danger btn-sm" type="button" style="color: white"> X </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <b>Total Amount:</b>
                                </td>
                                <td colspan="2">
                                    <b>{{purchase.amount}}</b>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label> Amount</label>
                        <input type="decimal" class="form-control" placeholder="Purchase Amount" v-model="purchase.amount" required>
                        <small v-if="errors.amount" class="text-danger">{{ errors.amount[0] }}</small>
                    </div>
                </div>
            </div>
            <div v-if="purchase.pay_type==1" class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>Payment Type</label>
                        <select class="form-control" required v-model="purchase.payment_type">
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
                        <label>Remarks</label>
                        <input type="text" class="form-control" placeholder="Enter Remarks" v-model="purchase.remarks" required>
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
    props: ['edit','vendors','products','payment_types'],
    created(){
        if(this.edit)
        {

            var vm = this;
            bus.$on('edit-purchase',function(purchase) {
        

                vm.purchase.id = purchase.id;
                vm.purchase.created_at = purchase.created_at;
                vm.purchase.vendor_id = purchase.vendor_id;
                vm.purchase.remarks = purchase.remarks;
                vm.purchase.amount = purchase.amount;
            });
        }
    },
    data () {
        return {
            purchase: {

                id: '',
                created_at:'',
                vendor_id:'',
                pay_type:0,
                remarks: '',
                payment_type: '',
                amount: '',
                items : [],
             

            },
            shows:[],
            optionsShown:false,
            searchFilter: '',
            loading: false,
            errors: {},
        }
    },
    computed: {
      filteredOptions() {
        const filtered = []; 
        const regOption = new RegExp(this.searchFilter, 'ig');
        for (const option of this.products) {
              if (this.searchFilter.length < 1 || option.name.match(regOption)){
                if (filtered.length < 6) filtered.push(option);
           }
        }
        return filtered;
      }
    },
    methods : {
        clear_data() {
            this.purchase.id = '';
            this.purchase.created_at = '';
            this.purchase.vendor_id='';
            this.purchase.remarks = '';
            this.purchase.amount = '';
            this.purchase.payment_type = '';
            this.purchase.items = [];
            this.errors = '';
        },
        add_more(){
            this.purchase.items.push({
                product: '',
                qty: '',
                rate:'',
                gst:'',
            });
            this.shows.push({
                show: false,
                
            });
        },
        set_shows(){
            var i;
            for(i=0;i<this.purchase.items.length;i++){
               this.shows.push({
                    show: false,
                });

            }
        },
        set(index){
             this.searchFilter =  this.purchase.items[index].product;
        },
        selectOption(option) {
            this.selected = option;
             this.shows[this.index].show = false;
            //this.optionsShown = false;
            this.purchase.items[this.index].product = this.selected.name;
            this.$emit('selected', this.selected);
        },
        showOptions(index){
            if (!this.disabled) {
              this.searchFilter = '';
              this.index = index;
              this.shows[index].show = true;
            }
        },
        exit(index) { 
            
            if (!this.selected.id) {
              this.selected = {};
              //this.purchase.items[index].partno = '';
            }
            this.$emit('selected', this.selected);
            this.shows[index].show = false;
        },
         deleteRow(index) {
            this.purchase.amount=parseFloat(this.purchase.amount)-(parseFloat(this.purchase.items[index].qty)*parseFloat(this.purchase.items[index].rate));
            this.purchase.items.splice(index,1);
            this.amount_cal();

        },
        amount_cal(id){
            var total=0;
            var total_spare=0;

            for(var i=0;i<this.purchase.items.length;i++)
            {

                if(this.purchase.items[i].qty)
                { 
                   if(this.purchase.items[i].rate){
                     total=total + parseFloat(this.purchase.items[i].rate)*parseFloat(this.purchase.items[i].qty);
                   }
                }

         }

            this.purchase.amount=total;
        
        },
        save() {
            this.loading = true;
            axios.post('/add_purchase',this.purchase)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Purchase updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Purchase added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('purchase-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Purchase Entry details", "", "error");
                    else
                        swal("Couldn't add Purchase Entry", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Purchase Entry details", "", "error");
                else
                    swal("Couldn't add Purchase Entry", "", "error");
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

     
            'purchase.remarks' : function(){
                this.purchase.remarks = this.purchase.remarks.toUpperCase();
               
            },
            searchFilter() {
                if (this.products.length === 0) {
                  this.selected = {};
                } 
                this.$emit('filter', this.searchFilter);
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