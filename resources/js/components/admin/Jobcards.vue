<template>
    <div class="row">
        <div class="nav-tabs-navigation mb-4">
            <div class="nav-tabs-wrapper">
                <ul class="nav nav-pills nav-pills-primary" data-tabs="pills">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" @click="type='active'" :class="{'active' : type=='active'}">Pending Completion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" @click="type='expired'" :class="{'active' : type=='expired'}">Pending Delivery</a>
                    </li>
                    <li>
                        <form v-on:submit.prevent="get_jobcards">  
                            <div class="input-group">
                                <input type="search" placeholder="Jobcard/Mobile No: " v-model="search" class="form-control" style="width:120px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" style="background-color:#454334">Search</button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li>
                        <button class="btn btn-primary btn-sm" style="background-color:#ff4433" @click="search='';get_jobcards();">Reset</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-12">


          <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;">S/N</th>
                        <th style="width: 60%;">Jobcard Details</th>
                        <th style="width: 35%;">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(jobcard,index) in jobcards">
                        <td>{{ index+1 }}</td>
                        <td> 
                          <table class='table borderless'>
                                <tbody>
                                    <tr>
                                        <td>
                                            Date: 
                                        </td>
                                        <td align="left">
                                            <b>{{ getformatteddate(jobcard.created_at) }}</b>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td>
                                          Jobcard No:
                                        </td>
                                        <td align="left">
                                         <b>{{ jobcard.jobcard_prefix }}{{ jobcard.jobcard_no }}</b>
                                      </td>
                                  </tr>  
                                  <tr>
                                      <td>
                                        Customer Name:
                                      </td>
                                      <td align="left">
                                        <b>{{ jobcard.name }} - {{ jobcard.mobile }}</b>
                                      </td>
                                  </tr>  
                                  <tr>
                                    <td>
                                      Model: 
                                    </td>
                                    <td align="left" v-if="jobcard.recovery==0">
                                       <b>{{ jobcard.make}} - {{jobcard.model }}</b>
                                    </td>
                                    <td align="left" v-else>
                                      <b>{{ jobcard.make}} - {{jobcard.item_type }} - {{jobcard.item_size }}</b>
                                     </td>
                                  </tr> 
                                  <tr>
                                    <td>
                                        Customer Voice: 
                                    </td>
                                    <td align="left">
                                      <b>{{ jobcard.customer_voice }}</b>
                                    </td>
                                  </tr> 

                                  <tr >
                                      <td>
                                        Technician Voice: 
                                      </td>
                                      <td align="left">
                                        
                                          <b>{{ jobcard.technician_voice }}</b>
                                      </td>
                                  </tr> 

                                  <tr>
                                    <td v-if="jobcard.technician_status==1">
                                      <b style="color:black;font-size: 14px;padding:5px">Technician Assigned</b>
                                    </td>
                                    <td v-else-if="jobcard.technician_status==2">
                                      <b style="color:green;font-size: 14px;padding:5px">Item Received back</b>
                                    </td>
                                    <td v-else>
                                      <b style="color:red;font-size: 14px;padding:5px">Technician Not Assigned</b>
                                    </td>
                                    <td align="left"  v-if="jobcard.holding_status==1">
                                      <button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#assignTech" @click="assign_tech(jobcard)"  style="background-color: yellow;">

                                        <b style="color:black">Jobcard Holded </b>

                                      </button>
                                    </td>
                                    <td align="left"  v-else>
                                      <button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#assignTech" @click="assign_tech(jobcard)"  style="background-color: green;">

                                        <b>Jobcard Options</b>
                                      </button>

                                      <button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#followUp" @click="follow_up(jobcard)"  style="background-color: grey;">

                                        <b>Followup Calls</b>
                                      </button>
                                    </td>

                                    

                                  </tr>
                                 

    

                                </tbody>
                          </table>
                        </td>
                        <td v-if="jobcard.reg_status==0 && jobcard.return_status==0">
                          <table class='table borderless'>
                            <tbody>
                            <tr>
                              <button v-if="jobcard.recovery==0" class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editJobCardModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;">
                                <i class="fa fa-pencil" aria-hidden="true"></i></button>
                              <button v-else class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editRecoveryModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;">
                                <i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </tr>
                            <br>
                            <tr>
                              <button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#photouploadModal"  @click="photoupload(jobcard.jobcard_no)" style="background-color: #FFC300;" v-if ="!company_id" >
                                <i class="fa fa-camera" aria-hidden="true"></i></button>
                            </tr>
                            <br>
                            <tr>
                              <td  v-if="company_id">
                                <a class="btn btn-success btn-sm m-0" 
                                :href="'/print_jobcard/'+jobcard.id+'?company_id='+company_id" target="_blank" style="background-color: #008CBA;">
                                  <i class="fa fa-print" aria-hidden="true"></i> </a>
                              <td v-else>
                                <a class="btn btn-success btn-sm m-0" 
                                :href="'/print_jobcard/'+jobcard.id" target="_blank" style="background-color: #008CBA;">
                                  <i class="fa fa-print" aria-hidden="true"></i> </a>
                              </td>
                        
                            </tr>
                            <br>
                            <tr>
                              <button class="btn btn-success btn-sm m-0" @click="mark_jobcardcompleted(jobcard.id)"  v-if ="!company_id && jobcard.holding_status==0">
                              <i class="fa fa-check" aria-hidden="true" ></i></button>
                            </tr>
                            </tbody>
                          </table>
                        <td v-if="jobcard.reg_status==1"> 
                          <table class='table borderless-full'>
                            <tbody>
                              <tr>
                                <button v-if="jobcard.recovery==0" class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editJobCardModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;margin-right: 16px;"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                <button v-else class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editRecoveryModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;margin-right: 16px;"><i class="fa fa-eye" aria-hidden="true"></i></button>
                              </tr>
                              <br>
                              <tr>
                                <td>
                                    <button  class="btn btn-success btn-sm m-0" type="button" data-toggle="modal" data-target="#otpModal" @click="show_otp_modal(jobcard,'mark_jobcarddelivered')"> <i class="fa fa-check" aria-hidden="true" ></i></button>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm m-0" type="button" data-toggle="modal" data-target="#otpModal" @click="show_otp_modal(jobcard,'mark_jobcardcreditdelivered')"> <i class="fa fa-check" aria-hidden="true" ></i></button>
                                </td>
                              </tr>
                              <br>
                              <tr> 
                                <td v-if="company_id">
                                    <a class="btn btn-success btn-sm m-0" :href="'/print_jobcard/'+jobcard.id+'?company_id='+company_id" target="_blank" style="background-color: #008CBA;">
                                    <i class="fa fa-print" aria-hidden="true"></i> </a>
                                <td v-else>
                                    <a class="btn btn-success btn-sm m-0" :href="'/print_jobcard/'+jobcard.id" target="_blank" style="background-color: #008CBA;">
                                    <i class="fa fa-print" aria-hidden="true"></i> </a>
                                </td>

                                <td  v-if="company_id">
                                    <a class="btn btn-success btn-sm m-0" 
                                    :href="'/print_bill/'+jobcard.id+'?company_id='+company_id" target="_blank" style="background-color: #008CBA;">
                                    <i class="fa fa-print" aria-hidden="true"></i> </a>
                                <td v-else>
                                    <a class="btn btn-success btn-sm m-0" 
                                    :href="'/print_bill/'+jobcard.id" target="_blank" style="background-color: maroon;"  >
                                    <i class="fa fa-print" aria-hidden="true"></i></a>
                                </td>    
                           

                               </tr>
                              <br>
                            </tbody>
                          </table>
                        <td v-if="jobcard.reg_status==2"> 
                          <table class='table borderless-full'>
                            <tbody>
                              <tr>
                                <span v-if="jobcard.return_status==1">
                                <b>
                                  Item returned to Customer <br>
                                  Return Remarks : {{ jobcard.return_remarks }}
                                  <br> 
                                  Delivery Date:  {{ getformatteddate(jobcard.delivered_date) }}
                                  <br> Total Amount: {{ jobcard.total_amount }}
                                </b> 
                              </span>
                              <span v-else>
                                <b>
                                  Item Delivered <br> Delivery Date:  {{ getformatteddate(jobcard.delivered_date) }}
                                  <br> Total Amount: {{ jobcard.total_amount }} <br> Payment: {{ jobcard.payment_type }}
                                </b> 
                              </span>
                            </tr>
                            <br>
                             <tr>
                                <td>
                                    <button  v-if="company_id" class="btn btn-success btn-sm m-0" type="button" data-toggle="modal" data-target="#otpModal" @click="show_otp_modal(jobcard,'mark_adminjobcarddelivered')"> <i class="fa fa-check" aria-hidden="true" ></i></button>
                                </td>
                                <td>
                                    <button v-if="company_id" class="btn btn-danger btn-sm m-0" type="button" data-toggle="modal" data-target="#otpModal" @click="show_otp_modal(jobcard,'mark_adminjobcardcreditdelivered')"> <i class="fa fa-check" aria-hidden="true" ></i></button>
                                </td>
                              </tr>
                            <br>
                            <tr>
                              <button v-if="jobcard.recovery==0" class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editJobCardModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;margin-right: 16px;"><i class="fa fa-eye" aria-hidden="true"></i></button>
                              <button v-else class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editRecoveryModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;margin-right: 16px;"><i class="fa fa-eye" aria-hidden="true"></i></button>
                              <td  v-if="company_id">
                                <a class="btn btn-success btn-sm m-0" 
                                :href="'/print_bill/'+jobcard.id+'?company_id='+company_id" target="_blank" style="background-color: #008CBA;">
                                  <i class="fa fa-print" aria-hidden="true"></i> </a>
                                <td v-else>
                                  <a class="btn btn-success btn-sm m-0" 
                                  :href="'/print_bill/'+jobcard.id" target="_blank" style="background-color: maroon;"  >
                                      <i class="fa fa-print" aria-hidden="true"></i></a>
                                </td>    
                              </tr>
                              
                            <br>
                            </tbody>
                          </table>
