<template>
	<div class="card card-plain">
		<div class="card-body">
			<h2 class="card-title text-center">REDEEM</h2>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<form id="searchForm" v-on:submit.prevent="redeem_search">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Search By</label>
									<select class="form-control" v-model="search.type" required>
										<option value="1">Referral Code</option>
										<option value="2">Registration No</option>
										<option value="3">Mobile</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>{{ search_label }}</label>
									<input type="text" v-model="search.value" class="form-control" :placeholder="search_label" required>
								</div>
							</div>
							<div class="col-12 text-center mt-2">
								<div class="form-group">
									<button class="btn btn-primary" type="submit" :disabled="searching">
										<span v-if="searching">Searching...</span>
										<span v-else>Search</span>
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			
			<h5 v-if="nomatch" class="text-center text-danger">No match found</h5>
			<div class="table-responsive">
				<table class="table custom-table" v-if="referrals.length > 0">
					<thead>
						<tr>
							<th>Slno</th>
							<th>Name</th>
							<th>Mobile</th>
							<th>Reg No</th>
							<th>Offer</th>
							<th>Discount Amount</th>
							<th>Service Type</th>
							<th>Validity</th>
							<th>Status</th>
							<th>Redeem</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(customer,index) in referrals">
							<td>{{ index+1 }}</td>
							<td>{{ customer.name }}</td>
							<td>{{ customer.mobile }}</td>
							<td>{{ customer.reg_no?customer.reg_no:'NA' }}</td>
							<td>{{ customer.campaign.name }}</td>
							<td><span v-if="customer.campaign.discount_type==2"> &#8377 </span>{{ parseFloat(customer.campaign.discount_amount) }}<span v-if="customer.campaign.discount_type==1">%</span></td>
							<td>{{ customer.campaign.service.name }}</td>
							<td class="nowrap" :class="{ 'text-danger' : customer.campaign.expired }">{{ convert_date(customer.campaign.to_date) }}</td>
							<td :colspan="customer.redeem_status==0  && (customer.campaign.expired || !check_day(customer.active_days)) ? 2 : 1">
								<span v-if="customer.redeem_status == 1" class="text-danger"><b>Redeemed</b></span>
								<span v-else-if="customer.campaign.expired" class="text-danger"><b>Expired</b></span>
								<div v-else-if="!check_day(customer.active_days)" class="text-danger" style="font-size: 12px;">
									<b>Available on {{ get_active_days(customer.active_days) }} only.</b>
								</div>
								<span v-else-if="customer.redeem_status == 0" class="text-success"><b>Available</b></span>
							</td>
							<td v-if="customer.redeem_status==1 || !customer.campaign.expired && check_day(customer.active_days)">
								<a class="btn btn-sm btn-success my-0 btn-block" :href="'/print_receipt/'+customer.referral_code" target="print" v-if="customer.redeem_status == 1">Print</a>
								<button  v-else class="btn btn-sm btn-primary my-0 btn-block" data-toggle="modal" data-target="#redeemModal" @click="show_modal(customer)">Redeem</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="redeemModal" data-backdrop="static" ref="redeemModal">
			<div class="modal-dialog mt-5" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title title my-0">REDEEM DETAILS</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form v-on:submit.prevent="redeem">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Offer</label>
										<div class="campaign-info">{{ modal.offer }}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Referral Code</label>
										<div class="campaign-info">{{ modal.referral_code }}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Reg No.</label>
										<div class="campaign-info">{{ modal.reg_no?modal.reg_no:'NA' }}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Discount</label>
										<div class="campaign-info"><span v-if="modal.discount_type==2">&#8377 </span>{{ parseFloat(modal.discount) }}<span v-if="modal.discount_type==1">%</span></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Service Type</label>
										<div class="campaign-info">{{ modal.service_type }}</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Amount</label>
										<input type="number" step="0.01" v-model="modal.labour_amount" class="form-control" placeholder="Amount" required>
										<small class="text-danger" v-if="errors.labour_amount">{{ errors.labour_amount[0] }}</small>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Discounted Amount</label>
										<input type="number" step="0.01" v-model="modal.discounted_amount" class="form-control" placeholder="Discounted Amount" required>
										<small class="text-danger" v-if="errors.discounted_amount">{{ errors.discounted_amount[0] }}</small>
									</div>
								</div>
								<!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Spare Amount</label>
                                        <input type="number" step="0.01" v-model="modal.spare_amount" class="form-control" placeholder="Spare Amount" required>
                                        <small class="text-danger" v-if="errors.spare_amount">{{ errors.spare_amount[0] }}</small>
                                    </div>
                                </div> -->
								<div class="col-md-6">
									<div class="form-group">
										<label>Tax</label>
										<input type="number" step="0.01" v-model="modal.tax" class="form-control" placeholder="Tax">
										<small class="text-danger" v-if="errors.tax">{{ errors.tax[0] }}</small>
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<h4 class="text-center mt-3 mb-0">BALANCE:<span class="ml-3">&#8377 {{ modal.balance }}</span></h4>
										<small class="text-center d-block mb-4">Amount + Tax - Discounted Amount</small>
									</div>
								</div>
							</div>
							<div class="row">
								<!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="d-block">Mobile</label>
                                        <h3 class="my-0 title">{{ modal.mobile }}</h3>
                                    </div>
                                </div> -->
								<!-- <div class="col-sm-6" v-if="!modal.alt_mobile">
                                    <div class="form-group text-center text-md-right">
                                        <label class="d-sm-block">&nbsp</label>
                                        <button class="btn btn-success btn-sm"  type="button" @click="set_alt_mobile('show')">Use Another Number</button>
                                    </div>
                                </div> -->
								<!-- <div class="col-12 " v-if="modal.alt_mobile">
                                    <div class="form-group">
                                        <label>New Mobile Number</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control new-number mr-2" v-model="modal.mobile2" required>
                                            <button class="btn btn-sm btn-danger m-0" @click="set_alt_mobile('hide')" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                        <small class="text-danger " v-if="errors.mobile2">{{ errors.mobile2[0] }}</small>
                                    </div>
                                </div> -->
							</div>
							<div class="row" v-if="!modal.sent_otp">
								<div class="col-12">
									<div class="form-group text-center">
										<button class="btn btn-primary">Redeem</button>
										<small class="text-danger text-center d-block" v-if="errors.send_otp">{{ errors.send_otp }}</small>
									</div>
								</div>
							</div>
							<div class="row justify-content-center text-center" v-else>
								<div class="col-6">
									<div class="form-group">
										<h4 class="mb-0">OTP</h4>
										<input type="number" class="form-control mr-2 otp" v-model="modal.otp" required>
										<small>Expires in 5 minutes</small>
										<div>
											<small class="text-danger d-block"  v-if="errors.otp">{{ errors.otp[0] }}</small>
											<div class="d-block" style="color: #2196f3">
												<small v-if="this.modal.timer == '00'" @click="send_otp" class="hoverable" style="color: #2196f3">Resend OTP</small>
												<small v-else>Resend OTP in 00:{{ modal.timer }}</small>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12">
									<button class="btn btn-success"type="submit" id="verify-btn">Verify And Redeem</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<iframe id="print" name="print" style="display:none;"></iframe>	
	</div>
