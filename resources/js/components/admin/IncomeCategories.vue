<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Income Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(incomecategory,index) in incomecategories">
                        <td>{{ index+1 }}</td>
                        <td>{{ incomecategory.name }}</td>
                        <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#expensecategoryModal"  @click="edit_incomecategory(incomecategory)">Edit</button></td>
                        <td><button class="btn btn-danger btn-sm m-0" @click="delete_incomecategory(incomecategory.id)">Delete</button></td>
                    </tr>
                    <tr v-if="incomecategories.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Income Categories'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expensecategoryModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT INCOME CATEGORY</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-incomecategory :edit="true"></add-incomecategory>
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
            this.get_incomecategories();
            var vm =this;
            bus.$on('incomecategory-added', function(){
                vm.get_incomecategories();
            });
        },
        data () {
            return {
                incomecategories: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_incomecategories() {
                this.loading = true;
                axios.get('get_incomecategories').
                then(response => {
                    this.incomecategories = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_incomecategory(incomecategory) {
                bus.$emit('edit-incomecategory',incomecategory);
            },

            delete_incomecategory(id) {
                swal({
                    title: "Delete Income Category?",
                    text: "Are you sure you want to delete this Income Category? This cannot be undone!",
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
                        axios.post('/delete_incomecategory',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Income Category deleted", "", "success");
                            this.get_incomecategories();
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