<td v-if="jobcard.reg_status==0 && jobcard.return_status==1"> 
    <table class='table borderless-full'>
        <tbody>

            <tr>

                <b>
                    Item Marked as returned  <br>
                    Return Remarks : {{ jobcard.return_remarks }}
                    <br> 
                    Not Delivered to Customer
                </b> 

            </span>

        </tr>
        <br>

        <tr>
            <button class="btn btn-success btn-sm m-0" data-toggle="modal"   @click="return_delivered(jobcard.id)" style="background-color: green;">Mark Delivery</button>



        </tr>
        <br>
        <tr>
            <button v-if="jobcard.recovery==0" class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editJobCardModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;margin-right: 16px;"><i class="fa fa-eye" aria-hidden="true"></i></button>

           <button v-else class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#editRecoveryModal"  @click="edit_jobcard(jobcard)" style="background-color: #f44336;margin-right: 16px;"><i class="fa fa-eye" aria-hidden="true"></i></button>

           <td v-if="company_id">
               <a class="btn btn-success btn-sm m-0" :href="'/print_bill/'+jobcard.id+'?company_id='+company_id" target="_blank" style="background-color: maroon;">
               <i class="fa fa-print" aria-hidden="true"></i> </a>
           <td v-else>
               <a class="btn btn-success btn-sm m-0" :href="'/print_bill/'+jobcard.id" target="_blank" style="background-color: maroon;">
               <i class="fa fa-print" aria-hidden="true"></i> </a>
           </td>
