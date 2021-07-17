<template>
	<div>
		<div class="card">  
			<div class="card-body">
				<h4 class="card-title">invoice Details</h4>
				
				<h5 class="row">
				 	<div class="col-md-4 mb-6">
						<b>Invoice NO :</b> {{ invoice.invoice_no }}
					</div>
					<div class="col-md-4 mb-2">
						<b>Name :</b> {{ invoice.name }}
					</div>
					<div class="col-md-4 mb-2">
						<b>Mobile :</b> {{ invoice.mobile }}
					</div>
					<div class="col-md-4 mb-2">
						<b>Total Payable :</b> {{ invoice.total_net_amount }}
					</div>
					<div class="col-md-4 mb-2">
						<b>Total Paid :</b> {{ total_paid }}
					</div>
					<div class="col-md-4 mb-2">
						<b>Balance :</b> {{ balance }}
					</div>
				</h5>
			</div>
		</div>
		<div class="table-responsive">
			<table class="custom-table table table-hover">
				<thead>
					<tr>
						<th>Sl No</th>
						<th>Date</th>
						<th>Payment Type</th>
						<th>Amount</th>
						<th>Remark</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="loading">
						<td colspan="100%" class="text-center">
							Loading...
						</td>
					</tr>
					<tr v-else-if="payments.length == 0">
						<td colspan="100%" class="text-center">No payments</td>
					</tr>
					<tr v-for="(payment,index) in payments" v-else>
						<td>{{ index + 1 }}</td>
						<td>{{ getformatteddate(payment.updated_at) }}</td>
						<td>{{ payment.payment_type ? payment.payment_type.name : '' }}</td>
						<td>{{ payment.amount }}</td>
						<td>{{ payment.remarks }}</td>
						<td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editPaymentModal" @click="edit(payment)">Edit</button></td>
						<td><button class="btn btn-danger btn-sm" @click="delete_payment(payment.id)">Delete</button></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="editPaymentModal" data-backdrop="static">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">Edit Payment</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<add-payment :invoice="invoice" :payment_types="payment_types" type="edit"></add-payment>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import moment from 'moment';
export default {
	props: ['invoice' ,'payment_types'],
	created(){

	},
	computed: {
		total_paid() {
			return _.sumBy(this.payments, function(payment) { return parseFloat(payment.amount); }).toFixed(2);
		},
		balance() {
			return (parseFloat(this.invoice.total_net_amount) - parseFloat(this.total_paid)).toFixed(2);
		},
	},

	data () {
		return {
			payments: [],
			loading: false,
		}
	},
	methods : {
		getformatteddate(date) {
			return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
		},
		get_payment_type(id) {
			const payment_type = this.payment_types.find(payment_type => payment_type.id == id);
			return payment_type ? payment_type.name : '';
		},
		get_payments() {
			this.loading = true;
			axios.post('/payments/get', {
				invoice_no: this.invoice.invoice_no,
				
			}).
			then(response => {
				this.payments = response.data;
				this.loading = false;
			}).
			catch(error => {
				this.loading = false;
			});
			
		},
		delete_payment(id) {
			swal({
				title: "Delete payment?",
				text: "Are you sure you want to delete this payment? This cannot be undone!",
				icon: "warning",
				buttons: {
					cancel: "No",
					confirm: {
						text: "Delete",
						value: "willDelete",
						closeModal: false,
					},
				}, 
				closeOnEsc: false,
				closeOnClickOutside: false,
				dangerMode: true,
			}) 
			.then((willDelete) => {
				if(willDelete)
				{
					axios.post('/payments/delete',{
						id: id  
					})
					.then(response => {
						swal.stopLoading();
						swal.close();
						swal("Payment deleted", "", "success");
						this.get_payments();
					}).
					catch(error => {
						swal.stopLoading();
						swal.close();
					});
				}
			});
		},
		edit(payment) {
			bus.$emit('edit-payment', payment)
		}
	},
	mounted() {
		this.get_payments();
		bus.$on('payment-added', () => {
			this.get_payments();
		})
	}
}
</script>

<style lang="css" scoped>

</style>