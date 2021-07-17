<template>
    <div>
      <form v-on:submit.prevent="save" class="bookingForm">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Vendor Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Vendor Name" autocomplete="on" v-model="vendor.name" required >
                    <small v-if="errors.name" 
                    class="text-danger">{{ errors.name[0] }}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address<span class="text-danger">*</span></label>
                    <input type="text"  class="form-control" placeholder="Vendor Address1" autocomplete="on" v-model="vendor.address1" required maxlength="200">
                    <small v-if="errors.address1" class="text-danger">{{ errors.address1[0] }}</small>
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Mobile No</label>
                    <input type="number" class="form-control" placeholder="Vendor Mobile No" v-model="vendor.mobile_no" required maxlength="10"  autocomplete="on" >
                    <small v-if="errors.mobile" class="text-danger">{{ errors.mobile_no[0] }}</small>
                </div>
            </div>
           
        </div>
        <div class="row">
           
            <div class="col-md-12">
                <div class="form-group">
                    <label>Opening Credit</label>
                    <input type="number" class="form-control" placeholder="Opening Credit" v-model="vendor.opening_credit" >
                    <small v-if="errors.opening_credit" class="text-danger">{{ errors.opening_credit[0] }}</small>
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
        console.log('edit');
        if(this.edit)
        {
           var vm = this;
            bus.$on('edit-vendor',function(vendor) {
                vm.clear_data();
                vm.vendor.id = vendor.id;
                vm.vendor.name = vendor.name;
                vm.vendor.mobile_no = vendor.mobile_no;
                vm.vendor.address1 = vendor.address;
                vm.vendor.opening_credit = vendor.opening_credit;
            });
        }
    },
    data () {
        return {
            vendor: {
                id:'',
                name: '',
                address: '',
                mobile_no: '',
                opening_credit:'',
            

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
            this.vendor.id='';
            this.vendor.name = '';
            this.vendor.mobile_no = '';
            this.vendor.address1 = '';      
            this.vendor.opening_credit = '';
            
          

        },
        save() {

            this.loading = true;
            axios.post('/add_vendor',this.vendor).
            then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        swal("Vendor Updated", "", "success");
                    else
                        swal("Vendor Added Successfully", "", "success");

                  
                    this.$refs.cancel_btn.click();
                    bus.$emit('vendor-added');
                    this.clear_data();
                }
                else if(response.data=="NoSMS"){
                    swal("Low SMS Credit, Please Top Up SMS", "", "error");
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update vendor", response.data, "error");
                    else
                        swal("Couldn't add vendor", response.data, "error");
                }
            }).
            catch(error => {
                if(this.edit)
                    swal("Couldn't update vendor", "", "error");
                else
                    swal("Couldn't add vendor", "", "error");
                this.loading = false;
                if(error.response.data.errors)
                    this.errors  = error.response.data.errors;
                else
                    this.errors = '';
            });
        },
        delete_customer() {
            swal({
                title: "Delete Vendor?",
                text: "Are you sure you want to delete this vendor? This cannot be undone!",
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
                    axios.post('/delete_customer',{
                        id: this.vendor.id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        
                        if(response.data == 'Success')
                        {
                            swal("vendor deleted", "", "success");
                            bus.$emit('vendor-added');
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