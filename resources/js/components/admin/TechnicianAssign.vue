<template>
    <div>
        <div style="text-align: center">
            <b>---------- Techinican Assigned History ------------</b>
        </div>
        <br>
        
        <div class="col-md-12" v-if="jobcard.techniciantimings.length>0">
         <div class="table-responsive">
            <table class="table table-bordered" style="background-color: #f5f8fa;">
                <thead>
                   <tr>
                       <th style="min-width:10px">S/N</th>
                       <th style="min-width:150px">Techician</th>
                       <th style="min-width:100px">Start time</th>
                       <th  style="min-width:100px">End Time</th>
                   </tr>
               </thead>
               <tbody>
                <tr v-for="(techniciantiming, index) in jobcard.techniciantimings">
                 <td>{{ index+1 }}</td>
                 <td>
                    
                     {{ techniciantiming.technician?techniciantiming.technician.name:'' }}
                     
                 </td>      
                 <td>
                    {{ convert_date(techniciantiming.start_time)}}
                </td>
                
                <td>
                    {{ techniciantiming.end_time?convert_date(techniciantiming.end_time):'Not Received' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
<form v-on:submit.prevent="save" class="jobCardForm" v-if ="jobcard.reg_status==0">
 
    <div class="col-md-12" v-if="jobcard.technician_status!=1">
        <div class="form-group">
            <label>Select Technician<span class="text-danger">*</span></label>
            <select class="form-control" v-model="jobcard.technician_id" >
                <option value="">Select technician</option>
                <option v-for="technician in technicians" :value="technician.id">{{ technician.name }}</option>
            </select> 
        </div>
    </div>
    <div class="col-md-12" v-else>
        <div class="form-group">
            <label>Technician Assigned Already </label>
            <button class="btn btn-success float-right" type="button" :disabled="loading"  @click="mark_received(jobcard.jobcard_no)" v-if="!company_id">MARK RECEIVED</button>
            <button class="btn btn-light" ref="cancel_btn" v-on:click="clear_data()" type="button" data-dismiss="modal" >Close</button>
        </div>
    </div>
    
    <div class="col-12" v-if="jobcard.technician_status!=1">
     <div  class="form-group">
        

         <button class="btn btn-primary float-right" type="submit" :disabled="loading" v-if ="jobcard.reg_status==0 || company_id" >Save</button>

         <button class="btn btn-light" ref="cancel_btn" v-on:click="clear_data()" type="button" data-dismiss="modal" >Close</button>
         
     </div>
 </div>
</form>

 <br>
 <br>
 <div style="text-align: center">
   <b>-----------------Holding Section------------------</b> 
</div>
<br>

<form v-if ="jobcard.reg_status==0">
    <div class="col-md-12" v-if="jobcard.holding_status==0">
        <div class="form-group" >
            <label>Holding Remarks</label>
            <textarea class="form-control"  v-model="jobcard.holding_remarks" style="text-transform: uppercase;" 
            maxlength="500" required>
            Enter Remarks 
        </textarea>
        <small v-if="errors.remarks">{{ errors.remarks[0] }}</small>
    </div>
    
</div>
<div class="col-md-12" v-if="jobcard.holding_status==1">
    <div class="form-group">
        <label>Item Holded - Holding Remarks</label>
        <br><b>{{jobcard.holding_remarks}}</b>
        
    </div>
</div>
<div class="col-12" v-if="jobcard.holding_status==0">
 <div  class="form-group">
    
  <button  class="btn btn-primary float-right"  type="button" :disabled="loading"  @click="mark_holded(jobcard.jobcard_no,jobcard.holding_remarks)" v-if ="jobcard.reg_status==0 || company_id" >Click to Hold</button>

  

  <button class="btn btn-light" ref="cancel_btn" v-on:click="clear_data()" type="button" data-dismiss="modal" >Close</button>
  
</div>
</div>
<div class="col-12" v-if="jobcard.holding_status==1">
 <div  class="form-group">

     <button class="btn btn-primary float-right"  type="button" :disabled="loading"  @click="release_hold(jobcard.jobcard_no)" v-if ="jobcard.reg_status==0 || company_id" >Release Hold</button>

     <button class="btn btn-light" ref="cancel_btn" v-on:click="clear_data()" type="button" data-dismiss="modal" >Close</button>
     
 </div>
</div>
</form>

 <div style="text-align: center" v-if ="jobcard.reg_status==0">
   <b>-----------------Return Item Section------------------</b> 
</div>
<br>
</form>
<form v-if ="jobcard.reg_status==0">
       <div class="col-12">
           <div class="form-group" >
               <label>Return Remarks</label>
               <textarea class="form-control"  v-model="jobcard.return_remarks" style="text-transform: uppercase;" 
               maxlength="500" required>
               Enter Remarks 
           </textarea>
          
       </div>
       
   </div>
 <div class="col-12">

 <div  class="form-group">
  <span v-if="jobcard.return_status==0" >  
  <button  class="btn btn-primary float-right" style="background-color:red" type="button" :disabled="loading"  @click="mark_return(jobcard.jobcard_no,jobcard.return_remarks)"  >Mark Item Returned</button>
</span>
<span  v-if="jobcard.return_status==1" >
  <button  class="btn btn-primary float-right" style="background-color:red" type="button" :disabled="loading"  @click="mark_returnback(jobcard.jobcard_no)"  >Add to list</button>
</span>
  

 
  

</div>
</div>
</form>




</div>
</template>




<script>
import moment from 'moment';
import Autocomplete from 'vuejs-auto-complete'


export default {
    props: ['type','technicians','company_id'],
    created() {
    },
    data () {
        return {

            jobcard:{
                no: '',
                techniciantimings : [],
                jobcard_no:'',
                technician_id:'',
                holding_remarks:'',
                technician_status:'',
                holding_status:'',
                return_remarks:'',
                return_status:'',
            
            },
            
            images: [],
            image_preview: '',
            models:{},
            catremarks:{},
            loading: false,
            errors: {},

        }
    },
    components: {
        Autocomplete,
    },
    methods : {
        convert_date(date) {
          return moment(date).format('DD-MM-YYYY h:mm:ss a');
      },
      mark_received(jcno) {
          if(this.company_id)
          {
           var url = '/mark_received?company_id='+this.company_id;  

       }
       else
       {
        var url = '/mark_received';
    }
    this.loading = true;
    axios.post(url,{
        jcno: jcno  
    }).
    then(response => {
       this.loading = false;
       if(response.data=="Success")
       {
           
           swal("Received From Technician Successfully", "", "success");
           this.$refs.cancel_btn.click();
           bus.$emit('receive-tech');
           this.clear_data();
       }
       else if(response.data=="NoSMS"){
        swal("Low SMS Credit, Please Top Up SMS", "", "error");
    }
    else
    {
        swal("Couldn't mark received from technician", response.data, "error");
    }
});
},
mark_holded(jcno,holding_remarks) {
 if(this.company_id)
 {
  var url = '/mark_holded?company_id='+this.company_id;  

}
else
{
   var url = '/mark_holded';
}
this.loading = true;
axios.post(url,{
   jcno: jcno,
   holding_remarks:holding_remarks 
}).
then(response => {
  this.loading = false;
  if(response.data=="Success")
  {
      
      swal("Jobcard Moved to Holding", "", "success");
      this.$refs.cancel_btn.click();
      bus.$emit('jobcard-updated');
      this.clear_data();
  }
  
else
{
   swal("Pls add remarks", "", "error");
}
});
},
mark_return(jcno,return_remarks) {
 if(this.company_id)
 {
  var url = '/mark_return?company_id='+this.company_id;  

}
else
{
   var url = '/mark_return';
}
this.loading = true;
axios.post(url,{
   jcno: jcno,
   return_remarks:return_remarks 
}).
then(response => {
  this.loading = false;
  if(response.data=="Success")
  {
      
      swal("Jobcard Moved to Return List", "", "success");
      this.$refs.cancel_btn.click();
      bus.$emit('jobcard-updated');
      this.clear_data();
  }
 
  else
  {
     swal("Pls add remarks", "", "error");
  }
});
},

mark_returnback(jcno) {
 if(this.company_id)
 {
  var url = '/mark_returnback?company_id='+this.company_id;  

}
else
{
   var url = '/mark_returnback';
}
this.loading = true;
axios.post(url,{
   jcno: jcno
}).
then(response => {
  this.loading = false;
  if(response.data=="Success")
  {
      
      swal("Jobcard Moved to PendingList", "", "success");
      this.$refs.cancel_btn.click();
      bus.$emit('jobcard-updated');
      this.clear_data();
  }
 
  else
  {
     swal("Some Error Occured", "", "error");
  }
});
},

release_hold(jcno) {
    if(this.company_id)
    {
     var url = '/release_hold?company_id='+this.company_id;  

 }
 else
 {
  var url = '/release_hold';
}
this.loading = true;
axios.post(url,{
  jcno: jcno
}).
then(response => {
 this.loading = false;
 if(response.data=="Success")
 {
     
     swal("Holding Released Successfully", "", "success");
     this.$refs.cancel_btn.click();
     bus.$emit('jobcard-updated');
     this.clear_data();
 }
 else if(response.data=="NoSMS"){
  swal("Low SMS Credit, Please Top Up SMS", "", "error");
}
else
{
  swal("Couldn't mark received from technician", response.data, "error");
}
});
},
clear_data() {

 
    this.jobcard.reg_status = '';
    this.jobcard.jobadvisor_id='';
    this.jobcard.technician_id='';
    this.jobcard.technician_status='';
    this.jobcard.techniciantimings=[];
    this.jobcard.holding_remarks='';
    this.jobcard.holding_status='';
    this.jobcard.return_remarks='';
    this.jobcard.return_status='';

},

save() {

    if(this.company_id)
    {
        var url = '/add_technician?company_id='+this.company_id;  

    }
    else
    {
     var url = '/add_technician';
 }
 this.loading = true;
 axios.post(url,this.jobcard).
 then(response => {
    this.loading = false;
    if(response.data=="Success")
    {
     
        swal("Technician Assigned Successfully", "", "success");

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
        bus.$on('assign-tech', (jobcard) => 
        {
            this.clear_data();
            this.jobcard.id = jobcard.id;
            this.jobcard.jobcard_no = jobcard.jobcard_no;
            this.jobcard.reg_status = jobcard.reg_status;
            this.jobcard.technician_status = jobcard.technician_status;
            this.jobcard.techniciantimings =_.cloneDeep(jobcard.techniciantimings);
            this.jobcard.technician_status = jobcard.technician_status;
            this.jobcard.service_type = jobcard.service ? jobcard.service.id : '';
            this.jobcard.jobadvisor_id = jobcard.jobadvisor_id;
            this.jobcard.holding_remarks = jobcard.holding_remarks;
            this.jobcard.holding_status = jobcard.holding_status;
            this.jobcard.return_remarks = jobcard.return_remarks;
            this.jobcard.return_status = jobcard.return_status;
            
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