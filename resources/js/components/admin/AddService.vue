<template>
	<div>
		<form v-on:submit.prevent="save" :id="edit+'serviceForm'">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label>Service Name</label>
						<input type="text" onkeyup="this.value = this.value.toUpperCase()" class="form-control" placeholder="Service Name" v-model="service.name" required>
						<small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
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
import moment from 'moment';

export default {
	props: ['edit'],
	created(){
		if(this.edit)
		{
			var vm = this;
			bus.$on('edit-service',function(service) {
				vm.clear_data();
				vm.service.id = service.id;
				vm.service.name = service.name;
			});
		}
	},
	data () {
		return {
			service: {
				id: '',
				name: '',
			},
			loading: false,
			errors: {},
		}
	},
	methods : {
		clear_data() {
			this.service.id = '';
			this.service.name = '';
			this.errors = '';
		},
		save() {
			this.loading = true;
			axios.post('/add_service',this.service)
			.then(response => {
			    this.loading = false;
			    if(response.data=="Success")
			    {
			    	if(this.edit)
                    {

			    		swal("Service updated", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }
                    
			    	else{
			    		swal("Service added successfully", "", "success");
			    		this.$refs.cancel_btn.click();
			    		this.clear_data();
			    	}

			    	bus.$emit('service-added');
			    	
			    }
			    else
			    {
			    	if(this.edit)
			    		swal("Couldn't update service details", "", "error");
			    	else
			    		swal("Couldn't add service", "", "error");
			    }
			})
			.catch(error => {
			    if(this.edit)
			    	swal("Couldn't update service details", "", "error");
			    else
			    	swal("Couldn't add service", "", "error");
				this.loading = false;
				if(error.response.data.errors)
			    	this.errors  = error.response.data.errors;
			    else
			    	this.errors = '';
			});
		},
		
	},
	mounted() {
	},
	watch: {

        'service.name' : function(){
            this.service.name = this.service.name.toUpperCase();

        },
	}
}
</script>

<style lang="css" scoped>

</style>