</tr>
</tbody>
</table>





</td>

</tr>
<tr v-if="jobcards.length==0">
    <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Bookings'}}</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="assignTech" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">ASSIGN TECHNICIAN</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <assign-technician :technicians="technicians"  :company_id="company_id" type="edit" ></assign-technician>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="followUp" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">FOLLOW UPS</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <followup-calls  :company_id="company_id" type="edit" ></followup-calls>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="editJobCardModal" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">EDIT JOBCARD</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <add-jobcard :services="services" :vehiclemakes="vehiclemakes" :technicians="technicians" :jobadvisors= "jobadvisors"  :categories="categories" :products="products" :company_id="company_id" type="edit" ></add-jobcard>
            </div>
           
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="editRecoveryModal" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">EDIT JOBCARD</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <add-recovery :services="services" :vehiclemakes="vehiclemakes" :technicians="technicians" :jobadvisors= "jobadvisors"  :categories="categories" :company_id="company_id" type="edit" ></add-recovery>
            </div>
           
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="photouploadModal" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">UPLOAD PHOTO</h3>
            </div>
            <form ref="imageUploadForm" v-on:submit.prevent="uploadphoto">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Choose Photo</label>
                        <div class="custom-file">
                            <label>
                                <input type="file" class="custom-file-input" ref="image" required accept=".jpg,.jpeg,.png"  @change="handleFileChange">
                                <span class="custom-file-label">Choose Photo</span>
                            </label>
                        </div>
                        <img :src="preview" class="preview" v-if="preview">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light float-right mr-auto" ref="cancel_btn" data-dismiss="modal" @click="clear_data()" type="button">Close</button>
                    <button class="btn btn-success float-right" type="submit" :disabled="uploading">{{ uploading ? 'Uploading...' : 'Upload' }}</button>

                </div>
            </form>
        </div>
    </div>

