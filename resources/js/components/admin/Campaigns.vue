<template>
	<div class="row">
		<div class="nav-tabs-navigation mb-4">
			<div class="nav-tabs-wrapper">
				<ul class="nav nav-pills nav-pills-primary" data-tabs="pills">
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" @click="type='active'" :class="{'active' : type=='active'}">Active Campaigns</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" @click="type='expired'" :class="{'active' : type=='expired'}">Expired Campaigns</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-12">
			<div class="table-responsive">
				<table class="custom-table table table-hover">
					<thead>
						<tr>
							<th>Sl.No</th>
							<th>Campaign Name</th>
							<th>Code</th>
							<th>Type</th>
							<th>From</th>
							<th>To</th>
							<th>Service Type</th>
							<th>Campaign Budget</th>
							<th>Discount Offered</th>
							<th>Discount Type</th>
							<th>Sent Count</th>
							<th>Redeemed Count</th>
							<th>Redeemed %</th>
							<th>View</th>
							<th v-if="type == 'active'">Import</th>
							<th>Download</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(campaign,index) in campaigns">
							<td>{{ index+1 }}</td>
							<td>{{ campaign.name }}</td>
							<td>{{ campaign.code }}</td>
							<td>
								{{ campaign_types[campaign.type] }}
							</td>
							<td class="nowrap">{{ convert_date(campaign.from_date) }}</td>
							<td class="nowrap">{{ convert_date(campaign.to_date) }}</td>
							<td>{{ campaign.service ? campaign.service.name : '' }}</td>
							<td>{{ campaign.amount?campaign.amount:"NA" }}</td>
							<td><span v-if="campaign.discount_type==2">&#8377 </span>{{ parseFloat(campaign.discount_amount) }}<span v-if="campaign.discount_type==1">%</span></td>
							<td>
								<div v-if="campaign.discount_type==1">Percentage</div>
								<div v-else-if="campaign.discount_type==2">Flat</div>
							</td>
							<td>{{ campaign.customers_count }}</td>
							<td>{{ campaign.redeemed_customers_count }}</td>
							<td>{{ campaign.customers_count ? (campaign.redeemed_customers_count/campaign.customers_count*100).toFixed(2) : 0 }}%</td>
							<td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#campaignModal"  @click="view_campaign(campaign)">View</button></td>
							<td v-if="type == 'active'"><button class="btn btn-danger btn-sm m-0" data-toggle="modal" data-target="#importModal" @click="show_import_modal(campaign.id,campaign.name,campaign.code,campaign.type)">Import</button></td>
							<td><a :href="'/campaigns/download_customers/'+campaign.campaign_id" class="btn btn-info btn-sm m-0"><i class="material-icons mr-2">save_alt</i>Download</a></td>
						</tr>
						<tr v-if="campaigns.length==0">
							<td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Campaigns'}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="campaignModal" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">CAMPAIGN DETAILS</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<add-campaign :services="services" :edit="true" :expired="expired" :campaign_types="campaign_types"></add-campaign>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="importModal" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">IMPORT</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form v-on:submit.prevent="upload_file" id="importForm">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label>Choose File</label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="importFile" required accept=".xlsx,.xls,.csv">
											<label class="custom-file-label" for="importFile">Choose file</label>
										</div>
										<small v-if="file_import.type == 1"><i class="fa fa-exclamation-circle text-warning mr-1"></i>SMS will be sent automatically</small>
									</div>
								</div>
								<div class="col-12" v-if="duplicates">
									<div class="form-group">
										<div class="text-danger"><b>Duplicate Entries:</b></div>
										{{ duplicates }}
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<button class="btn btn-primary float-right" type="submit" :disabled="uploading">{{ uploading ? 'Uploading...' : 'Upload' }}</button>
										<button class="btn btn-light float-right mr-2 cancel-btn" data-dismiss="modal" @click="clear_data()" type="reset" id="cancel-import-btn">Close</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment';

export default {
	/*mixins:[mixins],*/  /*props:['PROPERTY'],*/
	props: ['campaign_types','services'],
	watch: {
		type : function() {
			this.get_campaigns();
		}
	},
	created(){
		this.get_campaigns();
		if(this.type == 'expired')
			this.expired = true;
		var vm =this;
		bus.$on('campaign-updated', function(){
			vm.get_campaigns();
		});			
	},
	data () {
		return {
			type: 'active',
			campaigns: {},
			loading : false,
			uploading : false,
			errors  : {},
			file: '',
			expired: false,
			file_import: {
				id: '',
				name: '',
				code: '',
				file: '',
				type: '',
			},
			duplicates : '',
		}
	},
	methods : {
		get_campaigns() {
			this.loading = true;
			this.campaigns = [];
			axios.get('/get_campaigns',{
				params : {
					type: this.type
				}
			}).
			then(response => {
				this.campaigns = response.data;
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
			$('#importForm')[0].reset();
			this.duplicates = '',
			$("#importFile").change();
		},
		show_import_modal(id,name,code,type) {
			this.file_import.id = id;
			this.file_import.name = name;
			this.file_import.code = code;
			this.file_import.type = type;
		},
		upload_file(){
			let formData = new FormData();
			formData.append('name', this.file_import.name);
			formData.append('code', this.file_import.code);
			formData.append('id', this.file_import.id);
			formData.append('customers', document.getElementById('importFile').files[0]);
			this.uploading = true;
			this.duplicates = '';
			axios.post("/campaigns/import_customers", formData)
			.then(response => {
				this.uploading = false;
				if (response.data.status == 1) {
					swal("Customers added", "", "success");

					if(response.data.duplicates.length>0)
						this.duplicates = response.data.duplicates.join(', ');
					else{
						this.clear_data();
						$("#cancel-import-btn").click();
					}

					if(response.data.pdf)
					{
						window.open("/download_voucher/"+response.data.pdf)
					}

					this.get_campaigns();
				} else {
					swal(response.data.response,"", "error");
				}
			})
			.catch(error => {
				this.uploading = false;
				swal("Couldn't add customers", "", "error");
			});
		},
		view_campaign(campaign) {
			bus.$emit('view_campaign',campaign);
		}
	},
	mounted() {
		$(".table-responsive").floatingScroll();
		$("#importModal").on('hide.bs.modal', ()=>{
			this.clear_data();
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
</style>