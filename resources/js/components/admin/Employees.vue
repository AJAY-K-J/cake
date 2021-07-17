<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Employee Type</th>
                        <th>Name of Employee</th>
                      
                        <th>Employee Created</th>
                     
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(employee,index) in employees">
                        <td>{{ index+1 }}</td>

                        <td>{{ employee.designation?employee.designation.name:''}}</td>
                        <td>{{ employee.name }}</td>
                        <td>{{ convert_date(employee.created_at) }}</td>
                     
                        <td ><button class="btn btn-danger btn-sm m-0" @click="delete_employee(employee.id)">Delete</button></td>
                  
                    </tr>
                    <tr v-if="employees.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Employees'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="employeeModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT EMPLOYEE</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-employee :edit="true"></add-employee>
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
            this.get_employees();
            var vm =this;
            bus.$on('employee-added', function(){
                vm.get_employees();
            });
        },
        data () {
            return {
                employees: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            convert_date(date) {
               return moment(date).format('DD-MM-YYYY  h:mm:ss a');
               },
            get_employees() {
                this.loading = true;
                axios.get('get_employees').
                then(response => {
                    this.employees = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_employee(employee) {
                bus.$emit('edit-employee',employee);

            },

            delete_employee(id) {
                swal({
                    title: "Delete Employee?",
                    text: "Are you sure you want to delete this Employee? This cannot be undone!",
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
                        axios.post('/delete_employee',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Employee deleted", "", "success");
                            this.get_employees();
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