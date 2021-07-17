<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="custom-table table table-hover">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Brand</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(make,index) in makes">
                            <td>{{ index+1 }}</td>
                            <td>{{ make.name }}</td>
                            <td v-if="make.company_id!=0"><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#makeModal"  @click="edit_make(make)">Edit</button></td>
                            <td v-else>NA</td>
                            <td v-if="make.company_id!=0"><button class="btn btn-danger btn-sm m-0" @click="delete_make(make.id)">Delete</button></td>
                            <td v-else>NA</td>
                        </tr>
                        <tr v-if="makes.length==0">
                            <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Services'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="makeModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT BRAND</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-make :edit="true"></add-make>
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
        this.get_makes();
        var vm =this;
        bus.$on('make-added', function(){
            vm.get_makes();
        });
    },
    data () {
        return {
            makes: {},
            loading : false,
            errors  : {},
        }
    },
    methods : {
        get_makes() {
            this.loading = true;
            axios.get('get_makes').
            then(response => {
                this.makes = response.data;
                this.loading = false;
            }).
            catch(err => {
                this.loading = false;
            });
        },

        edit_make(make) {
            bus.$emit('edit-make',make);

        },

        delete_make(id) {
            swal({
                title: "Delete Brand?",
                text: "Are you sure you want to delete this Brand? This cannot be undone!",
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
                    axios.post('/delete_make',{
                        id: id  
                    })
                    .then(response => {
                        if (response.data== 'Success') 
                        {
                         swal.stopLoading();
                         swal.close();
                         swal("Brand deleted", "", "success");

                     } 
                     else
                     {
                        swal.stopLoading();
                        swal.close();
                        swal("Model Exists - please delete Model first to Delete Brand", "", "error");

                    }
                    this.get_makes();
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