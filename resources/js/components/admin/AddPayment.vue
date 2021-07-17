<template>
	<div>
		<form v-on:submit.prevent="save">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label>Payment Type <b class="text-danger">*</b></label>
					    <select class="form-control" required v-model="payment.payment_type">
                          <option value="">Select a payment type</option>
                          <option v-for="payment_type in payment_types" :value="payment_type.id">{{ payment_type.name }}</option>
                        </select>
						<small v-if="errors.payment_type" class="text-danger">{{ errors.payment_type[0] }}</small>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>Amount <b class="text-danger">*</b></label>
						<input type="number" class="form-control" placeholder="Enter amount" v-model="payment.amount" required step="0.01">
						<small v-if="errors.amount" class="text-danger">{{ errors.amount[0] }}</small>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<label>Remarks</label>
						<input type="text" class="form-control" placeholder="Enter remarks" v-model="payment.remarks">
					</div>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-12">
					<div class="form-group">
						<button class="btn btn-primary float-right" type="submit" :disabled="loading">Save</button>
						<button class="btn btn-light float-right mr-2" data-dismiss="modal" @click="clear_data()" ref="cancel_btn" type="button">Close</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>

<script>

export default {
	props: ['invoice' ,'payment_details', 'payment_types', 'type'],
	created() {

	},
	data () {
		return {
			payment: {
				invoice_no:this.invoice.invoice_no,
				payment_type: '',
				amount: '',
				remarks: '',
				id: '',
			},
			loading : false,
			errors  : {},
		}
	},
	methods : {
		save() {
			this.loading = true;
			axios.post('/payments/add' ,this.payment).
			then(response => {
			  this.loading = false;
               if(response.data == 'error')
			    {
			      swal('Error', 'Check Balance Amount', 'error')
			    }
			    else{

			      if(this.type == 'edit') 
			    	 swal('Payment details updated successfully', '', 'success')
			    	
			      else 
			    	 swal('Payment added successfully', '', 'success')
			    } 	
			 
			      this.$refs.cancel_btn.click();
                    bus.$emit('payment-added');
                    this.clear_data();
			}).
			catch(error => {
			    this.errors  = _.get(error, "response.data.errors", {});
			    swal('Error', 'Try again', 'error')
			    this.loading = false;
			});
		},
		clear_data() {
			this.payment.id = '';
			this.payment.payment_type = '';
			this.payment.amount = '';
			this.payment.remarks = '';
		}
	},
	mounted() {
		if(this.type == 'edit') {
			bus.$on('edit-payment', (payment)=>{
				this.payment.id = payment.id;
				this.payment.payment_type = payment.payment_type ? payment.payment_type.id : '';
				this.payment.amount = payment.amount;
				this.payment.remarks = payment.remarks;
			})
		}
	}
}
</script>

<style lang="css" scoped>

</style>