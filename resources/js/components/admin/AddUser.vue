<template>
	<div>
		<form v-on:submit.prevent="save" :id="edit+'userForm'">
			<div class="row">
				<div class="col-12">
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" placeholder="Name" v-model="user.name" required>
						<small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Role</label>
						<select class="form-control" v-model="user.role" required disabled>
							<option value="">Select a role</option>
							<option value="1">Admin</option>
							<option value="2">Service</option>
							<!-- <option v-for="role in roles" :value="role.id">{{ role.name }}</option> -->
						</select>
						<small v-if="errors.role" class="text-danger">{{ errors.role[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" placeholder="Email" v-model="user.email">
						<small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Mobile</label>
						<input type="tel" class="form-control" placeholder="Mobile" v-model="user.mobile">
						<small v-if="errors.mobile" class="text-danger">{{ errors.mobile[0] }}</small>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<h4 class="title mt-2 mb-3 text-center">LOGIN DETAILS</h4>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" placeholder="Username" v-model="user.username" required>
						<small v-if="errors.username" class="text-danger">{{ errors.username[0] }}</small>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Password</label>
						<input type="text" class="form-control" placeholder="Password" v-model="user.password" :required="!edit">
						<small v-if="edit">Leave blank if there is no change</small>
						<small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
					</div>
				</div>
				<div class="col-12" v-if="user.role!=1">
					<div class="form-group">
						<label>Login Status</label>
						<div class="togglebutton">
							<label>
								<input type="checkbox" v-model="user.status">
								<span class="toggle"></span>
								{{ status }}
							</label>
						</div>
					</div>
				</div>
				<div class="col-12 text-center" v-if="user.role==1">
					<small class="text-danger">You cannot disable or delete admin user</small>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-12">
					<div class="form-group">
						<button class="btn btn-danger" type="button" @click="delete_user()" v-if="edit && user.role!=1" :disabled=" user.role==1">Delete</button>
						<button class="btn btn-primary float-right" type="submit" :disabled="loading">Save</button>
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
	props: ['roles','edit'],
	created(){
		if(this.edit)
		{
			var vm = this;
			bus.$on('view_user',function(user) {
				vm.clear_data();
				vm.details = user;
				vm.user.id = user.id;
				vm.user.username = user.username;
				vm.user.password = user.password;
				vm.user.role = user.role_id;
				vm.user.name = user.name;
				vm.user.email = user.email;
				vm.user.mobile = user.mobile;
				if(user.status == 0)
					vm.user.status = true;
				else if(user.status == 1)
					vm.user.status = false;
			});
		}
	},
	data () {
		return {
			details: {},
			user: {
				id: '',
				username: '',
				password: '',
				role: 2,
				name: '',
				email: '',
				status: 'true',
				mobile: '',
			},
			loading: false,
			errors: {},
			status: 'Enabled',
		}
	},
	methods : {
		clear_data() {
			this.user.id = '';
			this.user.username = '';
			this.user.password = '';
			this.user.role = 2;
			this.user.name = '';
			this.user.email = '';
			this.user.status = true;
			this.user.mobile = '';
			this.errors = '';
		},
		save() {
			this.loading = true;
			this.errors = {};
			axios.post('/add_user',this.user)
			.then(response => {
			    this.loading = false;
			    if(response.data=="Success")
			    {
			    	if(this.edit)
                    {
			    		swal("User details updated", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }
			    	else{
			    		swal("User Added Successfully", "", "success");
			    		this.$refs.cancel_btn.click();
			    		this.clear_data();
			    	}
			    	bus.$emit('user-added');
			    }
			    else
			    {
			    	if(this.edit)
			    		swal("Couldn't update user details", "", "error");
			    	else
			    		swal("Couldn't add user", "", "error");
			    }
			})
			.catch(error => {
			    if(this.edit)
			    	swal("Couldn't update user details", "", "error");
			    else
			    	swal("Couldn't add user", "", "error");
				this.loading = false;
				if(error.response.data.errors)
			    	this.errors  = error.response.data.errors;
			    else
			    	this.errors = '';
			});
		},
		delete_user() {
			swal({
			  	title: "Delete User?",
			  	text: "Are you sure you want to delete this user? This cannot be undone!",
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
					axios.post('/delete_user',{
						user_id: this.user.user_id	
					})
					.then(response => {
						swal.stopLoading();
						swal.close();
					    this.$refs.cancel_btn.click();
					    swal("User deleted", "", "success");
					    bus.$emit('user-added');
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
		set_service_center_id() {
			this.user.service_center_id = '';
		}
	},
	mounted() {
	},
	watch: {
		'user.status' : function(){
			if(this.user.status)
				this.status = 'Enabled';
			else
				this.status = 'Disabled';
		},
	}
}
</script>

<style lang="css">
	.multiselect {
		min-height: 36px;
	}

	.multiselect__select {
		height: unset;
		top: 50%;
	}

	.multiselect__tags {
		min-height: 36px;
		padding-top: 0;
		border-radius: 0;
		border: none;
		border-bottom: 1px solid #ccc;
	}

	.multiselect__tag {
		overflow: unset;
		margin-top: 6px;
		margin-bottom: 6px;
	}

	.multiselect__placeholder {
		margin: 5px 0px;
	}

</style>