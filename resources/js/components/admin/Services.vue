<template>
	<div class="row">
		<div class="col-12">
			<div class="table-responsive">
			<table class="custom-table table table-hover">
				<thead>
					<tr>
						<th>Slno</th>
						<th>Service</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(service,index) in services">
						<td>{{ index+1 }}</td>
						<td>{{ service.name }}</td>
						<td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#serviceModal"  @click="edit_service(service)">Edit</button></td>
						<td><button class="btn btn-danger btn-sm m-0" @click="delete_service(service.id)">Delete</button></td>
					</tr>
					<tr v-if="services.length==0">
						<td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Services'}}</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="serviceModal" data-backdrop="static">
			<div class="modal-dialog mt-5" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">EDIT SERVICE</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<add-service :edit="true"></add-service>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
	import moment from 'moment';

	export default {
		props:[],
		created(){
			this.get_services();
			var vm =this;
			bus.$on('service-added', function(){
				vm.get_services();
			});
		},
		data () {
			return {
				services: {},
				loading : false,
				errors  : {},
			}
		},
		methods : {
			get_services() {
				this.loading = true;
				axios.get('get_services').
				then(response => {
					this.services = response.data;
					this.loading = false;
				}).
				catch(err => {
					this.loading = false;
				});
			},

			edit_service(service) {
				bus.$emit('edit-service',service);
			},

			delete_service(id) {
				swal({
				  	title: "Delete Service?",
				  	text: "Are you sure you want to delete this service? This cannot be undone!",
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
						axios.post('/delete_service',{
							id: id	
						})
						.then(response => {
							swal.stopLoading();
							swal.close();
						    swal("Service deleted", "", "success");
						    this.get_services();
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