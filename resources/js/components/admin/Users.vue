<template>
	<div class="row">
		<div class="col-12">
			<div class="table-responsive">
			<table class="custom-table table table-hover">
				<thead>
					<tr>
						<th>Slno</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Username</th>
						<th>Status</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(user,index) in users">
						<td>{{ index+1 }}</td>
						<td>{{ user.name }}</td>
						<td>{{ user.email }}</td>
						<td>{{ user.role ? user.role.name : '' }}</td>
						<td>{{ user.username }}</td>
						<td>
							<div v-if="user.status==0" class="text-success">Enabled</div>
							<div v-else-if="user.status==1" class="text-danger">Disabled</div>
						</td>
						<td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#userModal"  @click="view_user(user)">View</button></td>
						
					</tr>
					<tr v-if="users.length==0">
						<td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Users'}}</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="userModal" data-backdrop="static">
			<div class="modal-dialog mt-5" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">USER DETAILS</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<add-user :roles="roles" :edit="true"></add-user>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import moment from 'moment';

	export default {
		props:['roles'],
		created(){
			this.get_users();
			var vm =this;
			bus.$on('user-added', function(){
				vm.get_users();
			});
		},
		data () {
			return {
				users: {},
				loading : false,
				errors  : {},
			}
		},
		methods : {
			get_users() {
				this.loading = true;
				axios.get('get_users').
				then(response => {
					this.users = response.data;
					this.loading = false;
				}).
				catch(err => {
					this.loading = false;
				});
			},

			view_user(user) {
				bus.$emit('view_user',user);
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
			}

		},
	}
</script>

<style lang="css" scoped>

</style>