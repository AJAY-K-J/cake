<template>
	<div class="modal fade" tabindex="-1" role="dialog" id="changePasswordModal" data-backdrop="static">
		<div class="modal-dialog " role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title title my-0">CHANGE PASSWORD</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form v-on:submit.prevent="save">
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Current Password</label>
									<input type="password" class="form-control border-secondary rounded-0" required v-model="shiner.current_password">
									<i class="fa fa-eye show-pass-btn"></i>
									<small class="text-danger" v-if="invalid"><b>Invalid Password</b></small>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label>New Password</label>
									<input type="password" class="form-control border-secondary rounded-0" required v-model="shiner.new_password">
									<i class="fa fa-eye show-pass-btn"></i>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" class="form-control border-secondary rounded-0" v-model="shiner.confirm_password">
									<small class="text-danger" v-if="mismatch"><b>Password Mismatch</b></small>
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-12">
								<div class="form-group">
									<button class="btn btn-primary float-right" type="submit" :disabled="mismatch || shiner.confirm_password=='' || loading">{{ loading ? 'Saving' : 'Save' }}</button>
									<button class="btn btn-light float-right mr-2" data-dismiss="modal" @click="clear_data()" ref="cancel_btn" type="button">Close</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</template>

<script>
//import mixins from '../mixins/jarvis';
//Vue.component('COMPONENT',require('./COMPONENT'));

export default {
	/*mixins:[mixins],*/  /*props:['PROPERTY'],*/
	created(){

	},
	data () {
		return {
			shiner:{
				current_password : '',
				new_password : '',
				confirm_password : '',
			},
			loader  : '/loader/loader.gif',
			loading : false,
			errors  : {},
			invalid : false,
			mismatch : false,
		}
	},
	methods : {
		check_password() {
			if(this.shiner.new_password != this.shiner.confirm_password)
			{
				this.mismatch = true;
			}
			else
			{
				this.mismatch = false;
			}
		},
		clear_data() {
			this.shiner.current_password = '';
			this.shiner.new_password = '';
			this.shiner.confirm_password = '';
		},
		save() {
			this.loading = true;
			axios.post('/change-password',this.shiner).
			then(response => {
				this.loading = false;
				if(response.data.status==1) {
					swal("Password Changed successfully",'','success');
					this.shiner.current_password = '';
					this.shiner.new_password = '';
					this.shiner.confirm_password = '';
					this.$refs.cancel_btn.click();
				}
				else if(response.data.status==0) {
					this.invalid = true;
				}
				else
					swal("Couldn't change password",'','error');
			}).
			catch(error => {
				this.errors  = error.response.data.errors;
				this.loading = false;
			});
		}
	},
	mounted() {
		$(".show-pass-btn").on('mousedown', function(){
			$(this).siblings('[type=password]').attr('type','text')
		})

		$(".show-pass-btn").on('mouseup', function(){
			$(this).siblings('[type=text]').attr('type','password')
		})

		var vm = this;
		$("#changePasswordModal").on('hidden.bs.modal', function (e) {
		  vm.clear_data();
		})
	},
	watch : {
		'shiner.new_password' : function() { this.check_password(); },
		'shiner.confirm_password' : function() { this.check_password(); },
		'shiner.current_password' : function() { this.invalid=''; },
	}
}
</script>

<style lang="css" scoped>
.show-pass-btn {
	position: absolute;
	
	color: #666;
	z-index: 4;
}

.show-pass-btn:hover {
	cursor: pointer;
	color: #000;
}
</style>