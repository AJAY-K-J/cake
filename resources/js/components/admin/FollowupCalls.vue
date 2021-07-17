<template>
    <div>
        <div style="text-align: center">
            <b>---------- FollowUp Calls History ------------</b>
        </div>
        <br>
        
        <div class="col-md-12" v-if="jobcard.followupcalls.length>0">
         <div class="table-responsive">
            <table class="table table-bordered" style="background-color: #f5f8fa;">
                <thead>
                   <tr>
                       <th style="min-width:10px">S/N</th>
                       <th style="min-width:150px">Date</th>
                       <th style="min-width:100px">Call Status</th>
                       <th  style="min-width:100px">Remarks</th>
                   </tr>
               </thead>
               <tbody>
                <tr v-for="(followup, index) in jobcard.followupcalls">
                 <td>{{ index+1 }}</td>
                 <td>
                    
                     {{ convert_date(followup.created_at) }}
                     
                 </td>      
                 <td>
                    {{ followup.call_status}}
                </td>
                
                <td>
                    {{ followup.remarks }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
<form v-on:submit.prevent="save" class="jobCardForm">
 
    <div class="col-md-12">
        <div class="form-group">
            <label>Select Call Status<span class="text-danger">*</span></label>
            <select class="form-control" v-model="jobcard.call_status" required>
              
              <option disabled value="">Please select one</option>
                                  <option>Switched Off</option>
                                  <option>Not Reachable</option>
                                  <option>Busy</option>
                                  <option>Call Not Attended</option>
                                  <option>Call Attended</option>
            </select> 
        </div>
    </div>
    
    
    <div class="col-md-12">
        <div class="form-group">
            <label>Enter Remarks<span class="text-danger">*</span></label>
             <input type="text" class="form-control" placeholder="Enter Call Remarks" autocomplete="on" v-model="jobcard.call_remarks" required>
          <small v-if="errors.call_remarks" class="text-danger">{{ errors.call_remarks[0] }}</small>
        </div>
    </div>
    <div class="col-12" >
     <div  class="form-group">
        

         <button class="btn btn-primary float-right" type="submit" :disabled="loading" >Save</button>

         <button class="btn btn-light" ref="cancel_btn" v-on:click="clear_data()" type="button" data-dismiss="modal" >Close</button>
         
     </div>
 </div>
</form>


</div>
</template>




<script>
import moment from 'moment';
import Autocomplete from 'vuejs-auto-complete'


export default {
    props: ['type','company_id'],
    created() {
    },
    data () {
        return {

            jobcard:{
                no: '',
                followupcalls : [],
                jobcard_no:'',
                call_status:'',
                call_remarks:'',
            
            },
            loading: false,
            errors: {},

        }
    },
    components: {
        Autocomplete,
    },
    methods :
    {
        convert_date(date) {
          return moment(date).format('DD-MM-YYYY h:mm:ss a');
        },
     
        clear_data() {
          
    
            this.jobcard.followupcalls=[];
            this.jobcard.call_remarks='';
            this.jobcard.call_status='';
    

        },

save() {

    if(this.company_id)
    {
        var url = '/add_followup?company_id='+this.company_id;  

    }
    else
    {
     var url = '/add_followup';
 }
 this.loading = true;
 axios.post(url,this.jobcard).
 then(response => {
    this.loading = false;
    if(response.data=="Success")
    {
     
        swal("Followup Added Successfully", "", "success");

                    // console.log($(".campaignForm").find('.cancel-btn'));
                    this.$refs.cancel_btn.click();
                    bus.$emit('jobcard-updated');
                    this.clear_data();
                }
                else
                {
                   
                        swal("Please Select Technician", response.data, "error");
                  
                }
            }).
 catch(error => {
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


},

mounted() {
    if(true) 
    {
        bus.$on('follow-up', (jobcard) => 
        {
            this.clear_data();
            this.jobcard.id = jobcard.id;
            this.jobcard.jobcard_no = jobcard.jobcard_no;
            this.jobcard.reg_status = jobcard.reg_status;
            this.jobcard.followupcalls =_.cloneDeep(jobcard.followupcalls);
            
        })
    }
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


</style>