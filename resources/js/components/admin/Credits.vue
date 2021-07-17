<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                      
                        <th>Name</th>
                        <th>Mobile No</th>
                        <th>Credit Amount</th>
                        <th>Pay Credit</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(model,index) in models">
                        
    
                       
                        <td v-if="model.credit>0">{{ model.name}}</td>
                        <td v-if="model.credit>0">{{ model.mobile}}</td>
                       <td v-if="model.credit>0">{{ model.credit}}</td>
                       <td v-if="model.credit>0">
                           <button class="btn btn-sm btn-success my-0 btn-block" data-toggle="modal" data-target="#payModal" @click='show_modal(model.mobile,model.name)'>Pay Credit</button>
                       </td>
                     
                    </tr>
                    <tr v-if="models.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Services'}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="modal fade" tabindex="-1" role="dialog" id="payModal" data-backdrop="static" ref="payModal">
                <div class="modal-dialog mt-5" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title title my-0">Enter Credit Amount To Pay</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                    <div class="row">
                                    <div class="col-12 ">
                                        <div class="form-group">
                                            <label> Date (please select if any change)</label>
                                          <input type="date" class="form-control" placeholder="Select Date" autocomplete="on" v-model="shiner.created_at">
                                          <small v-if="errors.created_at" class="text-danger">{{ errors.created_at[0] }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-12 ">
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                       <select class="form-control" v-model="shiner.payment_type" required>
                                            <option disabled value="">Please select one</option>
                                          <option>Cash</option>
                                         <option>HDFC-Bank</option>
                                         <option>AXIS-Bank</option>
                                         <option>GooglePay</option>
                                        </select>
                                        <small class="text-danger " v-if="errors.payment_type">
                                        {{ errors.payment_type[0] }}</small>
                                    </div>
                                  </div>
                                </div>  
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Enter Amount to pay</label>
                                            <input type="text" class="form-control" v-model="shiner.pay" required>
                                            <small class="text-danger" v-if="errors.pay" >{{ errors.pay[0] }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Enter Remarks</label>
                                            <input type="text" class="form-control" v-model="shiner.remarks" required>
                                            <small class="text-danger" v-if="errors.remarks" >{{ errors.pay[0] }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button  class="btn btn-primary float-right" type="submit" :disabled="loading" @click="credit_payed()">Save</button>
                                            <button class="btn btn-light float-right mr-2" data-dismiss="modal" 
                                            @click="clear_data()" ref="cancel_btn" type="button">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
       <div class="modal fade" tabindex="-1" role="dialog" id="viewModal" data-backdrop="static" ref="viewModal">
           <div class="modal-dialog mt-5 modal-lg" role="document">
              

               <div class="modal-content">
                   <div class="modal-header">
                       <h3 class="modal-title title my-0">History</h3>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   
                   <div class="modal-body">
                       <div class="table-responsive">
                           <table id="history-table" class="table custom-table" style="width:100%">
                               <thead>
                                   <tr>
                                       <th>Sl No</th>
                                       <th>Date</th>
                                       <th>JC No</th>
                                       <th>Description</th>
                                       <th>credit</th>
                                       <th>debit</th>
                                   </tr>
                               </thead>
                               <tbody>

                               </tbody>
                           </table>
                       </div>
                   </div>
                    </div>
               </div>
           </div>

    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props:[],
        name: "models",
        created(){
            this.get_credits();
            
        },
        data () {
            return {
                models: {},
                customers:{},
                shiner: {
                  created_at:'',
                    name : '',
                    mobile : '',
                    pay : '',
                    payment_type:'',
                    remarks:'',
                    type:'jobcard',
                },
               
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_credits() { 
                this.loading = true;
                axios.get('get_credits').
                then(response => {
                    this.models = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },
                  show_modal(mobile_no,name) {
                    
                     this.shiner.name =name;    
                      this.shiner.mobile = mobile_no;
                     
                   
                     
            },
               get_history(mobile_no) {
                
                swal(mobile_no, "", "success");
                this.loading = true;
                axios.get('/loyalcustomer/get_history', {
                            mobile_no: mobile_no  
                        }).
                then(response => {
                    this.customers = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });

               
             
            },
            clear_data() {
                this.shiner.created_at='';
             this.shiner.name = '';
              this.shiner.mobile = '';
             this.shiner.pay = '';
             this.shiner.remarks = '';

                 // this.shiner.credit_amount = '';
             },
        
             credit_payed() {
                
                  this.loading = true;
                                  axios.post('/credit_payed',this.shiner)
                                 .then(response => {
                                     if (response.data.status == 1){ 

                                         swal("Payment against credit received", "", "success");
                                        this.clear_data();
                                        this.$refs.cancel_btn.click();
                                     }   
                                     else{
                                         swal("Could't Payagainst credit","", "error");
                                      }
                                     
                            
                                    this.get_credits();
                                 }).
                                   catch(error => {
                                     this.errors  = error.response.data.errors;
                                     this.loading = false;
                                 });
                              },

        },
    }
</script>

<style lang="css" scoped>

</style>