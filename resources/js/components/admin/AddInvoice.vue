<template>
    <div>
        <div>
            <form v-on:submit.prevent="find_customer">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                         
                          <input type="search" onkeyup="this.value = this.value.toUpperCase()" class="form-control" placeholder="Search by Mobile No/ Name" autocomplete="on" v-model="invoice.number" >

                      </div>
                  </div>
              </div>

          </form>
      </div>
      <form v-on:submit.prevent="save" class="bookingForm">
        <div class="row">

           

            <div class="col-md-4">
                <div class="form-group">
                    <label>Customer Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Customer Name" autocomplete="on" v-model="invoice.name"  style="text-transform: uppercase;" required >
                    <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Mobile No<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="Customer Mobile No" v-model="invoice.mobile" required maxlength="10"  autocomplete="on" >
                    <small v-if="errors.mobile" class="text-danger">{{ errors.mobile[0] }}</small>
                </div>
            </div>
             <div class="col-md-4">
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" class="form-control" placeholder="Location" v-model="invoice.location"   >
                    <small v-if="errors.location" class="text-danger">{{ errors.location[0] }}</small>
                </div>
            </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label>Customer GST</label>
                    <input type="text" class="form-control" placeholder="Customer GST" autocomplete="on" v-model="invoice.gst_no"  style="text-transform: uppercase;" >
                    <small v-if="errors.gst_no" class="text-danger">{{ errors.gst_no[0] }}</small>
                </div>
            </div>
           
           <div class="col-md-12">
               <h4> <button @click="add_more" class="btn btn-info float-right" type="button">ADD ITEM</button></h4>
               <div class="table-responsive">
                   <table class="table table-bordered" style="background-color: #f5f8fa;">
                       <thead>
                           <tr>
                               <th style="width:10px">S/N</th>
                              
                               <th style="width:350px">Description of Products</th>
                               <th style="width:100px">Stock Qty</th>
                               <th style="width:100px">Qty</th>
                               <th style="width:100px">Rate</th>
                              
                               <th style="width:100px">GST %</th>
                              <th style="width:150px">Select Cess</th>
                              <!--  <th style="width:100px">Gross Amount</th>
                               <th style="width:100px">Taxable Amount</th> -->
                               <th style="width:100px">Net Amount</th>
                              
                               <th>X</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr v-for="(item, index) in invoice.items">
                               <td>{{ index+1 }}</td>
                                     
                               <td>
                                   <input class="form-control"
                                      autocomplete="off"
                                      name="name"
                                      @focus="showOptions(index)"

                                      @keyup="set(index)"
                                      @blur="exit(index)"
                                      v-model="invoice.items[index].product"
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
                                   <input type="number" v-model="invoice.items[index].stock_qty" min="0" required 
                                   class="form-control" placeholder="0.00" readonly>
                               </td>
                              <td>
                                   <input type="number" v-model="invoice.items[index].qty" min="0" required 
                                   class="form-control" placeholder="Qty" @change="amount_cal($event.target.value)">
                               </td>
                               <td>
                                   <input type="number" v-model="invoice.items[index].rate" min="0" required 
                                   class="form-control" placeholder="Rate" @change="amount_cal($event.target.value)">
                               </td>
                           
                                 
                                <td>
                                    <input type="number" v-model="invoice.items[index].gst_percentage" min="0" 
                                    class="form-control" placeholder="%" required>
                                </td>  

                                <td>

                                    <select class="form-control" v-model="invoice.items[index].tax_type"  @change="amount_cal($event.target.value)">
                                      <option disabled value="">Select</option>
                                                               <option value="1">CESS</option>
                                                               <option value="2">NO CESS</option>
                                                               
                                    </select>
                                </td>  
                                
                                <!-- <td>
                                  {{ invoice.items[index].gross_amount }}
                                </td>   
                                <td>
                                  {{ invoice.items[index].taxable_amount }}
                                </td>    -->  
                                <td>
                                  {{ invoice.items[index].net_item }}
                                </td> 
                                  
                               <td>
                                   <button @click="deleteRow(index)" class="btn btn-danger btn-sm" type="button" style="color: white"> X </button>
                               </td>
                           </tr>

                           <tr>
                               <td colspan="2">
                                   <b>Total Spare Amount:</b>
                               </td>
                               <td colspan="1">
                                   <b>{{invoice.total_spare}}</b>
                               </td>
                               
                           </tr>
                       </tbody>
                   </table>
               </div>
           </div>
          <div class="col-4">
               <div class="form-group">
                   <label>Discount</label>
                   <input type="number" v-model="invoice.discount"
                   class="form-control" placeholder="Discount" @change="amount_cal($event.target.value)"></td>
               </div>
           </div>
           <div class="col-4">
               <div class="form-group">
                   <label>Amount to Pay</label>
                   <b>{{ invoice.total_pay }}</b>
               </div>
           </div>
           
       
          <div class="col-md-6">
              <div class="form-group">
                  <label>Remarks</label>
                  <input type="text" class="form-control" placeholder="Enter any remarks" v-model="invoice.remarks" maxlength="1000">
                  <small v-if="errors.remarks" class="text-danger">{{ errors.remarks[0] }}</small>
              </div>
          </div>
          <div class="col-2">
               <div class="form-group">
                   <input type="checkbox"  v-model="invoice.credit">
                    <label for="checkbox">Credit</label>
               </div>
           </div>
           <div v-if="invoice.credit!=1" class="col-4">
               <div class="form-group">
                   <label>Payment Type</label>
                  <select class="form-control" required v-model="invoice.payment_type">
                      <option value="">Select a payment type</option>
                      <option v-for="payment_type in payment_types" :value="payment_type.id">{{ payment_type.name }}</option>
                    </select>
                   <small class="text-danger " v-if="errors.payment_type">{{ errors.payment_type[0] }}</small>
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
    props: ['edit','company_id','products','payment_types','create'],
    created() {
      if(this.edit)
      {
       
          var vm = this;
          bus.$on('edit-invoice',function(invoice) {
          vm.clear_data();
           vm.invoice.id = invoice.id;
            vm.invoice.invoice_no = invoice.invoice_no;
            vm.invoice.name = invoice.name;
            vm.invoice.mobile = invoice.mobile;
            vm.invoice.gst_no = invoice.gst_no;
            vm.invoice.location = invoice.location;
            vm.invoice.payment_type = invoice.payment_type;
            
             vm.invoice.credit = invoice.credit;
            vm.$nextTick( function() {
                           
                vm.amount_cal();
             })
                     
            vm.invoice.discount = invoice.total_discount;
            vm.invoice.total_pay = invoice.total_pay;
            vm.invoice.remarks = invoice.remarks;
            vm.invoice.reg_status = invoice.reg_status;
            vm.invoice.items = invoice.items ? _.cloneDeep(invoice.items) : [];
            vm.set_shows();
          });
      }
      
    },
    data () {
        return {
            invoice: {
               
                name: '',
                invoice_no: '',
                order_id:'',
                mobile: '',
                location: '',
                gst_no:'',
                remarks:'',
                total_pay:'',
                credit:'',
                payment_type:'',
                discount:'',
                total_labour:'',
                items : [],
                number: '',
                
            },
            shows:[],
            optionsShown:false,
            searchFilter: '',
            selected: {},
            index:'',
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
            this.invoice.number = '';
            this.invoice.name = '';
            this.invoice.mobile = '';
            this.invoice.location = '';
            this.invoice.gst_no = '';
            this.invoice.remarks = '';
                this.invoice.credit = '';
            this.invoice.invoice_no='';
            this.invoice.payment_type='';
            this.invoice.items=[];
            this.invoice.total_pay='';
            this.invoice.total_spare='';  
            this.invoice.discount='';
            this.shows=[];

        },
        set(index){
             this.searchFilter =  this.invoice.items[index].product;
        },
        selectOption(option) {
            this.selected = option;
             this.shows[this.index].show = false;
            //this.optionsShown = false;
            this.invoice.items[this.index].product = this.selected.name;
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
            for(i=0;i<this.invoice.items.length;i++){
               this.shows.push({
                    show: false,
                });

            }
        },
        find_customer() {
            var str =  this.invoice.number.replace(/[^A-Z0-9]/ig, "");
            var data = {};

                data.mobile_no = str;

            axios.post('/find_customer',data).
            then(response => {
                if(response.data) {
                   this.invoice.name = response.data.name;
                   this.invoice.mobile = response.data.mobile;
                   this.invoice.location = response.data.location;
                   this.invoice.gst_no = response.data.gst_no;
                 
               } else {

                this.invoice.mobile = data.mobile_no;

            }
        }).
            catch(error => {
            });
        },
        get_rate_by_product(index){

            var product = this.invoice.items[index].product;
            if(product==''){
                 this.invoice.items[index].product='';
            }
            else{
            axios.post('get_rate_by_product',{ product : product}).then(response => {
                if(response.data==''){
                this.invoice.items[index].rate = '';
                }
                else{
                
                this.invoice.items[index].rate = response.data.mrp;
                this.invoice.items[index].gst_percentage = response.data.gst;
                this.invoice.items[index].qty = 1;
                this.amount_cal();
                  if(response.data.stock){
                   this.invoice.items[index].stock_qty = response.data.stock.qty;
                  }
                }
                
                
            });
           }


        },
        save() {

            
              if(this.company_id)
            var url = '/add_invoice?company_id='+this.company_id;  
        else
            var url = '/add_invoice';

        this.loading = true;
        axios.post(url,this.invoice).
           
            then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        swal("invoice Order Updated", "", "success");
                    else
                        swal("invoice Order Added Successfully", "", "success");

                    // console.log($(".campaignForm").find('.cancel-btn'));
                    this.$refs.cancel_btn.click();
                    bus.$emit('invoice-added');
                    this.clear_data();
                }
                else if(response.data.product){
                   swal("Couldn't update Invoice ", response.data.product+" Only Available in Stock : "+response.data.qty, "error");
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Invoice", response.data, "error");
                    else
                        swal("Couldn't add Invoice", response.data, "error");
                }
            }).
            catch(error => {
                if(this.edit)
                    swal("Couldn't update Invoice", "", "error");
                else
                    swal("Couldn't add Invoice", "", "error");
                this.loading = false;
                if(error.response.data.errors)
                    this.errors  = error.response.data.errors;
                else
                    this.errors = '';
            });
        },
        add_more(){
            this.invoice.items.push({
                category: '',
                product:'',
                stock_qty:'',
                qty:'',
                rate:'',
                discount:'',
                gst_percentage:'',
                tax_type:'',
                net_item:'',
                gross_amount:'',
                taxable_amount:'',
                
            });
            this.shows.push({
                show: false,
                
            });
        },  

        deleteRow(index) {
        this.invoice.total_pay=parseInt(this.invoice.total_pay)-[parseInt(this.invoice.items[index].qty)*parseInt(this.invoice.items[index].rate)];
        this.invoice.items.splice(index,1);
        this.amount_cal();
    },
    amount_cal(id)
    {
        var total=0;
        var discount=0;
        var total_spare=0;
        var spare_cgst=0;
        var spare_sgst=0;
        var spare_igst=0;
        var spare_cess=0;
        var total_labour=0;
        var service_cgst=0;
        var service_sgst=0;
        var service_igst=0;
        var service_cess=0;
        var gross_amount=0;
        var taxable_amount=0;
        
       

        for(var i=0;i<this.invoice.items.length;i++)
        {
             
           this.invoice.items[i].net_item=0;
           this.invoice.items[i].gross_amount=0;
           this.invoice.items[i].taxable_amount=0;

            if(this.invoice.items[i].rate)
            {
                
                    this.invoice.items[i].net_item=this.invoice.items[i].net_item+parseInt(this.invoice.items[i].rate)* parseInt(this.invoice.items[i].qty);
               
                   
                    this.invoice.items[i].gross_amount = this.invoice.items[i].net_item;
                    

                if(this.invoice.items[i].category==1)
                {
                    total_spare=total_spare+this.invoice.items[i].net_item;



                }else{
                   
                    total_labour=total_labour+this.invoice.items[i].net_item;
                    
                }
                   

                  
            }
          
           if(1)
           {
                
                this.invoice.items[i].taxable_amount=Number((this.invoice.items[i].net_item*100/(parseInt(this.invoice.items[i].gst_percentage)+101)).toFixed(2));
                this.invoice.items[i].net_item=this.invoice.items[i].net_item;
             

               total= total+this.invoice.items[i].net_item;
                
           }
        }
        if(this.invoice.discount)
        {
            discount=parseInt(this.invoice.discount);
            total=total-discount;
        }

        this.invoice.total_pay=total;
         this.invoice.total_labour=total_labour;
        this.invoice.total_spare=total_spare;
        // this.invoice.gross_amount=gross_amount;
        // this.invoice.total_taxable=taxable_amount;
        this.invoice.discount=discount;
    },
        delete_booking() {
            swal({
                title: "Delete Booking?",
                text: "Are you sure you want to delete this Invoice? This cannot be undone!",
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