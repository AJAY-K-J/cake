<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Expense Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(expensecategory,index) in expensecategories">
                        <td>{{ index+1 }}</td>
                        <td>{{ expensecategory.name }}</td>
                        <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#expensecategoryModal"  @click="edit_expensecategory(expensecategory)">Edit</button></td>
                        <td><button class="btn btn-danger btn-sm m-0" @click="delete_expensecategory(expensecategory.id)">Delete</button></td>
                    </tr>
                    <tr v-if="expensecategories.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Expense Categories'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expensecategoryModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT EXPENSE CATEGORY</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-expensecategory :edit="true"></add-expensecategory>
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
            this.get_expensecategories();
            var vm =this;
            bus.$on('expensecategory-added', function(){
                vm.get_expensecategories();
            });
        },
        data () {
            return {
                expensecategories: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_expensecategories() {
                this.loading = true;
                axios.get('get_expensecategories').
                then(response => {
                    this.expensecategories = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_expensecategory(expensecategory) {
                bus.$emit('edit-expensecategory',expensecategory);
            },

            delete_expensecategory(id) {
                swal({
                    title: "Delete Expense Category?",
                    text: "Are you sure you want to delete this Expense Category? This cannot be undone!",
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
                        axios.post('/delete_expensecategory',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Expense Category deleted", "", "success");
                            this.get_expensecategories();
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