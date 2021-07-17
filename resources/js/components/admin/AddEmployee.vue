<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'modelForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Employee Type<span class="text-danger">*</span></label>
                        

                          <select class="form-control" v-model="employee.employee_type">
                            <option value="">Select Employee Type</option>
                            <option v-for="designation in designations" :value="d esignation.id" >{{ designation.name }}</option>
                            </select>
                         
                         <small v-if="errors.employee_type" class="text-danger">{{ errors.employee_type[0] }}</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Employee Name</label>
                        <input type="text" class="form-control" placeholder="Employee Name" v-model="employee.name" required>
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
    props: ['edit','designations'],
    created(){
        if(this.edit)
        {

            var vm = this;
            bus.$on('edit-employee',function(employee) {
        // console.log(this.vehiclemakes);

                vm.employee.id = employee.id;
                vm.employee.employee_type = employee.employee_type;
                vm.employee.name = employee.name;
              
            });
        }
    },
    data () {
        return {
            employee: {

                id: '',
                employee_type:'',
                name: '',
               

            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.employee.id = '';
            this.employee.employee_type='';
            this.employee.name = '';
           
            this.errors = '';
        },

        save() {
            this.loading = true;
            axios.post('/add_employee',this.employee)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                        {swal("Employee updated", "", "success");
                    this.$refs.cancel_btn.click();
                    this.clear_data();
                }
                    else{
                        swal("Employee added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('employee-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Employee details", "", "error");
                    else
                        swal("Couldn't add Employee", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Employee details", "", "error");
                else
                    swal("Couldn't add Employee", "", "error");
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

     
            'employee.name' : function(){
                this.employee.name = this.employee.name.toUpperCase();
               
            },
    }
}
</script>

<style lang="css" scoped>

</style>