<template>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="custom-table table table-hover">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Product Name</th>
                        <th>MRP</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product,index) in products">
                        <td>{{ index+1 }}</td>
                        <td>{{ product.name }}</td>
                         <td>{{ product.mrp }}</td>
                        <td><button class="btn btn-success btn-sm m-0" data-toggle="modal" data-target="#expensecategoryModal"  @click="edit_product(product)">Edit</button></td>
                        <td><button class="btn btn-danger btn-sm m-0" @click="delete_product(product.id)">Delete</button></td>
                    </tr>
                    <tr v-if="products.length==0">
                        <td colspan="100%" class="text-center">{{ loading ? 'Loading...' : 'No Products'}}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expensecategoryModal" data-backdrop="static">
            <div class="modal-dialog mt-5" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title title my-0">EDIT PRODUCT</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <add-product :edit="true"></add-product>
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
            this.get_products();
            var vm =this;
            bus.$on('product-added', function(){
                vm.get_products();
            });
        },
        data () {
            return {
                products: {},
                loading : false,
                errors  : {},
            }
        },
        methods : {
            get_products() {
                this.loading = true;
                axios.get('get_products').
                then(response => {
                    this.products = response.data;
                    this.loading = false;
                }).
                catch(err => {
                    this.loading = false;
                });
            },

            edit_product(product) {
                bus.$emit('edit-product',product);
            },

            delete_product(id) {
                swal({
                    title: "Delete Product?",
                    text: "Are you sure you want to delete this Product? This cannot be undone!",
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
                        axios.post('/delete_product',{
                            id: id  
                        })
                        .then(response => {
                            swal.stopLoading();
                            swal.close();
                            swal("Product deleted", "", "success");
                            this.get_products();
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