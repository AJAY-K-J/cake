<template>
	<div>
		<form v-on:submit.prevent="save" class="campaignForm">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Campaign Name<span class="text-danger">*</span></label>
					<input type="text" class="form-control" placeholder="Campaign Name" autocomplete="off" v-model="campaign.name" required :disabled="expired || customers_count!=0">
					<small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="campaign-code">Campaign Code<span class="text-danger">*</span></label>
					<input type="text"  class="form-control" placeholder="Campaign Code" autocomplete="off" v-model="campaign.code" required maxlength="4" :disabled="expired || customers_count!=0">
					<small v-if="errors.code" class="text-danger">{{ errors.code[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Campaign Type<span class="text-danger">*</span></label>
					<select class="form-control" v-model="campaign.type" required :disabled="expired || customers_count!=0">
						<option value="">Select campaign type</option>
						<option v-for="(campaign_type,index) in campaign_types" :value="index">{{ campaign_type }}</option>
					</select>
					<small v-if="errors.type" class="text-danger">{{ errors.type[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Net Allocated Discount</label>
					<input type="number" class="form-control" placeholder="Net Allocated Discount" autocomplete="off" v-model="campaign.amount">
					<small v-if="errors.amount">{{ errors.amount[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>From Date<span class="text-danger">*</span></label>
					<input type="date" class="form-control capitalize" placeholder="From Date" autocomplete="off" v-model="campaign.from_date" max="campaign.to_date" required :disabled="expired || customers_count!=0">
					<small v-if="errors.from_date" class="text-danger">{{ errors.from_date[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>To Date<span class="text-danger">*</span></label>
					<input type="date" class="form-control" placeholder="To Date" autocomplete="off" v-model="campaign.to_date" :min="campaign.from_date" required :disabled="expired || customers_count!=0">
					<small v-if="errors.to_date" class="text-danger">{{ errors.to_date[0] }}</small>
				</div>
			</div>
			<div class="col-12">
				<div class="text-center mb-3">
					<label class="day-checkbox">
					    <input type="checkbox" v-model="all_days" :disabled="expired || customers_count!=0 || campaign.days.length==0">
					    <span class="day-label all-days" >ALL DAYS</span>
					</label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="0" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">SUNDAY</span>
				    </label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="1" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">MONDAY</span>
				    </label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="2" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">TUESDAY</span>
				    </label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="3" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">WEDNESDAY</span>
				    </label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="4" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">THURSDAY</span>
				    </label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="5" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">FRIDAY</span>
				    </label>
				    <label class="day-checkbox">
				        <input type="checkbox" value="6" v-model="campaign.days" :disabled="expired || customers_count!=0">
				        <span class="day-label" :class="{'fade-label' : all_days}">SATURDAY</span>
				    </label>
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<label>Service Type<span class="text-danger">*</span></label>
					<select class="form-control" v-model="campaign.service_type" required :disabled="expired || customers_count!=0">
						<option value="">Select service type</option>
						<option v-for="service in services" :value="service.id">{{ service.name }}</option>
					</select>
					<small v-if="errors.service_type" class="text-danger">{{ errors.service_type[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Discount Type<span class="text-danger">*</span></label>
					<select class="form-control" v-model="campaign.discount_type" required :disabled="expired || customers_count!=0">
						<option value="">Select discount type</option>
						<option value="1">PERCENTAGE</option>
						<option value="2">FLAT</option>
					</select>
					<small v-if="errors.discount_type" class="text-danger">{{ errors.discount_type[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>{{ discount_label }} <span class="text-danger">*</span></label>
					<input type="number" class="form-control" v-model="campaign.discount_amount" step="0.01" :placeholder="discount_label" required :disabled="expired || customers_count!=0">
					<small v-if="errors.discount_amount" class="text-danger">{{ errors.discount_amount[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Initiated By</label>
					<input type="text"  class="form-control" v-model="campaign.initiated_by" placeholder="Initiated By">
					<small v-if="errors.initiated_by">{{ errors.initiated_by[0] }}</small>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Approved By</label>
					<input type="text"  class="form-control" v-model="campaign.approved_by" placeholder="Approved By">
					<small v-if="errors.approved_by">{{ errors.approved_by[0] }}</small>
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<label>Template<span class="text-danger">*</span></label>
					<small>You can use variables <b>#NAME#</b>, <b>#REGNO#</b> and <b>#REFERRAL#</b> to create the <b>SMS/Voucher</b> template for Campaign.</small>
					<textarea type="text" class="form-control" placeholder="Template" rows=5 required v-model="campaign.template" :disabled="expired || customers_count!=0"></textarea>
					<small><b>Preview: </b><br><span v-html="preview" style="white-space: pre-wrap"></span></small>
					<small v-if="errors.template" class="text-danger">{{ errors.template[0] }}</small>
				</div>
			</div>
			<div class="col-12" :class="{ 'd-none': campaign.type!=3 }">
				<div class="form-group bmd-form-group">
					<label class="bmd-label-static">SME Template</label>
					<small>Leave this blank if you do not want to send SMS from SME application</small>
					<textarea type="text" class="form-control" placeholder="SME Template" rows=5 v-model="campaign.sme_template" :disabled="expired || customers_count!=0"></textarea>
					<small v-if="errors.sme_template" class="text-danger">{{ errors.sme_template[0] }}</small>
				</div>
			</div>
			<div class="col-12">
				<div class="form-group">
					<small v-if="expired" class="text-danger">Cannot update or delete expired campaigns</small>
					<small v-else-if="customers_count" class="text-danger">Cannot update or delete campaigns that have customers in it</small>
					<button v-if="edit && !expired && !customers_count" class="btn btn-danger" type="button" @click="delete_campaign">Delete</button>
					<button v-if="!expired && !customers_count" class="btn btn-primary float-right" type="submit" :disabled="loading || expired">Save</button>
					<button class="btn btn-light float-right mr-2" ref="cancel_btn" data-dismiss="modal" @click="clear_data()" type="button">Close</button>
				</div>
			</div>
		</div>
		</form>
	</div>
</template>

<script>
import moment from 'moment';


export default {
	props: ['services','edit','expired','campaign_types'],
	created() {
		if(this.edit)
		{
			var vm = this;
			bus.$on('view_campaign',function(campaign) {
				vm.campaign.campaign_id = campaign.campaign_id;
				vm.campaign.name = campaign.name;
				vm.campaign.code = campaign.code;
				vm.campaign.type = campaign.type;
				vm.campaign.amount = campaign.amount;
				vm.campaign.from_date = campaign.from_date;
				vm.campaign.to_date = campaign.to_date;
				vm.campaign.service_type = campaign.service_type ? campaign.service_type.id : '';
				vm.campaign.discount_type = campaign.discount_type;
				vm.campaign.discount_amount = campaign.discount_amount;
				vm.campaign.initiated_by = campaign.initiated_by;
				vm.campaign.approved_by = campaign.approved_by;
				vm.campaign.template = campaign.template;
				vm.campaign.sme_template = campaign.sme_template;
				vm.customers_count = campaign.customers_count;
				vm.campaign.days = campaign.days ? campaign.days.split(',') : [];
			});
		}
	},
	data () {
		return {
			campaign: {
				campaign_id: '',
				name: '',
				code: '',
				type: '',
				amount: '',
				from_date: moment().format('YYYY-MM-DD'),
				to_date: moment().format('YYYY-MM-DD'),
				service_type: '',
				discount_type: '',
				discount_amount: '',
				initiated_by: '',
				approved_by: '',
				template: '',
				sme_template: '',
				days: [],
			},
			all_days: true,
			customers_count: '',
			preview : '',
			discount_label: 'Discount Amount',
			loading: false,
			errors: {},

		}
	},
	methods : {
		clear_data() {
			this.campaign.employee_id = '';
			this.campaign.name = '';
			this.campaign.code = '';
			this.campaign.type = '';
			this.campaign.amount = '';
			this.campaign.from_date = moment().format('YYYY-MM-DD');
			this.campaign.to_date = moment().format('YYYY-MM-DD');
			this.campaign.service_type = '';
			this.campaign.discount_type = '';
			this.campaign.discount_amount = '';
			this.campaign.initiated_by = '';
			this.campaign.approved_by = '';
			this.campaign.template = '';
			this.campaign.sme_template = '';
			this.campaign.days = [];
			this.errors = '';
			this.discount_label= 'Discount Amount';
		},
		save() {
			if(this.expired || this.customers_count)
				return false;
			this.loading = true;
			axios.post('/add_campaign',this.campaign).
			then(response => {
			    this.loading = false;
			    if(response.data=="Success")
			    {
			    	if(this.edit)
			    		swal("Campaign Updated", "", "success");
			    	else
			    		swal("Campaign Added Successfully", "", "success");

			    	// console.log($(".campaignForm").find('.cancel-btn'));
			    	this.$refs.cancel_btn.click();
			    	bus.$emit('campaign-updated');
			    	this.clear_data();
			    }
			    else
			    {
			    	if(this.edit)
			    		swal("Couldn't update campaign", response.data, "error");
			    	else
			    		swal("Couldn't add campaign", response.data, "error");
			    }
			}).
			catch(error => {
			    if(this.edit)
			    	swal("Couldn't update campaign", "", "error");
			    else
			    	swal("Couldn't add campaign", "", "error");
				this.loading = false;
				if(error.response.data.errors)
			    	this.errors  = error.response.data.errors;
			    else
			    	this.errors = '';
			});
		},
		get_preview(){
			this.preview = this.campaign.template;
			this.preview = this.preview.replace("#NAME#", "Mr. John");
			this.preview = this.preview.replace("#REGNO#", "KL 10 9999");
			this.preview = this.preview.replace("#REFERRAL#", this.campaign.code+"123456");
			this.preview = this.preview.replace("#CENTER#", "Malappuram");
			this.preview = this.preview.replace("#CRM#", "1580336469");
		},
		delete_campaign() {
			swal({
			  	title: "Delete Campaign?",
			  	text: "Are you sure you want to delete this campaign? This cannot be undone!",
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
					axios.post('/delete_campaign',{
						campaign_id: this.campaign.campaign_id	
					})
					.then(response => {
						swal.stopLoading();
						swal.close();
					    
					    if(response.data == 'Success')
					    {
					    	swal("Campaign deleted", "", "success");
					    	bus.$emit('campaign-updated');
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
		}
	},
	mounted() {
	},
	watch: {
		'campaign.discount_type' : function(){
			this.discount_label =  this.campaign.discount_type == 1 ? 'Discount Percentage' : this.campaign.discount_type == 2 ? 'Discount Amount' : 'Discount Amount';
		},
		'campaign.template' : function(){
			this.get_preview();
		},
		'campaign.code' : function(){
			this.campaign.code = this.campaign.code.toUpperCase();
			this.get_preview();
		},
        'campaign.name' : function(){
            this.campaign.name = this.campaign.name.toUpperCase();
           
        },
        'campaign.initiated_by' : function(){
            this.campaign.initiated_by = this.campaign.initiated_by.toUpperCase();
           
        },
        'campaign.approved_by' : function(){
            this.campaign.approved_by = this.campaign.approved_by.toUpperCase();
           
        },
		'campaign.days' : function() {
			this.all_days = this.campaign.days && this.campaign.days.length > 0 ? false : true;
		},
		'all_days' : function() {
			if(this.all_days==true)
				this.campaign.days = [];
		}
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