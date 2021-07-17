<template>
 <div class="container-fluid">
  <div class="table-responsive">

    <table id="report-table" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
            <tr>
                <th width="60px">Slno</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Product</th>
                <th>QTY</th>
                <th>MRP</th>
                <th>GST</th>
              
            </tr>
        </thead>
    </table>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="customerModal" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title my-0">EDIT STOCK</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <edit-stock :edit="true" :vendors = "vendors"></edit-stock>
            </div>
        </div>
    </div>
</div>

</div>
</template>

<script>
import moment from 'moment';
import DataTable from 'datatables.net-bs4';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';

export default {
    props:['vendors'],
    created(){

        var vm =this;
        bus.$on('stock-updated', function(){
           vm.table.ajax.reload();
       });
    },
    mounted() {

        var vm = this
        this.table = $("#report-table").DataTable({
            pageLength: 100,
            ajax: {
                url: "/get_stocks",
                type: "GET",
                dataSrc: '',
            },
            columns: [
            {
                render: function(data, type, row, meta) {
                    return '';
                },
            },
            {
             data: '',
             render: function(data, type, row, meta) {

                 return `<button class="btn btn-primary btn-sm view-button" data-toggle="modal" data-target="#customerModal" 
                 data-id="${row.id}"><i class="fa fa-pencil" aria-hidden="true"></button>`;
             }
            },
            {
              data: '',
              render: function(data, type, row, meta) {

                  return `<button class="btn btn-danger btn-sm delete-button" data-toggle="modal" 
                  data-id="${row.id}"><i class="fa fa-close" aria-hidden="true"></button>`;
              }
            },
            { data: 'product.name' },
            { data: 'qty' },  
            { data: 'product.mrp' },
            { data: 'product.gst' },


],
columnDefs: [
{ "targets": ['nosearch'], "searchable": false },
{ "targets": 0, "sortable": false }
]
});
        
        this.table.on( 'order.dt search.dt', ()=> {
            this.table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        var vm = this;
        $(document).on('click','.view-button',function(){
            var id = $(this).data('id');
            vm.edit_stock(id);
        })
        var vm = this;
        $(document).on('click','.delete-button',function(){
            var id = $(this).data('id');
            vm.delete_stock(id);
        })

        this.table.on( 'draw', function () {
        });
           
           
        
    },
    data () {
        return {
            stocks: {},
            loading : false,
            errors  : {},
        }
    },
    methods : {
        get_stocks() {
            this.loading = true;
            axios.get('get_stocks').
            then(response => {
                this.stocks = response.data;
                this.loading = false;
            }).
            catch(err => {
                this.loading = false;
            });
        },

        edit_stock(id) {

            bus.$emit('edit-stock',id);
        },

        delete_stock(id) {
            swal({
                title: "Delete stock?",
                text: "Are you sure you want to delete this stock? This cannot be undone!",
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
                    axios.post('/delete_stock',{
                        id: id  
                    })
                    .then(response => {
                        swal.stopLoading();
                        swal.close();
                        swal("Stock deleted", "", "success");
                        this.table.ajax.reload();
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