</div>
<!-- Image Preview -->
<div id="imagePreviewModal">
    <button class="btn close-image-modal btn-lg px-2 py-1 bg-none"><i class="fa fa-times"></i></button>
    <div class="image-modal-body">
        <img :src="image_preview">
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="otpModal" data-backdrop="static" ref="redeemModal">
    <div class="modal-dialog mt-5" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">OTP</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form v-on:submit.prevent="verify_otp">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="form-group">
                                <label>Delivery Date (please select if any change)</label>
                              <input type="date" class="form-control" placeholder="Select Date" autocomplete="on" v-model="otp.delivery_date">
                              <small v-if="errors.delivery_date" class="text-danger">{{ errors.delivery_date[0] }}</small>
                            </div>
                        </div>
                        
                        <div class="col-12 " v-if="this.otp.type == 'mark_jobcarddelivered' || this.otp.type == 'mark_adminjobcarddelivered'">
                          <div class="form-group">
                              <label>Payment Type</label>
                                <select class="form-control" v-model="otp.payment_type" required>
                                  <option disabled value="">Please select one</option>
                                  <option>Cash</option>
                                   <option>HDFC-Bank</option>
                         <option>AXIS-Bank</option>
                                  <option>GooglePay</option>
                                </select>
                              <small class="text-danger " v-if="errors.payment_type">{{ errors.payment_type[0] }}</small>
                          </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="d-block">Mobile</label>
                                <h3 class="my-0 title">{{ otp.mobile }}</h3>
                            </div>
                        </div>
                        <div class="col-sm-6" v-if="!otp.alt_mobile">
                            <div class="form-group text-center text-md-right">
                                <label class="d-sm-block">&nbsp</label>
                                <button class="btn btn-success btn-sm"  type="button" @click="set_alt_mobile('show')">Use Another Number</button>
                            </div>
                        </div>
                        <div class="col-12 " v-if="otp.alt_mobile">
                            <div class="form-group">
                                <label>New Mobile Number</label>
                                <div class="input-group">
                                    <input type="number" class="form-control new-number mr-2" v-model="otp.mobile2" required>
                                    <button class="btn btn-sm btn-danger m-0" @click="set_alt_mobile('hide')" type="button"><i class="fa fa-times"></i></button>
                                </div>
                                <small class="text-danger " v-if="errors.mobile2">{{ errors.mobile2[0] }}</small>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row" v-if="!otp.sent_otp">
                        <div class="col-12">
                            <div class="form-group text-center">
                                <button class="btn btn-primary" id="otp-btn">Send OTP</button>
                                <small class="text-danger text-center" v-if="errors.send_otp">{{ errors.send_otp }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="!otp.sent_otp">
                        <div class="col-12">
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="button" style="background-color: #f44336" @click="verify_without_otp()" >Verify Without OTP</button>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center text-center" v-else>
                        <div class="col-6">
                            <div class="form-group">
                                <h4 class="mb-0">OTP</h4>
                                <input type="number" class="form-control mr-2 otp" v-model="otp.otp" required>
                                <small>Expires in 5 minutes</small>
                                <div>
                                    <small class="text-danger d-block"  v-if="errors.otp">{{ errors.otp[0] }}</small>
                                    <div class="d-block" style="color: #2196f3">
                                        <small v-if="this.otp.timer == '00'" @click="send_otp" class="hoverable" style="color: #2196f3">Resend OTP</small>
                                        <small v-else>Resend OTP in 00:{{ otp.timer }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success" type="submit" id="verify-btn">Verify</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
</div>
</div>
</template>

<script>
import moment from 'moment';
import Timer from 'tiny-timer';

export default {
    /*mixins:[mixins],*/  /*props:['PROPERTY'],*/
    props: ['services', 'vehiclemakes','technicians','jobadvisors','company_id','categories','products'],
    watch: {
        type : function() {
            this.get_jobcards();
        }
    },
    created(){
        this.get_jobcards();
        if(this.type == 'expired')
            this.expired = true;
        var vm =this;
        bus.$on('jobcard-updated', function(){
            vm.get_jobcards();
        }); 
        bus.$on('receive-tech', function(){
            vm.get_jobcards();
        }); 
        bus.$on('jobcard-deleted', function(){
            vm.get_jobcards();
        });   
        bus.$on('jobcard-delivered', function(){
            vm.get_jobcards();
        });        
    },
    data () {
        return {
            upload_id:'',
            uploading: false,
            preview: '',
            type: 'active',
            jobcards: {},
            loading : false,
            uploading : false,
            errors  : {},
            file: '',
            expired: false,
            id:'',
            amount:'',
            image_preview: '',
            search: '',
            otp: {
                mobile: '',
                mobile2: '',
                payment_type:'',
                otp: '',
                delivery_date:'',
                alt_mobile: false,
                sent_otp: false,
                timer: '60',
                id: '',
                type: '',
            },
            timer: new Timer,
            otp_error: ''
        }
    },
    methods : {
        getformatteddate(date) {
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },
        get_jobcards() {
            this.loading = true;
            this.jobcards = [];
            if(this.company_id)
            {
                var url = '/get_jobcards?company_id='+this.company_id+'&search='+this.search;  

            }
            else
            {
               var url = '/get_jobcards?search='+this.search;
           }
           axios.get(url,{
            params : {
                type: this.type
            }
        }).
           then(response => {
            this.jobcards = response.data;
            this.loading = false;

            this.$nextTick(() => {
                $(".table-responsive").floatingScroll();
            })
        }).
           catch(err => {
            this.loading = false;
        });
       },
       convert_date(date) {
        return moment(date).format('DD-MM-YYYY');
    },
    clear_data() {
        this.amount = '';
    },
    photoupload(j_no){
        this.upload_id = j_no;
        this.$refs.imageUploadForm.reset();
        this.handleFileChange();
    },
    handleFileChange() {
        var image = this.$refs.image.files[0];
        var name = "Choose File"
        if(image) {
            name = image.name;
            var reader = new FileReader();
            var vm = this;
            reader.onload = function (e) {
                vm.preview = e.target.result;
            };
            reader.readAsDataURL(image);
        }
        else {
            this.preview = '';
        }
        $(".custom-file-label").text(name);
    },
    uploadphoto() {
        this.uploading = true;
        this.errors = {};

        let formData = new FormData();
        formData.append('upload_id', this.upload_id);
        formData.append('image', this.$refs.image.files[0]);

        axios.post('/upload_image',formData)
        .then(response => {
            this.uploading = false;
            swal("Image uploaded",'','success');
            this.$refs.cancel_btn.click();
        })
        .catch(error => {
            swal("Couldn't upload image", "", "error");
            this.uploading = false;
        });
    },

    mark_jobcardcompleted(id) {
        swal({
            title: "Mark Completion?",
            text: "Are you sure you want to mark this Completed",
            icon: "warning",
            buttons: {
                cancel: "No",
                catch: {
                  text: "Yes",
                  value: "willDelete",
                  closeModal: false,
              },
          },
          dangerMode: true,
      })
        .then((willDelete) => {
            if(willDelete)
            {
                axios.post('/mark_jobcardcompleted',{
                    id: id  
                })
                .then(response => {
                    if (response.data.status == 1) 

                        swal("Mark Completed Successfully", "", "success");
                    else
                        swal(response.data.response,"", "error");

                    this.get_jobcards();
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
    async mark_jobcarddelivered(id,payment_type,delivery_date) {

        await axios.post('/mark_jobcarddelivered',{
            id: id ,
            payment_type:payment_type,
            delivery_date:delivery_date,
           
        })
        .then(response => {
            if (response.data.status == 1) 
                swal("Jobcard Delivered Successfully", "", "success");
            else
                swal(response.data.response,"", "error");

            this.get_jobcards();
        }).
        catch(error => {
            this.errors  = error.response.data.errors;
            this.loading = false;
        });
    },

     async mark_adminjobcarddelivered(id,payment_type,delivery_date) {

        await axios.post('/mark_adminjobcarddelivered',{
            id: id ,
            payment_type:payment_type,
            delivery_date:delivery_date,
            company_id:this.company_id,
        })
        .then(response => {
            if (response.data.status == 1) 
                swal("Jobcard Delivered Successfully", "", "success");
            else
                swal(response.data.response,"", "error");

            this.get_jobcards();
        }).
        catch(error => {
            this.errors  = error.response.data.errors;
            this.loading = false;
        });
    },
   async mark_adminjobcardcreditdelivered(id,delivery_date) {
    await axios.post('/mark_adminjobcardcreditdelivered',{
        id: id,
        delivery_date:delivery_date,
        company_id:this.company_id,
    })
    .then(response => {
        if (response.data.status == 1) 

            swal("Jobcard Delivered as Credit Delivery", "", "success");
        else
            swal(response.data.response,"", "error");

        this.get_jobcards();
    }).
      catch(error => {
        this.errors  = error.response.data.errors;
        this.loading = false;
    });
  },
  async mark_jobcardcreditdelivered(id,delivery_date) {
    await axios.post('/mark_jobcardcreditdelivered',{
        id: id,
        delivery_date:delivery_date,
      
    })
    .then(response => {
        if (response.data.status == 1) 

            swal("Jobcard Delivered as Credit Delivery", "", "success");
        else
            swal(response.data.response,"", "error");

        this.get_jobcards();
    }).
      catch(error => {
        this.errors  = error.response.data.errors;
        this.loading = false;
    });
  },
  edit_jobcard(jobcard) {
    bus.$emit('edit-jobcard', jobcard);
},
assign_tech(jobcard) {
    bus.$emit('assign-tech', jobcard);
},

follow_up(jobcard) {
    bus.$emit('follow-up', jobcard);
},

set_alt_mobile(status){
    if(status=='show')
    {
        this.otp.alt_mobile = true;
    }
    else if(status=='hide')
    {
        this.otp.alt_mobile = false;
    }
},
send_otp(){
    this.errors = {};
    this.timer.stop();
    this.otp.timer = '59';
    var seconds = 59;
    var vm = this;
    this.timer.on('tick', function(ms){
        if(seconds < 10)
            vm.otp.timer = '0'+seconds;
        else
            vm.otp.timer = seconds;
        seconds--;
    });

    this.timer.start(1000 * 59);

    var mobile = this.otp.alt_mobile ? this.otp.mobile2 : this.otp.mobile;
    $("#otp-btn").attr('disabled','disabled').text('Sending OTP');
    axios.post('/jobcard/send-otp',{
        mobile : mobile,
        id : this.otp.id,
    }).
    then(response => {
        $("#otp-btn").removeAttr('disabled').text('Send OTP');
        if(response.data.status == 1)
        {
            this.otp.sent_otp = true;
            swal("OTP Sent to "+mobile,"","success");
        }
        else
        {
            this.otp.sent_otp = false;
            swal("Error",response.data.response,"error");
            this.errors.send_otp = response.data.response;
        }
    }).
    catch(error => {
        $("#otp-btn").removeAttr('disabled').text('Send OTP');
        swal("Error","Couldnt send OTP","error");
    });
},
verify_otp() {
    if(!this.otp.sent_otp)
    {
        this.send_otp();
    }
    else
    {
        this.errors = {};
        this.otp.mobile2 = this.otp.alt_mobile ? this.otp.mobile2 : '';
        $("#verify-btn").attr('disabled','disabled').text('Verifying');
        axios.post('/jobcard/verify-otp',{
            id : this.otp.id,
            mobile : this.otp.mobile,
            payment_type : this.otp.payment_type,
            delivery_date:this.otp.delivery_date,
            mobile2 : this.otp.mobile2,
            otp: this.otp.otp,
        }).
        then(response => {

            if(response.data.status == 1)
            {
                var promise = '';
                if(this.otp.type == 'mark_jobcardcreditdelivered')
                    promise = this.mark_jobcardcreditdelivered(this.otp.id,this.otp.delivery_date);
                else if(this.otp.type == 'mark_jobcarddelivered')
                    promise =this.mark_jobcarddelivered(this.otp.id,this.otp.payment_type,this.otp.delivery_date);
                else if(this.otp.type == 'mark_adminjobcarddelivered')
                    promise =this.mark_adminjobcarddelivered(this.otp.id,this.otp.payment_type,this.otp.delivery_date);
                else if(this.otp.type == 'mark_adminjobcardcreditdelivered')
                    promise =this.mark_adminjobcardcreditdelivered(this.otp.id,this.otp.delivery_date);

                if(promise)
                    promise.then(()=>{
                        $("#verify-btn").removeAttr('disabled').text('Verify');
                        $("#otpModal").modal('hide');
                    });
                else
                    swal("OTP verified","","success");
            }
            else
            {
                this.errors = {'otp': [response.data.response]};
            }
        }).
        catch(error => {
            $("#verify-btn").removeAttr('disabled').text('Verify');
            swal("Error","Couldnt verify OTP","error");
            console.log(error);
        });
    }
},

verify_without_otp()
{

    var promise = '';
    if( this.otp.type == 'mark_jobcardcreditdelivered')
        promise = this.mark_jobcardcreditdelivered(this.otp.id,this.otp.delivery_date);
    else if(this.otp.type == 'mark_adminjobcardcreditdelivered')
        promise =this.mark_adminjobcardcreditdelivered(this.otp.id,this.otp.delivery_date);
    else if(this.otp.payment_type && this.otp.type == 'mark_jobcarddelivered')
        promise =this.mark_jobcarddelivered(this.otp.id,this.otp.payment_type,this.otp.delivery_date);
    else if(this.otp.payment_type && this.otp.type == 'mark_adminjobcarddelivered')
        promise =this.mark_adminjobcarddelivered(this.otp.id,this.otp.payment_type,this.otp.delivery_date);
   
    else
        swal("Please Select Payment Type",'','error');
    if(promise)
        promise.then(()=>{
        
            $("#otpModal").modal('hide');
        });

},
show_otp_modal(jobcard,type) {
    if(this.otp.id != jobcard.id || this.otp.type != type) {
        this.otp.mobile = jobcard.mobile;
        this.otp.mobile2 = jobcard.mobile2;
        this.otp.payment_type = '';
        this.otp.id = jobcard.id;
        this.otp.otp = '';
        this.otp.delivery_date='';
        this.otp.alt_mobile = false;
        this.otp.sent_otp = false;
        this.otp.timer = '60';
        this.otp.type = type;
    }
}
},
mounted() {
    $(".table-responsive").floatingScroll();
    bus.$on('preview-image', (image)=>{
        this.image_preview = image;
        $('#imagePreviewModal').addClass('show')
    })

    $("#imagePreviewModal").click(function() {
        $('#imagePreviewModal').removeClass('show')
    })

    $("#imagePreviewModal .image-modal-body").click(function(event) {
        event.stopPropagation();
    })




},

}
</script>

<style lang="css" scoped>

.nav-item:hover {
    cursor: pointer;
}

.nav-pills .nav-item .nav-link {
    border-radius: 0.2rem;
    padding: 4px 10px;
}

.nav-pills .nav-item .nav-link.active {
    box-shadow: 1px 4px 16px 0 rgba(0,0,0,.2), 0px 4px 4px -11px rgba(156,39,176,.6);
}

.preview {
    display: block;
    margin: 20px auto 0 auto;
    width: 300px;
    height: 100px;
    object-fit: contain;
    object-position: center;
}

#imagePreviewModal {
    background: #000000aa;
    height: 100vh;
    width: 100vw;
    left: 0;
    top: 0;
    position: absolute;
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1050;
}

#imagePreviewModal .image-modal-body {
    max-height: 500px;
    max-width: 500px;
}

#imagePreviewModal .image-modal-body img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}
.newspaper {


  -webkit-column-gap: 40px; /* Chrome, Safari, Opera */
  -moz-column-gap: 40px; /* Firefox */
  column-gap: 40px;
}

#imagePreviewModal.show {
    display: flex!important;
}

.close-image-modal {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    box-shadow: none;
}
.borderless td, .borderless th {
    border: none;
    padding: 0px;
    margin: 0px;
    text-align: left;
    width:50%;
}
.borderless-full td, .borderless-full th {
    border: none;
    padding: 0px;
    margin: 0px;
    text-align: left;
    width:50%;
}

.new-number , .otp{
    font-size: 1.25rem;
    font-weight: 700;
    color: #3c4858;
    font-family: 'Roboto Slab', sans-serif;
    letter-spacing: 1px;
}

.otp {
    text-align: center;
    letter-spacing: 5px;
    font-family: 'Roboto', sans-serif;
    font-style: 1.5rem;
}
</style>