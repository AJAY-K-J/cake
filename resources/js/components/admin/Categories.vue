<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="custom-table table table-hover">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category,index) in categories">
                            <td>{{ index+1 }}</td>
                            <td>{{ category.name }}</td>
                            <td v-if="category.company_id!=0"><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#makeModal"  @click="edit_category(category)">Edit</button></td>
                            <td v-else>NA</td>
                            <td v-if="category.company_id!=0"><button class="btn btn-danger btn-sm m-0" @click="delete_category(category.id)">Delete</button></td>
                            <td v-else>NA</td>
                        </tr>
                        <tr v-if="categories.length==0">
                            <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Categories'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="makeModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT CATEGORY</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-category :edit="true"></add-category>
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
        this.get_categories();
        var vm =this;
        bus.$on('category-added', function(){
            vm.get_categories();
        });
    },
    data () {
        return {
            categories: {},
            loading : false,
            errors  : {},
        }
    },
    methods : {
        get_categories() {
            this.loading = true;
            axios.get('get_categories').
            then(response => {
                this.categories = response.data;
                this.loading = false;
            }).
            catch(err => {
                this.loading = false;
            });
        },

        edit_category(category) {
            bus.$emit('edit-category',category);

        },

        delete_category(id) {
            swal({
                title: "Delete Category?",
                text: "Are you sure you want to delete this Category? This cannot be undone!",
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
                    axios.post('/delete_category',{
                        id: id  
                    })
                    .then(response => {
                        if (response.data== 'Success') 
                        {
                         swal.stopLoading();
                         swal.close();
                         swal("Category deleted", "", "success");

                     } 
                     else
                     {
                        swal.stopLoading();
                        swal.close();
                        swal("Remark Exists - please delete Remarks first to Delete Category", "", "error");

                    }
                    this.get_categories();
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