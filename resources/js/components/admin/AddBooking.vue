<template>
    <div>
        <form v-on:submit.prevent="find_customer">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                     
                      <input type="search" onkeyup="this.value = this.value.toUpperCase()" class="form-control" placeholder="Search by Mobile No/ Register No" autocomplete="on" v-model="booking.no" >

                  </div>
              </div>
          </div>
      </form>
      <form v-on:submit.prevent="save" class="bookingForm">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Customer Code</span></label>
                    <input type="number" class="form-control" placeholder="Customer Code" autocomplete="on" v-model="booking.customer_id" disabled >
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Customer Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Customer Name" autocomplete="on" v-model="booking.name" required >
                    <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">


                    <label>Location<span class="text-danger">*</span></label>
                    <input type="text"  class="form-control" placeholder="Customer Location" autocomplete="on" v-model="booking.location" required maxlength="200">
                    <small v-if="errors.location" class="text-danger">{{ errors.location[0] }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mobile No<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="Customer Mobile No" v-model="booking.mobile" required maxlength="10"  autocomplete="on" >
                    <small v-if="errors.mobile" class="text-danger">{{ errors.mobile[0] }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">

                  <label>Make<span class="text-danger">*</span></label>

                  <select class="form-control" v-model="booking.make" @change="get_models_by_make()" ref="make">
                    <option value="">Select Make</option>
                    <option v-for="make in vehiclemakes" :value="make.name" :data-id="make.id">{{ make.name }}</option>
                </select>
                <small v-if="errors.make" class="text-danger">{{ errors.make[0] }}</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Model<span class="text-danger">*</span></label>
                <select class="form-control" v-model="booking.model" >
                 <option value="">Select Model</option>
                 <option v-for="model in models" :value="model.name">{{ model.name }}</option>
             </select>
             <small v-if="errors.model" class="text-danger">{{ errors.model[0] }}</small>
         </div>
     </div>
     <div class="col-md-6">
        <div class="form-group">
            <label>Register No<span class="text-danger">*</span></label>
            <input type="text" onkeyup="this.value = this.value.toUpperCase()" class="form-control" placeholder="Vehicle Register No" v-model="booking.reg_no" required maxlength="25">
            <small v-if="errors.reg_no" class="text-danger">{{ errors.reg_no[0] }}</small>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label>Service Type<span class="text-danger">*</span></label>
            <select class="form-control" v-model="booking.service_type" required >
                <option value="">Select service type</option>
                <option v-for="service in services" :value="service.id">{{ service.name }}</option>
            </select>
            <small v-if="errors.service_type" class="text-danger">{{ errors.service_type[0] }}</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Remarks</label>
            <input type="text" class="form-control" placeholder="Enter any remarks" v-model="booking.remarks" maxlength="1000">
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
    props: ['services','edit','expired','vehiclemakes'],
    created() {
        if(this.edit)
        {
            var vm = this;
            bus.$on('view_campaign',function(booking) {

                vm.booking.name = booking.name;
                vm.booking.location = booking.location;
                vm.booking.mobile = booking.mobile;
                vm.booking.make = booking.make;
                vm.booking.model = booking.model;
                vm.booking.reg_no = booking.reg_no;
                vm.booking.service_type = booking.service_type ? booking.service_type.id : '';
                vm.booking.remarks = booking.remarks;
                
            });
        }
    },
    data () {
        return {
            booking: {
                no: '',
                name: '',
                location: '',
                mobile: '',
                make: '',
                customer_id:'',
                model: '',
                reg_no: '',
                service_type: '',
                remarks:'',

            },
    
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
            this.booking.customer_id = '';
            this.booking.name = '';
            this.booking.location = '';
            this.booking.mobile = '';
            this.booking.make = '';
            this.booking.model = '';
            this.booking.reg_no = '';
            this.booking.service_type = '';
            this.booking.remarks = '';
            this.booking.no='';

        },
        save() {

            this.loading = true;
            axios.post('/add_booking',this.booking).
            then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        swal("Booking Updated", "", "success");
                    else
                        swal("Booking Added Successfully", "", "success");

                    // console.log($(".campaignForm").find('.cancel-btn'));
                    this.$refs.cancel_btn.click();
                    bus.$emit('booking-updated');
                    this.clear_data();
                }
                else if(response.data=="NoSMS"){
                    swal("Low SMS Credit, Please Top Up SMS", "", "error");
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update booking", response.data, "error");
                    else
                        swal("Couldn't add booking", response.data, "error");
                }
            }).
            catch(error => {
                if(this.edit)
                    swal("Couldn't update booking", "", "error");
                else
                    swal("Couldn't add booking", "", "error");
                this.loading = false;
                if(error.response.data.errors)
                    this.errors  = error.response.data.errors;
                else
                    this.errors = '';
            });
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
        get_models_by_make() {
            var make_id = $(this.$refs.make).children("option:selected").data('id');
            axios.get('/get_models_by_make/'+make_id).then(response => {
                this.models = response.data;
            });
        },   
        find_customer() {
            var str =  this.booking.no.replace(/[^A-Z0-9]/ig, "");
            var data = {};
            if(isNaN(str)) 
                data.register_no = str;
            else
                data.mobile_no = str;

            axios.post('/find_customer',data).
            then(response => {
                if(response.data) {
                   console.log(response.data);
                    this.booking.name = response.data.name;
                    this.booking.customer_id = response.data.customer_id?response.data.customer_id:'';
                    this.booking.mobile = response.data.mobile;
                    this.booking.location = response.data.location;
                    this.booking.make = response.data.make;
                    this.booking.model = response.data.model;
                    this.booking.reg_no = response.data.reg_no;
                    this.booking.service_type = response.data.service_type;
                    this.$nextTick( function() {
                        this.get_models_by_make();
                    })
                } else {
                    this.booking.reg_no = data.register_no;

                    this.booking.mobile = data.mobile_no;

                }
            }).
            catch(error => {
            });
        }
    },
     
    mounted() {
    },
    watch:{
        'booking.name' : function(){
            this.booking.name = this.booking.name.toUpperCase();

        },
        'booking.location' : function(){
            this.booking.location = this.booking.location.toUpperCase();

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
</style>