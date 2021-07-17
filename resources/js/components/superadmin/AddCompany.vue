<template>
	<div>
		<form v-on:submit.prevent="save" ref="companyForm">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Company Name<span class="text-danger">*</span></label>
						<input type="text" class="form-control" placeholder="Name" v-model="company.company_name" required>
						<small v-if="errors.company_name" class="text-danger">{{ errors.company_name[0] }}</small>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>Logo</label>
						<div class="custom-file">
							<label>
								<input type="file" class="custom-file-input" ref="logo" required accept=".jpg,.jpeg,.png" :required="company.id == ''" @change="handleFileChanage">
								<span class="custom-file-label">Choose logo</span>
							</label>
						</div>
						<small v-if="edit">Leave blank if there is no change</small>
						<img :src="logo" class="logo" v-if="logo">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h4 class="title mt-2 mb-3 text-center">SMS SETTINGS</h4>
				</div>
				<div class="col-12 text-center">
					<div class="form-check">
						<label class="form-check-label font-weight-bold">
							<input class="form-check-input" type="checkbox" v-model="company.default_sms_settings">
							Use default SMS settings
							<span class="form-check-sign">
								<span class="check"></span>
							</span>
						</label>
					</div>
				</div>
			</div>
			<div class="row" v-if="!company.default_sms_settings">
				<div class="col-md-6">
					<div class="form-group">
						<label>SMS Username<span class="text-danger" v-if="!company.default_sms_settings"> </span></label>
						<input type="text" class="form-control" placeholder="SMS Username" v-model="company.sms_username"  
                        :disabled="company.default_sms_settings">
						<small v-if="errors.sms_username" class="text-danger">{{ errors.sms_username[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">

						<label>SMS Password<span v-if="!company.default_sms_settings"> </span></label>
						<input type="text" class="form-control" placeholder="SMS Password" v-model="company.sms_password" :disabled="company.default_sms_settings">
						<div><small v-if="errors.sms_password" class="text-danger">{{ errors.sms_password[0] }}</small></div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>SMS Sender ID<span v-if="!company.default_sms_settings">*</span></label>
						<input type="text" class="form-control" placeholder="SMS Sender ID" v-model="company.sms_sender_id" :required="!company.default_sms_settings" :disabled="company.default_sms_settings" size="6">
						<div><small v-if="errors.sms_sender_id" class="text-danger">{{ errors.sms_sender_id[0] }}</small></div>
					</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>SMS API<span class="text-danger" v-if="!company.default_sms_settings">*</span></label>
                        <input type="text" class="form-control" placeholder="SMS API" v-model="company.sms_api" :required="!company.default_sms_settings" :disabled="company.default_sms_settings" size="200">
                        <div><small v-if="errors.sms_api" class="text-danger">{{ errors.sms_api[0] }}</small></div>
                    </div>
                </div>
			</div>
			<div class="row">
				<div class="col-12">
					<h4 class="title mt-2 mb-3 text-center">ADMIN EMPLOYEE DETAILS</h4>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>Name<span class="text-danger">*</span></label>
						<input type="text" class="form-control" placeholder="Name" v-model="company.admin_name" required>
						<small v-if="errors.admin_name" class="text-danger">{{ errors.admin_name[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Mobile No</label>
						<input type="number" class="form-control" placeholder="Mobile No" v-model="company.mobile" length="10">
						<small v-if="errors.mobile" class="text-danger">{{ errors.mobile[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" placeholder="Email" v-model="company.email">
						<small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h4 class="title mt-2 mb-3 text-center">ADMIN LOGIN DETAILS</h4>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Username<span class="text-danger">*</span></label>
						<input type="text" class="form-control" placeholder="Username" v-model="company.username" required>
						<small v-if="errors.username" class="text-danger">{{ errors.username[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Password<span class="text-danger" v-if="!edit">*</span></label>
						<input type="text" class="form-control" placeholder="Password" v-model="company.password" :required="!edit">
						<div><small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small></div>
						<small v-if="edit">Leave blank if there is no change</small>
					</div>
				</div>
				<div class="col-12"><small><span class="text-danger">*</span> Mandatory fields</small></div>
			</div>
			<div class="row mt-4">

				<div class="col-12">
					<div class="form-group">
						<button class="btn btn-danger" type="button" @click="delete_company()" v-if="edit" :disabled="company.company_type==0">Delete</button>
						<button class="btn btn-primary float-right" type="submit" :disabled="loading">{{ loading ? 'Saving' : 'Save' }}</button>
						<button class="btn btn-light float-right mr-2" data-dismiss="modal" @click="clear_data()" ref="cancel_btn" type="button">Close</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
import moment from 'moment';

export default {
	props: {
		edit: {
			type: Boolean,
			default: false
		}
	},
	created(){
		var vm = this;
		if(this.edit)
		{
			bus.$on('view_company',function(company) {
				vm.clear_data();
				vm.company.id = company.id;
				vm.company.company_name = company.name;
				if(company.logo) {

					vm.logo = '/storage/'+company.logo;
				}
				vm.current_logo = vm.logo;

				vm.company.user_id = _.get(company, 'admin.id', '');
				vm.company.admin_name = _.get(company, 'admin.name', '');
				vm.company.mobile = _.get(company, 'admin.mobile', '');
				vm.company.email = _.get(company, 'admin.email', '');

				vm.company.username = _.get(company, 'admin.username', '');
				vm.company.password = '';

				vm.company.sms_username = _.get(company, 'sms.username', '');
				vm.company.sms_password = _.get(company, 'sms.password', '');
				vm.company.sms_sender_id = _.get(company, 'sms.sender_id', '');
                vm.company.sms_api = _.get(company, 'sms.api', '');
				vm.company.default_sms_settings = company.sms ? false : true;

			});
		}

		bus.$on('clear_data', function() {
			vm.clear_data();
		});

	},
	data () {
		return {
			company: {
				id: '',
				company_name : '',
				user_id : '',
				admin_name : '',
				mobile : '',
				email : '',
				username : '',
				password : '',
				sms_sender_id : '',
				sms_username : '',
                sms_api : '',
				sms_password : '',
				default_sms_settings: false,
			},
			logo: '',
			current_logo: '',
			loading: false,
			errors: {},
			status: 'Enabled',
		}
	},
	methods : {
		clear_data() {
			this.company.id = '';
			this.company.company_name = '';
			this.company.user_id = '';
			this.company.admin_name = '';
			this.company.mobile = '';
			this.company.email = '';
			this.company.username = '';
			this.company.password = '';
			this.company.sms_sender_id = '';
			this.company.sms_username = '';
			this.company.sms_password = '';
            this.company.sms_api = '';
			this.company.default_sms_settings = false;
			this.errors = {};
			this.logo = '';
			this.current_logo = '';
			this.loading = false;
			this.$refs.companyForm.reset();
			this.handleFileChanage();
		},
		handleFileChanage() {
			this.company.logo = this.$refs['logo'].files[0];
			var name = "Choose File"
			if(this.company.logo) {
				name = this.company.logo.name;
				var reader = new FileReader();
				var vm = this;
				reader.onload = function (e) {
					vm.logo = e.target.result;
				};
				reader.readAsDataURL(this.company.logo);
			}
			else {
				this.logo = this.current_logo;
				this.company.logo = '';
			}
			$(".custom-file-label").text(name);
		},
		save() {
			this.loading = true;
			this.errors = {};

			let formData = new FormData();
			_.forEach(this.company, function(value, key) {
				if(value)
					formData.append(key, value);
			});

			axios.post('/add_company',formData)
			.then(response => {
				this.loading = false;
				if(response.data.status==1) {
					if(this.edit)
						swal("Company details updated", "", "success");
					else {
						swal("Company Added Successfully", "", "success");
						this.$refs.cancel_btn.click();
						this.clear_data();
					}
					bus.$emit('get_companies');
				}
				else {
					if(this.edit)
						swal("Couldn't update company details", "", "error");
					else
						swal("Couldn't add company", "", "error");
				}
			})
			.catch(error => {
				if(this.edit)
					swal("Couldn't update company details", "", "error");
				else
					swal("Couldn't add company", "", "error");
				this.loading = false;
				this.errors  = _.get(error,'response.data.errors',{});
			});
		},
		delete_company() {
			swal({
				title: "Delete Company?",
				text: "Are you sure you want to delete this company? This cannot be undone!",
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
					axios.post('/delete_company',{
						id: this.company.id	
					})
					.then(response => {
						swal.stopLoading();
						swal.close();
						if(response.data.status==1) {
							this.$refs.cancel_btn.click();
							swal("Company deleted", "", "success");
							bus.$emit('get_companies');
						} 
						else {
							swal("Couldn't delete company", "", "error");
						}
					}).
					catch(error => {
						swal.stopLoading();
						swal.close();
						this.errors  = _.get(error,'response.data.errors',{});
						swal("Couldn't delete company", "", "error");
						this.loading = false;
					});
				}
			});
		},
	},
	mounted() {

	},
	watch: {

	}
}
</script>

<style scoped>

.logo {
	display: block;
	margin: 20px auto 0 auto;
	width: 300px;
	height: 100px;
	object-fit: contain;
	object-position: center;
}

.form-check-label {
	color: black !important;
}
</style>
