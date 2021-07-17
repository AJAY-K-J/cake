<template>

	<div class="container-fluid">
		<div class="card ">
			<div class="card-body">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label>Service</label>
							<select class="form-control"  v-model="shiner.service_id">
								<option selected  value=''>Choose a service</option>
								<option  v-for="service in service_selct" :value="service.id">{{ service.name }}</option>
							</select> 
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>From Date</label>
							<input type="date" placeholder="From Date" autocomplete="off"  required="required" v-model="shiner.from" class="form-control" :max="shiner.to">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>To Date</label>
							<input type="date" placeholder="To Date" autocomplete="off" required="required" v-model="shiner.to" class="form-control" :min="shiner.from">
						</div>
					</div>
					<div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
						<button @click="get_data" class="btn btn-block btn-success btn-sm m-0 mr-md-2">Filter</button>
					</div>
					<div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
						<button @click="clear_filter"  class="btn btn-block btn-info btn-sm m-0">Clear Filters</button>
					</div>
					<div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
						<a :href="`/reports/campaigns/data?campaign_id=${shiner.campaign_id}&from=${shiner.from}&to=${shiner.to}&export=true`"  class="btn btn-block btn-primary btn-sm m-0" target="_blank">Download</a>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table id="report-table" class="table custom-table" style="width:100%">
				<thead>
					<tr>
						<th>Sl#</th>
						<th>Service Name</th>
						<th class="nosearch">Total Bookings</th>
						<th class="nosearch">Conversion Count</th>
						<th class="nosearch">Conversion %</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
import moment from 'moment';
import mixins from '../../mixins/jarvis';
import DataTable from 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
	mixins:[mixins],  props:['service_selct'],
	created(){
	},
	mounted() {
		var vm = this
		this.table = $("#report-table").DataTable({
			ajax: {
				url: "/reports/services/data",
				type: "GET",
				dataSrc: '',
				data: function(d) {
					d.from = vm.shiner.from;
					d.to = vm.shiner.to;
					d.service_id = vm.shiner.service_id;
				},
			},
			columns: [
			{
				render: function(data, type, row, meta) {
					return '';
				},
			},
			{ data: 'name' },
			{ data: 'total_bookings' },
			{ data: 'total_redeemed' },
			{
				data: '',
				render: function(data, type, row, meta) {
					if(row.total_bookings > 0)
						return (row.total_redeemed / row.total_bookings * 100).toFixed(2)+'%';
					else
						return '0%';
				}
			},
			],
			columnDefs: [ {
				"targets": ['nosearch'],
				"searchable": false
			}]
		});

		this.table.on( 'order.dt search.dt', ()=> {
			this.table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
	},
	data () {
		return {
			shiner: {
				from:'',
				to:'',
				service_id:'',
			},
			services: [],
			loading: false,
			errors : {},
			table: ''
		}
	},
	methods : {
		get_data() {
			this.table.ajax.reload();
		},
		clear_filter(){
			this.shiner.from='';
			this.shiner.to='';
			this.shiner.service_id='';
			this.get_data();
		},
	},
}
</script>

<style lang="css" scoped>

</style>