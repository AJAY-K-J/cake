<template>
	<div class="row">
		<div class="col-12">
			<div class="table-responsive">
			<table class="custom-table table table-hover">
				<thead>
					<tr>
						<th>Slno</th>
						<th>Name</th>
                        <th>Sender ID</th>
                        <th>API</th>
                        <th>Created At</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(company,index) in companies">
						<td>{{ index+1 }}</td>
						<td>{{ company.name }}</td>
                        <td>{{ company.sms?company.sms.sender_id:"AMOTOR" }}</td>
                        <td>{{ company.sms?company.sms.api:"" }}</td>
                        <td>{{ company.created_at }}</td>
						<td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#companyModal"  @click="view_company(company)">View</button></td>
					</tr>
					<tr v-if="companies.length==0">
						<td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Companies'}}</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="companyModal" data-backdrop="static">
			<div class="modal-dialog mt-5" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">COMPANY DETAILS</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<add-company :edit="true"></add-company>
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

		data () {
			return {
				companies: [],
				loading : false,
				errors  : {},
			}
		},
		created(){
			this.get_companies();
			var vm =this;
			bus.$on('get_companies', function(){
				vm.get_companies();
			});
		},
		methods : {
			get_companies() {
				this.loading = true;
				axios.get('get_companies').
				then(response => {
					this.companies = response.data;
					this.loading = false;
				}).
				catch(err => {
					this.loading = false;
				});
			},

			view_company(company) {
				bus.$emit('view_company',company);
			},

			expiry_date(date) {
				return date ? moment(date).format("DD-MM-YYYY") : '';
			}

		},
	}
</script>

<style lang="css" scoped>

</style>