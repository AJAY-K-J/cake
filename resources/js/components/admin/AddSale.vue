<template>
    <div>
        <!-- <form v-on:submit.prevent="find_customer">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                     
                      <input type="search" onkeyup="this.value = this.value.toUpperCase()" class="form-control" placeholder="Search by Mobile No/ Register No" autocomplete="on" v-model="booking.no" >

                  </div>
              </div>
          </div>
      </form> -->
      <form v-on:submit.prevent="save" class="bookingForm">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Customer Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Customer Name" autocomplete="on" v-model="sale.customer_name"  style="text-transform: uppercase;" required >
                    <small v-if="errors.customer_name" class="text-danger">{{ errors.customer_name[0] }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mobile No<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="Customer Mobile No" v-model="sale.mobile" required maxlength="10"  autocomplete="on" >
                    <small v-if="errors.mobile" class="text-danger">{{ errors.mobile[0] }}</small>
                </div>
            </div>
              
           
           <div class="col-md-12">
               <h4> <button @click="add_more" class="btn btn-info float-right" type="button">ADD ITEM</button></h4>
               <div class="table-responsive">
                   <table class="table table-bordered" style="background-color: #f5f8fa;">
                       <thead>
                           <tr>
                               <th style="width:10px">S/N</th>
                               <th style="width:500px">Description of Products</th>
                               <th style="width:100px">Qty</th>
                               <th style="width:100px">Rate</th>
                               <th>X</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr v-for="(item, index) in sale.items">
                               <td>{{ index+1 }}</td>
                               <td>
                                   <input class="form-control"
                                      autocomplete="off"
                                      name="name"
                                      @focus="showOptions(index)"

                                      @keyup="set(index)"
                                      @blur="exit(index)"
                                      v-model="sale.items[index].service_string"
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
                                   <input type="number" v-model="sale.items[index].qty" min="0" required 
                                   class="form-control" placeholder="Quantity"
                                   @change="amount_cal($event.target.value)">
                               </td>
                               <td>
                                   <input type="number" v-model="sale.items[index].rate" min="0" required 
                                   class="form-control" placeholder="Rate" @change="amount_cal($event.target.value)">
                               </td>   
                               <td>
                                   <button @click="deleteRow(index)" class="btn btn-danger btn-sm" type="button" style="color: white"> X </button>
                               </td>
                           </tr>
                           <tr>
                               <td colspan="2">
                                   <b>Total Amount:</b>
                               </td>
                               <td colspan="1">
                                   <b>{{sale.total_spare}}</b>
                               </td>
                               
                           </tr>
                       </tbody>
                   </table>
               </div>
           </div>
           <div class="col-4">
               <div class="form-group">
                   <label>Discount</label>
                   <input type="number" v-model="sale.discount"
                   class="form-control" placeholder="Discount" @change="amount_cal($event.target.value)"></td>
               </div>
           </div>
           <div class="col-2">
               <div class="form-group">
                   <label>Amount to Pay</label>
                   <b>{{ sale.total_pay }}</b>
               </div>
           </div>
           <div class="col-2">
               <div class="form-group">
                   <input type="checkbox" id="sale.credit" v-model="sale.credit">
                    <label for="checkbox">Credit</label>
               </div>
           </div>
           <div v-if="sale.credit!=1" class="col-4">
               <div class="form-group">
                   <label>Payment Type</label>
                  <select class="form-control" required v-model="sale.payment_type">
                      <option value="">Select a payment type</option>
                      <option v-for="payment_type in payment_types" :value="payment_type.id">{{ payment_type.name }}</option>
                    </select>
                   <small class="text-danger " v-if="errors.payment_type">{{ errors.payment_type[0] }}</small>
               </div>
           </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Remarks</label>
            <input type="text" class="form-control" placeholder="Enter any remarks" v-model="sale.remarks" maxlength="1000">
            <small v-if="errors.remarks" class="text-danger">{{ errors.remarks[0] }}</small>
        </div>
    </div>
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
    props: ['edit','company_id','products','payment_types'],
    created() {
      if(this.edit)
      {
        console.log("HELLO WORLD");
          var vm = this;
          bus.$on('edit-sale',function(sale) {
          vm.clear_data();
           vm.sale.id = sale.id;
            vm.sale.receipt_no = sale.receipt_no;
            vm.sale.customer_name = sale.customer_name;
            vm.sale.mobile = sale.mobile;
            vm.sale.payment_type = sale.payment_type;
            vm.$nextTick( function() {
                           
                vm.amount_cal();
             })
                     
            vm.sale.discount = sale.discount;
            vm.sale.total_pay = sale.total_pay;
            vm.sale.credit = sale.credit;
            vm.sale.remarks = sale.remarks;
            vm.sale.reg_status = sale.reg_status;
            vm.sale.items = sale.receipts ? _.cloneDeep(sale.receipts) : [];
            vm.set_shows();
          });
      }
    },
    data () {
        return {
            sale: {
                customer_name: '',
                receipt_no: '',
                mobile: '',
                remarks:'',
                total_pay:'',
                credit:'',
                payment_type:'',
                discount:'',
                items : [],

            },
            shows:[],
            optionsShown:false,
            searchFilter: '',
            loading: false,
            errors: {},

        }
    },
    components: {
        Autocomplete,
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
            this.sale.customer_name = '';
            this.sale.mobile = '';
           
            this.sale.remarks = '';
            this.sale.receipt_no='';
            this.sale.payment_type='';
            this.sale.items=[];
            this.sale.total_pay='';
            this.sale.total_spare='';  
            this.sale.discount='';
            this.shows=[];

        },
        set(index){
             this.searchFilter =  this.sale.items[index].service_string;
        },
        selectOption(option) {
            this.selected = option;
             this.shows[this.index].show = false;
            //this.optionsShown = false;
            this.sale.items[this.index].service_string = this.selected.name;
            this.get_rate_by_product(this.index);
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
              //this.purchase.items[index].product = '';
            }
            this.$emit('selected', this.selected);
            this.shows[index].show = false;
        },
        set_shows(){
            var i;
            for(i=0;i<this.sale.items.length;i++){
               this.shows.push({
                    show: false,
                });

            }
        },
        get_rate_by_product(index){

            var product = this.sale.items[index].service_string;
            if(product==''){
                 this.sale.items[index].service_string='';
            }
            else{
            axios.post('get_rate_by_product',{ product : product}).then(response => {
                if(response.data==''){
                this.sale.items[index].rate = '';
                }
                else{
                this.sale.items[index].rate = response.data.mrp;
                this.sale.items[index].qty = 1;
                this.amount_cal();
                }
                
                
            });
           }


        },
        save() {

            
              if(this.company_id)
            var url = '/add_sale?company_id='+this.company_id;  
        else
            var url = '/add_sale';

        this.loading = true;
        axios.post(url,this.sale).
           
            then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        swal("Sale Updated", "", "success");
                    else
                        swal("Sale Added Successfully", "", "success");

                    // console.log($(".campaignForm").find('.cancel-btn'));
                    this.$refs.cancel_btn.click();
                    bus.$emit('sale-added');
                    this.clear_data();
                }
                else if(response.data=="NoSMS"){
                    swal("Low SMS Credit, Please Top Up SMS", "", "error");
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update sale", response.data, "error");
                    else
                        swal("Couldn't add sale", response.data, "error");
                }
            }).
            catch(error => {
                if(this.edit)
                    swal("Couldn't update sale", "", "error");
                else
                    swal("Couldn't add sale", "", "error");
                this.loading = false;
                if(error.response.data.errors)
                    this.errors  = error.response.data.errors;
                else
                    this.errors = '';
            });
        },
        add_more(){
            this.sale.items.push({
             
                service_string:'',
                qty:'',
                rate:'',
                
            });
            this.shows.push({
                show: false,
                
            });
        },  

        deleteRow(index) {
        this.sale.total_pay=parseInt(this.sale.total_pay)-[parseInt(this.sale.items[index].qty)*parseInt(this.sale.items[index].rate)];
        this.sale.items.splice(index,1);
        this.amount_cal();
    },
    amount_cal(id)
    {
        var total=0;
        var discount=0;
        var total_spare=0;
       

        for(var i=0;i<this.sale.items.length;i++)
        {

            total_spare=total_spare + parseInt(this.sale.items[i].qty)*parseInt(this.sale.items[i].rate);
            total=total+ parseInt(this.sale.items[i].qty)*parseInt(this.sale.items[i].rate);
        }
        if(this.sale.discount)
        {
            discount=parseInt(this.sale.discount);
            total=total-discount;
        }

        this.sale.total_pay=total;
        this.sale.total_spare=total_spare;
        this.sale.discount=discount;
    },
        delete_booking() {
            swal({
                title: "Delete Booking?",
                text: "Are you sure you want to delete this booking? This cannot be undone!",
                icon: "warning",
                buttons: {
                    cancel: "No",
                    catch: {
                      text: "Delete",
                      value: "willDelete",
                      closeModal: false,
                  },
              },
              dangerMode: true,
          })
            .then((willDelete) => {
                if(willDelete)
                {
                    axios.post('/delete_booking',{
                        booking_id: this.booking.id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        
                        if(response.data == 'Success')
                        {
                            swal("booking deleted", "", "success");
                            bus.$emit('booking-updated');
                            this.$refs.cancel_btn.click();
                        }
                        else
                        {
                            swal("Not deleted", response.data, "error");
                        }

                        
                    }).
                    catch(error => {
                        swal.stopLoading();
                        swal.close();
                        this.errors  = error.response.data.errors;
                        this.loading = false;
                    });
                }
            });
        },


    },
     
  mounted() {
     
    

      },
    watch:{
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