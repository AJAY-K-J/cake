<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="custom-table table table-hover">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Accessory</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(accessory,index) in accessories">
                            <td>{{ index+1 }}</td>
                            <td>{{ accessory.name }}</td>
                            <td v-if="accessory.company_id!=0"><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#makeModal"  @click="edit_category(accessory)">Edit</button></td>
                            <td v-else>NA</td>
                            <td v-if="accessory.company_id!=0"><button class="btn btn-danger btn-sm m-0" @click="delete_category(accessory.id)">Delete</button></td>
                            <td v-else>NA</td>
                        </tr>
                        <tr v-if="accessories.length==0">
                            <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Accessories'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="makeModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT ACCESSORY</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-accessory :edit="true"></add-accessory>
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
        this.get_accessories();
        var vm =this;
        bus.$on('accessory-added', function(){
            vm.get_accessories();
        });
    },
    data () {
        return {
            accessories: {},
            loading : false,
            errors  : {},
        }
    },
    methods : {
        get_accessories() {
            this.loading = true;
            axios.get('get_accessories').
            then(response => {
                this.accessories = response.data;
                this.loading = false;
            }).
            catch(err => {
                this.loading = false;
            });
        },

        edit_accessory(accessory) {
            bus.$emit('edit-accessory',accessory);

        },

        delete_accessory(id) {
            swal({
                title: "Delete Accessory?",
                text: "Are you sure you want to delete this Accessory? This cannot be undone!",
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
                    axios.post('/delete_accessory',{
                        id: id  
                    })
                    .then(response => {
                        if (response.data== 'Success') 
                        {
                         swal.stopLoading();
                         swal.close();
                         swal("Accessory deleted", "", "success");

                     } 
                     else
                     {
                        swal.stopLoading();
                        swal.close();
                        swal("Issue to Delete Accessory", "", "error");

                    }
                    this.get_accessories();
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