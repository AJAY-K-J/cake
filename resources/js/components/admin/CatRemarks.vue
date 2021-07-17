<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Category</th>
                        <th>Remark</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(catremark,index) in catremarks">
                        <td>{{ index+1 }}</td>
                        <td>{{ catremark.category.name }}</td>
                        <td>{{ catremark.name }}</td>
                        <td v-if="catremark.company_id!=0"><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#modelModal"  @click="edit_catremark(catremark)">Edit</button></td>
                        <td v-else>NA</td>
                        <td v-if="catremark.company_id!=0"><button class="btn btn-danger btn-sm m-0" @click="delete_catremark(catremark.id)">Delete</button></td>
                        <td v-else>NA</td>
                    </tr>
                    <tr v-if="catremarks.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Remarks'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modelModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT REMARK</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-catremark :edit="true" :categories="categories"></add-catremark>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props:['categories'],
        name: "catremarks",
        created(){
            this.get_catremarks();
            var vm =this;
            bus.$on('catremark-added', function(){
                vm.get_catremarks();
            });
        },
        data () {
            return {
                catremarks: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_catremarks() {
                this.loading = true;
                axios.get('get_catremarks').
                then(response => {
                    this.catremarks = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_catremark(catremark) {
                bus.$emit('edit-catremark',catremark);
                // console.log(model);
               
            },

            delete_catremark(id) {
                swal({
                    title: "Delete Remark?",
                    text: "Are you sure you want to delete this Remark? This cannot be undone!",
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
                        axios.post('/delete_catremark',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Remark deleted", "", "success");
                            this.get_catremarks();
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