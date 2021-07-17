<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(model,index) in models">
                        <td>{{ index+1 }}</td>
                        <td>{{ model.vehicle_make.name }}</td>
                        <td>{{ model.name }}</td>
                        <td v-if="model.company_id!=0"><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#modelModal"  @click="edit_model(models[index])">Edit</button></td>
                        <td v-else>NA</td>
                        <td v-if="model.company_id!=0"><button class="btn btn-danger btn-sm m-0" @click="delete_model(model.id)">Delete</button></td>
                        <td v-else>NA</td>
                    </tr>
                    <tr v-if="models.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Services'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modelModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT MODEL</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-model :edit="true" :vehiclemakes="vehiclemakes"></add-model>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props:['vehiclemakes'],
        name: "models",
        created(){
            this.get_models();
            var vm =this;
            bus.$on('model-added', function(){
                vm.get_models();
            });
        },
        data () {
            return {
                models: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_models() {
                this.loading = true;
                axios.get('get_models').
                then(response => {
                    this.models = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_model(model) {
                bus.$emit('edit-model',model);
                // console.log(model);
               
            },

            delete_model(id) {
                swal({
                    title: "Delete model?",
                    text: "Are you sure you want to delete this model? This cannot be undone!",
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
                        axios.post('/delete_model',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Model deleted", "", "success");
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