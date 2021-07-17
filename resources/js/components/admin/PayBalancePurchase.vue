<template>

  <div class="row">
		<div class="nav-tabs-navigation mb-8">
		
		</div>  	 			
	   <div class="col-12">
			<div class="table-responsive">
				<table class="custom-table table table-hover">
					<thead>
						<tr>
							<th style="width: 5%;">S/N</th>
							<th style="width: 60%;">Purchase Details</th>
							<th style="width: 35%;">Options</th>

						</tr>
					</thead>
					<tbody>
						<tr v-for="(purchase,index) in purchases" >


							<td>{{ index+1 }}</td>
							<td class="newspaper"> 

								<table class='table borderless'>
									<tbody>
										<tr>
											<td>
												Date: 
											</td>
											<td align="left">
												<b>{{ getformatteddate(purchase.created_at) }}</b>
											</td>
										</tr>  
										<tr>
											<td>
												Purchase No:
											</td>
											<td align="left">
												<b>{{ purchase.purchase_id }}</b>
											</td>
										</tr>  
										<tr>
											<td>
												Vendor Name:
											</td>
											<td align="left">
												<b>{{ purchase.vendor.name }}</b>
											</td>
										</tr>  
										<tr>
											<td>
												Mobile: 
											</td>
											<td align="left">
												<b>{{ purchase.vendor.mobile }}</b>
											</td>
										</tr> 
										<tr>
											<td>
												Remarks:
											</td>
											<td align="left">
												<b>{{ purchase.remarks }}</b>
											</td>
										</tr> 
										<tr>
											<td>
												Balance Amount:
											</td>
											<td align="left">
												<b>Rs.{{ purchase.amount-purchase.payed_amount }}</b>
											</td>
										</tr>  
									</tbody>
								</table>


								<td >
									
									<a class="btn btn-success btn-sm m-0" :href="'/purchase_payments/'+purchase.id" 
									 style="background:#3e2723" target="_blank"> 
										<i class="fas fa-receipt"  aria-hidden="true" ></i>
									</a>
								</td>

							</tr>
							<tr v-if="purchases.length==0">
								<td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Balance Paynent'}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			
		</div>
	</div>
</template>

<script>
import moment from 'moment';

export default {
	/*mixins:[mixins],*/  /*props:['PROPERTY'],*/
	props: ['purchases'],
	created(){
	
	},
	data () {
		return {
			loading : false,
			uploading : false,
			errors  : {},
		}
	},
	methods : {
		getformatteddate(date) {
			return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
		},

		convert_date(date) {
			return moment(date).format('DD-MM-YYYY');
		},
		clear_data() {
			
		},
		


	},
	mounted() {
	

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

.preview {
	display: block;
	margin: 20px auto 0 auto;
	width: 300px;
	height: 100px;
	object-fit: contain;
	object-position: center;
}

#imagePreviewModal {
	background: #000000aa;
	height: 100vh;
	width: 100vw;
	left: 0;
	top: 0;
	position: absolute;
	display: none;
	justify-content: center;
	align-items: center;
	z-index: 1050;
}

#imagePreviewModal .image-modal-body {
	max-height: 500px;
	max-width: 500px;
}

#imagePreviewModal .image-modal-body img {
	width: 100%;
	height: 100%;
	object-fit: contain;
	object-position: center;
}
.newspaper {


	-webkit-column-gap: 40px; /* Chrome, Safari, Opera */
	-moz-column-gap: 40px; /* Firefox */
	column-gap: 40px;
}

#imagePreviewModal.show {
	display: flex!important;
}

.close-image-modal {
	position: absolute;
	top: 10px;
	right: 10px;
	background: none;
	box-shadow: none;
}
.borderless td, .borderless th {
	border: none;
	padding: 0px;
	margin: 0px;
	text-align: left;
	width:50%;
}


</style>