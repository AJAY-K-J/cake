<template>
    <div>
        <form v-on:submit.prevent="save" class="jobCardForm">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Customer Name" autocomplete="on" v-model="jobcard.name" required style="text-transform: uppercase;">
                        <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                    </div>
                </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label>Customer Type<span class="text-danger">*</span></label>
                          <select class="form-control" v-model="jobcard.dealer" required>
                            <option disabled value="">Please select one</option>
                            <option>Dealer</option>
                            <option>Customer</option>
                        </select>
                        <small v-if="errors.dealer" class="text-danger">{{ errors.dealer[0] }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text"  class="form-control" placeholder="Customer Location" autocomplete="on" v-model="jobcard.location" maxlength="200" style="text-transform: uppercase;">
                        <small v-if="errors.location">{{ errors.location[0] }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Mobile No<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Customer Mobile No" v-model="jobcard.mobile" required maxlength="10"  autocomplete="on" >
                        <small v-if="errors.mobile" class="text-danger">{{ errors.mobile[0] }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Brand<span class="text-danger">*</span></label>

                      <input type="text" class="form-control" placeholder="Customer Mobile No" v-model="jobcard.make" required  autocomplete="on" >
                      <small v-if="errors.make" class="text-danger">{{ errors.make[0] }}</small>

                </div>
            </div>
        
                <div class="col-md-4">
                    <div class="form-group">
                        <label> Item Type<span class="text-danger">*</span></label>
                        <select class="form-control" v-model="jobcard.item_type" required>
                          <option disabled value="">Please select one</option>
                          <option>Hard Disk</option>
                          <option>SSD</option>
                          <option>Memory Card</option>
                          <option>Pen Drive</option>
                      </select>
                      <small v-if="errors.item_type" class="text-danger">{{ errors.item_type[0] }}</small>
                  </div>
              </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> Item Size<span class="text-danger">*</span></label>
                       
                       <input type="text" class="form-control" placeholder="Item Size" v-model="jobcard.item_size" required  autocomplete="on" >
                       <small v-if="errors.make" class="text-danger">{{ errors.item_size[0] }}</small>
                     
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label>Select Job Advisor<span class="text-danger">*</span></label>
                    <select class="form-control" v-model="jobcard.jobadvisor_id" required >
                        <option value="">Select Job Advisor</option>
                        <option v-for="jobadvisor in jobadvisors" :value="jobadvisor.id">{{ jobadvisor.name }}</option>
                    </select>
                    <small v-if="errors.jobadvisor_id" class="text-danger">{{ errors.jobadvisor_id[0] }}</small>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>Customer Voice</label>
                    <textarea  class="form-control"  v-model="jobcard.customer_voice" maxlength="500"  style="text-transform: uppercase;"> Enter Customer Voice</textarea>
                    <small v-if="errors.customer_voice">{{ errors.customer_voice[0] }}</small>
                </div>
            </div>
           
            <div class="col-md-3">

                <div class="form-group">
                    <input type="checkbox" id="jobcard.without_warranty" v-model="jobcard.without_warranty">
                    <label for="checkbox">  Without Warranty</label>
                </div>
            </div>
            <div class="col-md-3">

                <div class="form-group">
                    <input type="checkbox" id="jobcard.customer_dead_risk" v-model="jobcard.customer_dead_risk">
                    <label for="checkbox"> Customer Dead Risk</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label>Estimate Amount</label>
                    <input type="text" class="form-control"  placeholder="Enter Estimate Amount" v-model="jobcard.estimate_amount"> 
                    <small v-if="errors.estimate_amount">{{ errors.customer_voice[0] }}</small>
                </div>
            </div>

            
            <div class="col-md-12">
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control"  v-model="jobcard.remarks" style="text-transform: uppercase;" maxlength="1000">
                        Enter Remarks 
                    </textarea>
                    <small v-if="errors.remarks">{{ errors.remarks[0] }}</small>
                </div>
            </div>

            <div class="col-md-12">
                <h4> <button @click="add_more" class="btn btn-info float-right" type="button"  >ADD ITEM</button></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" style="background-color: #f5f8fa;">
                        <thead>
                            <tr>
                                <th style="min-width:10px">S/N</th>
                                <th style="min-width:200px">Enter Service</th>
                                <th style="min-width:100px">Rate</th>
                                <th style="min-width:100px">Technician</th>
                                <th>X</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in jobcard.items">
                                <td>{{ index+1 }}</td>
                                <td>
                                    <input type="text" v-model="item.service_string" style="
                                    text-transform: uppercase;" class="form-control" placeholder="Enter Service" required>
                                </td>
                                
                                <td>
                                    <input type="number" v-model="item.rate" min="0" required 
                                    class="form-control" placeholder="Rate" @change="amount_cal($event.target.value)">
                                </td>

                                <td>
                                    <select class="form-control" v-model="jobcard.items[index].technician_id" >
                                        <option value="">Select technician</option>
                                        <option v-for="technician in technicians" :value="technician.id">{{ technician.name }}</option>
                                    </select>
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
                                    <b>{{jobcard.total_spare}}</b>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Discount</label>
                    <input type="number" v-model="jobcard.discount"
                    class="form-control" placeholder="Discount" @change="amount_cal($event.target.value)"></td>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Amount to Pay</label>
                    <b>{{ jobcard.total_pay }}</b>
                </div>
            </div>



            <div class="col-md-3">

             <div class="form-group">
                <label>Previous Jobcard No (if Re-Enter)</label>
                <input type="number" class="form-control" placeholder="Please enter last jobcard no" autocomplete="on" v-model="jobcard.renter_jobcard_no" style="text-transform: uppercase;">
                <small v-if="errors.renter_jobcard_no" class="text-danger">{{ errors.name[0] }}</small>
            </div>
        </div>
        <div class="col-12" v-if="!jobcard.signature_path">
            <canvas ref="canvas" class="signaturePad d-block" height="100" width="350"></canvas>
            <button class="btn btn-default btn" @click="clear_signature" type="button">Clear Signature</button>
        </div>
        <div class="col-12" v-if="jobcard.signature_path">
          <span class="imageshow">
              <img :src="'/storage/'+jobcard.signature_path" data-toggle="modal" data-target='#imageModal'>

          </span>
      </div>
      <div class="col-12 mb-3">
        <div  class="form-group">
            <span v-for="(image, index) in images" class="imageshow">
                <img :src="'/storage/'+image.image_path" @click="show_preview('/storage/'+image.image_path)" data-toggle="modal" data-target='#imageModal'>
                <button class="btn btn-danger btn-block" @click="delete_image($event,image.id)" type="button"  v-if ="company_id  || jobcard.reg_status==0">Delete</button>
            </span>
        </div>
    </div>
    <div class="col-12">
        <div  class="form-group">
            <button class="btn btn-light" ref="cancel_btn" v-on:click="clear_data()" type="button" data-dismiss="modal" >Close</button>

            <button v-if="!company_id" class="btn btn-primary float-right" type="submit" :disabled="loading" >Save</button>

            <button  class="btn btn-danger float-right mr-4" type="button" @click="delete_jobcard(jobcard.id)" v-if="type=='edit' && jobcard.reg_status==0 && !company_id">Delete</button>

            <button class="btn btn-danger float-right mr-4" type="button" @click="add_list(jobcard.id)" v-if="type=='edit' && jobcard.reg_status>=1 && !company_id && jobcard.renter_status==0 ">Add to Pending List</button>



        </div>
    </div>

</div>
</form>

</div>
</template>




<script>
import moment from 'moment';
import Autocomplete from 'vuejs-auto-complete'
import SignaturePad from 'signature_pad';



export default {
    props: ['services','type','expired','vehiclemakes','technicians','jobadvisors','company_id','categories'],
    created() {
    },
    data () {
        return {

            jobcard:{
                no: '',
                name: '',
                location: '',
                mobile: '',
                make: '',
                model: '',
                serial_no: '',  
                dealer: '',
                item_type:'',
                item_size:'',
                reg_status: '',
                remarks:'',
                partno: '',
                discount:0,
                total_pay:'',
                customer_voice:'',
                total_spare:'',
                total_labour:'',
                mrp: 0,
                labour: 0,
                jobadvisor_id:'',
                qty: 0,
                items : [],
                customercategories : [],
                images : [],
                total:0,
                mob_no:'',
                jobcard_no:'',
                battery:'',
                charger:'',
                sim:'',
                dvd_drive:'',
                bag:'',
                customer_dead_risk:'',
                with_warranty:'',
                without_warranty:'',
                technician_status:'',
                signature_path:'',
                estimate_amount:'',
                renter_jobcard_no:'',
                renter_status:'',
            },
            images: [],
            image_preview: '',
            models:{},
            catremarks:{},
            loading: false,
            signature: '',
            errors: {},

        }
    },
    components: {
        Autocomplete,
    },
    methods : {
        mark_jobcarddelivered(id) {
          swal({
              title: "Mark Delivery?",
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
            signaturePad: ''
        })
          .then((willDelete) => {
              if(willDelete)
              {
                  axios.post('/mark_jobcarddelivered',{
                      id: id  
                  })
                  .then(response => {
                      if (response.data.status == 1) 
                      {
                          swal("Mark Delivered Successfully", "", "success");
                          this.$refs.cancel_btn.click();
                          bus.$emit('jobcard-delivered');
                          this.clear_data();
                      }
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
      clear_data() {
        this.signaturePad.clear();
        this.jobcard.name = '';
        this.jobcard.jobcard_no = '';
        this.jobcard.location = '';
        this.jobcard.mobile = '';
        this.jobcard.make = '';
        this.jobcard.item_size='';
        this.jobcard.item_type='';
        this.jobcard.model = '';
        this.jobcard.serial_no = '';
        this.jobcard.dealer = '';
        this.jobcard.reg_status = '';
        this.jobcard.service_type = '';
        this.jobcard.customer_voice = '';
        this.jobcard.remarks = '';
        this.jobcard.no='';
        this.jobcard.discount='';
        this.jobcard.total_spare='';
        this.jobcard.total_labour='';
        this.jobcard.customer_dead_risk='';
        this.jobcard.with_warranty='';
        this.jobcard.without_warranty='';
        this.jobcard.total_pay='';
        this.jobcard.jobadvisor_id='';
        this.jobcard.items=[];
        this.jobcard.customercategories=[];
        this.jobcard.images=[];
        this.jobcard.mob_no='';
        this.jobcard.technician_status='';
        this.jobcard.signature_path='';
        this.jobcard.estimate_amount='';
        this.jobcard.battery='';
        this.jobcard.charger='';
        this.jobcard.sim='';
        this.jobcard.dvd_drive='';
        this.jobcard.bag='';
        this.jobcard.renter_jobcard_no='';
        this.jobcard.renter_status='';
        this.images = [];

    },
    add_more(){
        this.jobcard.items.push({
            partno: '',
            qty: '',
            service_id:'',
            rate:'',
            labour:''
        });
    },
    add_more_issues(){

        this.jobcard.customercategories.push({
            category_id: '',
            catremark_id: '',
            catremarks: []
        });
    },
    deleteRow_issues(index) {
        this.jobcard.customercategories.splice(index,1);

    },
    deleteRow(index) {
        this.jobcard.total_pay=parseInt(this.jobcard.total_pay)-parseInt(this.jobcard.items[index].rate);
        this.jobcard.items.splice(index,1);

    },
    amount_cal(id)
    {
        var total=0;
        var discount=0;
        var total_spare=0;
        var total_labour=0;

        for(var i=0;i<this.jobcard.items.length;i++)
        {

            total_spare=total_spare + parseInt(this.jobcard.items[i].rate);
            total=total + parseInt(this.jobcard.items[i].rate);

        }
        if(this.jobcard.discount)
        {
            discount=parseInt(this.jobcard.discount);
            total=total-discount;
        }

        this.jobcard.total_pay=total;
        this.jobcard.total_spare=total_spare;
        this.jobcard.total_labour=total_labour;
        this.jobcard.discount=discount;
    },
    delete_jobcard(id) {

        swal({
            title: "Delete Jobcard?",
            text: "Are you sure you want to delete this Jobcard? This cannot be undone!",
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
                axios.post('/delete_jobcard',{
                    id: id  
                })
                .then(response => {
                    swal.stopLoading();
                    swal.close();
                    swal("Jobcard deleted", "", "success");
                    this.$refs.cancel_btn.click();
                    bus.$emit('jobcard-deleted');
                    this.clear_data();
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
    add_list(id) {

        swal({
            title: "Add to Pending Completion List",
            text: "Are you sure you want to move this Jobcard? to Pending Completion List!",
            icon: "warning",
            buttons: {
                cancel: "No",
                catch: {
                  text: "ok",
                  value: "willDelete",
                  closeModal: false,
              },
          },
          dangerMode: true,
      })
        .then((willDelete) => {
            if(willDelete)
            {
                axios.post('/add_list',{
                    id: id  
                })
                .then(response => {
                    swal.stopLoading();
                    swal.close();
                    swal("Jobcard moved to pending completion list", "", "success");
                    this.$refs.cancel_btn.click();
                    bus.$emit('jobcard-deleted');
                    this.clear_data();
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
    save() {
        let formData = new FormData();
        if(!this.signaturePad.isEmpty())
        {
            this.signature = this.signaturePad.toDataURL("image/jpeg");
            var block = this.signature.split(";");
            var contentType = block[0].split(":")[1];
            var realData = block[1].split(",")[1];
            var blob = this.b64toBlob(realData, contentType);
            formData.append('signature', blob);
        }
        $.each(this.jobcard, (key,value)=>{
            if(Array.isArray(value))
                formData.append(key,JSON.stringify(value));
            else
                formData.append(key,value);
        });

        if(this.company_id)
            var url = '/add_jobcard?company_id='+this.company_id;  
        else
            var url = '/add_jobcard';

        this.loading = true;
        axios.post(url,formData).
        then(response => {
            this.loading = false;
            if(response.data=="Success")
            {
                if(this.type)
                    swal("jobcard Updated", "", "success");
                else
                    swal("jobcard Added Successfully", "", "success");

                // console.log($(".campaignForm").find('.cancel-btn'));
                this.$refs.cancel_btn.click();
                bus.$emit('jobcard-updated');
                this.clear_data();
            }
            else if(response.data=="NoSMS"){
                swal("Low SMS Credit, Please Top Up SMS", "", "error");
            }
            else
            {
                if(this.type)
                    swal("Couldn't update jobcard", response.data, "error");
                else
                    swal("Couldn't add jobcard", response.data, "error");
            }
        }).
        catch(error => {
            console.log(error)
            if(this.type)
                swal("Couldn't update jobcard", "", "error");
            else
                swal("Couldn't add jobcard", "", "error");
            this.loading = false;
            if(error.response.data.errors)
                this.errors  = error.response.data.errors;
            else
                this.errors = '';
        });
    },

    get_models_by_make() {

        var make_id = $(this.$refs.make).children("option:selected").data('id');
        axios.get('/get_models_by_make/'+make_id).then(response => {
            this.models = response.data;
        });
    },   

    get_catremarks_by_category(category_id,index) {
        axios.get('/get_catremarks_by_category/'+category_id).then(response => {
            this.jobcard.customercategories[index].catremarks = response.data;
        });
    },  
    find_customer() {
        var str =  this.jobcard.no.replace(/[^A-Z0-9]/ig, "");
        var data = {};
        if(isNaN(str)) 
            data.register_no = str;
        else
            data.mobile_no = str;

        axios.post('/find_customer',data).
        then(response => {
            if(response.data) {
             console.log(response.data);
             this.jobcard.name = response.data.name;
             this.jobcard.mobile = response.data.mobile;
             this.jobcard.location = response.data.location;
             this.jobcard.make = response.data.make;
             this.jobcard.model = response.data.model;
             this.jobcard.serial_no = response.data.serial_no;
             this.jobcard.customer_voice = response.data.customer_voice;
             this.jobcard.service_type = response.data.service_type;
             this.jobcard.jobadvisor_id = response.data.jobadvisor_id;
             this.$nextTick( function() {
                this.total=this.get_models_by_make();



            })
         } else {
            this.jobcard.serial_no = data.register_no;

            this.jobcard.mobile = data.mobile_no;

        }
    }).
        catch(error => {
        });
    },
    delete_image($event,id) {
        swal({
            title: "Delete Image?",
            text: "Are you sure you want to delete this image? This cannot be undone!",
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
                $($event.target).attr('disabled', 'disabled');
                axios.post('/delete_image',{
                    id: id
                }).
                then(response => {
                    swal.stopLoading();
                    swal.close();
                    $($event.target).parent().remove();
                }).
                catch(error => {
                    swal.stopLoading();
                    swal.close();
                    $($event.target).removeAttr('disabled');
                });
            }
        });
    },
    get_images() {
        this.images = [];
        if(this.company_id)
        {
            var url = '/jobcard/get_images?company_id='+this.company_id;  

        }
        else
        {
         var url = '/jobcard/get_images';
     }
     axios.post(url,{
        jobcard_no: this.jobcard.jobcard_no
    }).
     then(response => {
        this.images = response.data;
    }).
     catch(error => {
     });
 },
 show_preview(image) {
    bus.$emit('preview-image', image)
},
clear_signature() {
    this.signaturePad.clear();
},
b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;
    var byteCharacters = atob(b64Data);
    var byteArrays = []
    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);
        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }
        var byteArray = new Uint8Array(byteNumbers);
        byteArrays.push(byteArray);
    }
    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
},

},


mounted() {
    if(this.type=='edit') {
        bus.$on('edit-jobcard', (jobcard) => {
            this.clear_data();
            this.jobcard.id = jobcard.id;
            this.jobcard.jobcard_no = jobcard.jobcard_no;
            this.jobcard.name = jobcard.name;
            this.jobcard.mobile = jobcard.mobile;
            this.jobcard.location = jobcard.location;
            this.jobcard.make = jobcard.make;
            this.jobcard.item_size = jobcard.item_size;
            this.jobcard.item_type = jobcard.item_type;
            this.jobcard.customercategories = [];
            this.jobcard.model = jobcard.model;
            this.jobcard.serial_no = jobcard.serial_no;
            this.jobcard.customer_voice = jobcard.customer_voice;
            this.jobcard.dealer = jobcard.dealer;
            this.jobcard.discount = jobcard.discount;
            this.jobcard.total_pay = jobcard.total_pay;
            this.jobcard.remarks = jobcard.remarks;
            this.jobcard.reg_status = jobcard.reg_status;
            this.jobcard.technician_status = jobcard.technician_status;
            this.jobcard.service_type = jobcard.service ? jobcard.service.id : '';
            this.jobcard.items = jobcard.jobcards ? _.cloneDeep(jobcard.jobcards) : [];
            this.jobcard.images = jobcard.images ? _.cloneDeep(jobcard.images): [];
            this.jobcard.jobadvisor_id = jobcard.jobadvisor_id;
            this.jobcard.signature_path = jobcard.signature_path;
            this.jobcard.mob_no = jobcard.mob_no;
            this.jobcard.estimate_amount = jobcard.estimate_amount;
            this.jobcard.battery = jobcard.battery;
            this.jobcard.charger = jobcard.charger;
            this.jobcard.sim = jobcard.sim;
            this.jobcard.bag = jobcard.bag;
            this.jobcard.dvd_drive = jobcard.dvd_drive;
            this.jobcard.customer_dead_risk=jobcard.customer_dead_risk;
            this.jobcard.with_warranty=jobcard.with_warranty;
            this.jobcard.without_warranty=jobcard.without_warranty;
            this.jobcard.renter_jobcard_no=jobcard.renter_jobcard_no;
            this.jobcard.renter_status=jobcard.renter_status;
            this.signaturePad.clear();

            this.get_images();
        })
    }
    this.signaturePad = new SignaturePad(this.$refs.canvas, {
        backgroundColor: 'rgb(255,255,255)'
    });

    /*$('#editJobCardModal,#addBookingModal').on('shown.bs.modal', ()=>{
        this.$refs.canvas.width = $(this.$refs.canvas).parent().width();
        this.signaturePad.clear();
    });

    $(window).on('resize', ()=>{
        this.$refs.canvas.width = $(this.$refs.canvas).parent().width();
        this.signaturePad.clear();
    });*/

},
watch:{



}
}
</script>

<style lang="css" scoped>
/*[disabled] {
    background-color: inherit;
    font-weight: bold;
}
*/
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
.imageshow {
    height: 200px;
    width:200px;
    display: inline-block;
    border: 1px solid #ccc;
    padding: 2px;
    margin-right: 15px;
    margin-bottom: 15px;
}

.imageshow img {
    height: 100%;
    width: 100%;
    object-fit: contain;
    object-position: center;
}

.imageshow img:hover {
    cursor: pointer;
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

.signaturePad {
    border: 1px solid #ccc;
}
</style>