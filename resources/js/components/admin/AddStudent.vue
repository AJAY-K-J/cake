<template>
    <div>
        <form v-on:submit.prevent="save" :id="edit+'serviceForm'">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Name of Student</label>
                        <input type="text" class="form-control" placeholder=" Name" v-model="student.name" required>
                        <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                    <label>Name of College</label>
                        <input type="text" class="form-control" placeholder=" College" v-model="student.college" required>
                        <small v-if="errors.college" class="text-danger">{{ errors.college[0] }}</small>
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
            bus.$on('edit-student',function(student) {
                vm.clear_data();
                vm.student.id = student.id;
                vm.student.name = student.name;
                vm.student.college=student.college;
            });
        }
    },
    data () {
        return {
            student: {
                id: '',
                name: '',
                college: '',
                
            },
            loading: false,
            errors: {},
        }
    },
    methods : {
        clear_data() {
            this.student.id = '';
            this.student.name = '';
            this.student.college = '';
            this.errors = '';
        },
        save() {
            this.loading = true;
            axios.post('/add_student',this.student)
            .then(response => {
                this.loading = false;
                if(response.data=="Success")
                {
                    if(this.edit)
                    {
                        swal("Student updated", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }
                    
                    else{
                        swal("Student added successfully", "", "success");
                        this.$refs.cancel_btn.click();
                        this.clear_data();
                    }

                    bus.$emit('student-added');
                    
                }
                else
                {
                    if(this.edit)
                        swal("Couldn't update Student details", "", "error");
                    else
                        swal("Couldn't add Student", "", "error");
                }
            })
            .catch(error => {
                if(this.edit)
                    swal("Couldn't update Student details", "", "error");
                else
                    swal("Couldn't add Student", "", "error");
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


    }
}
</script>

<style lang="css" scoped>

</style>