</template>

<script>
import moment from 'moment';
import Timer from 'tiny-timer';
//Vue.component('COMPONENT',require('./COMPONENT'));

export default {
	/*mixins:[mixins],*/  /*props:['PROPERTY'],*/
	props: ['services'],
	created(){

	},
	data () {
		return {
			search:{
				type: '1',
				value: ''
			},
			referrals: '',
			nomatch: false,
			search_label : 'Search Referral Code',
			loading : false,
			searching : false,
			errors  : {},
			modal: {
				customer_id: '',
				offer: '',
				reg_no: '',
				service_type: '',
				discount: '',
				discount_type: '',
				mobile: '',
				mobile2: '',
				otp: '',
				labour_amount: 0,
				discounted_amount: 0,
				tax: 0,
				balance: 0,
				alt_mobile: false,
				sent_otp: false,
				timer: '60',
				referral_code: '',
			},
			timer: new Timer,
			otp_error: ''
		}
	},
	methods : {
		redeem_search() {
			this.searching = true;
			this.nomatch = false;
			this.referrals = '';
			axios.post('/redeem/search',this.search)
			.then(response => {
				this.searching = false;
				if(response.data)
				{
					if(response.data.length > 0)
					{
						this.referrals = response.data;
						this.referrals.sort(function(a,b){
						  return new Date(b.campaign.to_date) - new Date(a.campaign.to_date);
						});
						this.nomatch = false;
					}
					else
					{
						this.nomatch = true;
					}
				}
				else
					this.nomatch = true;

				this.$nextTick(() => {
					$(".table-responsive").floatingScroll();
				})
			})
			.catch(error => {
				this.searching = false;
			});
		},
		convert_date(date) {
			return moment(date).format('DD-MM-YYYY');
		},
		show_modal(customer)
		{
			this.modal.customer_id = customer.customer_id;
			this.modal.offer = customer.campaign.name;
			this.modal.reg_no = customer.reg_no;
			this.modal.service_type = customer.campaign.service.name;
			this.modal.discount = customer.campaign.discount_amount;
			this.modal.discount_type = customer.campaign.discount_type;
			this.modal.mobile = customer.mobile;
			this.modal.mobile2 = customer.mobile2;
			this.modal.referral_code = customer.referral_code;
			
			this.modal.otp = '';
			this.modal.labour_amount = '';
	
			this.modal.tax = '';
			if(this.modal.discount_type==2)
				this.modal.discounted_amount = customer.campaign.discount_amount;
			else
				this.modal.discounted_amount = '';
			this.modal.balance = 0;
			this.modal.alt_mobile = false;
			this.modal.sent_otp = false;
			this.errors = {};
		},
		set_alt_mobile(status){
			if(status=='show')
			{
				this.modal.alt_mobile = true;
			}
			else if(status=='hide')
			{
				this.modal.alt_mobile = false;
			}
		},
		send_otp(){
			this.loading = true;
			this.errors = {};
			this.timer.stop();
			this.modal.timer = '59';
			var seconds = 59;
			var vm = this;
			this.timer.on('tick', function(ms){
				if(seconds < 10)
					vm.modal.timer = '0'+seconds;
				else
					vm.modal.timer = seconds;
				seconds--;
			});

			this.timer.start(1000 * 59);

			var mobile = this.modal.alt_mobile ? this.modal.mobile2 : this.modal.mobile;
			axios.post('/redeem/send_otp',{
				mobile : mobile,
				customer_id : this.modal.customer_id,
			}).
			then(response => {
				if(response.data.status == 1)
				{
					this.modal.sent_otp = true;
					swal("OTP Sent to "+mobile,"","success");
				}
				else
				{
					this.modal.sent_otp = false;
					swal("Error",response.data.response,"error");
					this.errors = { send_otp: response.data.response }
				}
			}).
			catch(error => {
				this.loading = false;
				this.errors = _.get(this.errors,'response.data.errors',{});
			});
		},
		redeem() {
				axios.post('/redeem/redeem_submit',{
					customer_id : this.modal.customer_id,
					tax : this.modal.tax,
					labour_amount : this.modal.labour_amount,
					discounted_amount : this.modal.discounted_amount,
					service_type: this.modal.service_type,
				}).
				then(response => {
					$("#verify-btn").removeAttr('disabled').text('Verify and Redeem');
					if(response.data.status == 1)
					{
						swal("Offer redeemed successfully","","success");
						$("#redeemModal").modal('hide');
						this.redeem_search();
					}
					else
					{
						this.errors = {'otp': [response.data.response]};
					}
				}).
				catch(error => {
					$("#verify-btn").removeAttr('disabled').text('Verify and Redeem');
					this.loading = false;
					this.errors = _.get(this.errors,'response.data.errors',{});
				});
		},
		calculate_balance()
		{
			var labour_amount = this.modal.labour_amount ? parseFloat(this.modal.labour_amount) : 0;
			var discounted_amount = this.modal.discounted_amount ? parseFloat(this.modal.discounted_amount) : 0;
			var tax = this.modal.tax ? parseFloat(this.modal.tax) : 0;
			var balance = labour_amount  + tax - discounted_amount;
			balance = balance.toFixed(2);
			if(balance < 0)
				balance = 0;
			this.modal.balance = balance;
		},
		check_day(days) {

			if(!days)
				return true;

			var check = days.find((day) => {
				return day == moment().day();
			});

			if(check != undefined) {
				return true;
			}
			else
				return false;
		},
		get_active_days(days) {
			var str = '';
			days.forEach(function(day,index) {
			  if(index != 0 ) {
			  	if(index != days.length-1)
			  		str += ', ';
			  	else
			  		str += ' and ';
			  }
			  str += moment().day(day).format("dddd")+'s';
			});
			return str;
		}
	},
	watch: {
		'search.type' : function(){
			console.log(this.search.type);
			switch(this.search.type)
			{
				case "1": this.search_label = 'Search Referral Code'; break;
				case "2": this.search_label = 'Search Registration No'; break;
				case "3": this.search_label = 'Search Mobile'; break;
				default: this.search_label = 'Search'; break;
			}
		},
		'modal.labour_amount' : function() {
			if(this.modal.discount_type == 1){
				var labour_amount = this.modal.labour_amount ? parseFloat(this.modal.labour_amount) : 0;
				var discount = this.modal.discount ? parseFloat(this.modal.discount) : 0;
				var discounted_amount = labour_amount * discount / 100;
				this.modal.discounted_amount = discounted_amount.toFixed(2);
			}
			else {
				this.calculate_balance();
			}
		},
		'modal.discounted_amount' : function() {	
			this.calculate_balance();
		},
		'modal.spare_amount' : function() {
			this.calculate_balance();
		},
		'modal.tax' : function() {
			this.calculate_balance();
		}
	},
	mounted() {
		$(".table-responsive").floatingScroll();
	},
}
</script>

<style lang="css" scoped>
h5,h4,h3 {
	font-weight: bold;
	color: #444;
	margin: 0;
}

.campaign-info {
	font-size: 16px;
	font-weight: bold;
}


.new-number , .otp{
	font-size: 1.25rem;
	font-weight: 700;
	color: #3c4858;
	font-family: 'Roboto Slab', sans-serif;
	letter-spacing: 1px;
}

.otp {
	text-align: center;
	letter-spacing: 5px;
	font-family: 'Roboto', sans-serif;
	font-style: 1.5rem;
}
</style>