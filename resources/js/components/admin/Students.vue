<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Name of Student</th>
                        <th>College</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(student,index) in students">
                        <td>{{ index+1 }}</td>
                        <td>{{ student.name }}</td>
                         <td>{{ student.college }}</td>
                        <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#studentModal"  @click="edit_student(student)">Edit</button></td>
                        <td><button class="btn btn-danger btn-sm m-0" @click="delete_student(student.id)">Delete</button></td>
                    </tr>
                    <tr v-if="students.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Students'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="studentModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT STUDENT</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-student :edit="true"></add-student>
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
            this.get_students();
            var vm =this;
            bus.$on('student-added', function(){
                vm.get_students();
            });
        },
        data () {
            return {
                students: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_students() {
                this.loading = true;
                axios.get('get_students').
                then(response => {
                    this.students = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_student(student) {
                bus.$emit('edit-student',student);
            },

            delete_student(id) {
                swal({
                    title: "Delete Student?",
                    text: "Are you sure you want to delete this Student? This cannot be undone!",
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
                        axios.post('/delete_student',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Student deleted", "", "success");
                            this.get_students();
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