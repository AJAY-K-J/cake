<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Purchase Vendor</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(vendor,index) in vendors">
                        <td>{{ index+1 }}</td>
                        <td>{{ vendor.name }}</td>
                        <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#expensecategoryModal"  @click="edit_vendor(vendor)">Edit</button></td>
                        <td><button class="btn btn-danger btn-sm m-0" @click="delete_vendor(vendor.id)">Delete</button></td>
                    </tr>
                    <tr v-if="vendors.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Purchase Vendors'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expensecategoryModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT VENDOR</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-vendor :edit="true"></add-vendor>
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
            this.get_vendors();
            var vm =this;
            bus.$on('vendor-added', function(){
                vm.get_vendors();
            });
        },
        data () {
            return {
                vendors: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_vendors() {
                this.loading = true;
                axios.get('get_vendors').
                then(response => {
                    this.vendors = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_vendor(vendor) {
                bus.$emit('edit-vendor',vendor);
            },

            delete_vendor(id) {
                swal({
                    title: "Delete Purchase Vendor?",
                    text: "Are you sure you want to delete this Purchase Vendor? This cannot be undone!",
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
                        axios.post('/delete_vendor',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Purchase Vendor deleted", "", "success");
                            this.get_vendors();
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